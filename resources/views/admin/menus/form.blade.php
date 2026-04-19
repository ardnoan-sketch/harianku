@php
    $isEdit     = isset($menu);
    $action     = $isEdit ? route('admin.menus.update', $menu->id) : route('admin.menus.store');
    $method     = $isEdit ? 'PUT' : null;
    $pageTitle  = $isEdit ? "Edit Menu: {$menu->name}" : 'Add New Menu';
    $breadLast  = $isEdit ? 'Edit' : 'Add New';
    $submitLabel = $isEdit ? 'Update Menu' : 'Save Menu';
@endphp
<x-app-layout>
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <x-ui.page-header :title="$pageTitle" :breadcrumbs="['Administrator', ['label' => 'Menus', 'url' => route('admin.menus.index')], $breadLast]" />
            <x-form :action="$action" :method="$method" cancelRoute="{{ route('admin.menus.index') }}" :submitLabel="$submitLabel">
                <div x-data="{ iconType: '{{ $menu->icon_type ?? 'class' }}' }" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="col-span-1">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Menu Name <span class="text-red-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name', $menu->name ?? '') }}" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                    </div>
                    <div class="col-span-1">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Route Name or URL</label>
                        <input type="text" name="url_or_route" value="{{ old('url_or_route', $menu->url_or_route ?? '') }}" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="admin.dashboard">
                    </div>
                    <div class="col-span-1">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Module <span class="text-red-500">*</span></label>
                        <input type="text" name="module" value="{{ old('module', $menu->module ?? '') }}" list="moduleList" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required placeholder="Type a new module name or select existing">
                        <datalist id="moduleList">
                            @foreach($modules as $mod)
                                <option value="{{ $mod }}">
                            @endforeach
                        </datalist>
                        <p class="text-xs text-gray-500 mt-1">💡 Type a new module name to auto-create it, or pick one from the list.</p>
                    </div>
                    <div class="col-span-1">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Parent Menu (Optional)</label>
                        <select name="parent_id" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="">-- Root Menu --</option>
                            @foreach($parents as $p)
                                <option value="{{ $p->id }}" {{ isset($menu) && $menu->parent_id == $p->id ? 'selected' : '' }}>{{ $p->name }} ({{ $p->module }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-span-1">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Icon Type <span class="text-red-500">*</span></label>
                        <select name="icon_type" x-model="iconType" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                            <option value="class">CSS Class (Boxicons / FontAwesome)</option>
                            <option value="image">Upload Internal Image</option>
                        </select>
                    </div>
                    <div class="col-span-1" x-show="iconType === 'class'">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Icon Class Name</label>
                        <input type="text" name="icon_value" value="{{ old('icon_value', (isset($menu) && $menu->icon_type === 'class') ? $menu->icon_value : '') }}" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="bx bx-home">
                    </div>
                    <div class="col-span-1" x-show="iconType === 'image'" style="display: none;">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Upload Icon Image{{ isset($menu) ? ' (Leave blank to keep current)' : '' }}</label>
                        @if(isset($menu) && $menu->icon_type == 'image' && $menu->icon_value)
                            <div class="mb-2">
                                <img src="{{ Storage::url($menu->icon_value) }}" class="w-10 h-10 object-contain border rounded bg-gray-50">
                            </div>
                        @endif
                        <input type="file" name="icon_image" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" accept="image/*">
                    </div>
                    <div class="col-span-1">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Permission Requirement (Optional)</label>
                        <select name="permission_name" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="">-- Free Access (If Role Matches) --</option>
                            @foreach($permissions as $perm)
                                <option value="{{ $perm->name }}" {{ isset($menu) && $menu->permission_name == $perm->name ? 'selected' : '' }}>{{ $perm->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-span-1">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Order <span class="text-red-500">*</span></label>
                        <input type="number" name="order_no" value="{{ old('order_no', $menu->order_no ?? 0) }}" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                    </div>
                </div>
            </x-form>
        </div>
    </div>
</x-app-layout>
