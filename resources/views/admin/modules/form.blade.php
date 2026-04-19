@php
    $isEdit      = isset($module);
    $action      = $isEdit ? route('admin.modules.update', $module->id) : route('admin.modules.store');
    $method      = $isEdit ? 'PUT' : null;
    $pageTitle   = $isEdit ? "Edit Module: {$module->label}" : 'Add New Module';
    $breadLast   = $isEdit ? 'Edit' : 'Add New';
    $submitLabel = $isEdit ? 'Update Module' : 'Save Module';
@endphp
<x-app-layout>
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <x-ui.page-header :title="$pageTitle" :breadcrumbs="['Administrator', ['label' => 'Modules', 'url' => route('admin.modules.index')], $breadLast]" />
            <x-form :action="$action" :method="$method" cancelRoute="{{ route('admin.modules.index') }}" :submitLabel="$submitLabel">
                @if(!$isEdit)
                    <p class="text-sm text-gray-500 mb-6 border-b pb-4">Once saved, the module will appear on the Portal. Make sure its <strong>Entry Route</strong> is registered in <code>routes/web.php</code>.</p>
                @endif
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="col-span-1">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Module Key Name <span class="text-red-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name', $module->name ?? '') }}" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required placeholder="hrd" pattern="[a-z_]+" title="Lowercase letters and underscores only">
                        <p class="text-xs text-gray-400 mt-1">Lowercase &amp; underscores only. e.g. <code>hrd</code>, <code>inventory</code></p>
                    </div>
                    <div class="col-span-1">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Label (shown on Portal) <span class="text-red-500">*</span></label>
                        <input type="text" name="label" value="{{ old('label', $module->label ?? '') }}" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required placeholder="Human Resource">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                        <input type="text" name="description" value="{{ old('description', $module->description ?? '') }}" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Manage employees, attendance, and payroll">
                    </div>
                    <div class="col-span-1">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Icon Class (Boxicons)</label>
                        <input type="text" name="icon_class" value="{{ old('icon_class', $module->icon_class ?? 'bx bx-cube') }}" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="bx bx-cube">
                    </div>
                    <div class="col-span-1">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Entry Route Name <span class="text-red-500">*</span></label>
                        <input type="text" name="entry_route" value="{{ old('entry_route', $module->entry_route ?? '') }}" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required placeholder="hrd.dashboard">
                        <p class="text-xs text-gray-400 mt-1">Laravel route name (must exist in web.php)</p>
                    </div>
                    <div class="col-span-1">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Gradient Color - Start</label>
                        <input type="text" name="color_from" value="{{ old('color_from', $module->color_from ?? 'from-blue-500') }}" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="from-blue-500">
                    </div>
                    <div class="col-span-1">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Gradient Color - End</label>
                        <input type="text" name="color_to" value="{{ old('color_to', $module->color_to ?? 'to-blue-700') }}" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="to-blue-700">
                    </div>
                    <div class="col-span-1">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Required Role</label>
                        <select name="required_role" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="">-- Open to All Users --</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->name }}" {{ isset($module) && $module->required_role == $role->name ? 'selected' : '' }}>{{ $role->name }}</option>
                            @endforeach
                        </select>
                        <p class="text-xs text-gray-400 mt-1">Admins always have access to all modules</p>
                    </div>
                    <div class="col-span-1">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Order</label>
                        <input type="number" name="order_no" value="{{ old('order_no', $module->order_no ?? 0) }}" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>
                    <div class="md:col-span-2 mt-2">
                        <div class="flex items-center gap-3">
                            <input type="checkbox" name="is_active" id="is_active" value="1" {{ !$isEdit || $module->is_active ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                            <label for="is_active" class="text-sm font-medium text-gray-700">Active Module (shown on Portal)</label>
                        </div>
                    </div>
                </div>
            </x-form>
        </div>
    </div>
</x-app-layout>
