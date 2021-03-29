<?php


namespace App\Queries;


interface PharmacyQueryInterface
{
    public function execute(int $perPage = 10);

    public function setId(int $id = null);

    public function setName(string $name = null);
}
