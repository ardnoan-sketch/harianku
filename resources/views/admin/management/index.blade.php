<x-app-layout>
    <x-ui.page-header title="Module & Menu Management" :breadcrumbs="['Administrator', 'Management']" />

    <x-ui.page-container padding="normal">
        <x-ui.alert type="success" />
        <x-ui.alert type="error" />

        {{-- Tabs Container --}}
        <div x-data="{ activeTab: '{{ $defaultTab ?? 'modules' }}' }">
            {{-- Tabs Navigation --}}
            <div class="mb-6 border-b border-[var(--border-subtle)]">
                <nav class="flex space-x-8" aria-label="Tabs">
                    <button type="button"
                            @@click="activeTab = 'modules'"
                            :class="{ 'border-[var(--accent)] text-[var(--accent)]': activeTab === 'modules', 'border-transparent text-[var(--text-muted)] hover:text-[var(--text-secondary)] hover:border-[var(--border-subtle)]': activeTab !== 'modules' }"
                            class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors flex items-center gap-2">
                        <i class="bx bx-package"></i>
                        Modules
                        <span class="ml-2 bg-[var(--accent-muted-bg)] text-[var(--accent)] px-2 py-0.5 rounded-full text-xs">
                            {{ $modules->total() }}
                        </span>
                    </button>
                    <button type="button"
                            @@click="activeTab = 'menus'"
                            :class="{ 'border-[var(--accent)] text-[var(--accent)]': activeTab === 'menus', 'border-transparent text-[var(--text-muted)] hover:text-[var(--text-secondary)] hover:border-[var(--border-subtle)]': activeTab !== 'menus' }"
                            class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors flex items-center gap-2">
                        <i class="bx bx-menu"></i>
                        Menu Structure
                        <span class="ml-2 bg-[var(--accent-muted-bg)] text-[var(--accent)] px-2 py-0.5 rounded-full text-xs">
                            {{ $menuCount }}
                        </span>
                    </button>
                    <button type="button"
                            @@click="activeTab = 'roles'"
                            :class="{ 'border-[var(--accent)] text-[var(--accent)]': activeTab === 'roles', 'border-transparent text-[var(--text-muted)] hover:text-[var(--text-secondary)] hover:border-[var(--border-subtle)]': activeTab !== 'roles' }"
                            class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors flex items-center gap-2">
                        <i class="bx bx-shield-alt"></i>
                        Roles & Permissions
                        <span class="ml-2 bg-[var(--accent-muted-bg)] text-[var(--accent)] px-2 py-0.5 rounded-full text-xs">
                            {{ $roles->total() }}
                        </span>
                    </button>
                </nav>
            </div>

            {{-- Tab Content --}}
            
            {{-- Modules Tab --}}
            <div x-show="activeTab === 'modules'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                <div class="flex justify-between items-center mb-4">
                    <div>
                        <h3 class="text-lg font-semibold text-[var(--text-primary)]">Application Modules</h3>
                        <p class="text-sm text-[var(--text-muted)]">Kelola modul aplikasi yang tampil di Portal.</p>
                    </div>
                    <a href="{{ route('admin.management.modules.create') }}" class="btn-theme-primary">
                        <i class="bx bx-plus mr-1"></i> Tambah Modul
                    </a>
                </div>

                <div class="card-theme overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left">
                            <thead class="bg-[var(--bg-body)] text-[var(--text-secondary)] uppercase text-xs">
                                <tr>
                                    <th class="px-6 py-3 font-semibold">Order</th>
                                    <th class="px-6 py-3 font-semibold">Module</th>
                                    <th class="px-6 py-3 font-semibold">Label</th>
                                    <th class="px-6 py-3 font-semibold">Entry Route</th>
                                    <th class="px-6 py-3 font-semibold">Permission Required</th>
                                    <th class="px-6 py-3 font-semibold">Status</th>
                                    <th class="px-6 py-3 font-semibold text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-[var(--border-subtle)]">
                                @forelse($modules as $mod)
                                    <tr class="hover:bg-[var(--table-row-hover)] transition">
                                        <td class="px-6 py-4 whitespace-nowrap text-[var(--text-secondary)]">{{ $mod->order_no }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center gap-2">
                                                <div class="w-8 h-8 rounded-lg bg-gradient-to-br {{ $mod->color_from }} {{ $mod->color_to }} flex items-center justify-center">
                                                    <i class="{{ $mod->icon_class }} text-white text-sm"></i>
                                                </div>
                                                <span class="font-medium text-[var(--text-primary)]">{{ $mod->name }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-[var(--text-primary)]">{{ $mod->label }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-[var(--text-secondary)] font-mono text-xs">{{ $mod->entry_route }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($mod->required_permission)
                                                <span class="bg-[var(--accent-muted-bg)] text-[var(--accent)] px-2 py-1 rounded text-xs" title="{{ $mod->required_permission }}">
                                                    {{ Str::limit($mod->required_permission, 25) }}
                                                </span>
                                            @else
                                                <span class="text-[var(--text-muted)] text-xs">-</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 py-1 rounded-full text-xs {{ $mod->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                                {{ $mod->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right">
                                            <a href="{{ route('admin.management.modules.edit', $mod->id) }}" class="text-[var(--accent)] hover:opacity-90 mr-3">
                                                <i class="bx bx-edit text-lg"></i>
                                            </a>
                                            <form action="{{ route('admin.management.modules.destroy', $mod->id) }}" method="POST" class="inline-block" 
                                                  onsubmit="return confirm('Yakin hapus modul ini? Semua menu terkait tidak akan tampil.');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-[var(--danger)] hover:text-[var(--danger-hover)]">
                                                    <i class="bx bx-trash text-lg"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-8 text-center text-[var(--text-muted)]">
                                            <i class="bx bx-package text-4xl mb-2 block"></i>
                                            Belum ada modul. Tambah modul baru untuk mulai.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if($modules->hasPages())
                        <div class="px-6 py-4 border-t border-[var(--border-subtle)]">
                            {{ $modules->links() }}
                        </div>
                    @endif
                </div>
            </div>

            {{-- Menus Tab --}}
            <div x-show="activeTab === 'menus'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" style="display: none;">
                <div class="flex flex-col lg:flex-row gap-6">
                    
                    {{-- Sidebar: Module Filter --}}
                    <div class="lg:w-64 shrink-0">
                        <div class="card-theme p-4 sticky top-4">
                            <h4 class="font-semibold text-[var(--text-primary)] mb-3 flex items-center gap-2">
                                <i class="bx bx-filter-alt"></i> Filter by Module
                            </h4>
                            <div class="space-y-1">
                                <a href="{{ route('admin.management.index', ['tab' => 'menus']) }}" 
                                   class="block px-3 py-2 rounded-lg text-sm transition {{ !$selectedModule ? 'bg-[var(--accent)] text-white' : 'text-[var(--text-secondary)] hover:bg-[var(--table-row-hover)]' }}">
                                    <i class="bx bx-grid-alt mr-2"></i> All Modules
                                    <span class="float-right text-xs bg-[var(--bg-body)] px-2 py-0.5 rounded {{ !$selectedModule ? 'text-[var(--accent)] bg-white' : 'text-[var(--text-muted)]' }}">{{ $menuCount }}</span>
                                </a>
                                @foreach($modules as $mod)
                                    <a href="{{ route('admin.management.index', ['tab' => 'menus', 'module' => $mod->name]) }}" 
                                       class="block px-3 py-2 rounded-lg text-sm transition {{ $selectedModule === $mod->name ? 'bg-[var(--accent)] text-white' : 'text-[var(--text-secondary)] hover:bg-[var(--table-row-hover)]' }}">
                                        <i class="{{ $mod->icon_class }} mr-2"></i> {{ $mod->label }}
                                        <span class="float-right text-xs bg-[var(--bg-body)] px-2 py-0.5 rounded {{ $selectedModule === $mod->name ? 'text-[var(--accent)] bg-white' : 'text-[var(--text-muted)]' }}">
                                            {{ $menus->where('module', $mod->name)->count() }}
                                        </span>
                                    </a>
                                @endforeach
                            </div>
                            
                            <div class="mt-4 pt-4 border-t border-[var(--border-subtle)]">
                                <a href="{{ route('admin.management.menus.create', ['module' => $selectedModule]) }}" class="btn-theme-primary w-full justify-center text-center block">
                                    <i class="bx bx-plus mr-1"></i> Tambah Menu
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- Menu Tree View --}}
                    <div class="flex-1">
                        <div class="flex justify-between items-center mb-4">
                            <div>
                                <h3 class="text-lg font-semibold text-[var(--text-primary)]">
                                    Menu Structure
                                    @if($selectedModule)
                                        <span class="text-[var(--text-muted)] font-normal">- {{ $modules->firstWhere('name', $selectedModule)?->label ?? $selectedModule }}</span>
                                    @endif
                                </h3>
                                <p class="text-sm text-[var(--text-muted)]">
                                    @if($selectedModule)
                                        Kelola hierarki menu untuk modul {{ $selectedModule }}.
                                    @else
                                        Lihat struktur menu lengkap dengan hierarki parent-child.
                                    @endif
                                </p>
                            </div>
                        </div>

                        <div class="card-theme p-4">
                            @php
                                $rootMenus = $menus->whereNull('parent_id')->sortBy('order_no');
                            @endphp
                            
                            @if($rootMenus->count() > 0)
                                <x-ui.menu-tree :menus="$rootMenus" :module="$selectedModule" />
                            @else
                                <div class="text-center py-8 text-[var(--text-muted)]">
                                    <i class="bx bx-menu text-4xl mb-2 block"></i>
                                    @if($selectedModule)
                                        Belum ada menu untuk modul {{ $selectedModule }}.
                                        <a href="{{ route('admin.management.menus.create', ['module' => $selectedModule]) }}" class="text-[var(--accent)] hover:underline block mt-2">
                                            Tambah menu pertama
                                        </a>
                                    @else
                                        Belum ada menu root. Tambah menu untuk memulai.
                                    @endif
                                </div>
                            @endif
                        </div>

                        {{-- Orphaned Menus (children without visible parent due to filter) --}}
                        @if($selectedModule)
                            @php
                                $orphanedMenus = $menus->where('module', $selectedModule)->whereNotNull('parent_id')->filter(function($menu) use ($menus, $selectedModule) {
                                    $parent = $menus->firstWhere('id', $menu->parent_id);
                                    return !$parent || $parent->module !== $selectedModule;
                                });
                            @endphp
                            @if($orphanedMenus->count() > 0)
                                <div class="mt-6">
                                    <h4 class="text-sm font-semibold text-[var(--text-secondary)] mb-2 flex items-center gap-2">
                                        <i class="bx bx-unlink text-[var(--warning)]"></i>
                                        Menu dengan Parent di Modul Lain ({{ $orphanedMenus->count() }})
                                    </h4>
                                    <div class="card-theme p-4 opacity-75">
                                        <x-ui.menu-tree :menus="$orphanedMenus" :module="$selectedModule" />
                                    </div>
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            </div>

            {{-- Roles Tab --}}
            <div x-show="activeTab === 'roles'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" style="display: none;">
                <div class="flex justify-between items-center mb-4">
                    <div>
                        <h3 class="text-lg font-semibold text-[var(--text-primary)]">Roles & Permissions</h3>
                        <p class="text-sm text-[var(--text-muted)]">Kelola role dan permissions untuk RBAC.</p>
                    </div>
                    <a href="{{ route('admin.management.roles.create') }}" class="btn-theme-primary">
                        <i class="bx bx-plus mr-1"></i> Tambah Role
                    </a>
                </div>

                <div class="card-theme overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left">
                            <thead class="bg-[var(--bg-body)] text-[var(--text-secondary)] uppercase text-xs">
                                <tr>
                                    <th class="px-6 py-3 font-semibold">Role Name</th>
                                    <th class="px-6 py-3 font-semibold">Guard</th>
                                    <th class="px-6 py-3 font-semibold">Permissions Count</th>
                                    <th class="px-6 py-3 font-semibold text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-[var(--border-subtle)]">
                                @forelse($roles as $role)
                                    <tr class="hover:bg-[var(--table-row-hover)] transition-colors">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-2">
                                                <span class="px-2 py-1 rounded text-xs font-medium {{ $role->name === 'admin' ? 'bg-[var(--accent)] text-white' : 'bg-[var(--accent-muted-bg)] text-[var(--accent)]' }}">
                                                    {{ $role->name }}
                                                </span>
                                                @if($role->name === 'admin')
                                                    <i class="bx bx-crown text-[var(--warning)]" title="Super Admin"></i>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-[var(--text-muted)]">{{ $role->guard_name }}</td>
                                        <td class="px-6 py-4">
                                            <span class="px-2 py-1 rounded-full text-xs {{ $role->permissions_count > 0 ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                                                {{ $role->permissions_count }} permissions
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right">
                                            <a href="{{ route('admin.management.roles.edit', $role->id) }}" class="text-[var(--accent)] hover:opacity-90 mr-3">
                                                <i class="bx bx-edit text-lg"></i>
                                            </a>
                                            @if($role->name !== 'admin' || $roles->where('name', 'admin')->count() > 1)
                                                <form action="{{ route('admin.management.roles.destroy', $role->id) }}" method="POST" class="inline-block" 
                                                      onsubmit="return confirm('Yakin hapus role ini? Semua user dengan role ini akan kehilangan akses.');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-[var(--danger)] hover:text-[var(--danger-hover)]">
                                                        <i class="bx bx-trash text-lg"></i>
                                                    </button>
                                                </form>
                                            @else
                                                <span class="text-[var(--text-muted)] cursor-not-allowed" title="Cannot delete the only admin role">
                                                    <i class="bx bx-trash text-lg"></i>
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-8 text-center text-[var(--text-muted)]">
                                            <i class="bx bx-shield-alt text-4xl mb-2 block"></i>
                                            Belum ada role. Tambah role baru untuk mulai.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if($roles->hasPages())
                        <div class="px-6 py-4 border-t border-[var(--border-subtle)]">
                            {{ $roles->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </x-ui.page-container>
</x-app-layout>
