<?php

namespace App\Http\Controllers;

use App\Http\Requests\PharmacyRatingRequest;
use App\Queries\Eloquent\PharmacyRatingQuery;
use App\Queries\PharmacyRatingQueryInterface;

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

        $pharmaciesWithRatings = $pharmaciesWithRatings->map(function($pharmacy) {
            return [
                'name' => $pharmacy->name,
                'rating' => $pharmacy->ratings->first()
            ];
        });

        return response()->json(['data' => $pharmaciesWithRatings]);
    }
}
