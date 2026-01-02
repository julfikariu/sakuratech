<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'user_id', 'name', 'path', 'size',
        'type', 'uploaded_at', 'attachable_id', 'attachable_type'
    ];

    protected $appends = ['url'];

    public function attachable()
    {
        return $this->morphTo();
    }

    // Get full URL
    public function getUrlAttribute()
    {
        return asset('storage/' . $this->path);
    }
}   
