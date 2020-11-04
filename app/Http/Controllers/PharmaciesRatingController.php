<?php

namespace App\Http\Controllers;

use App\Http\Requests\PharmacyRatingRequest;
use App\Repositories\Contracts\RatingRepositoryContract;

class PharmaciesRatingController extends Controller
{
    private $ratingRepository;


    public function __construct(RatingRepositoryContract $ratingRepository)
    {
        $this->ratingRepository = $ratingRepository;
    }

    public function index(PharmacyRatingRequest $pharmacyRatingRequest)
    {
    }

    public function show(PharmacyRatingRequest $pharmacyRatingRequest, $pharmacy_id)
    {
        $year = $pharmacyRatingRequest->get('year');
        $month = $pharmacyRatingRequest->get('month');

        $rating = $this->ratingRepository->getPharmacyLowestRatingByYearAndMonth($pharmacy_id, $year, $month);

        return response()->json(['rating' => $rating]);
    }
}
