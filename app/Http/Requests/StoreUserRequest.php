<?php

namespace App\Http\Requests;

use App\Models\User;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreUserRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->user()->checkPermission('user_create');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
            ],
            'email' => [
                'required',
                'unique:users',
            ],
            'sell_do_user_id' => [
               'string'
            ],
            'password' => [
                'required',
            ],
            'user_type' => [
                'required',
            ],
            'contact_number_1' => [
                'string',
                'nullable',
            ],
            'contact_number_2' => [
                'string',
                'nullable',
            ],
            'website' => [
                'string',
                'nullable',
            ],
        ];
    }
}
