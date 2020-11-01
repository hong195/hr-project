<?php


namespace App\Repositories\Contracts;


interface BaseEloquentRepositoryContract
{
    public function create(array $data);

    public function update(int $id, array $data);

    public function delete(int $id);

    public function findById(int $id);

    public function findBy(string $field, $value);

}
