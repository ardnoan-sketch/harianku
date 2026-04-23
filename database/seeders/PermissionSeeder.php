<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            // Admin Module Permissions
            ['name' => 'admin.dashboard.view', 'guard_name' => 'web', 'label' => 'View Admin Dashboard'],
            ['name' => 'admin.users.view', 'guard_name' => 'web', 'label' => 'View Users'],
            ['name' => 'admin.users.create', 'guard_name' => 'web', 'label' => 'Create User'],
            ['name' => 'admin.users.edit', 'guard_name' => 'web', 'label' => 'Edit User'],
            ['name' => 'admin.users.delete', 'guard_name' => 'web', 'label' => 'Delete User'],
            ['name' => 'admin.management.view', 'guard_name' => 'web', 'label' => 'View Access Management'],
            ['name' => 'admin.modules.view', 'guard_name' => 'web', 'label' => 'View Modules'],
            ['name' => 'admin.modules.create', 'guard_name' => 'web', 'label' => 'Create Module'],
            ['name' => 'admin.modules.edit', 'guard_name' => 'web', 'label' => 'Edit Module'],
            ['name' => 'admin.modules.delete', 'guard_name' => 'web', 'label' => 'Delete Module'],
            ['name' => 'admin.menus.view', 'guard_name' => 'web', 'label' => 'View Menus'],
            ['name' => 'admin.menus.create', 'guard_name' => 'web', 'label' => 'Create Menu'],
            ['name' => 'admin.menus.edit', 'guard_name' => 'web', 'label' => 'Edit Menu'],
            ['name' => 'admin.menus.delete', 'guard_name' => 'web', 'label' => 'Delete Menu'],
            ['name' => 'admin.roles.view', 'guard_name' => 'web', 'label' => 'View Roles'],
            ['name' => 'admin.roles.create', 'guard_name' => 'web', 'label' => 'Create Role'],
            ['name' => 'admin.roles.edit', 'guard_name' => 'web', 'label' => 'Edit Role'],
            ['name' => 'admin.roles.delete', 'guard_name' => 'web', 'label' => 'Delete Role'],
            ['name' => 'admin.themes.view', 'guard_name' => 'web', 'label' => 'View Themes'],
            ['name' => 'admin.themes.create', 'guard_name' => 'web', 'label' => 'Create Theme'],
            ['name' => 'admin.themes.edit', 'guard_name' => 'web', 'label' => 'Edit Theme'],
            ['name' => 'admin.themes.delete', 'guard_name' => 'web', 'label' => 'Delete Theme'],

            // Finance Module Permissions
            ['name' => 'finance.dashboard.view', 'guard_name' => 'web', 'label' => 'View Finance Dashboard'],
            ['name' => 'finance.transactions.view', 'guard_name' => 'web', 'label' => 'View Transactions'],
            ['name' => 'finance.transactions.create', 'guard_name' => 'web', 'label' => 'Create Transaction'],
            ['name' => 'finance.transactions.edit', 'guard_name' => 'web', 'label' => 'Edit Transaction'],
            ['name' => 'finance.transactions.delete', 'guard_name' => 'web', 'label' => 'Delete Transaction'],
            ['name' => 'finance.categories.view', 'guard_name' => 'web', 'label' => 'View Categories'],
            ['name' => 'finance.categories.create', 'guard_name' => 'web', 'label' => 'Create Category'],
            ['name' => 'finance.categories.edit', 'guard_name' => 'web', 'label' => 'Edit Category'],
            ['name' => 'finance.categories.delete', 'guard_name' => 'web', 'label' => 'Delete Category'],
            ['name' => 'finance.export', 'guard_name' => 'web', 'label' => 'Export Finance Data'],

            // HRD Module Permissions
            ['name' => 'hrd.dashboard.view', 'guard_name' => 'web', 'label' => 'View HRD Dashboard'],
            ['name' => 'hrd.employees.view', 'guard_name' => 'web', 'label' => 'View Employees'],
            ['name' => 'hrd.employees.create', 'guard_name' => 'web', 'label' => 'Create Employee'],
            ['name' => 'hrd.employees.edit', 'guard_name' => 'web', 'label' => 'Edit Employee'],
            ['name' => 'hrd.employees.delete', 'guard_name' => 'web', 'label' => 'Delete Employee'],

            // Productivity Module Permissions
            ['name' => 'productivity.myday.view', 'guard_name' => 'web', 'label' => 'View My Day'],
            ['name' => 'productivity.myday.manage', 'guard_name' => 'web', 'label' => 'Manage My Day Tasks'],
            ['name' => 'productivity.calendar.view', 'guard_name' => 'web', 'label' => 'View Calendar'],
            ['name' => 'productivity.quests.view', 'guard_name' => 'web', 'label' => 'View Quests'],
            ['name' => 'productivity.quests.create', 'guard_name' => 'web', 'label' => 'Create Quest'],
            ['name' => 'productivity.quests.edit', 'guard_name' => 'web', 'label' => 'Edit Quest'],
            ['name' => 'productivity.quests.delete', 'guard_name' => 'web', 'label' => 'Delete Quest'],
            ['name' => 'productivity.notes.view', 'guard_name' => 'web', 'label' => 'View Notes'],
            ['name' => 'productivity.notes.create', 'guard_name' => 'web', 'label' => 'Create Note'],
            ['name' => 'productivity.notes.edit', 'guard_name' => 'web', 'label' => 'Edit Note'],
            ['name' => 'productivity.notes.delete', 'guard_name' => 'web', 'label' => 'Delete Note'],
            ['name' => 'productivity.notebooks.view', 'guard_name' => 'web', 'label' => 'View Notebooks'],
            ['name' => 'productivity.notebooks.create', 'guard_name' => 'web', 'label' => 'Create Notebook'],
            ['name' => 'productivity.notebooks.edit', 'guard_name' => 'web', 'label' => 'Edit Notebook'],
            ['name' => 'productivity.notebooks.delete', 'guard_name' => 'web', 'label' => 'Delete Notebook'],
            ['name' => 'productivity.notebooks.items.manage', 'guard_name' => 'web', 'label' => 'Manage Notebook Items'],
        ];

        foreach ($permissions as $permission) {
            $perm = Permission::firstOrCreate(
                ['name' => $permission['name'], 'guard_name' => $permission['guard_name']]
            );
            // Update label if provided
            if (isset($permission['label'])) {
                $perm->label = $permission['label'];
                $perm->save();
            }
        }
    }
}
