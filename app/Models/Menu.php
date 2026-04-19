<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = 'ar_menus';

    protected $fillable = [
        'name',
        'url_or_route',
        'icon_type',
        'icon_value',
        'parent_id',
        'module',
        'permission_name',
        'order_no',
    ];

    public function children()
    {
        return $this->hasMany(Menu::class, 'parent_id')->orderBy('order_no');
    }

    public function parent()
    {
        return $this->belongsTo(Menu::class, 'parent_id');
    }
}
