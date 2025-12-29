<?php

namespace App\Http\Requests\Admin\Ticket;

use Illuminate\Foundation\Http\FormRequest;

class TicketRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'assignee_id' => ['nullable', 'exists:users,id'],
            'priority' => ['required', 'in:Low,Medium,High'],
            'status' => ['required', 'in:Open,Pending,Closed'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Please enter title.',
        ];
    }
}
