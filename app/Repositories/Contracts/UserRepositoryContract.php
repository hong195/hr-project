<?php


namespace App\Repositories\Contracts;


interface UserRepositoryContract
{
    /**
     * @param array $meta
     * @return mixed
     */
    public function saveMeta(array $meta);
}
