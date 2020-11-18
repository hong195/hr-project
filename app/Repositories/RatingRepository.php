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

    public function getPharmacyRatingsByYearAndMonth(int $pharmacy_id, int $year, int $month)
    {
        $pharmacy = $this->pharmacyRepository->findById($pharmacy_id);

        return $pharmacy->ratings()
            ->whereYear('ratings.created_at', $year)
            ->whereMonth('ratings.created_at', $month)
            ->get();
    }

    public function getPharmacyLowestRatingByYearAndMonth(int $pharmacy_id, int $year, int $month)
    {
        return $this->getPharmacyRatingsByYearAndMonth($pharmacy_id, $year, $month)
            ->load('checks')
            ->sortBy('scored')
            ->first();
    }

    public function getUserRatingByYearAndMonth(int $user_id, int $year, int $month)
    {
        $user = $this->userRepository->findById($user_id);

        return $user->ratings()->whereYear('created_at', $year)->whereMonth('created_at', $month)->with('checks')->first();
    }

}
