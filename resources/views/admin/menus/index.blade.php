<x-app-layout>
    <x-ui.page-header title="Daftar Menu" :breadcrumbs="['Administrator', 'Menus']" />

    <x-ui.page-container padding="normal">
        <x-ui.alert type="success" />
        <x-ui.alert type="error" />

        <x-grid 
                title="Daftar Menu" 
                description="Kelola menu sidebar untuk seluruh modul di aplikasi."
                createRoute="{{ route('admin.menus.create') }}"
                createLabel="Tambah Menu"
                :headers="['Order', 'Name', 'Module', 'Parent', 'Icon Type', 'Route/URL', 'Actions']"
                :pagination="$menus"
            >
                @foreach($menus as $menu)
                <tr class="hover:bg-[var(--table-row-hover)] transition">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-[var(--text-secondary)]">{{ $menu->order_no }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-[var(--text-primary)]">{{ $menu->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-[var(--text-secondary)]">{{ $menu->module }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-[var(--text-secondary)]">{{ $menu->parent ? $menu->parent->name : '-' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-[var(--text-secondary)]">{{ $menu->icon_type }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-[var(--text-secondary)]">{{ $menu->url_or_route }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <a href="{{ route('admin.menus.edit', $menu->id) }}" class="text-[var(--accent)] hover:opacity-90 mr-3"><i class="bx bx-edit text-lg"></i></a>
                        <form action="{{ route('admin.menus.destroy', $menu->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus menu ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-[var(--danger)] hover:text-[var(--danger-hover)]"><i class="bx bx-trash text-lg"></i></button>
                        </form>
                    </td>
                </tr>
                @endforeach
        </x-grid>
    </x-ui.page-container>
</x-app-layout>
