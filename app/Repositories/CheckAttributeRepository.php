<?php


namespace App\Repositories;


use App\Models\CheckAttribute;
use App\Repositories\Contracts\CheckAttributeRepositoryContract;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as SupportCollection;

class CheckAttributeRepository extends AbstractRepository implements CheckAttributeRepositoryContract
{
    private $attributes = [];

    public function __construct(CheckAttribute $checkAttribute)
    {
        parent::__construct($checkAttribute);
    }

    public function create(array $checkAttributeRequest)
    {
        $checkAttributeRequest = collect($checkAttributeRequest);
        $this->setAttributes($checkAttributeRequest);

        $attributes = $this->attributes;
        $attributes['type'] = 'radio';
        $attributes['use_in_rating'] = true;

        return parent::create($attributes);
    }

    public function update(int $id, array $checkAttributeRequest)
    {
        $checkAttributeRequest = collect($checkAttributeRequest);
        $this->model = $this->findById($id);

        return $this->setAttributes($checkAttributeRequest)->model->update($this->attributes);
    }

    private function setAttributes(SupportCollection $attributes)
    {
        $this->attributes = $attributes->except('options')->toArray();
        return $this;
    }

    public function getUsedInRating() : Collection
    {
        return $this->model->useInRating()->get();
    }

    public function saveOptions(array $options)
    {
        $this->model->options()->createMany($options);
    }

    public function deleteOptions()
    {
        $this->model->options()->delete();
    }

    public function all()
    {
        return parent::all()->sortBy('order');
    }

    public function with(array $relations)
    {
        return parent::with($relations)->sortByDesc('order');
    }
}
