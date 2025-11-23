<?php

namespace App\Http\Requests\Admin\Permission;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PermissionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                Rule::unique('permissions', 'name')->ignore($this->permission->id ?? null),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Please enter permission name.',
        ];
    }
}
