<?php

namespace App\Http\Requests\Admin\Client;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ClientRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
  
        return [
            'company_name'=>['required', 'string', 'max:255'],
            'email'=>['required', 'string', 'email', 'max:255', 
                Rule::unique('users', 'email')->ignore($this->client->id ?? null)
            ],
            'name'=>['required', 'string'],
            'phone'=>['nullable', 'string'],
            'address'=>['nullable', 'string'],
            'website'=>['nullable', 'string'],
            'status'=>['required', 'in:Active,Inactive'],
            'password'=>[$this->isMethod('post') ? 'required' : 'nullable', 'string', 'min:8'],            
        ];
    }

    /**
     * Get custom error messages for validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Please enter name.',
        ];
    }
}
