<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $modules = [
            [
                'name'          => 'admin',
                'label'         => 'Administrator',
                'description'   => 'Kelola Pengguna, Role, Menu, dan Konfigurasi Sistem',
                'icon_class'    => 'bx bx-cog',
                'color_from'    => 'from-indigo-500',
                'color_to'      => 'to-purple-600',
                'entry_route'   => 'admin.dashboard',
                'required_role' => 'admin',
                'order_no'      => 1,
                'is_active'     => true,
            ],
            [
                'name'          => 'finance',
                'label'         => 'Finance (Harianku)',
                'description'   => 'Pencatatan Keuangan, Pemasukan & Pengeluaran Harian',
                'icon_class'    => 'bx bx-money',
                'color_from'    => 'from-green-500',
                'color_to'      => 'to-teal-600',
                'entry_route'   => 'finance.dashboard',
                'required_role' => 'finance',
                'order_no'      => 2,
                'is_active'     => true,
            ],
        ];

        foreach ($modules as $module) {
            \App\Models\Module::updateOrCreate(['name' => $module['name']], $module);
        }
    }
}
