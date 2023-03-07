<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserPasswordChangeRequest extends FormRequest
{
    public function rules()
    {
        return [
            'password' => 'bail|required|min:8',
            'confirm_password' => 'bail|required|same:password',
        ];
    }
}
