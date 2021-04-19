<?php

namespace App\Queries\Eloquent;

use App\Models\Pharmacy;
use App\Queries\PharmacyRatingQueryInterface;
use App\Queries\Traits\OrderByTrait;

class PharmacyRatingQuery implements PharmacyRatingQueryInterface
{
    use OrderByTrait;

    /**
     * @var int
     */
    private $month;
    /**
     * @var int
     */
    private $year;
    /**
     * @var int|null
     */
    private $pharmacyId;

    /**
     * @var Pharmacy
     */
    private $pharmacy;

    public function __construct(int $pharmacyId = null, int $year = null, int $month = null)
    {
        $this->pharmacy = new Pharmacy;
        $this->pharmacyId = $pharmacyId;
        $this->year = $year ? $year : now()->year;
        $this->month = $month ? $month : now()->month;
    }

    public function setPharmacyId(int $pharmacyId)
    {
        $this->pharmacyId = $pharmacyId;
        return $this;
    }

    public function execute()
    {
        return $this->pharmacy
            ->when($this->pharmacyId, function ($query) {
                return $query->where('id', $this->pharmacyId);
            })
            ->whereHas(
                'ratings', function ($query) {
                return $query->whereMonth('ratings.created_at', $this->month)
                    ->whereYear('ratings.created_at', $this->year)->orderByRaw('ABS(ratings.scored/ratings.out_of)');
            })
            ->with(
                [
                    'ratings' => function ($query) {
                        return $query->whereMonth('ratings.created_at', $this->month)
                            ->whereYear('ratings.created_at', $this->year)->orderByRaw('ABS(ratings.scored/ratings.out_of)');
                    },
                    'ratings.user',
                    'users'
                ]
            )
            ->get();
    }

    /**
     * @param int $year
     * @return PharmacyRatingQuery
     */
    public function setYear(int $year): PharmacyRatingQuery
    {
        $this->year = $year;
        return $this;
    }

    /**
     * @param int $month
     * @return PharmacyRatingQuery
     */
    public function setMonth(int $month): PharmacyRatingQuery
    {
        $this->month = $month;
        return $this;
    }
}
