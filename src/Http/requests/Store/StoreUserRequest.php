<?php

namespace App\Http\Requests\Store;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows('add_users');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'unique:users',
                'max:50',
            ],
            'email' => [
                'required',
                'unique:users',
                'max:250',
            ],
            'role_id' => [
                'required',
                'integer',
            ],
            'roles' => [
                'required',
                'array',
            ],
            'password' => [
                'required',
                'string',
                'min:6',
            ],
        ];
    }
}
