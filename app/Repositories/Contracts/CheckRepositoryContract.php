<?php


namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Collection;

interface CheckRepositoryContract
{
    public function saveMeta(array $meta);

    public function findUsersChecksByYearAndMonth(int $user_id, int $year, int $month) : Collection;
}
