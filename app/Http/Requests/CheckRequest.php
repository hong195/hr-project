<?php

namespace App\Http\Requests;

use App\Repositories\Contracts\CheckAttributeRepositoryContract;

class CheckRequest extends AbstractRequest
{
    protected $attributeName = 'meta';

    private $checkAttributeRepository;

    public function __construct(CheckAttributeRepositoryContract $checkAttributeRepository,
                                array $query = [],
                                array $request = [],
                                array $attributes = [],
                                array $cookies = [],
                                array $files = [],
                                array $server = [],
                                $content = null)
    {
        $this->checkAttributeRepository = $checkAttributeRepository;
        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);
    }

    protected $rules = [
        'user_id' => ['required', 'exists:users,id'],
        'created_at' => ['required','date','before:today'],
        'sum' => ['required', 'integer']
    ];

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return $this->getRules();
    }

    protected function getCheckAttributes()
    {
        return $this->checkAttributeRepository->all();
    }

    protected function formatCheckAttributesRules()
    {
        $this->getCheckAttributes()->each(function ($attr) {
            //Todo make field proper validation, ie field must match 1 or 10
            $rule = ['string', 'nullable'];
            if ($attr->use_in_rating) {
                $rule = ['numeric', 'nullable'];
            }
            $this->rules["$this->attributeName.$attr->name"] = $rule;
        });
    }

    public function getRules()
    {
        $this->formatCheckAttributesRules();
        return $this->rules;
    }
}
