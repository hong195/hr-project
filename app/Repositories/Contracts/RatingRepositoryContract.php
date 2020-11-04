<?php


namespace App\Repositories\Contracts;


interface RatingRepositoryContract
{
    public function getPharmacyLowestRatingByYearAndMonth(int $pharmacy_id, int $year, int $month);

    public function getUserRatingByYearAndMonth(int $user_id, int $year, int $month);
}
