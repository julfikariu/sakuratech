<?php

namespace App\Http\Requests\Admin\Project;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProjectRequest extends FormRequest
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
            'title'=>['required', 'string', 'max:255'],
            'client_id'=>['required', 'exists:clients,id'],
            'type'=>['nullable', 'string', 'max:255'],
            'description'=>['nullable', 'string'],        
            'start_date'=>['nullable', 'date'],
            'deadline'=>['nullable', 'date', 'after_or_equal:start_date'],
            'progress_info'=>['nullable', 'integer', 'between:0,100'],
            'status'=>['required', 'in:Active,Completed,Pending'],
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
            'title.required' => 'Please enter title.',
        ];
    }
}
