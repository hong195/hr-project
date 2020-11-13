<?php


namespace App\Repositories;


use App\Models\User;
use App\Repositories\Contracts\UserRepositoryContract;
use \Illuminate\Support\Collection as SupportCollection;

class UserRepository extends AbstractRepository implements UserRepositoryContract
{
    /**
     * @var array
     */
    private $attributes = [];

    public function __construct(User $user)
    {
        parent::__construct($user);
    }

    public function create(array $data)
    {
        $data = collect($data);
        $this->setMainAttributes($data);

        $this->model = parent::create($this->attributes);

        if ($data->has('role')) {
            $this->attachRole($data->get('role'));
        }

        if ($data->has('meta')) {
            $this->saveUserMeta($data->get('meta'));
        }

        return $this->model;
    }

    public function update(int $id, array $data)
    {
        $this->model = $this->findById($id);
        $data = collect($data);
        $this->setMainAttributes($data);

        if (!$data->get('password')) {
            $data->forget('password');
        }

        if ($data->has('role')) {
            $this->detachRole();
            $this->attachRole($data->get('role'));
        }

        if ($data->has('meta')) {
            $this->deleteUserMeta();
            $this->saveUserMeta($data->get('meta'));
        }

        return parent::update($id, $this->attributes);
    }

    public function attachRole(int $id)
    {
        $this->model->roles()->attach($id);
    }

    public function detachRole(int $id = null)
    {
        if (!$id) {
            return $this->model->roles()->detach();
        }

        return $this->model->detach($id);
    }

    public function deleteUserMeta()
    {
        if (!$this->model) {
            return false;
        }

        return $this->model->meta()->delete();
    }

    public function saveUserMeta(array $meta)
    {
        $meta = collect($meta)->map(function($value, $key){
            return ['name' => $key, 'value' => $value];
        })->values()->all();

        return $this->model->meta()->createMany($meta);
    }

    private function setMainAttributes(SupportCollection $attributes)
    {
        $this->attributes =  $attributes->except(['meta', 'role'])->toArray();
    }
}
