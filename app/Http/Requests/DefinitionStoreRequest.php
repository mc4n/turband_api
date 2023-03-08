<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DefinitionStoreRequest extends FormRequest
{
    public function rules()
    {
        return [
            'definition' => 'bail|required|min:2|max:500',
            'example' => 'max:500',
            'word' => 'bail|required|min:2|max:150',
        ];
    }
}
