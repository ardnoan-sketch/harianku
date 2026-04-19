<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        $menus = \App\Models\Menu::with('parent')->orderBy('module')->orderBy('order_no')->paginate(5);
        return view('admin.menus.index', compact('menus'));
    }

    public function create()
    {
        $parents = \App\Models\Menu::whereNull('parent_id')->get();
        $permissions = \Spatie\Permission\Models\Permission::all();
        $modules = \App\Models\Menu::select('module')->distinct()->orderBy('module')->pluck('module');
        return view('admin.menus.form', compact('parents', 'permissions', 'modules'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'url_or_route' => 'nullable|string|max:255',
            'icon_type' => 'required|in:class,image',
            'icon_value' => 'nullable|string|max:255',
            'icon_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'parent_id' => 'nullable|exists:ar_menus,id',
            'module' => 'required|string|max:50',
            'permission_name' => 'nullable|string|exists:ar_permissions,name',
            'order_no' => 'required|integer'
        ]);

        if ($request->icon_type === 'image' && $request->hasFile('icon_image')) {
            $path = $request->file('icon_image')->store('menu_icons', 'public');
            $validated['icon_value'] = $path;
        }

        \App\Models\Menu::create($validated);

        return redirect()->route('admin.menus.index')->with('success', 'Menu created successfully.');
    }

    public function edit(\App\Models\Menu $menu)
    {
        $parents = \App\Models\Menu::whereNull('parent_id')->where('id', '!=', $menu->id)->get();
        $permissions = \Spatie\Permission\Models\Permission::all();
        $modules = \App\Models\Menu::select('module')->distinct()->orderBy('module')->pluck('module');
        return view('admin.menus.form', compact('menu', 'parents', 'permissions', 'modules'));
    }

    public function update(Request $request, \App\Models\Menu $menu)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'url_or_route' => 'nullable|string|max:255',
            'icon_type' => 'required|in:class,image',
            'icon_value' => 'nullable|string|max:255',
            'icon_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'parent_id' => 'nullable|exists:ar_menus,id',
            'module' => 'required|string|max:50',
            'permission_name' => 'nullable|string|exists:ar_permissions,name',
            'order_no' => 'required|integer'
        ]);

        if ($request->icon_type === 'image' && $request->hasFile('icon_image')) {
            // Delete old if exists
            if ($menu->icon_type === 'image' && $menu->icon_value) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($menu->icon_value);
            }
            $path = $request->file('icon_image')->store('menu_icons', 'public');
            $validated['icon_value'] = $path;
        }

        $menu->update($validated);

        return redirect()->route('admin.menus.index')->with('success', 'Menu updated successfully.');
    }

    public function destroy(\App\Models\Menu $menu)
    {
        if ($menu->icon_type === 'image' && $menu->icon_value) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($menu->icon_value);
        }
        $menu->delete();
        return redirect()->route('admin.menus.index')->with('success', 'Menu deleted successfully.');
    }
}
