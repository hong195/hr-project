<?php


namespace App\Services;

use App\Enums\CheckLimit;
use App\Exceptions\UserRatingException;
use App\Models\Rating;
use App\Models\User;
use App\Repositories\Contracts\CheckAttributeRepositoryContract;
use App\Repositories\Contracts\RatingRepositoryContract;
use App\Repositories\Contracts\UserRepositoryContract;
use Carbon\Carbon;

class RatingService
{
    /**
     * @var array|iterable
     */
    private $checks;
    /**
     * @var array|iterable
     */
    private $checkAttributesRepository;
    /**
     * @var User
     */
    private $user;
    /**
     * @var Carbon
     */
    private $creationDate;
    /**
     * @var UserRepositoryContract
     */
    private $ratingRepository;

    /**
     * RatingService constructor.
     * @param CheckAttributeRepositoryContract $checkAttributesRepository
     * @param RatingRepositoryContract $ratingRepository
     */
    public function __construct(CheckAttributeRepositoryContract $checkAttributesRepository,
                                RatingRepositoryContract $ratingRepository)
    {
        $this->checkAttributesRepository = $checkAttributesRepository;
        $this->ratingRepository = $ratingRepository;
    }

    /**
     * @param Carbon $creationDate
     * @return RatingService
     */
    public function setCreationDate(Carbon $creationDate)
    {
        $this->creationDate = $creationDate;
        return $this;
    }

    /**
     * Get possible total points, total depends on check attributes
     * @throws UserRatingException
     */
    public function createRating(): Rating
    {
        $scored = $this->getScoredPoints();
        $out_of = $this->getTotalPoints();


        if ($scored > $out_of) {
            throw new UserRatingException(__('rating.scored_error'));
        }

        $rating = $this->ratingRepository->create([
                'user_id' => $this->user->id,
                'scored' => $this->getScoredPoints(),
                'out_of' => $this->getTotalPoints(),
                'conversion' => $this->getConversion(),
                'created_at' => $this->creationDate->toDateString()
            ]);
        $rating->checks()->sync($this->checks->map->id);

        return $rating;
    }

    /**
     * Get Users scored points, depends on checks criteria
     * @return int|float
     */
    protected function getTotalPoints()
    {
        return $this->checkAttributesRepository->getUsedInRating()->sum(function ($attribute) {
            return $attribute->options->max->value * CheckLimit::MINIMUM_FOR_CREATING_RATING;
        });
    }

    /**
     * Get Users scored points, depends on checks criteria
     * @return int|float
     */
    protected function getScoredPoints()
    {
        return $this->checks->sum(function ($check) {
            return collect($check->criteria)->filter->use_in_rating->sum(function ($criteria) {
                return collect($criteria->options)->sum(function ($option) {
                    return $option->selected ? $option->value : 0;
                });
            });
        });
    }

    public function getConversion()
    {
        return $this->checks->sum(function ($check) {
            return $check->conversion;
        });
    }
    /**
     * @param array|iterable $checks
     * @return RatingService
     */
    public function setChecks($checks)
    {
        $this->checks = $checks;
        return $this;
    }

    /**
     * @param User $user
     * @return RatingService
     */
    public function setUser(User $user)
    {
        $this->user = $user;
        return $this;
    }
}
