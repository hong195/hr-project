<?php


namespace App\Queries\Eloquent;


use App\Models\User;
use App\Queries\Traits\OrderByTrait;
use App\Queries\UserQueryInterface;

class UserQuery implements UserQueryInterface
{

    use OrderByTrait;

    private $userId;
    /**
     * @var int|null
     */
    private $pharmacyId;
    /**
     * @var string|null
     */
    private $name;

    private $ratingMonth;

    private $ratingYear;

    public function __construct(int $userId = null,
                                int $pharmacyId = null,
                                string $name = null,
                                int $ratingMonth = null,
                                int $ratingYear = null)
    {

        $this->pharmacyId = $pharmacyId;
        $this->name = $name;
        $this->userId = $userId;
        $this->ratingMonth = $ratingMonth;
        $this->ratingYear = $ratingYear;
    }

    public function execute(int $perPage = 10, int $page = 1): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return $this->getQuery()
            ->when($this->userId, function ($query) {
                $query->where('id', $this->userId);
            })
            ->when($this->pharmacyId, function ($query) {
                return $query->where('pharmacy_id', $this->pharmacyId);
            })
            ->when($this->name, function ($query) {
                $query->where('first_name', 'like', "%$this->name%")
                    ->orWhere('last_name', 'like', "%$this->name%")
                    ->orWhere('patronymic', 'like', "%$this->name%");
            })
            ->when($this->orderBy, function ($query) {
                $query->orderBy($this->orderBy, $this->direction = 'ASC');
            })
            ->paginate($perPage, $columns = ['*'], $pageName = 'page', $page);
    }

    private function getQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return $this->ratingYear && $this->ratingMonth
            ? User::with([
                'ratings' => function ($query) {
                    return $query->whereYear('created_at', $this->ratingYear)->whereMonth('created_at', $this->ratingMonth);
                },
            ])
            : User::query();
    }

    public function setId(int $id = null): UserQuery
    {
        $this->userId = $id;
        return $this;
    }

    public function setName(string $name = null): UserQuery
    {
        $this->name = $name;
        return $this;
    }
}
