@php
    $isEdit      = isset($module);
    $action      = $isEdit ? route('admin.management.modules.update', $module->id) : route('admin.management.modules.store');
    $method      = $isEdit ? 'PUT' : null;
    $pageTitle   = $isEdit ? "Edit Module: {$module->label}" : 'Add New Module';
    $breadLast   = $isEdit ? 'Edit' : 'Add New';
    $submitLabel = $isEdit ? 'Update Module' : 'Save Module';
    $inputClass  = 'form-input-theme';
@endphp
<x-app-layout>
    <x-ui.page-header :title="$pageTitle" :breadcrumbs="['Administrator', ['label' => 'Management', 'url' => route('admin.management.index', ['tab' => 'modules'])], $breadLast]" />

    <x-ui.page-container narrow padding="normal">
        <div class="card-theme p-6">
            <form action="{{ $action }}" method="POST" class="space-y-6">
                @csrf
                @if($method)
                    @method($method)
                @endif

                @if(!$isEdit)
                    <div class="p-4 rounded-lg bg-[var(--accent-muted-bg)] border border-[var(--accent)] border-opacity-20 mb-6">
                        <p class="text-sm text-[var(--text-secondary)]">
                            <i class="bx bx-info-circle mr-1"></i>
                            Once saved, the module will appear on the Portal. Make sure its <strong>Entry Route</strong> is registered in <code class="text-[var(--accent)]">routes/web.php</code>.
                        </p>
                    </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Module Key --}}
                    <div class="col-span-1">
                        <label class="block text-sm font-medium text-[var(--text-secondary)] mb-1">
                            Module Key Name <span class="text-[var(--danger)]">*</span>
                        </label>
                        <input type="text" name="name" value="{{ old('name', $module->name ?? '') }}" 
                               class="{{ $inputClass }}" required 
                               placeholder="hrd" pattern="[a-z_]+" 
                               title="Lowercase letters and underscores only">
                        <p class="text-xs text-[var(--text-muted)] mt-1">
                            Lowercase & underscores only. e.g. <code>hrd</code>, <code>inventory</code>
                        </p>
                    </div>

                    {{-- Label --}}
                    <div class="col-span-1">
                        <label class="block text-sm font-medium text-[var(--text-secondary)] mb-1">
                            Label (shown on Portal) <span class="text-[var(--danger)]">*</span>
                        </label>
                        <input type="text" name="label" value="{{ old('label', $module->label ?? '') }}" 
                               class="{{ $inputClass }}" required placeholder="Human Resource">
                    </div>

                    {{-- Description --}}
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-[var(--text-secondary)] mb-1">Description</label>
                        <input type="text" name="description" 
                               value="{{ old('description', $module->description ?? '') }}" 
                               class="{{ $inputClass }}" 
                               placeholder="Manage employees, attendance, and payroll">
                    </div>

                    {{-- Icon Class --}}
                    <div class="col-span-1">
                        <label class="block text-sm font-medium text-[var(--text-secondary)] mb-1">Icon Class (Boxicons)</label>
                        <input type="text" name="icon_class" 
                               value="{{ old('icon_class', $module->icon_class ?? 'bx bx-cube') }}" 
                               class="{{ $inputClass }}" placeholder="bx bx-cube">
                    </div>

                    {{-- Entry Route --}}
                    <div class="col-span-1">
                        <label class="block text-sm font-medium text-[var(--text-secondary)] mb-1">
                            Entry Route Name <span class="text-[var(--danger)]">*</span>
                        </label>
                        <input type="text" name="entry_route" 
                               value="{{ old('entry_route', $module->entry_route ?? '') }}" 
                               class="{{ $inputClass }}" required placeholder="hrd.dashboard">
                        <p class="text-xs text-[var(--text-muted)] mt-1">Laravel route name (must exist in web.php)</p>
                    </div>

                    {{-- Color From --}}
                    <div class="col-span-1">
                        <label class="block text-sm font-medium text-[var(--text-secondary)] mb-1">Gradient Color - Start</label>
                        <input type="text" name="color_from" 
                               value="{{ old('color_from', $module->color_from ?? 'from-blue-500') }}" 
                               class="{{ $inputClass }}" placeholder="from-blue-500">
                    </div>

                    {{-- Color To --}}
                    <div class="col-span-1">
                        <label class="block text-sm font-medium text-[var(--text-secondary)] mb-1">Gradient Color - End</label>
                        <input type="text" name="color_to" 
                               value="{{ old('color_to', $module->color_to ?? 'to-blue-700') }}" 
                               class="{{ $inputClass }}" placeholder="to-blue-700">
                    </div>

                    {{-- Required Permission --}}
                    <div class="col-span-1">
                        <label class="block text-sm font-medium text-[var(--text-secondary)] mb-1">Required Permission</label>
                        <select name="required_permission" class="{{ $inputClass }}">
                            <option value="">-- Open to All Users --</option>
                            @foreach($permissions as $moduleKey => $modulePermissions)
                                <optgroup label="{{ ucfirst($moduleKey) }}">
                                    @foreach($modulePermissions as $permission)
                                        <option value="{{ $permission->name }}" {{ isset($module) && is_object($module) && $module->required_permission == $permission->name ? 'selected' : '' }}>
                                            {{ $permission->label ?? ucwords(str_replace(['.', '_'], ' ', $permission->name)) }}
                                        </option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                        <p class="text-xs text-[var(--text-muted)] mt-1">Users need this permission to access. Admins always have access.</p>
                    </div>

                    {{-- Order --}}
                    <div class="col-span-1">
                        <label class="block text-sm font-medium text-[var(--text-secondary)] mb-1">Order</label>
                        <input type="number" name="order_no" 
                               value="{{ old('order_no', $module->order_no ?? 0) }}" 
                               class="{{ $inputClass }}">
                    </div>

                    {{-- Active Checkbox --}}
                    <div class="md:col-span-2">
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" name="is_active" id="is_active" value="1" 
                                   {{ !$isEdit || $module->is_active ? 'checked' : '' }}
                                   class="w-4 h-4 rounded border-[var(--border-subtle)] text-[var(--accent)] focus:ring-[var(--accent)]">
                            <span class="text-sm font-medium text-[var(--text-primary)]">
                                Active Module (shown on Portal)
                            </span>
                        </label>
                    </div>
                </div>

                {{-- Actions --}}
                <div class="flex items-center justify-end gap-3 pt-6 border-t border-[var(--border-subtle)]">
                    <a href="{{ route('admin.management.index', ['tab' => 'modules']) }}" 
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
