<?php

namespace App\Http\Requests;

class CheckRequest extends AbstractRequest
{
    protected $attributeName = 'meta';

    protected $rules = [
        'user_id' => 'required|exists:users,id',
        'name' => 'required',
        'created_at' => 'required|date|before:today'
    ];
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() : array
    {
        return $this->getRules();
    }

    protected function getCheckAttributes() {
        return \App\Models\CheckAttribute::all();
    }

    protected function formatCheckAttributesRules() {
        $this->getCheckAttributes()->each(function ($attr) {
            $this->rules["$this->attributeName.$attr->name"] = $attr->options->validation_rule;
        });
    }

    public function getRules()
    {
        $this->formatCheckAttributesRules();
        return $this->rules;
    }
}
