<?php


namespace App\Query;


use App\Models\Pharmacy;

class PharmacyRatingQuery
{
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

    public function setYear(int $year)
    {
        $this->year = $year;
        return $this;
    }

    public function setMonth(int $month)
    {
        $this->month = $month;
        return $this;
    }

    public function execute()
    {
        return $this->pharmacy
            ->when($this->pharmacyId, function ($query) {
                return $query->where('pharmacy_id', $this->pharmacyId);
            })
            ->with(['ratings' => function ($query) {
                return $query->whereMonth('ratings.created_at', $this->month)
                    ->whereYear('ratings.created_at', $this->year)->orderByRaw('ABS(ratings.scored/ratings.out_of)');
            }])
            ->get();
    }
}
