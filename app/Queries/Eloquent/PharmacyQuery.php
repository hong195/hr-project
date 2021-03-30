<?php

namespace App\Queries\Eloquent;

use App\Models\Pharmacy;
use App\Models\Rating;
use App\Models\User;
use App\Queries\PharmacyQueryInterface;
use App\Queries\Traits\OrderByTrait;
use Illuminate\Support\Facades\DB;

class PharmacyQuery implements PharmacyQueryInterface
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
    /**
     * @var array
     */
    private $with;

    public function __construct(int $id = null, string $name = null)
    {
        $this->id = $id;
        $this->name = $name;
    }

    public function execute(int $perPage = 10): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return $this->getQuery()
            ->when($this->id, function ($query) {
                $query->where('id', $this->id);
            })
            ->when($this->name, function ($query) {
                $query->where('name', "%$this->name%");
            })
            ->when($this->orderBy, function($query) {
                if ($this->orderBy === 'users_count') {
                    $query->orderByDesc(User::selectRaw('count(id) as count')
                            ->whereColumn('pharmacy_id', 'pharmacies.id')
                            ->orderBy('count', $this->direction = 'ASC'));
                }else {
                    $query->orderBy($this->orderBy, $this->direction = 'ASC');
                }
            })
            ->paginate($perPage);
    }

    private function getQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return $this->with ? Pharmacy::with($this->with) : Pharmacy::query();
    }

    public function setWith(array $relation)
    {
        $this->with = $relation;
    }

    public function setId(int $id = null): PharmacyQuery
    {
        $this->id = $id;
        return $this;
    }

    public function setName(string $name = null): PharmacyQuery
    {
        $this->name = $name;
        return $this;
    }
}
