<?php

namespace App\Http\Controllers;

use App\Enums\Pagination;
use App\Http\Requests\UserRatingRequest;
use App\Http\Resources\EmployeeResource;
use App\Http\Resources\RatingResource;
use App\Models\Rating;
use App\Queries\UserQueryInterface;

class UserRatingController extends Controller
{
    public function index(UserRatingRequest $request): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $perPage = $request['perPage'] ?? Pagination::DEFAULT_PER_PAGE;

        $ratings = Rating::query()
                ->with(['user' => function($query) use ($request){
                    $query->when($request->get('name'), function ($q, $name) {
                        $q->where('first_name', 'like', $name);
                        $q->orWhere('last_name', 'like', $name);
                        $q->orWhere('patronymic', 'like', $name);
                    });
                }])
                ->whereYear('created_at', $request->get('ratingYear'))
                ->whereMonth('created_at', $request->get('ratingMonth'))
                ->when($request->get('pharmacyId'), function ($query) use ($request){
                    $query->whereHas('user', function ($q) use ($request){
                        $q->where('pharmacy_id', $request->get('pharmacyId'));
                    });
                })
                ->when($request->get('orderBy'), function($query, $orderBy) use ($request){
                    if ($orderBy === 'rating') {
                        $query->orderByRaw('ABS(scored/out_of) ' . $request->get('direction', 'ASC'));
                    }else {
                        $query->orderBy($orderBy, $request->get('direction', 'ASC'));
                    }
                })

                ->paginate($perPage);

        return RatingResource::collection($ratings);
    }
}
