<?php


namespace App\Queries\Eloquent;


use App\Models\User;
use App\Queries\Traits\OrderByTrait;
use App\Queries\UserQueryInterface;

class UserQuery implements UserQueryInterface
{

    use OrderByTrait;
    /**
     * @var int|null
     */
    private $id;
    /**
     * @var string|null
     */
    private $name;

    public function __construct(int $id = null, string $name = null)
    {

        $this->id = $id;
        $this->name = $name;
    }

    public function execute(int $perPage = 10, int $page = 1): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return User::query()
            ->when($this->id, function ($query) {
                $query->where('id', "%$this->id%");
            })
            ->when($this->name, function ($query) {
                $query->where('name', "%$this->name%");
            })
            ->when($this->orderBy, function($query) {
                $query->orderBy($this->orderBy, $this->direction = 'ASC');
            })
            ->paginate($perPage, $columns = ['*'], $pageName = 'page', $page);
    }

    public function setId(int $id = null): UserQuery
    {
        $this->id = $id;
        return $this;
    }

    public function setName(string $name = null): UserQuery
    {
        $this->name = $name;
        return $this;
    }
}
