<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRatingRequest;
use App\Repositories\Contracts\RatingRepositoryContract;

class UserRatingController extends Controller
{
    private $ratingRepository;


    public function __construct(RatingRepositoryContract $ratingRepository)
    {
        $this->ratingRepository = $ratingRepository;
    }

    public function show(UserRatingRequest $userRatingRequest)
    {
        $year = $userRatingRequest->get('year');
        $month = $userRatingRequest->get('month');
        $user_id = $userRatingRequest->get('user_id');

        $rating = $this->ratingRepository->getUserRatingByYearAndMonth($user_id, $year, $month);

        return response()->json(['rating' => $rating]);
    }
}
