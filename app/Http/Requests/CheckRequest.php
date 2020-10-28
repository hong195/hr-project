<?php

namespace App\Http\Requests;

use App\Models\CheckAttribute;

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
        return CheckAttribute::where('use_in_filter', true)->get();
    }

    protected function formatCheckAttributesRules() {
        $this->getCheckAttributes()->each(function ($attr) {
            $this->rules["$this->attributeName.$attr->name"] = $attr->validation_rule;
        });
    }

    public function getRules()
    {
        $this->formatCheckAttributesRules();
        return $this->rules;
    }
}
