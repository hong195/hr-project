<?php


namespace App\Services\Contracts;


interface CriteriaInterface
{
    public function generate(array $data);

    public function getCriteriaList() : array;
}
