<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            @if (session('status'))
                <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50" role="alert">
                  {{ session('status') }}
                </div>
            @endif

            <!-- Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Total Income -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-500 text-sm">Pemasukan (Total)</div>
                    <div class="text-2xl font-bold text-green-600">Rp {{ number_format($totalIncome, 0, ',', '.') }}</div>
                </div>
                <!-- Total Expense -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-500 text-sm">Pengeluaran (Total)</div>
                    <div class="text-2xl font-bold text-red-600">Rp {{ number_format($totalExpense, 0, ',', '.') }}</div>
                </div>
                <!-- Balance -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-500 text-sm">Saldo Saat Ini</div>
                    <div class="text-2xl font-bold text-blue-600">Rp {{ number_format($balance, 0, ',', '.') }}</div>
                </div>
            </div>

            <!-- Chart & Actions -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 md:col-span-2">
                    <h3 class="text-lg font-bold mb-4">Grafik Transaksi (6 Bulan Terakhir)</h3>
                    <canvas id="transactionChart" height="100"></canvas>
                </div>
                
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-bold mb-4">Export Data</h3>
                    <p class="text-gray-600 text-sm mb-4">Download laporan Anda secara asynchronous agar tidak membebani server saat datanya jutaan.</p>
                    
                    <form action="{{ route('finance.export.trigger') }}" method="POST">
                        @csrf
                        <input type="hidden" name="format" value="csv">
                        <x-primary-button class="w-full justify-center">
                            Export ke CSV (Background)
                        </x-primary-button>
                    </form>
                    
                    <form action="{{ route('finance.export.trigger') }}" method="POST" class="mt-2">
                        @csrf
                        <input type="hidden" name="format" value="xlsx">
                        <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            <i class="bx bx-spreadsheet mr-2 text-lg"></i> Export ke Excel
                        </button>
                    </form>
                </div>
            </div>

            <!-- Recent Transactions -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold mb-4">Transaksi Terbaru</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th class="px-6 py-3">Tanggal</th>
                                <th class="px-6 py-3">Kategori</th>
                                <th class="px-6 py-3">Deskripsi</th>
                                <th class="px-6 py-3">Nominal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($recentTransactions as $transaction)
                                <tr class="bg-white border-b">
                                    <td class="px-6 py-4">{{ $transaction->date }}</td>
                                    <td class="px-6 py-4">{{ $transaction->category->name ?? '-' }}</td>
                                    <td class="px-6 py-4">{{ $transaction->description }}</td>
                                    <td class="px-6 py-4 font-bold {{ $transaction->type === 'income' ? 'text-green-600' : 'text-red-600' }}">
                                        {{ $transaction->type === 'income' ? '+' : '-' }} Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-center">Belum ada transaksi</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <!-- Chart.js Setup -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('transactionChart').getContext('2d');
        const transactionChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($labels) !!},
                datasets: [
                    {
                        label: 'Pemasukan',
                        data: {!! json_encode($incomes) !!},
                        backgroundColor: 'rgba(34, 197, 94, 0.6)',
                        borderColor: 'rgb(34, 197, 94)',
                        borderWidth: 1
                    },
                    {
                        label: 'Pengeluaran',
                        data: {!! json_encode($expenses) !!},
                        backgroundColor: 'rgba(239, 68, 68, 0.6)',
                        borderColor: 'rgb(239, 68, 68)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</x-app-layout>
