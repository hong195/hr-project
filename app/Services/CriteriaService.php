<?php


namespace App\Services;

use App\Repositories\Contracts\CheckAttributeRepositoryContract;
use App\Services\Contracts\CriteriaInterface;

class CriteriaService implements CriteriaInterface
{
    private $checkAttributeRepository;

    private $criteriaList = [];

    public function __construct(CheckAttributeRepositoryContract $checkAttributeRepository)
    {
        $this->checkAttributeRepository = $checkAttributeRepository;
    }

    public function generate(array $data = null)
    {
        $data = collect($data);
        $checkAttributes = $this->checkAttributeRepository->all();

        $checkAttributes->each(function($attribute) use ($data){

            if (!$attribute->use_in_rating && $data->has($attribute->name)) {
                $attribute->value = $data[$attribute->name];
                return true;
            }
            $attribute->options->each(function($option) use ($attribute,$data){
                $option->selected  = $data->has($attribute->name) && $option->id == $data[$attribute->name];
            });
        });

        $this->criteriaList = $checkAttributes->toArray();

        return $this;
    }

    public function getCriteriaList() : array
    {
        return $this->criteriaList;
    }
}
