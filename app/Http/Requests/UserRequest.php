<?php

namespace App\Http\Requests;

class UserRequest extends AbstractRequest
{
    /**
     * @var \string[][]
     */
    protected $rules = [
        'pharmacy_id' => ['exists:pharmacies,id'],
        'first_name' => ['required', 'alpha'],
        'last_name' => ['required', 'alpha'],
        'patronymic' => ['required', 'alpha'],
        'email' => ['required', 'email', 'unique:users,email'],
        'password' => ['required', 'min:6', 'alpha_dash'],
        'role' => ['required', 'exists:roles,id'],
        'meta.gender' => ['nullable'],
        'meta.birthday' => ['date', 'nullable'],
    ];

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        if ($this->isUpdating()) {
            $this->rules['email'] = 'required|email';
        }

        return $this->rules;
    }
}
