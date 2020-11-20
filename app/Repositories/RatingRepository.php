<?php


namespace App\Repositories;


use App\Models\Rating;
use App\Repositories\Contracts\RatingRepositoryContract;

class RatingRepository extends AbstractRepository implements RatingRepositoryContract
{
    /**
     * PharmacyRepository
     */
    private $pharmacyRepository;
    /**
     * UserRepository
     */
    private $userRepository;

    public function __construct(Rating $rating,
                                PharmacyRepository $pharmacyRepository,
                                UserRepository $userRepository)
    {
        parent::__construct($rating);
        $this->pharmacyRepository = $pharmacyRepository;
        $this->userRepository = $userRepository;
    }
}
