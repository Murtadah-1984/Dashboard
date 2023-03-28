<?php

namespace App\Http\Requests\Store;

use App\Models\Role;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class StoreRoleRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => [
                'required',
                'unique:roles',
                'max:50',
            ],
            'display_name' => [
                'required',
                'unique:roles',
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
