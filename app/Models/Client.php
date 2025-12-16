<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model
{
    protected $fillable = [
        'user_id',
        'company_name',
        'phone',
        'address',
        'website',
    ];

    /**
     * Get the projects for the client.
     * 
     * @return HasMany
     */
    public function projects()
    {
        return $this->hasMany(Project::class);
    }
}
