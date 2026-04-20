<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <x-ui.page-header title="User Management" :breadcrumbs="['Administrator', 'Users']" />
            <x-ui.alert type="success" />
            <x-ui.alert type="error" />

            <x-grid 
                title="User Management" 
                description="Kelola pengguna aplikasi dan hak akses (role) mereka."
                createRoute="{{ route('admin.users.create') }}"
                createLabel="Tambah User"
                :headers="['Nama', 'Email', 'Role', 'Bergabung Pada', 'Aksi']"
                :pagination="$users"
            >
                @foreach($users as $user)
                    <tr class="hover:bg-[var(--table-row-hover)] transition">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-[var(--text-primary)]">{{ $user->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-[var(--text-secondary)]">{{ $user->email }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-[var(--text-secondary)]">
                            {{ $user->roles->pluck('name')->implode(', ') ?: '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-[var(--text-secondary)]">
                            {{ $user->created_at->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="{{ route('admin.users.edit', $user->id) }}" class="text-[var(--accent)] hover:opacity-90 mr-3"><i class="bx bx-edit text-lg"></i></a>

                            @if($user->id !== auth()->id())
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus user ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-[var(--danger)] hover:text-[var(--danger-hover)]"><i class="bx bx-trash text-lg"></i></button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </x-grid>
        </div>
    </div>
</x-app-layout>
