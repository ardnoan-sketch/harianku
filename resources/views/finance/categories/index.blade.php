<x-app-layout>
    <x-ui.page-header title="Kategori Keuangan" :breadcrumbs="['Finance', 'Kategori']" />

    <x-ui.page-container padding="normal">
        <x-ui.alert type="success" />
        <x-ui.alert type="error" />

        <x-grid 
                title="Kategori Keuangan" 
                description="Kelola kategori pemasukan dan pengeluaran personal Anda."
                createRoute="{{ route('finance.categories.create') }}"
                createLabel="Tambah Kategori"
                :headers="['Nama Kategori', 'Tipe', 'Dibuat Pada', 'Aksi']"
                :pagination="$categories"
            >
                @forelse($categories as $category)
                    <tr class="hover:bg-[var(--table-row-hover)] transition">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-[var(--text-primary)]">{{ $category->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-[var(--text-secondary)]">
                            {{ $category->type === 'income' ? 'Pemasukan' : 'Pengeluaran' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-[var(--text-secondary)]">
                            {{ $category->created_at->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="{{ route('finance.categories.edit', $category->id) }}" class="text-[var(--accent)] hover:opacity-90 mr-3"><i class="bx bx-edit text-lg"></i></a>
                            <form action="{{ route('finance.categories.destroy', $category->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus kategori ini? Pastikan tidak ada transaksi yang menggunakannya.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-[var(--danger)] hover:text-[var(--danger-hover)]"><i class="bx bx-trash text-lg"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-sm text-[var(--text-muted)]">
                            Anda belum memiliki kategori apapun. Silakan tambah kategori baru.
                        </td>
                    </tr>
                @endforelse
        </x-grid>
    </x-ui.page-container>
</x-app-layout>
