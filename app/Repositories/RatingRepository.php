<?php


namespace App\Repositories;


use App\Models\Rating;
use App\Repositories\Contracts\RatingRepositoryContract;

class RatingRepository extends AbstractRepository implements RatingRepositoryContract
{
    public function __construct(Rating $rating)
    {
        parent::__construct($rating);
    }
}
