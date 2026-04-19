<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <x-ui.page-header title="Kategori Keuangan" :breadcrumbs="['Finance', 'Kategori']" />
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
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $category->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            {{ $category->type === 'income' ? 'Pemasukan' : 'Pengeluaran' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            {{ $category->created_at->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="{{ route('finance.categories.edit', $category->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-3"><i class="bx bx-edit text-lg"></i></a>
                            <form action="{{ route('finance.categories.destroy', $category->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus kategori ini? Pastikan tidak ada transaksi yang menggunakannya.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900"><i class="bx bx-trash text-lg"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">
                            Anda belum memiliki kategori apapun. Silakan tambah kategori baru.
                        </td>
                    </tr>
                @endforelse
            </x-grid>
        </div>
    </div>
</x-app-layout>
