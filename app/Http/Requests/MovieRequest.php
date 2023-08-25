<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
class MovieRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'tail' => ['required', 'string'],
            'date_from' => ['required', 'date_format:yyyy-mm-dd hh:mm'],
           'date_to' =>  ['required', 'date_format:yyyy-mm-dd hh:mm']
        ];
    }
}
