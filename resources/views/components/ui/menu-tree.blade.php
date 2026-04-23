@props([
    'menus' => [],
    'level' => 0,
    'module' => null,
])

<ul class="space-y-1 {{ $level > 0 ? 'ml-6 pl-3 border-l-2 border-[var(--border-subtle)]' : '' }}">
    @foreach($menus as $menu)
        @if($module && $menu->module !== $module)
            @continue
        @endif
        <li class="group">
            <div class="flex items-center gap-3 p-2 rounded-lg hover:bg-[var(--table-row-hover)] transition {{ $level === 0 ? 'bg-[var(--bg-surface)] border border-[var(--border-subtle)]' : '' }}">
                {{-- Drag Handle --}}
                <div class="cursor-move text-[var(--text-muted)] hover:text-[var(--text-secondary)]">
                    <i class="bx bx-grid-vertical"></i>
                </div>

                {{-- Icon --}}
                <div class="w-8 h-8 rounded-lg bg-[var(--accent-muted-bg)] flex items-center justify-center shrink-0">
                    @if($menu->icon_type === 'image' && $menu->icon_value)
                        <img src="{{ asset('storage/' . $menu->icon_value) }}" alt="" class="w-5 h-5 object-contain">
                    @else
                        <i class="{{ $menu->icon_value ?? 'bx bx-menu' }} text-[var(--accent)]"></i>
                    @endif
                </div>

                {{-- Menu Info --}}
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-2">
                        <span class="font-medium text-[var(--text-primary)] truncate">{{ $menu->name }}</span>
                        @if($menu->children->count() > 0)
                            <span class="text-xs bg-[var(--accent-muted-bg)] text-[var(--accent)] px-2 py-0.5 rounded-full">
                                {{ $menu->children->count() }} sub
                            </span>
                        @endif
                    </div>
                    <div class="text-xs text-[var(--text-muted)] truncate">
                        {{ $menu->url_or_route ?? 'No route' }}
                        @if($menu->permission_name)
                            <span class="mx-1">•</span>
                            <span class="text-[var(--accent)]">{{ $menu->permission_name }}</span>
                        @endif
                    </div>
                </div>

                {{-- Order Badge --}}
                <span class="text-xs text-[var(--text-muted)] bg-[var(--bg-body)] px-2 py-1 rounded">
                    #{{ $menu->order_no }}
                </span>

                {{-- Actions --}}
                <div class="flex items-center gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                    <a href="{{ route('admin.management.menus.edit', $menu->id) }}" 
                       class="p-1.5 rounded text-[var(--accent)] hover:bg-[var(--accent-muted-bg)] transition"
                       title="Edit">
                        <i class="bx bx-edit"></i>
                    </a>
                    <form action="{{ route('admin.management.menus.destroy', $menu->id) }}" method="POST" class="inline" 
                          onsubmit="return confirm('Yakin ingin menghapus menu ini?{{ $menu->children->count() > 0 ? ' Semua sub-menu juga akan terhapus!' : '' }}');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="p-1.5 rounded text-[var(--danger)] hover:bg-[var(--danger)] hover:bg-opacity-10 transition" title="Delete">
                            <i class="bx bx-trash"></i>
                        </button>
                    </form>
                </div>
            </div>

            {{-- Recursive Children --}}
            @if($menu->children && $menu->children->count() > 0)
                <x-ui.menu-tree :menus="$menu->children" :level="$level + 1" :module="$module" />
            @endif
        </li>
    @endforeach
</ul>
