<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create Roles
        $adminRole = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'admin']);
        $financeRole = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'finance']);

        // Create Users and assign roles
        $adminUser = \App\Models\User::firstOrCreate(
            ['email' => 'admin@example.com'],
            ['name' => 'Administrator', 'password' => bcrypt('password')]
        );
        $adminUser->assignRole($adminRole);

        $financeUser = \App\Models\User::firstOrCreate(
            ['email' => 'finance@example.com'],
            ['name' => 'Finance Staff', 'password' => bcrypt('password')]
        );
        $financeUser->assignRole($financeRole);

        $superUser = \App\Models\User::firstOrCreate(
            ['email' => 'super@example.com'],
            ['name' => 'Super User', 'password' => bcrypt('password')]
        );
        $superUser->assignRole([$adminRole, $financeRole]);
    }
}
