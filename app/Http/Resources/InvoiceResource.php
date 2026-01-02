<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'inv_unique_id' => $this->inv_unique_id,      
            'client'        => $this->client?->company_name,
            'project'       => $this->project?->title,
            'invoice_id'    => $this->invoice_id,
            'amount'        => $this->amount,
            'issue_date'    => optional($this->issue_date)->format('d M Y'),
            'due_date'      => optional($this->due_date)->format('d M Y'),
            'notes'         => $this->notes,
            'status'        => $this->status,
            'created_at'    => optional($this->created_at)->format('d M Y, h:i A'),
        ];
    }
}
