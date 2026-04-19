<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ThemeMode extends Model
{
    protected $table = 'ar_theme_modes';

    protected $fillable = [
        'slug',
        'name',
        'description',
        'sort_order',
        'is_active',
        'is_user_selectable',
        'css_tokens',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'is_user_selectable' => 'boolean',
            'css_tokens' => 'array',
        ];
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'theme_mode_id');
    }

    public static function defaultSlug(): string
    {
        return static::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->value('slug') ?? 'light';
    }

    public static function selectableQuery()
    {
        return static::query()
            ->where('is_active', true)
            ->where('is_user_selectable', true)
            ->orderBy('sort_order');
    }
}
