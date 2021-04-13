<?php

namespace App\Http\Requests;

class UserRequest extends AbstractRequest
{
    public function authorize(): bool
    {
        if ($this->user() && $this->user()->hasRole(['admin', 'editor'])) {
            return true;
        }

        return false;
    }

    protected $rules = [
        'pharmacy_id' => ['required_if:role,2', 'nullable', 'exists:pharmacies,id'],
        'first_name' => ['required'],
        'last_name' => ['required'],
        'patronymic' => ['required'],
        'login' => ['required', 'min:6', 'alpha_dash', 'unique:users,login'],
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
            $this->rules['login'] = ['required', 'min:6', 'alpha_dash', 'unique:users,login,' . $this->route('user')];
            $this->rules['password'] = 'nullable';
        }

        return $this->rules;
    }
}
