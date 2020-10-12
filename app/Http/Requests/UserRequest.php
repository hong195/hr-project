<?php

namespace App\Http\Requests;

class UserRequest extends AbstractRequest
{
    protected $rules = [
        'pharmacy_id' => 'exists:pharmacies,id',
        'first_name' => 'required|alpha',
        'last_name' => 'required|alpha',
        'patronymic' => 'required|alpha',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:6|alpha_dash',
        'meta' => ''
    ];
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() : bool
    {
        // Todo make user ability validation
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() : array
    {
        if ($this->isUpdating()) {
            $this->rules['email'] = 'required|email';
        }

        return $this->rules;
    }
}
