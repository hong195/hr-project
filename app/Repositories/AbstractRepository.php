<?php


namespace App\Repositories;


use App\Repositories\Contracts\BaseEloquentRepositoryContract;
use Illuminate\Database\Eloquent\Model;

abstract class AbstractRepository implements BaseEloquentRepositoryContract
{
    /**
     * @var
     */
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data)
    {
        $this->model = $this->findById($id);
        return $this->model->update($data);
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function findById(int $id)
    {
        return $this->findBy('id', $id)->firstOrFail();
    }

    /**
     * @param string $field
     * @param $value
     * @return mixed
     */
    public function findBy(string $field, $value)
    {
        return $this->model->where($field, $value);
    }

    public function delete(int $id)
    {
        $this->model->destroy($id);
    }

    public function all()
    {
        return $this->model->all();
    }

    public function setModel(Model $model)
    {
        $this->model = $model;
        return $this;
    }

    /**
     * @return Model
     */
    public function getModel()
    {
        return $this->model;
    }
}
