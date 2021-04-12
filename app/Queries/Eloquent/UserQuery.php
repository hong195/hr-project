<?php


namespace App\Queries\Eloquent;


use App\Models\Rating;
use App\Models\User;
use App\Queries\Traits\OrderByTrait;
use App\Queries\UserQueryInterface;
use Illuminate\Database\Query\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;

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
    /**
     * @var bool
     */
    private $withRating;

    public function __construct(int $userId = null,
                                int $pharmacyId = null,
                                string $name = null,
                                int $ratingMonth = null,
                                int $ratingYear = null,
                                bool $withRating = false)
    {

        $this->pharmacyId = $pharmacyId;
        $this->name = $name;
        $this->userId = $userId;
        $this->ratingMonth = $ratingMonth;
        $this->ratingYear = $ratingYear;
        $this->withRating = $withRating;
    }

    public function execute(int $perPage = 10, int $page = 1): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        $query =  $this->getQuery()
            ->whereHas('roles', function ($query) {
                $query->whereNotIn('id', [User::ADMIN_ROLE, User::EDITOR_ROLE]);
            })
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
            });

        return $query->paginate($perPage);
    }

    private function getQuery()
    {
        return User::with('pharmacy');
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
