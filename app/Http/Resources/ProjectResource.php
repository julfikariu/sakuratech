<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'           => $this->id,
            'title'        => $this->title,
            'client_id'    => $this->client_id,
            'client_name'  => $this->client->company_name ?? null,
            'type'         => $this->type,
            'description'  => $this->description,
            'start_date'   => $this->start_date?->format('d M Y'),
            'deadline'     => $this->deadline?->format('d M Y'),
            'status'       => $this->status,
            'created_at'   => $this->created_at?->format('d M Y, h:i A'),
        ];
    }
}
