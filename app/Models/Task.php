<?php

namespace App\Models;

use App\Models\Comment;
use App\Models\Project;
use App\Models\Checklist;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'project_id', 'title', 'description', 'status', 'priority', 'due_date', 'assigned_to'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function checklists()
    {
        return $this->hasMany(Checklist::class);
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function assignedTo()
    {
        return $this->belongsTo(\App\Models\User::class, 'assigned_to');
    }

    protected $casts = [
        'due_date' => 'date',
    ];
}

