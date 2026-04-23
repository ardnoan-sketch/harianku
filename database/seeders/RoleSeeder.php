<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

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
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $financeRole = Role::firstOrCreate(['name' => 'finance']);
        $hrdRole = Role::firstOrCreate(['name' => 'hrd']);

        // Assign all permissions to admin role
        $allPermissions = Permission::all();
        $adminRole->syncPermissions($allPermissions);

        // Assign finance permissions to finance role
        $financePermissions = Permission::where('name', 'like', 'finance.%')
            ->orWhere('name', 'like', 'productivity.%')
            ->get();
        $financeRole->syncPermissions($financePermissions);

        // Assign HRD permissions to hrd role
        $hrdPermissions = Permission::where('name', 'like', 'hrd.%')
            ->orWhere('name', 'like', 'productivity.%')
            ->get();
        $hrdRole->syncPermissions($hrdPermissions);

        // Create Users and assign roles
        $adminUser = \App\Models\User::firstOrCreate(
            ['email' => 'admin@example.com'],
            ['name' => 'Administrator', 'password' => \Illuminate\Support\Facades\Hash::make('password')]
        );
        $adminUser->assignRole($adminRole);

        $financeUser = \App\Models\User::firstOrCreate(
            ['email' => 'finance@example.com'],
            ['name' => 'Finance Staff', 'password' => \Illuminate\Support\Facades\Hash::make('password')]
        );
        $financeUser->assignRole($financeRole);

        $hrdUser = \App\Models\User::firstOrCreate(
            ['email' => 'hrd@example.com'],
            ['name' => 'HRD Staff', 'password' => \Illuminate\Support\Facades\Hash::make('password')]
        );
        $hrdUser->assignRole($hrdRole);

        $superUser = \App\Models\User::firstOrCreate(
            ['email' => 'super@example.com'],
            ['name' => 'Super User', 'password' => \Illuminate\Support\Facades\Hash::make('password')]
        );
        $superUser->assignRole([$adminRole, $financeRole, $hrdRole]);

    }
}
