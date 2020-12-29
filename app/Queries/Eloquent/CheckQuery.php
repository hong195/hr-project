<?php


namespace App\Queries\Eloquent;


use App\Models\Check;
use App\Queries\CheckQueryInterface;
use App\Queries\Traits\OrderByTrait;

class CheckQuery implements CheckQueryInterface
{
    use OrderByTrait;
    /**
     * @var int|null
     */
    private $userId;
    /**
     * @var string|null
     */
    private $name;
    /**
     * @var int|null
     */
    private $year;
    /**
     * @var int|null
     */
    private $month;
    /**
     * @var array
     */
    private $relations;
    /**
     * @var int|null
     */
    private $ratingId;

    public function __construct(int $user_id = null,
                                string $name = null,
                                int $year = null ,
                                int $month = null,
                                int $ratingId = null)
    {

        $this->userId = $user_id;
        $this->name = $name;
        $this->year = $year;
        $this->month = $month;
        $this->ratingId = $ratingId;
    }

    public function execute(int $perPage = 10, int $page = 1): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return $this->getQuery()
            ->when($this->userId, function ($query){
                $query->whereHas('ratings', function ($query) {
                    return $query->where('ratings.id', $this->ratingId);
                });
            })
            ->when($this->ratingId, function ($query){
                $query->whereHas('user_id', $this->userId);
            })
            ->when($this->year, function ($query){
                $query->whereYear('created_at', $this->year);
            })
            ->when($this->month, function ($query){
                $query->whereMonth('created_at', $this->month);
            })
            ->when($this->name, function ($query){
                $query->where('name', $this->name);
            })
            ->when($this->orderBy, function($query) {
                $query->orderBy($this->orderBy, $this->direction = 'ASC');
            })
            ->paginate($perPage, $columns = ['*'], $pageName = 'page', $page);
    }

    protected function getQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return $this->relations ? Check::with($this->relations) : Check::query();
    }

    public function with(array $relations): CheckQuery
    {
        foreach ($relations as $single) {
            if (!$single) {
                continue;
            }
            $this->relations[] = $single;
        }

        return $this;
    }

    public function setUserId(int $userId = null): CheckQuery
    {
        $this->userId = $userId;
        return $this;
    }

    public function setName(string $name = null): CheckQuery
    {
        $this->name = $name;
        return $this;
    }

    public function setRatingId(int $ratingId = null): CheckQuery
    {
        $this->ratingId = $ratingId;
        return $this;
    }
}
