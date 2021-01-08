<?php


namespace App\Queries;


interface CheckQueryInterface
{
    public function execute(int $perPage = 10, int $page = 1);

    public function with(array $relations);

    public function setUserId(int $userId = null);

    public function setName(string $name = null);
}
