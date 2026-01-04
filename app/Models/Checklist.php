<?php

namespace App\Models;

use App\Models\Task;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Model;

class Checklist extends Model
{
    protected $fillable = ['task_id', 'title'];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}
