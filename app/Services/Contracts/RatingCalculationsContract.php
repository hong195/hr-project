<?php


namespace App\Services\Contracts;


use App\Models\Rating;

interface RatingCalculationsContract
{
    public function createRating();

    public function updateRating(Rating $rating);
}
