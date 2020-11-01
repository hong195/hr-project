<?php


namespace App\Repositories\Traits;


use Carbon\Carbon;

trait ToCarbonTrait
{
    /**
     * Transform date into Carbon instance if it is not
     * @param $date
     * @return Carbon
     */
    public function transformDate($date) : Carbon
    {
        $date = $date instanceof Carbon ? $date : Carbon::parse($date);
        return $date;
    }
}
