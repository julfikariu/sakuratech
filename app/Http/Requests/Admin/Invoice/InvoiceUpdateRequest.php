<?php

namespace App\Http\Requests\Admin\Invoice;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class InvoiceUpdateRequest extends FormRequest
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
            'issue_date'=>['required', 'date'],
            'due_date'=>['required', 'date', 'after_or_equal:issue_date'],
            'notes'=>['nullable', 'string'],        

            // Invoice items validation
            'items' => ['nullable', 'array'],
            'items.*.id' => ['nullable', 'integer', 'exists:invoice_items,id'],
            'items.*.description' => ['required', 'string'],
            'items.*.qty' => ['required', 'numeric', 'min:1'],
            'items.*.rate' => ['required', 'numeric', 'min:0'],
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
            'due_date.after_or_equal' => 'The due date must be a date after or equal to the issue date.',
            'items.*.description.required' => 'Each item must have a description.',
            'items.*.qty.required' => 'Each item must have a quantity.',
            'items.*.rate.required' => 'Each item must have a rate.',

        ];
    }
}
