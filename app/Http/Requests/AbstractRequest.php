<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

abstract class AbstractRequest extends FormRequest
{
    public function authorize(): bool
    {
        if ($this->user() && $this->user()->hasRole(['Admin', 'Editor'])) {
            return true;
        }

        return false;
    }

    abstract public function rules(): array;

    /**
     * Handle a failed validation attempt.
     *
     * @param Validator $validator
     * @throws ValidationException
     */
    protected function failedValidation(Validator $validator): void
    {
        throw new ValidationException(
            $validator,
            response()->json($validator->errors(), 422)
        );
    }

    public function isUpdating(): bool
    {
        return in_array($this->getMethod(), ['PUT', 'PATCH']);
    }
}
