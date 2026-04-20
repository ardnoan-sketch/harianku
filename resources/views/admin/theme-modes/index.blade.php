<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <x-ui.page-header title="Tema & Warna" :breadcrumbs="['Administrator', 'Tema']" />
            <x-ui.alert type="success" />
            <x-ui.alert type="error" />

            <x-grid
                title="Daftar mode tampilan"
                description="CRUD preset warna dan mode tampilan. Pengguna memilih tema dari header; tambah atau edit mode di sini (slug unik). Field JSON opsional menimpa variabel CSS default."
                createRoute="{{ route('admin.theme-modes.create') }}"
                createLabel="Tambah mode"
                :headers="['Urutan', 'Slug', 'Nama', 'Aktif', 'Dipilih user', 'Actions']"
                :pagination="$themeModes"
            >
                @foreach($themeModes as $mode)
                    <tr class="hover:bg-[var(--table-row-hover)] transition">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-[var(--text-secondary)]">{{ $mode->sort_order }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-[var(--text-primary)]">{{ $mode->slug }}</td>
                        <td class="px-6 py-4 text-sm text-[var(--text-primary)]">
                            <div class="font-medium">{{ $mode->name }}</div>
                            @if($mode->description)
                                <div class="text-xs text-[var(--text-muted)] mt-0.5">{{ $mode->description }}</div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-[var(--text-secondary)]">{{ $mode->is_active ? 'Ya' : 'Tidak' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-[var(--text-secondary)]">{{ $mode->is_user_selectable ? 'Ya' : 'Tidak' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="{{ route('admin.theme-modes.edit', $mode) }}" class="text-[var(--accent)] hover:opacity-90 mr-3"><i class="bx bx-edit text-lg"></i></a>
                            <form action="{{ route('admin.theme-modes.destroy', $mode) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus mode tema ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-[var(--danger)] hover:text-[var(--danger-hover)]"><i class="bx bx-trash text-lg"></i></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </x-grid>
        </div>
    </div>
</x-app-layout>
