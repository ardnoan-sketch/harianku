<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * Idempotent: aman dipanggil berulang (mis. php artisan db:seed --class=MenuSeeder)
     * karena setiap baris dipetakan lewat module + url_or_route yang unik.
     */
    public function run(): void
    {
        $menus = [
            // Admin Module
            [
                'keys' => ['module' => 'admin', 'url_or_route' => 'admin.dashboard'],
                'attributes' => ['name' => 'Dashboard', 'icon_type' => 'class', 'icon_value' => 'bx bx-home-alt', 'order_no' => 1],
            ],
            [
                'keys' => ['module' => 'admin', 'url_or_route' => 'admin.users.index'],
                'attributes' => ['name' => 'User Management', 'icon_type' => 'class', 'icon_value' => 'bx bx-user-circle', 'order_no' => 2],
            ],
            [
                'keys' => ['module' => 'admin', 'url_or_route' => 'admin.modules.index'],
                'attributes' => ['name' => 'Module Management', 'icon_type' => 'class', 'icon_value' => 'bx bx-package', 'order_no' => 3],
            ],
            [
                'keys' => ['module' => 'admin', 'url_or_route' => 'admin.menus.index'],
                'attributes' => ['name' => 'Menu Management', 'icon_type' => 'class', 'icon_value' => 'bx bx-list-ul', 'order_no' => 4],
            ],
            [
                'keys' => ['module' => 'admin', 'url_or_route' => 'admin.theme-modes.index'],
                'attributes' => ['name' => 'Tema & Warna', 'icon_type' => 'class', 'icon_value' => 'bx bx-palette', 'order_no' => 5],
            ],

            // Finance Module
            [
                'keys' => ['module' => 'finance', 'url_or_route' => 'finance.dashboard'],
                'attributes' => ['name' => 'Dashboard', 'icon_type' => 'class', 'icon_value' => 'bx bx-pie-chart-alt-2', 'order_no' => 1],
            ],
            [
                'keys' => ['module' => 'finance', 'url_or_route' => 'finance.categories.index'],
                'attributes' => ['name' => 'Kategori', 'icon_type' => 'class', 'icon_value' => 'bx bx-category', 'order_no' => 2],
            ],
            [
                'keys' => ['module' => 'finance', 'url_or_route' => 'finance.transactions.index'],
                'attributes' => ['name' => 'Transaksi', 'icon_type' => 'class', 'icon_value' => 'bx bx-transfer', 'order_no' => 3],
            ],

            // HRD Module
            [
                'keys' => ['module' => 'hrd', 'url_or_route' => 'hrd.dashboard'],
                'attributes' => ['name' => 'Dashboard', 'icon_type' => 'class', 'icon_value' => 'bx bx-bar-chart-square', 'order_no' => 1],
            ],
            [
                'keys' => ['module' => 'hrd', 'url_or_route' => 'hrd.employees.index'],
                'attributes' => ['name' => 'Data Karyawan', 'icon_type' => 'class', 'icon_value' => 'bx bx-id-card', 'order_no' => 2],
            ],
        ];


        foreach ($menus as $row) {
            Menu::updateOrCreate($row['keys'], $row['attributes']);
        }
    }
}
