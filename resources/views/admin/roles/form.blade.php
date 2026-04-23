@php
    $isEdit     = isset($role);
    $action     = $isEdit ? route('admin.management.roles.update', $role->id) : route('admin.management.roles.store');
    $method     = $isEdit ? 'PUT' : null;
    $pageTitle  = $isEdit ? "Edit Role: {$role->name}" : 'Add New Role';
    $breadLast  = $isEdit ? 'Edit' : 'Add New';
    $submitLabel = $isEdit ? 'Update Role' : 'Save Role';
    $inputClass = 'form-input-theme';
    $selectedPermissions = $rolePermissions ?? old('permissions', []);
    $totalPermissions = $permissions->flatten()->count();
@endphp
<x-app-layout>
    <x-ui.page-header :title="$pageTitle" :breadcrumbs="['Administrator', ['label' => 'Management', 'url' => route('admin.management.index', ['tab' => 'roles'])], $breadLast]" />

    <x-ui.page-container narrow padding="normal">
        <div class="card-theme p-6">
            <form action="{{ $action }}" method="POST" class="space-y-6">
                @csrf
                @if($method)
                    @method($method)
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Role Name --}}
                    <div class="col-span-1">
                        <label class="block text-sm font-medium text-[var(--text-secondary)] mb-1">
                            Role Name <span class="text-[var(--danger)]">*</span>
                        </label>
                        <input type="text" name="name" value="{{ old('name', $role->name ?? '') }}" 
                               class="{{ $inputClass }}" required 
                               placeholder="editor"
                               {{ $isEdit && $role->name === 'admin' ? 'readonly' : '' }}>
                        <p class="text-xs text-[var(--text-muted)] mt-1">
                            Use lowercase, no spaces. e.g. <code>editor</code>, <code>manager</code>
                        </p>
                        @if($isEdit && $role->name === 'admin')
                            <p class="text-xs text-[var(--warning)] mt-1">
                                <i class="bx bx-info-circle"></i> Admin role name cannot be changed.
                            </p>
                        @endif
                    </div>

                    {{-- Guard Name --}}
                    <div class="col-span-1">
                        <label class="block text-sm font-medium text-[var(--text-secondary)] mb-1">
                            Guard Name
                        </label>
                        <input type="text" name="guard_name" value="{{ old('guard_name', $role->guard_name ?? 'web') }}" 
                               class="{{ $inputClass }}" readonly>
                        <p class="text-xs text-[var(--text-muted)] mt-1">
                            Default guard is <code>web</code>
                        </p>
                    </div>
                </div>

                {{-- Permissions Section --}}
                <div class="pt-6 border-t border-[var(--border-subtle)]" x-data="{ search: '', expandedModules: {{ json_encode($permissions->keys()->all()) }} }">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-4">
                        <div>
                            <h4 class="text-lg font-semibold text-[var(--text-primary)]">Permissions</h4>
                            <p class="text-sm text-[var(--text-muted)]">
                                {{ $totalPermissions }} total permissions across {{ $permissions->count() }} modules.
                                <span x-show="search" x-text="'Filtering: ' + document.querySelectorAll('.permission-checkbox:checked').length + ' selected'"></span>
                            </p>
                        </div>
                        <div class="flex flex-wrap gap-2">
                            <div class="relative">
                                <i class="bx bx-search absolute left-3 top-1/2 -translate-y-1/2 text-[var(--text-muted)]"></i>
                                <input type="text" x-model="search" placeholder="Search permissions..."
                                       class="pl-9 pr-4 py-1.5 text-sm rounded-lg bg-[var(--bg-body)] border border-[var(--border-subtle)] focus:border-[var(--accent)] focus:ring-1 focus:ring-[var(--accent)] w-48">
                            </div>
                            <button type="button" onclick="checkAll(true)" class="px-3 py-1.5 text-sm rounded bg-[var(--accent-muted-bg)] text-[var(--accent)] hover:opacity-90 transition">
                                <i class="bx bx-check-square mr-1"></i> All
                            </button>
                            <button type="button" onclick="checkAll(false)" class="px-3 py-1.5 text-sm rounded bg-[var(--bg-body)] text-[var(--text-muted)] hover:bg-[var(--table-row-hover)] transition">
                                <i class="bx bx-rectangle mr-1"></i> None
                            </button>
                        </div>
                    </div>

                    @if($permissions->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
                            @foreach($permissions as $module => $modulePermissions)
                                <div class="card-theme border border-[var(--border-subtle)] overflow-hidden"
                                     x-show="search === '' || {{ json_encode($modulePermissions->pluck('name')->all()) }}.some(p => p.toLowerCase().includes(search.toLowerCase())) || {{ json_encode($modulePermissions->pluck('label')->filter()->values()->all()) }}.some(l => l && l.toLowerCase().includes(search.toLowerCase())) || '{{ strtolower($module) }}'.includes(search.toLowerCase())"
                                     x-transition>
                                    <button type="button" @click="expandedModules.includes('{{ $module }}') ? expandedModules = expandedModules.filter(m => m !== '{{ $module }}') : expandedModules.push('{{ $module }}')"
                                            class="w-full flex items-center justify-between p-3 bg-[var(--bg-body)] hover:bg-[var(--table-row-hover)] transition">
                                        <h5 class="font-semibold text-[var(--text-primary)] flex items-center gap-2 capitalize">
                                            <i class="bx bx-folder text-[var(--accent)]"></i>
                                            {{ $module }}
                                            @php
                                                $selectedInModule = collect($selectedPermissions)->filter(fn($p) => $modulePermissions->contains('name', $p))->count();
                                            @endphp
                                            @if($selectedInModule > 0)
                                                <span class="text-xs bg-[var(--accent)] text-white px-1.5 py-0.5 rounded">{{ $selectedInModule }}/{{ $modulePermissions->count() }}</span>
                                            @else
                                                <span class="text-xs bg-[var(--accent-muted-bg)] text-[var(--accent)] px-2 py-0.5 rounded-full">{{ $modulePermissions->count() }}</span>
                                            @endif
                                        </h5>
                                        <i class="bx bx-chevron-down text-[var(--text-muted)] transition-transform duration-200"
                                           :class="{ 'rotate-180': expandedModules.includes('{{ $module }}') }"></i>
                                    </button>
                                    <div x-show="expandedModules.includes('{{ $module }}')" x-collapse class="p-3">
                                        <div class="space-y-2 max-h-64 overflow-y-auto scrollbar-hide">
                                            @foreach($modulePermissions as $permission)
                                                <label class="flex items-center gap-2 cursor-pointer group permission-item"
                                                       x-show="search === '' || '{{ strtolower($permission->name) }}'.includes(search.toLowerCase()) || '{{ strtolower($permission->label ?? "") }}'.includes(search.toLowerCase()) || '{{ strtolower($module) }}'.includes(search.toLowerCase())"
                                                       title="{{ $permission->name }}">
                                                    <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                                                           {{ in_array($permission->name, $selectedPermissions) ? 'checked' : '' }}
                                                           class="w-4 h-4 rounded border-[var(--border-subtle)] text-[var(--accent)] focus:ring-[var(--accent)] permission-checkbox">
                                                    <span class="text-sm text-[var(--text-secondary)] group-hover:text-[var(--text-primary)] transition truncate">
                                                        {{ $permission->label ?? ucwords(str_replace(['.', '_'], ' ', $permission->name)) }}
                                                    </span>
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8 text-[var(--text-muted)]">
                            <i class="bx bx-lock-alt text-4xl mb-2 block"></i>
                            <p>No permissions available. Run <code>php artisan db:seed</code> to populate permissions.</p>
                        </div>
                    @endif
                </div>

                {{-- Actions --}}
                <div class="flex items-center justify-end gap-3 pt-6 border-t border-[var(--border-subtle)]">
                    <a href="{{ route('admin.management.index', ['tab' => 'roles']) }}" 
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

    <script>
        function checkAll(checked) {
            document.querySelectorAll('.permission-checkbox').forEach(cb => {
                cb.checked = checked;
            });
        }
    </script>
</x-app-layout>
