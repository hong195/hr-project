<?php

namespace App\Http\Requests;

class UserRatingRequest extends AbstractRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'ratingYear' => ['required', 'integer'],
            'ratingMonth' => ['required', 'integer'],
            'userId' => ['nullable', 'integer'],
            'perPage' => ['integer', 'nullable'],
            'page' => ['integer', 'nullable'],
        ];
    }
}
