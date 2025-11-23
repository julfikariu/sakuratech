<?php
namespace App\Models;
use Spatie\Permission\Models\Permission as SpatiePermission;

class Permission extends SpatiePermission
{
     protected $fillable = [
        'name',
        'guard_name',
        'module_id',
        'permission_key',
        'icon',
        'order_id',
        'menu_item',
    ];

    protected $casts = [
        'menu_item' => 'boolean',
    ];

    /**
     * Get the module that owns the permission.
     */
    public function module()
    {
        return $this->belongsTo(Module::class);
    }
}
