<?php


namespace App\Queries\Traits;


trait OrderByTrait
{
    public $direction;
    public $orderBy;

    public function setDirection(string $direction = null)
    {
        $this->direction = $direction;
        return $this;
    }

    public function setOrderBy(string $orderBy = null)
    {
        $this->orderBy = $orderBy;
        return $this;
    }
}
