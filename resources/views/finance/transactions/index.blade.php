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
                        <label class="block text-xs font-medium text-[var(--text-muted)] mb-1">Mulai Tanggal</label>
                        <input type="date" name="start_date" value="{{ request('start_date') }}" class="w-full rounded-md shadow-sm text-sm bg-[var(--bg-surface)] border-[var(--border-subtle)] text-[var(--text-primary)] focus:ring-[var(--accent)] focus:border-[var(--accent)]">
                    </div>

                    <!-- Filter Date End -->
                    <div class="w-full sm:w-auto">
                        <label class="block text-xs font-medium text-[var(--text-muted)] mb-1">Sampai Tanggal</label>
                        <input type="date" name="end_date" value="{{ request('end_date') }}" class="w-full rounded-md shadow-sm text-sm bg-[var(--bg-surface)] border-[var(--border-subtle)] text-[var(--text-primary)] focus:ring-[var(--accent)] focus:border-[var(--accent)]">
                    </div>

                    <!-- Filter Type -->
                    <div class="w-full sm:w-auto">
                        <label class="block text-xs font-medium text-[var(--text-muted)] mb-1">Tipe Transaksi</label>
                        <select name="type" class="w-full rounded-md shadow-sm text-sm bg-[var(--bg-surface)] border-[var(--border-subtle)] text-[var(--text-primary)] focus:ring-[var(--accent)] focus:border-[var(--accent)]">
                            <option value="">Semua Tipe</option>
                            <option value="income" {{ request('type') == 'income' ? 'selected' : '' }}>Pemasukan</option>
                            <option value="expense" {{ request('type') == 'expense' ? 'selected' : '' }}>Pengeluaran</option>
                        </select>
                    </div>
                </x-slot>

                @forelse($transactions as $transaction)
                    <tr class="hover:bg-[var(--table-row-hover)] transition">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-[var(--text-secondary)]">
                            {{ \Carbon\Carbon::parse($transaction->date)->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-[var(--text-secondary)]">
                            {{ $transaction->type === 'income' ? 'Pemasukan' : 'Pengeluaran' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-[var(--text-secondary)]">
                            {{ $transaction->category->name ?? '-' }}
                        </td>
                        <td class="px-6 py-4 text-sm text-[var(--text-secondary)]">
                            {{ Str::limit($transaction->description, 50) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-[var(--text-primary)] font-medium">
                            {{ $transaction->type === 'income' ? '+' : '-' }} Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="{{ route('finance.transactions.edit', $transaction->id) }}" class="text-[var(--accent)] hover:opacity-90 mr-3"><i class="bx bx-edit text-lg"></i></a>
                            <form action="{{ route('finance.transactions.destroy', $transaction->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus transaksi ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-[var(--danger)] hover:text-[var(--danger-hover)]"><i class="bx bx-trash text-lg"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-sm text-[var(--text-muted)]">
                            Tidak ada data transaksi yang ditemukan.
                        </td>
                    </tr>
                @endforelse
            </x-grid>
        </div>
    </div>
</x-app-layout>
