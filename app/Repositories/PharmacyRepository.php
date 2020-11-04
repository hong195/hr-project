<?php


namespace App\Repositories;


use App\Models\Pharmacy;

class PharmacyRepository extends AbstractRepository
{
    public function __construct(Pharmacy $pharmacy)
    {
        parent::__construct($pharmacy);
    }
}
