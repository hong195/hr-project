<?php

namespace App\Http\Controllers;

use App\Http\Requests\PharmacyRatingRequest;
use App\Queries\Eloquent\PharmacyRatingQuery;
use App\Queries\PharmacyRatingQueryInterface;
use Illuminate\Http\Request;

class PharmaciesRatingController extends Controller
{
    /**
     * @var PharmacyRatingQuery
     */
    private $pharmacyRatingQuery;

    public function __construct(PharmacyRatingQueryInterface $pharmacyRatingQuery)
    {
        $this->pharmacyRatingQuery = $pharmacyRatingQuery;
    }

    public function index(PharmacyRatingRequest $request): \Illuminate\Http\JsonResponse
    {
        $pharmaciesWithRatings = $this->pharmacyRatingQuery->execute();

        $pharmaciesWithRatings = $pharmaciesWithRatings->map(function ($pharmacy) {
            return [
                'name' => $pharmacy->name,
                'rating' => $pharmacy->ratings->first() ? $pharmacy->ratings->first() : ['scored' => 0, 'out_of' => 'Нет Рейтинга'],
                'ratings' => $pharmacy->ratings
            ];
        });

        return response()->json(['data' => $pharmaciesWithRatings]);
    }

    public function show($id, Request $request)
    {

    }
}
