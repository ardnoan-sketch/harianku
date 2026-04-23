<x-app-layout>
    <x-ui.page-header title="Daftar Modul" :breadcrumbs="['Administrator', 'Modules']" />

    <x-ui.page-container padding="normal">
        <x-ui.alert type="success" />
        <x-ui.alert type="error" />

        <x-grid 
                title="Daftar Modul Aplikasi" 
                description="Setiap modul yang Anda buat di sini akan otomatis muncul sebagai kartu di halaman Portal, sesuai role yang ditetapkan."
                createRoute="{{ route('admin.modules.create') }}"
                createLabel="Tambah Modul"
                :headers="['Order', 'Nama (key)', 'Label', 'Entry Route', 'Role Dibutuhkan', 'Status', 'Actions']"
                :pagination="$modules"
            >
                @foreach($modules as $mod)
                <tr class="hover:bg-[var(--table-row-hover)] transition text-sm">
                    <td class="px-6 py-4 whitespace-nowrap text-[var(--text-secondary)]">{{ $mod->order_no }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-[var(--text-primary)]">{{ $mod->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-[var(--text-primary)]">{{ $mod->label }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-[var(--text-secondary)]">{{ $mod->entry_route }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-[var(--text-secondary)]">{{ $mod->required_role ?: '-' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-[var(--text-secondary)]">{{ $mod->is_active ? 'Aktif' : 'Non-Aktif' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap font-medium">
                        <a href="{{ route('admin.modules.edit', $mod->id) }}" class="text-[var(--accent)] hover:opacity-90 mr-3"><i class="bx bx-edit text-lg"></i></a>
                        <form action="{{ route('admin.modules.destroy', $mod->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin hapus modul ini? Semua menu yang menggunakan modul ini di sidebar tidak akan tampil lagi.');">
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
