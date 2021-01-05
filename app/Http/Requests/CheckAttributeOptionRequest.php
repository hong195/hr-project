<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckAttributeOptionRequest extends AbstractRequest
{
    public function authorize() : bool
    {
        return true;
    }

    public function rules() : array
    {
        return [
            'check_attribute_id' => 'required',
            'name' => ['required', 'alpha'],
            'label'=> ['required', 'alpha'],
            'value' => ['nullable'],
            'description' => ['nullable']
        ];
    }
}
