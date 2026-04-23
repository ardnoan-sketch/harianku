<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Module;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class ManagementController extends Controller
{
    public function index(Request $request)
    {
        $modules = Module::orderBy('order_no')->paginate(10, ['*'], 'modules_page');
        $menus = Menu::with(['children', 'parent'])
            ->orderBy('module')
            ->orderBy('order_no')
            ->get();
        
        $menuCount = $menus->count();
        $selectedModule = $request->get('module');
        $defaultTab = $request->get('tab', 'modules');
        
        // Roles data
        $roles = Role::withCount('permissions')->paginate(10, ['*'], 'roles_page');
        
        return view('admin.management.index', compact(
            'modules', 
            'menus', 
            'menuCount', 
            'selectedModule',
            'defaultTab',
            'roles'
        ));
    }

    // Module routes - delegate to ModuleController
    public function moduleCreate()
    {
        return app(ModuleController::class)->create();
    }

    public function moduleStore(Request $request)
    {
        return app(ModuleController::class)->store($request);
    }

    public function moduleEdit(Module $module)
    {
        $permissions = \Spatie\Permission\Models\Permission::all()->groupBy(function ($permission) {
            $parts = explode('.', $permission->name);
            return $parts[0] ?? 'other';
        });
        return view('admin.management.module-form', compact('module', 'permissions'));
    }

    public function moduleUpdate(Request $request, Module $module)
    {
        return app(ModuleController::class)->update($request, $module);
    }

    public function moduleDestroy(Module $module)
    {
        return app(ModuleController::class)->destroy($module);
    }

    // Menu routes - delegate to MenuController
    public function menuCreate(Request $request)
    {
        $module = $request->get('module');
        $parents = Menu::whereNull('parent_id');
        if ($module) {
            $parents = $parents->where('module', $module);
        }
        $parents = $parents->get();
        
        $permissions = \Spatie\Permission\Models\Permission::all();
        $modules = Module::orderBy('order_no')->pluck('name');
        
        return view('admin.management.menu-form', compact('parents', 'permissions', 'modules', 'module'));
    }

    public function menuStore(Request $request)
    {
        return app(MenuController::class)->store($request);
    }

    public function menuEdit(Menu $menu)
    {
        $parents = Menu::whereNull('parent_id')
            ->where('id', '!=', $menu->id)
            ->where('module', $menu->module)
            ->get();
        $permissions = \Spatie\Permission\Models\Permission::all();
        $modules = Module::orderBy('order_no')->pluck('name');
        
        return view('admin.management.menu-form', compact('menu', 'parents', 'permissions', 'modules'));
    }

    public function menuUpdate(Request $request, Menu $menu)
    {
        return app(MenuController::class)->update($request, $menu);
    }

    public function menuDestroy(Menu $menu)
    {
        return app(MenuController::class)->destroy($menu);
    }

    // Role routes - delegate to RoleController
    public function roleCreate()
    {
        return app(RoleController::class)->create();
    }

    public function roleStore(Request $request)
    {
        return app(RoleController::class)->store($request);
    }

    public function roleEdit(Role $role)
    {
        return app(RoleController::class)->edit($role);
    }

    public function roleUpdate(Request $request, Role $role)
    {
        return app(RoleController::class)->update($request, $role);
    }

    public function roleDestroy(Role $role)
    {
        return app(RoleController::class)->destroy($role);
    }
}
