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
    public function castToCarbon($date = null) : Carbon
    {
        if (!$date) {
            $date = Carbon::parse($date);
        }
        $date = $date instanceof Carbon ? $date : Carbon::parse($date);

        return $date;
    }
}
