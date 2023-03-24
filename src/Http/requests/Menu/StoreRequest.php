<?php

namespace App\Http\Requests\Menu;

use App\Models\Role;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class StoreRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('add_menus');
    }

    public function rules()
    {
        return [
            'title' => [
                'required',
                'unique:menus',
                'max:80',
            ],
            'route' => [
                'required',
                'unique:menus',
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
