<?php

namespace Database\Seeders;

use App\Models\ThemeMode;
use Illuminate\Database\Seeder;

class ThemeModeSeeder extends Seeder
{
    public function run(): void
    {
        $modes = [
            [
                'slug' => 'light',
                'name' => 'Light',
                'description' => 'Tampilan terang standar.',
                'sort_order' => 10,
                'is_active' => true,
                'is_user_selectable' => true,
                'css_tokens' => null,
            ],
            [
                'slug' => 'night',
                'name' => 'Night',
                'description' => 'Mode gelap untuk kerja malam.',
                'sort_order' => 20,
                'is_active' => true,
                'is_user_selectable' => true,
                'css_tokens' => null,
            ],
            [
                'slug' => 'retro',
                'name' => 'Retro Game',
                'description' => 'Nuansa pixel / arcade klasik.',
                'sort_order' => 30,
                'is_active' => true,
                'is_user_selectable' => true,
                'css_tokens' => null,
            ],
        ];

        foreach ($modes as $row) {
            ThemeMode::updateOrCreate(
                ['slug' => $row['slug']],
                $row
            );
        }
    }
}
