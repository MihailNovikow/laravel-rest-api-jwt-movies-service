<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
class UserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => ['nullable', 'string'],
            'email' => ['nullable', 'string'],
            'username' => ['nullable', 'string'],
           'password' =>  ['nullable', 'string']
        ];
    }
}
