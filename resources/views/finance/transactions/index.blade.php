<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <x-ui.page-header title="Daftar Transaksi" :breadcrumbs="['Finance', 'Transaksi']" />
            <x-ui.alert type="success" />
            <x-ui.alert type="error" />

            <x-grid 
                title="Daftar Transaksi" 
                description="Catat dan pantau arus kas personal Anda di sini."
                createRoute="{{ route('finance.transactions.create') }}"
                createLabel="Tambah Transaksi"
                :headers="['Tanggal', 'Tipe', 'Kategori', 'Deskripsi', 'Nominal', 'Aksi']"
                :pagination="$transactions"
            >
                <x-slot name="filters">
                    <!-- Filter Date Start -->
                    <div class="w-full sm:w-auto">
                        <label class="block text-xs font-medium text-gray-500 mb-1">Mulai Tanggal</label>
                        <input type="date" name="start_date" value="{{ request('start_date') }}" class="w-full border-gray-300 rounded-md shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    <!-- Filter Date End -->
                    <div class="w-full sm:w-auto">
                        <label class="block text-xs font-medium text-gray-500 mb-1">Sampai Tanggal</label>
                        <input type="date" name="end_date" value="{{ request('end_date') }}" class="w-full border-gray-300 rounded-md shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    <!-- Filter Type -->
                    <div class="w-full sm:w-auto">
                        <label class="block text-xs font-medium text-gray-500 mb-1">Tipe Transaksi</label>
                        <select name="type" class="w-full border-gray-300 rounded-md shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">Semua Tipe</option>
                            <option value="income" {{ request('type') == 'income' ? 'selected' : '' }}>Pemasukan</option>
                            <option value="expense" {{ request('type') == 'expense' ? 'selected' : '' }}>Pengeluaran</option>
                        </select>
                    </div>
                </x-slot>

                @forelse($transactions as $transaction)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            {{ \Carbon\Carbon::parse($transaction->date)->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            {{ $transaction->type === 'income' ? 'Pemasukan' : 'Pengeluaran' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            {{ $transaction->category->name ?? '-' }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-700">
                            {{ Str::limit($transaction->description, 50) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $transaction->type === 'income' ? '+' : '-' }} Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="{{ route('finance.transactions.edit', $transaction->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-3"><i class="bx bx-edit text-lg"></i></a>
                            <form action="{{ route('finance.transactions.destroy', $transaction->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus transaksi ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900"><i class="bx bx-trash text-lg"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-sm text-gray-500">
                            Tidak ada data transaksi yang ditemukan.
                        </td>
                    </tr>
                @endforelse
            </x-grid>
        </div>
    </div>
</x-app-layout>
