<?php

namespace App\Http\Requests;

class CheckAttributeRequest extends AbstractRequest
{
    private $attributeName = 'options';
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() : array
    {
        return [
            'name' => ['string', 'required'],
            'type' => ['required'],
            'label' => ['required'],
            'validation_rule' => ['nullable'],
            'use_in_rating' => ['boolean'],
            'order' => ['nullable'],
            'options.*.name' => ['string'],
            'options.*.value' => ['numeric'],
            'options.*.label' => ['string'],
        ];
    }
}
