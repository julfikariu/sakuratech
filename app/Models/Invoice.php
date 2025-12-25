<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Invoice extends Model
{
    protected $table = 'invoices';

    protected $fillable = [
        'inv_unique_id',
        'client_id',
        'project_id',
        'amount',
        'status',
        'issue_date',
        'due_date',
        'terms',
        'notes',
    ];

    protected $casts = [
        'issue_date' => 'date',
        'due_date' => 'date',
    ];

    public function items()
    {
        return $this->hasMany(InvoiceItem::class, 'invoice_id');
    }
}
