<?php

namespace App\Http\Requests\Admin\Task;

use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() != null;
    }

    public function rules(): array
    {
        return [
            'project_id' => ['nullable', 'exists:projects,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            // 'status' => ['required', 'string', 'in:open,in_progress,closed'],
            'priority' => ['nullable', 'string', 'in:low,medium,high'],
            'due_date' => ['nullable', 'date'],
            'assigned_to' => ['nullable', 'exists:users,id'],
        ];
    }

    protected function prepareForValidation(): void
    {
        // normalize status and priority
        if ($this->has('status')) {
            $this->merge(['status' => strtolower($this->input('status'))]);
        }
        if ($this->has('priority')) {
            $this->merge(['priority' => strtolower($this->input('priority'))]);
        }
    }
}
