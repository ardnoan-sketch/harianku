<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $menus = [
            [
                'keys' => ['module' => 'admin', 'url_or_route' => 'admin.dashboard'],
                'attributes' => ['name' => 'Dashboard', 'icon_type' => 'class', 'icon_value' => 'bx bxs-dashboard', 'order_no' => 1],
            ],
            [
                'keys' => ['module' => 'admin', 'url_or_route' => 'admin.users.index'],
                'attributes' => ['name' => 'User Management', 'icon_type' => 'class', 'icon_value' => 'bx bxs-user-account', 'order_no' => 2],
            ],
            [
                'keys' => ['module' => 'admin', 'url_or_route' => 'admin.menus.index'],
                'attributes' => ['name' => 'Menu Management', 'icon_type' => 'class', 'icon_value' => 'bx bx-menu', 'order_no' => 3],
            ],
            [
                'keys' => ['module' => 'admin', 'url_or_route' => 'admin.modules.index'],
                'attributes' => ['name' => 'Module Management', 'icon_type' => 'class', 'icon_value' => 'bx bx-package', 'order_no' => 4],
            ],
            [
                'keys' => ['module' => 'admin', 'url_or_route' => 'admin.theme-modes.index'],
                'attributes' => ['name' => 'Theme Management', 'icon_type' => 'class', 'icon_value' => 'bx bx-palette', 'order_no' => 5],
            ],

            // Finance Module
            [
                'keys' => ['module' => 'finance', 'url_or_route' => 'finance.dashboard'],
                'attributes' => ['name' => 'Dashboard', 'icon_type' => 'class', 'icon_value' => 'bx bxs-dashboard', 'order_no' => 1],
            ],
            [
                'keys' => ['module' => 'finance', 'url_or_route' => 'finance.transactions.index'],
                'attributes' => ['name' => 'Transactions', 'icon_type' => 'class', 'icon_value' => 'bx bx-transfer', 'order_no' => 2],
            ],
            [
                'keys' => ['module' => 'finance', 'url_or_route' => 'finance.categories.index'],
                'attributes' => ['name' => 'Categories', 'icon_type' => 'class', 'icon_value' => 'bx bx-category', 'order_no' => 3],
            ],

            // HRD Module
            [
                'keys' => ['module' => 'hrd', 'url_or_route' => 'hrd.dashboard'],
                'attributes' => ['name' => 'Dashboard', 'icon_type' => 'class', 'icon_value' => 'bx bxs-dashboard', 'order_no' => 1],
            ],
            [
                'keys' => ['module' => 'hrd', 'url_or_route' => 'hrd.employees.index'],
                'attributes' => ['name' => 'Data Karyawan', 'icon_type' => 'class', 'icon_value' => 'bx bx-id-card', 'order_no' => 2],
            ],

            // Productivity Module
            [
                'keys' => ['module' => 'productivity', 'url_or_route' => 'productivity.myday'],
                'attributes' => ['name' => 'My Day', 'icon_type' => 'class', 'icon_value' => 'bx bx-calendar-check', 'order_no' => 1],
            ],
            [
                'keys' => ['module' => 'productivity', 'url_or_route' => 'productivity.calendar'],
                'attributes' => ['name' => 'Calendar', 'icon_type' => 'class', 'icon_value' => 'bx bx-calendar', 'order_no' => 2],
            ],
            [
                'keys' => ['module' => 'productivity', 'url_or_route' => 'notes.index'],
                'attributes' => ['name' => 'Notes', 'icon_type' => 'class', 'icon_value' => 'bx bx-note', 'order_no' => 3],
            ],
            [
                'keys' => ['module' => 'productivity', 'url_or_route' => 'notebooks.index'],
                'attributes' => ['name' => 'Notebook', 'icon_type' => 'class', 'icon_value' => 'bx bx-book-content', 'order_no' => 4],
            ],
            [
                'keys' => ['module' => 'productivity', 'url_or_route' => 'productivity.quests.index'],
                'attributes' => ['name' => 'Quests', 'icon_type' => 'class', 'icon_value' => 'bx bx-target-lock', 'order_no' => 5],
            ],
        ];

        foreach ($menus as $menu) {
            Menu::updateOrCreate($menu['keys'], $menu['attributes']);
        }
    }
}
