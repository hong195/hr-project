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
    public function rules(): array
    {
        $rules = [
            'name' => ['required','min:2'],
            'address' => ['string', 'nullable'],
            'email' =>['required', 'email', 'unique:pharmacies,email'],
            'coordinates' => ['array', 'nullable'],
            'order' => ['numeric', 'nullable']
        ];

        if ($this->isUpdating()) {
            $rules['email'] = ['required', 'email', 'unique:pharmacies,email,' . $this->route('pharmacy')];
            $rules['password'] = 'nullable';
        }

        return $rules;
    }
}
