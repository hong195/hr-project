<?php


namespace App\Repositories\Contracts;


interface UserRepositoryContract
{
    public function saveUserMeta(array $meta);

    public function deleteUserMeta();

    public function attachRole(int $id);

    public function detachRole(int $id = null);
}
