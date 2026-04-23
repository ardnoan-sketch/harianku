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
            // Admin Module
            [
                'keys' => ['module' => 'admin', 'url_or_route' => 'admin.dashboard'],
                'attributes' => ['name' => 'Dashboard', 'icon_type' => 'class', 'icon_value' => 'bx bxs-dashboard', 'order_no' => 1, 'permission_name' => 'admin.dashboard.view'],
            ],
            [
                'keys' => ['module' => 'admin', 'url_or_route' => 'admin.users.index'],
                'attributes' => ['name' => 'User Management', 'icon_type' => 'class', 'icon_value' => 'bx bxs-user-account', 'order_no' => 2, 'permission_name' => 'admin.users.view'],
            ],
            [
                'keys' => ['module' => 'admin', 'url_or_route' => 'admin.management.index'],
                'attributes' => ['name' => 'Module & Menu Management', 'icon_type' => 'class', 'icon_value' => 'bx bx-sitemap', 'order_no' => 3, 'permission_name' => 'admin.management.view'],
            ],
            [
                'keys' => ['module' => 'admin', 'url_or_route' => 'admin.management.index'],
                'attributes' => ['name' => 'Roles & Permissions', 'icon_type' => 'class', 'icon_value' => 'bx bx-shield-alt', 'order_no' => 4, 'parent_id' => null, 'permission_name' => 'admin.roles.view'],
            ],
            [
                'keys' => ['module' => 'admin', 'url_or_route' => 'admin.theme-modes.index'],
                'attributes' => ['name' => 'Theme Management', 'icon_type' => 'class', 'icon_value' => 'bx bx-palette', 'order_no' => 5, 'permission_name' => 'admin.themes.view'],
            ],

            // Finance Module
            [
                'keys' => ['module' => 'finance', 'url_or_route' => 'finance.dashboard'],
                'attributes' => ['name' => 'Dashboard', 'icon_type' => 'class', 'icon_value' => 'bx bxs-dashboard', 'order_no' => 1, 'permission_name' => 'finance.dashboard.view'],
            ],
            [
                'keys' => ['module' => 'finance', 'url_or_route' => 'finance.transactions.index'],
                'attributes' => ['name' => 'Transactions', 'icon_type' => 'class', 'icon_value' => 'bx bx-transfer', 'order_no' => 2, 'permission_name' => 'finance.transactions.view'],
            ],
            [
                'keys' => ['module' => 'finance', 'url_or_route' => 'finance.categories.index'],
                'attributes' => ['name' => 'Categories', 'icon_type' => 'class', 'icon_value' => 'bx bx-category', 'order_no' => 3, 'permission_name' => 'finance.categories.view'],
            ],

            // HRD Module
            [
                'keys' => ['module' => 'hrd', 'url_or_route' => 'hrd.dashboard'],
                'attributes' => ['name' => 'Dashboard', 'icon_type' => 'class', 'icon_value' => 'bx bxs-dashboard', 'order_no' => 1, 'permission_name' => 'hrd.dashboard.view'],
            ],
            [
                'keys' => ['module' => 'hrd', 'url_or_route' => 'hrd.employees.index'],
                'attributes' => ['name' => 'Data Karyawan', 'icon_type' => 'class', 'icon_value' => 'bx bx-id-card', 'order_no' => 2, 'permission_name' => 'hrd.employees.view'],
            ],

            // Productivity Module
            [
                'keys' => ['module' => 'productivity', 'url_or_route' => 'productivity.myday'],
                'attributes' => ['name' => 'My Day', 'icon_type' => 'class', 'icon_value' => 'bx bx-calendar-check', 'order_no' => 1, 'permission_name' => 'productivity.myday.view'],
            ],
            [
                'keys' => ['module' => 'productivity', 'url_or_route' => 'productivity.calendar'],
                'attributes' => ['name' => 'Calendar', 'icon_type' => 'class', 'icon_value' => 'bx bx-calendar', 'order_no' => 2, 'permission_name' => 'productivity.calendar.view'],
            ],
            [
                'keys' => ['module' => 'productivity', 'url_or_route' => 'notes.index'],
                'attributes' => ['name' => 'Notes', 'icon_type' => 'class', 'icon_value' => 'bx bx-note', 'order_no' => 3, 'permission_name' => 'productivity.notes.view'],
            ],
            [
                'keys' => ['module' => 'productivity', 'url_or_route' => 'notebooks.index'],
                'attributes' => ['name' => 'Notebook', 'icon_type' => 'class', 'icon_value' => 'bx bx-book-content', 'order_no' => 4, 'permission_name' => 'productivity.notebooks.view'],
            ],
            [
                'keys' => ['module' => 'productivity', 'url_or_route' => 'productivity.quests.index'],
                'attributes' => ['name' => 'Quests', 'icon_type' => 'class', 'icon_value' => 'bx bx-target-lock', 'order_no' => 5, 'permission_name' => 'productivity.quests.view'],
            ],
        ];

        foreach ($menus as $menu) {
            Menu::updateOrCreate($menu['keys'], $menu['attributes']);
        }
    }
}
