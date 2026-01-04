<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'project_id' => $this->project_id,
            'project_title' => $this->project?->title,
            'title' => $this->title,
            'description' => $this->description,
            'status' => $this->status,
            'priority' => $this->priority,
            'due_date' => $this->due_date?->format('d M Y'),
            'assigned_to' => $this->assigned_to,
            'assigned_to_name' => $this->assignedTo?->name ?? null,
            'created_at' => $this->created_at?->format('d M Y, h:i A'),
        ];
    }
}
