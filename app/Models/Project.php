<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Project extends Model
{
    protected $table = 'projects';

    protected $fillable = [
        'title',
        'client_id',
        'type',
        'description',        
        'start_date',
        'deadline',
        'status',
        'progress',
    ];

    protected $casts = [
        'start_date' => 'date',
        'deadline' => 'date',
    ];
}
