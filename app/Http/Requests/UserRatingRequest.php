<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRatingRequest extends AbstractRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() : bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() : array
    {
        return [
            'user_id' => ['required', 'integer'],
            'year' => ['required', 'integer'],
            'month' => ['required', 'integer'],
        ];
    }
}
