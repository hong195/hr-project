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

        return $this->paginate($query);
    }

    private function getQuery()
    {
        if ($this->withRating && $this->ratingYear && $this->ratingMonth) {
            $query = Db::table('users')->select('*')
                ->join('ratings', 'ratings.user_id', '=', 'users.id')
                ->select('users.*', 'ratings.id as rating_id',
                    'ratings.scored as rating_scored',
                    'ratings.user_id as rating_user_id',
                    'ratings.out_of as rating_out_of',
                    'ratings.created_at as rating_create_at'
                )
                ->whereYear('ratings.created_at', $this->ratingYear)
                ->whereMonth('ratings.created_at', $this->ratingMonth)
                ->orderByRaw('ABS(scored/out_of) DESC');
        } else if ($this->ratingYear && $this->ratingMonth) {
            $query = User::with([
                'ratings' => function ($query) {
                    return $query->whereYear('created_at', $this->ratingYear)->whereMonth('created_at', $this->ratingMonth);
                },
            ]);
        } else {
            $query = User::with('pharmacy');
        }

        return $query;
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

    private function paginate($query, $perPage = 10)
    {
        $total = $query->get()->count();
        $page = Paginator::resolveCurrentPage();
        $items = $query->forPage($page, $perPage)->get();
        $items = $this->hydrateResults($items);

        return new LengthAwarePaginator($items, $total, $perPage, $page);
    }

    private function hydrateResults($result): \Illuminate\Support\Collection
    {
        return collect($result)->map(function($item) {

            if (!($item instanceof User)) {
                $user = User::hydrate([
                    [
                        'id' => $item->id,
                        'first_name' => $item->first_name,
                        'last_name' => $item->last_name,
                        'patronymic' => $item->patronymic,
                        'email' => $item->email,
                    ]
                ])->first();

                if (property_exists($item,'rating_id')) {
                    $rating = Rating::hydrate([
                        [
                            'id' => $item->rating_id,
                            'user_id' => $item->rating_user_id,
                            'scored' => $item->rating_scored,
                            'out_of' => $item->rating_out_of,
                            'created_at' => $item->rating_create_at
                        ]
                    ]);

                    $user->setRelation('ratings', $rating);
                }

                $item = $user;
            }

            return $item;
        });
    }
}
