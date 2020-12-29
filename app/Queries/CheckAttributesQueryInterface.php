<?php


namespace App\Queries;


interface CheckAttributesQueryInterface
{
    public function execute(int $perPage = 10, int $page = 1);

    public function setName(string $name = null);

    public function setLabel(string $label = null);

    public function setType(string $type = null);

    public function setUsingInRating(bool $usedInRating = null);
}
