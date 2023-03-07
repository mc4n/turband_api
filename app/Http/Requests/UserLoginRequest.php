<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserLoginRequest extends FormRequest
{
    public function rules()
    {
        return [
            'username' =>
            'bail|required|regex:/^(?=.{3,15}$)(?![_.])(?!.*[_.]{2})[a-zA-Z0-9._]+(?<![_.])$/u',
            'password' =>
            'bail|required|min:8',
        ];
    }
}
