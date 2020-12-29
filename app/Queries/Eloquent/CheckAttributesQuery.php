<?php


namespace App\Queries\Eloquent;


use App\Models\CheckAttribute;
use App\Queries\CheckAttributesQueryInterface;
use App\Queries\Traits\OrderByTrait;

class CheckAttributesQuery implements CheckAttributesQueryInterface
{
    use OrderByTrait;
    /**
     * @var string|null
     */
    private $name;
    /**
     * @var string|null
     */
    private $label;
    /**
     * @var string|null
     */
    private $type;
    /**
     * @var bool|null
     */
    private $usedInRating;

    public function __construct(string $name = null, string $label = null, string $type = null, bool $usedInRating = null)
    {
        $this->name = $name;
        $this->label = $label;
        $this->type = $type;
        $this->usedInRating = $usedInRating;
    }

    public function execute(int $perPage = 10, int $page = 1): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return CheckAttribute::with(['options'])
            ->when($this->name, function ($query) {
                $query->where('name', "%$this->name%");
            })
            ->when($this->label, function ($query) {
                $query->where('label', "%$this->label%");
            })
            ->when($this->type, function ($query) {
                $query->where('type', $this->type);
            })
            ->when($this->usedInRating, function ($query) {
                $query->where('use_in_rating', $this->usedInRating);
            })
            ->when($this->orderBy, function($query) {
                $query->orderBy($this->orderBy, $this->direction = 'ASC');
            })
            ->paginate($perPage, $columns = ['*'], $pageName = 'page', $page);
    }

    public function setName(string $name = null): CheckAttributesQuery
    {
        $this->name = $name;
        return $this;
    }

    public function setLabel(string $label = null): CheckAttributesQuery
    {
        $this->label = $label;
        return $this;
    }

    public function setType(string $type = null): CheckAttributesQuery
    {
        $this->type = $type;
        return $this;

    }

    public function setUsingInRating(bool $usedInRating = null): CheckAttributesQuery
    {
        $this->usedInRating = $usedInRating;
        return $this;
    }
}
