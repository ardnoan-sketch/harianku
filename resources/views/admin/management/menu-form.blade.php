@php
    $isEdit     = isset($menu);
    $action     = $isEdit ? route('admin.management.menus.update', $menu->id) : route('admin.management.menus.store');
    $method     = $isEdit ? 'PUT' : null;
    $pageTitle  = $isEdit ? "Edit Menu: {$menu->name}" : 'Add New Menu';
    $breadLast  = $isEdit ? 'Edit' : 'Add New';
    $submitLabel = $isEdit ? 'Update Menu' : 'Save Menu';
    $inputClass = 'form-input-theme';
    $selectedModule = $module ?? old('module', $menu->module ?? '');
@endphp
<x-app-layout>
    <x-ui.page-header :title="$pageTitle" :breadcrumbs="['Administrator', ['label' => 'Management', 'url' => route('admin.management.index', ['tab' => 'menus'])], $breadLast]" />

    <x-ui.page-container narrow padding="normal">
        <div class="card-theme p-6" x-data="{ iconType: '{{ $menu->icon_type ?? 'class' }}' }">
            <form action="{{ $action }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @if($method)
                    @method($method)
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Menu Name --}}
                    <div class="col-span-1">
                        <label class="block text-sm font-medium text-[var(--text-secondary)] mb-1">
                            Menu Name <span class="text-[var(--danger)]">*</span>
                        </label>
                        <input type="text" name="name" value="{{ old('name', $menu->name ?? '') }}" 
                               class="{{ $inputClass }}" required>
                    </div>

                    {{-- Route/URL --}}
                    <div class="col-span-1">
                        <label class="block text-sm font-medium text-[var(--text-secondary)] mb-1">
                            Route Name or URL
                        </label>
                        <input type="text" name="url_or_route" 
                               value="{{ old('url_or_route', $menu->url_or_route ?? '') }}" 
                               class="{{ $inputClass }}" placeholder="admin.dashboard">
                    </div>

                    {{-- Module --}}
                    <div class="col-span-1">
                        <label class="block text-sm font-medium text-[var(--text-secondary)] mb-1">
                            Module <span class="text-[var(--danger)]">*</span>
                        </label>
                        <select name="module" class="{{ $inputClass }}" required>
                            <option value="">-- Select Module --</option>
                            @foreach($modules as $mod)
                                <option value="{{ $mod }}" {{ $selectedModule === $mod ? 'selected' : '' }}>
                                    {{ $mod }}
                                </option>
                            @endforeach
                        </select>
                        <p class="text-xs text-[var(--text-muted)] mt-1">
                            Menu akan muncul di sidebar untuk modul ini
                        </p>
                    </div>

                    {{-- Parent Menu --}}
                    <div class="col-span-1">
                        <label class="block text-sm font-medium text-[var(--text-secondary)] mb-1">
                            Parent Menu (Optional)
                        </label>
                        <select name="parent_id" class="{{ $inputClass }}">
                            <option value="">-- Root Menu --</option>
                            @foreach($parents as $p)
                                @if(!$isEdit || $p->id !== $menu->id)
                                    <option value="{{ $p->id }}" {{ isset($menu) && $menu->parent_id == $p->id ? 'selected' : '' }}>
                                        {{ $p->name }} ({{ $p->module }})
                                    </option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    {{-- Icon Type --}}
                    <div class="col-span-1">
                        <label class="block text-sm font-medium text-[var(--text-secondary)] mb-1">
                            Icon Type <span class="text-[var(--danger)]">*</span>
                        </label>
                        <select name="icon_type" x-model="iconType" class="{{ $inputClass }}" required>
                            <option value="class">CSS Class (Boxicons)</option>
                            <option value="image">Upload Image</option>
                        </select>
                    </div>

                    {{-- Icon Class --}}
                    <div class="col-span-1" x-show="iconType === 'class'">
                        <label class="block text-sm font-medium text-[var(--text-secondary)] mb-1">
                            Icon Class Name
                        </label>
                        <input type="text" name="icon_value" 
                               value="{{ old('icon_value', (isset($menu) && $menu->icon_type === 'class') ? $menu->icon_value : '') }}" 
                               class="{{ $inputClass }}" placeholder="bx bx-home">
                    </div>

                    {{-- Icon Image --}}
                    <div class="col-span-1" x-show="iconType === 'image'" x-cloak>
                        <label class="block text-sm font-medium text-[var(--text-secondary)] mb-1">
                            Upload Icon Image{{ isset($menu) ? ' (Leave blank to keep current)' : '' }}
                        </label>
                        @if(isset($menu) && $menu->icon_type == 'image' && $menu->icon_value)
                            <div class="mb-2 p-2 bg-[var(--bg-body)] rounded-lg inline-block">
                                <img src="{{ Storage::url($menu->icon_value) }}" class="w-10 h-10 object-contain">
                            </div>
                        @endif
                        <input type="file" name="icon_image" class="{{ $inputClass }}" accept="image/*">
                        <input type="hidden" name="icon_value" :disabled="iconType !== 'image'" value="{{ old('icon_value', (isset($menu) && $menu->icon_type === 'image') ? $menu->icon_value : '') }}">
                    </div>

                    {{-- Permission --}}
                    <div class="col-span-1">
                        <label class="block text-sm font-medium text-[var(--text-secondary)] mb-1">
                            Permission Requirement (Optional)
                        </label>
                        <select name="permission_name" class="{{ $inputClass }}">
                            <option value="">-- Free Access (If Role Matches) --</option>
                            @foreach($permissions as $perm)
                                <option value="{{ $perm->name }}" {{ isset($menu) && $menu->permission_name == $perm->name ? 'selected' : '' }}>
                                    {{ $perm->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Order --}}
                    <div class="col-span-1">
                        <label class="block text-sm font-medium text-[var(--text-secondary)] mb-1">
                            Order <span class="text-[var(--danger)]">*</span>
                        </label>
                        <input type="number" name="order_no" 
                               value="{{ old('order_no', $menu->order_no ?? 0) }}" 
                               class="{{ $inputClass }}" required>
                    </div>
                </div>

                {{-- Actions --}}
                <div class="flex items-center justify-end gap-3 pt-6 border-t border-[var(--border-subtle)]">
                    <a href="{{ route('admin.management.index', ['tab' => 'menus', 'module' => $selectedModule]) }}" 
                       class="px-4 py-2 rounded-lg text-sm font-medium text-[var(--text-secondary)] hover:bg-[var(--table-row-hover)] transition">
                        Cancel
                    </a>
                    <button type="submit" class="btn-theme-primary">
                        <i class="bx bx-save mr-1"></i> {{ $submitLabel }}
                    </button>
                </div>
            </form>
        </div>
    </x-ui.page-container>
</x-app-layout>
