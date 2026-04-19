<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    protected $table = 'ar_modules';

    protected $fillable = [
        'name', 'label', 'description', 'icon_class',
        'color_from', 'color_to', 'entry_route',
        'required_role', 'order_no', 'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Scope untuk mengambil modul aktif yang boleh diakses user.
     */
    public function scopeAccessibleBy($query, $user)
    {
        return $query->where('is_active', true)
            ->orderBy('order_no')
            ->get()
            ->filter(function ($module) use ($user) {
                if (!$module->required_role) return true;
                return $user->hasRole($module->required_role) || $user->hasRole('admin');
            });
    }
}
