<?php

namespace App\Http\Requests\User;



use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;


class UpdateRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('edit_users');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
                Rule::unique('users')->ignore(request()->id),
            ],
            'email' => [
                'required',
                Rule::unique('users')->ignore(request()->id),
            ],
            'role_id' => [
                'required',
                'integer',
            ],
            'roles.*' => [
                'integer',
            ],
            'roles' => [
                'required',
                'array',
            ],
        ];
    }
}
