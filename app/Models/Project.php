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

    /**
     * Get the client that owns the project.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }
}
