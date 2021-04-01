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
            'label' => ['required'],
            'order' => ['nullable', 'integer'],
        ];
    }
}
