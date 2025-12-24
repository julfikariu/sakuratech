<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class InvoiceItem extends Model
{
    protected $table = 'invoice_items';

    protected $fillable = [
        'invoice_id',
        'description',
        'price',
        'quantity',
        'total',
    ];

}
