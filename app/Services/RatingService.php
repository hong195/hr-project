<?php


namespace App\Services;

use App\Models\CheckAttribute;
use App\Models\Rating;
use App\Models\User;
use App\Services\Contracts\RatingCalculationsContract;
use Carbon\Carbon;
use Ramsey\Collection\Collection;

class RatingService implements RatingCalculationsContract
{
    /**
     * @var array|iterable
     */
    private $checks;
    /**
     * @var array|iterable
     */
    private $checkAttributes;
    /**
     * @var User
     */
    private $user;
    /**
     * @var Carbon
     */
    private $creationDate;

    /**
     * RatingCalculations constructor.
     * @param User $user
     * @param Carbon $ratingCreationDate
     * @param Collection|null $checks
     */
    public function __construct(User $user, Carbon $ratingCreationDate, Collection $checks = null)
    {
        $this->user = $user;
        $this->creationDate = $ratingCreationDate;
        $this->checkAttributes = CheckAttribute::where('options->use_in_filter', true)->get();
        $this->setUserChecksIfNotSet($checks);
    }

    /**
     *
     */
    public function createRating()
    {
        return $this->user->ratings()->create([
            'result' => $this->getScoredPoints(),
            'total' => $this->getTotalPoints(),
            'created_at' => '',
        ]);
    }

    /**
     * @param Rating $rating
     * @return int
     */
    public function updateRating(Rating $rating)
    {
        return $rating->update([
            'result' => $this->getScoredPoints(),
            'total' => $this->getTotalPoints(),
            'created_at' => '',
        ]);
    }

    public function getTotalPoints(): int
    {
        $this->checkAttributes->sum(function ($attribute) {

        });

        return 0;
    }

    public function getScoredPoints(): int
    {
        return 0;
    }

    /**
     * set user checks for generating ratings
     * @param Collection|null $checks
     * @return void
     */
    public function setUserChecksIfNotSet(Collection $checks = null): void
    {
        $this->checks = $checks ? $checks : $this->user->checks()
            ->whereYear('created_at', $this->creationDate->year)
            ->whereMonth('created_at', $this->creationDate->month)
            ->get();
    }
}
