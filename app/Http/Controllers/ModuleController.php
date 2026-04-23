<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ModuleController extends Controller
{
    protected $rules = [
        'name'                => 'required|string|max:50|regex:/^[a-z_]+$/',
        'label'               => 'required|string|max:100',
        'description'         => 'nullable|string|max:255',
        'icon_class'          => 'nullable|string|max:100',
        'color_from'          => 'required|string|max:100',
        'color_to'            => 'required|string|max:100',
        'entry_route'         => 'required|string|max:100',
        'required_permission' => 'nullable|string|max:100',
        'order_no'            => 'required|integer',
        'is_active'           => 'boolean',
    ];

    public function index()
    {
        $modules = \App\Models\Module::orderBy('order_no')->paginate(5);
        return view('admin.modules.index', compact('modules'));
    }

    public function create()
    {
        $permissions = \Spatie\Permission\Models\Permission::all()->groupBy(function ($permission) {
            $parts = explode('.', $permission->name);
            return $parts[0] ?? 'other';
        });
        return view('admin.modules.form', compact('permissions'));
    }

    public function store(\Illuminate\Http\Request $request)
    {
        $validated = $request->validate($this->rules);
        $validated['is_active'] = $request->has('is_active');
        \App\Models\Module::create($validated);
        return redirect()->route('admin.management.index', ['tab' => 'modules'])->with('success', 'Modul berhasil ditambahkan!');
    }

    public function edit(\App\Models\Module $module)
    {
        $permissions = \Spatie\Permission\Models\Permission::all()->groupBy(function ($permission) {
            $parts = explode('.', $permission->name);
            return $parts[0] ?? 'other';
        });
        return view('admin.modules.form', compact('module', 'permissions'));
    }

    public function update(\Illuminate\Http\Request $request, \App\Models\Module $module)
    {
        $rules = $this->rules;
        $rules['name'] = 'required|string|max:50|regex:/^[a-z_]+$/|unique:ar_modules,name,' . $module->id;
        $validated = $request->validate($rules);
        $validated['is_active'] = $request->has('is_active');
        $module->update($validated);
        return redirect()->route('admin.management.index', ['tab' => 'modules'])->with('success', 'Modul berhasil diupdate!');
    }

    public function destroy(\App\Models\Module $module)
    {
        $module->delete();
        return redirect()->route('admin.management.index', ['tab' => 'modules'])->with('success', 'Modul berhasil dihapus!');
    }
}
