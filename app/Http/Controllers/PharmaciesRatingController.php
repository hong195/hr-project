<?php

namespace App\Http\Controllers;

use App\Http\Requests\PharmacyRatingRequest;
use App\Repositories\Contracts\RatingRepositoryContract;
use App\Repositories\PharmacyRepository;

class PharmaciesRatingController extends Controller
{
    private $ratingRepository;
    private $pharmacyRepository;


    public function __construct(RatingRepositoryContract $ratingRepository, PharmacyRepository $pharmacyRepository)
    {
        $this->ratingRepository = $ratingRepository;
        $this->pharmacyRepository = $pharmacyRepository;
    }

    public function index(PharmacyRatingRequest $request)
    {
        $year = $request->get('year');
        $month = $request->get('month');

        $pharmacies = $this->pharmacyRepository->all();

        $scores = [];
        $pharmacyNames = [];

        foreach ($pharmacies as $pharmacy) {
            $rating = $this->ratingRepository
                ->getPharmacyLowestRatingByYearAndMonth($pharmacy->id, $year, $month);
            array_push($scores, $rating ? (int)$rating->scored : 0);
            array_push($pharmacyNames, $pharmacy->name);
        }

        return response()->json(['data' => $scores, 'labels' => $pharmacyNames ]);
    }

    public function show(PharmacyRatingRequest $pharmacyRatingRequest, $pharmacy_id)
    {
        $year = $pharmacyRatingRequest->get('year');
        $month = $pharmacyRatingRequest->get('month');

        $rating = $this->ratingRepository->getPharmacyLowestRatingByYearAndMonth($pharmacy_id, $year, $month);
        return response()->json(['rating' => $rating]);
    }
}
