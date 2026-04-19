<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin Module Menus
        \App\Models\Menu::create([
            'name' => 'Dashboard',
            'url_or_route' => 'admin.dashboard',
            'icon_type' => 'class',
            'icon_value' => 'bx bx-home-alt',
            'module' => 'admin',
            'order_no' => 1
        ]);
        \App\Models\Menu::create([
            'name' => 'Menu Management',
            'url_or_route' => 'admin.menus.index',
            'icon_type' => 'class',
            'icon_value' => 'bx bx-list-ul',
            'module' => 'admin',
            'order_no' => 2
        ]);

        \App\Models\Menu::updateOrCreate(
            ['module' => 'admin', 'url_or_route' => 'admin.theme-modes.index'],
            [
                'name' => 'Mode Tema',
                'icon_type' => 'class',
                'icon_value' => 'bx bx-palette',
                'order_no' => 3,
            ]
        );

        // Finance Module Menus
        \App\Models\Menu::create([
            'name' => 'Dashboard',
            'url_or_route' => 'finance.dashboard',
            'icon_type' => 'class',
            'icon_value' => 'bx bx-pie-chart-alt-2',
            'module' => 'finance',
            'order_no' => 1
        ]);
    }
}
