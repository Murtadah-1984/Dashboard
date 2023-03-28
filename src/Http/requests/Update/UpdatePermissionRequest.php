<?php

namespace App\Http\Requests\Update;

use App\Models\Role;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

class UpdatePermissionRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('edit_permissions');
    }

    public function rules()
    {
        return [
            'key' => [
                'required',
                Rule::unique('permissions')->ignore(request()->id),
                'max:80',
            ],
            'table_name' => [
                'required',
                'max:60',
            ],
        ];
    }
}
