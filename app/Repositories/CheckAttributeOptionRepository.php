<?php


namespace App\Repositories;


use App\Models\CheckAttributeOption;

class CheckAttributeOptionRepository extends AbstractRepository
{
    public function __construct(CheckAttributeOption $option)
    {
        parent::__construct($option);
    }
}
