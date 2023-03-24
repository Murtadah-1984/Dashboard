<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;


class MassForceDeleteRequest extends FormRequest
{
    public function authorize(Request $request)
    {
        return Gate::allows("forceDelete_".$request->slug);
    }

    public function rules(Request $request)
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => "exists:$request->slug,id",
        ];
    }
}
