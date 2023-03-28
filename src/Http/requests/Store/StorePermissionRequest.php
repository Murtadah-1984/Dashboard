<?php

namespace App\Http\Requests\Store;

use App\Models\Role;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class StorePermissionRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('add_permissions');
    }

    public function rules()
    {
        return [
            'key' => [
                'required',
                'unique:permissions',
                'max:80',
            ],
            'table_name' => [
                'required',
                'max:50',
            ],
        ];
    }
}
