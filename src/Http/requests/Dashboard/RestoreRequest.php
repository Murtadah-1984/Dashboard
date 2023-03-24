<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;


class RestoreRequest extends FormRequest
{
    public function authorize(Request $request)
    {
        return Gate::allows("restore_".$request->slug);
    }

    public function rules(Request $request)
    {
        return [
            'id'   => "required|integer|exists:$request->slug,id",
        ];
    }
}
