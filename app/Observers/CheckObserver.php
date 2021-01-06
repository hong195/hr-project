<?php

namespace App\Observers;

use App\Enums\CheckLimit;
use App\Exceptions\UserRatingException;
use App\Models\Check;
use App\Notifications\RatingCreated;
use App\Repositories\Contracts\CheckRepositoryContract;
use App\Services\RatingService;

class CheckObserver
{
    private $ratingService;
    private $checkRepository;

    /**
     * CheckObserver constructor.
     * @param RatingService $ratingService
     * @param CheckRepositoryContract $checkRepository
     */
    public function __construct(RatingService $ratingService, CheckRepositoryContract $checkRepository)
    {
        $this->ratingService = $ratingService;
        $this->checkRepository = $checkRepository;
    }

    /**
     * @param Check $check
     */
    public function created(Check $check): void
    {
        $user = $check->user;
        $created_at = $check->created_at;
        $userChecks = $this->checkRepository
            ->findUsersChecksByYearAndMonth($user->id, $created_at->year, $created_at->month);

        if ($userChecks->count() !== CheckLimit::MINIMUM_FOR_CREATING_RATING) {
            return;
        }

        try {
            $rating = $this->ratingService
                        ->setUser($user)
                        ->setCreationDate($created_at)
                        ->setChecks($userChecks)
                        ->createRating();

            $user->notify(new RatingCreated($rating));

        } catch (UserRatingException $e) {
            report($e);
        }
    }
}
