<?php

namespace App\Http\Requests\Update;

use App\Models\Role;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

class UpdateMenuRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('edit_permissions');
    }

    public function rules()
    {
        return [
            'title' => [
                'required',
                Rule::unique('menus')->ignore(request()->id),
                'max:80',
            ],
            'route' => [
                'required',
                Rule::unique('menus')->ignore(request()->id),
                'max:100',
            ],
            'policy' => [
                'required',
                'max:100',
            ],
            'class' => [
                'required',
                'max:100',
            ],
        ];
    }
}
