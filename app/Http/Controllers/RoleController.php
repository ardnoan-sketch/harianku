<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::withCount('permissions')->paginate(10);
        return view('admin.roles.index', compact('roles'));
    }

    public function create()
    {
        $permissions = Permission::all()->groupBy(function ($permission) {
            // Group by module prefix (e.g., 'admin.users.create' -> 'admin')
            $parts = explode('.', $permission->name);
            return $parts[0] ?? 'other';
        });
        return view('admin.roles.form', compact('permissions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50|unique:ar_roles,name',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:ar_permissions,name',
        ]);

        $role = Role::create(['name' => $validated['name']]);

        if (!empty($validated['permissions'])) {
            $role->syncPermissions($validated['permissions']);
        }

        return redirect()->route('admin.management.index', ['tab' => 'roles'])
            ->with('success', 'Role created successfully.');
    }

    public function edit(Role $role)
    {
        $permissions = Permission::all()->groupBy(function ($permission) {
            $parts = explode('.', $permission->name);
            return $parts[0] ?? 'other';
        });
        $rolePermissions = $role->permissions->pluck('name')->toArray();
        return view('admin.roles.form', compact('role', 'permissions', 'rolePermissions'));
    }

    public function update(Request $request, Role $role)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50|unique:ar_roles,name,' . $role->id,
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:ar_permissions,name',
        ]);

        $role->update(['name' => $validated['name']]);

        if (!empty($validated['permissions'])) {
            $role->syncPermissions($validated['permissions']);
        } else {
            $role->syncPermissions([]);
        }

        return redirect()->route('admin.management.index', ['tab' => 'roles'])
            ->with('success', 'Role updated successfully.');
    }

    public function destroy(Role $role)
    {
        // Prevent deleting admin role if it's the only admin role
        if ($role->name === 'admin') {
            $adminCount = Role::where('name', 'admin')->count();
            if ($adminCount <= 1) {
                return redirect()->route('admin.management.index', ['tab' => 'roles'])
                    ->with('error', 'Cannot delete the only admin role.');
            }
        }

        $role->delete();
        return redirect()->route('admin.management.index', ['tab' => 'roles'])
            ->with('success', 'Role deleted successfully.');
    }
}
