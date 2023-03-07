<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRegisterRequest extends FormRequest
{
    public function rules()
    {
        return [
            'username' =>
            'bail|required|regex:/^(?=.{3,15}$)(?![_.])(?!.*[_.]{2})[a-zA-Z0-9._]+(?<![_.])$/u|unique:users',
            // 'email' => 'bail|required|string|email|unique:users',
            'password' => 'bail|required|min:8',
            'confirm_password' => 'bail|required|same:password',
        ];
    }

    function messages()
    {
        return [
            'username.regex' => __('validation.username.regex'),
            'confirm_password.same' => __('validation.confirm_password.same'),
        ];
    }
}
