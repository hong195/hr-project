<?php


namespace App\Repositories;


use App\Models\User;
use App\Repositories\Contracts\UserRepositoryContract;

class UserRepository extends AbstractRepository implements UserRepositoryContract
{
    public function __construct(User $user)
    {
        parent::__construct($user);
    }

    public function saveMeta(array $meta)
    {
        if (!$meta) {
            return;
        }

        $this->model->meta()->delete();
    }
}
