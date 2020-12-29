<?php


namespace App\Queries;


interface UserQueryInterface
{
    public function execute(int $perPage = 10, int $page = 1);

    public function setId(int $id = null);

    public function setName(string $name = null);
}
