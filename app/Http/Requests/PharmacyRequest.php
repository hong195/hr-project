<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PharmacyRequest extends AbstractRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() : array
    {
        return [
            'name' => ['required','min:2'],
            'address' => ['string', 'nullable'],
            'coordinates' => ['array', 'nullable'],
            'order' => ['numeric', 'nullable']
        ];
    }
}
