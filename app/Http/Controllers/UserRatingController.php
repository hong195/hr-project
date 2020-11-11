<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRatingRequest;
use App\Http\Resources\UserResource;
use App\Repositories\Contracts\RatingRepositoryContract;
use App\Repositories\Contracts\UserRepositoryContract;
use Illuminate\Http\Request;

class UserRatingController extends Controller
{
    private $ratingRepository;

    private $userRepository;

    public function __construct(RatingRepositoryContract $ratingRepository, UserRepositoryContract $userRepository)
    {
        $this->ratingRepository = $ratingRepository;
        $this->userRepository = $userRepository;
    }

    public function index(Request $request)
    {
        $year = $request->get('year') ? $request->get('year') : now()->year;
        $month = $request->get('month') ? $request->get('month') : now()->month;

        $userWithRatings = $this->userRepository->getModel()
            ->when($request->get('pharmacy_id'), function($query, $pharmacy_id){
                return $query->where('pharmacy_id', $pharmacy_id);
            })
            ->with(
                [
                    'ratings' => function ($query) use ($year, $month) {
                        return $query->whereYear('created_at', $year)->whereMonth('created_at', $month);
                    },
                ]
            )
            ->get();

        return UserResource::collection($userWithRatings);
    }

    public function show(UserRatingRequest $userRatingRequest)
    {
        $year = $userRatingRequest->get('year');
        $month = $userRatingRequest->get('month');
        $user_id = $userRatingRequest->get('user_id');

        $rating = $this->ratingRepository->getUserRatingByYearAndMonth($user_id, $year, $month);

        return response()->json(['rating' => $rating]);
    }

    public function getRatingChecks(int $id)
    {

    }
}
