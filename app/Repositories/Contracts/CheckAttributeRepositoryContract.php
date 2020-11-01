<?php

namespace App\Repositories\Contracts;

use \Illuminate\Database\Eloquent\Collection;

interface CheckAttributeRepositoryContract
{
    /**
     * Get attributes models used in rating calculations
     * @return Collection
     */
    public function getUsedInRating() : Collection;

    public function saveOptions(array $options);
}
