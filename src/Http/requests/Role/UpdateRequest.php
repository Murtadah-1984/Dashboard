<?php

namespace App\Http\Requests\Role;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;
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
                'required',
                'max:50',
                Rule::unique('roles')->ignore(request()->id),
            ],
            'display_name' => [
                'required',
                Rule::unique('roles')->ignore(request()->id),
                'max:50',
            ],
            'permissions.*' => [
                'integer',
            ],
            'permissions' => [
                'required',
                'array',
            ],

        ];
    }
}
