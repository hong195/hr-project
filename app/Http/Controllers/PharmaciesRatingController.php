<?php

namespace App\Http\Controllers;

use App\Http\Requests\PharmacyRatingRequest;
use App\Query\PharmacyRatingQuery;
use App\Repositories\Contracts\RatingRepositoryContract;

class PharmaciesRatingController extends Controller
{
    /**
     * @var RatingRepositoryContract
     */
    private $ratingRepository;

    /**
     * @var PharmacyRatingQuery
     */
    private $query;

    public function __construct(RatingRepositoryContract $ratingRepository, PharmacyRatingQuery $query)
    {
        $this->query = $query;
        $this->ratingRepository = $ratingRepository;
    }

    public function index(PharmacyRatingRequest $request)
    {
        $year = $request->get('year');
        $month = $request->get('month');

        $pharmaciesWithRatings = $this->query->setYear($year)
                                            ->setMonth($month)
                                            ->execute();

        $pharmaciesWithRatings = $pharmaciesWithRatings->map(function($pharmacy) {
            return [
                'name' => $pharmacy->name,
                'rating' => $pharmacy->ratings->first()
            ];
        });

        return response()->json(['data' => $pharmaciesWithRatings]);
    }
}
