@php
    $isEdit      = isset($transaction);
    $action      = $isEdit ? route('finance.transactions.update', $transaction->id) : route('finance.transactions.store');
    $method      = $isEdit ? 'PUT' : null;
    $pageTitle   = $isEdit ? 'Edit Transaksi' : 'Tambah Transaksi';
    $breadLast   = $isEdit ? 'Edit' : 'Tambah Baru';
    $submitLabel = $isEdit ? 'Update Transaksi' : 'Simpan Transaksi';
    $formTitle   = $isEdit ? 'Ubah Data Transaksi' : 'Data Transaksi';
    $formDesc    = $isEdit ? 'Perbarui detail transaksi.' : 'Catat pemasukan atau pengeluaran baru.';
    $defaultType = $isEdit ? $transaction->type : 'expense';
@endphp
<x-app-layout>
    <x-ui.page-header :title="$pageTitle" :breadcrumbs="['Finance', ['label' => 'Transaksi', 'url' => route('finance.transactions.index')], $breadLast]" />

    <x-ui.page-container narrow padding="normal">
            <x-form :action="$action" :method="$method" cancelRoute="{{ route('finance.transactions.index') }}" :submitLabel="$submitLabel" :title="$formTitle" :description="$formDesc">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="col-span-1">
                        <label for="date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal <span class="text-red-500">*</span></label>
                        <input type="date" name="date" id="date" value="{{ old('date', $transaction->date ?? date('Y-m-d')) }}" required class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        @error('date') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-span-1">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tipe Transaksi <span class="text-red-500">*</span></label>
                        <div class="flex items-center gap-6 mt-1">
                            <div class="flex items-center">
                                <input id="type_income" name="type" type="radio" value="income" {{ old('type', $defaultType) === 'income' ? 'checked' : '' }} required class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300" onchange="filterCategories()">
                                <label for="type_income" class="ml-2 block text-sm font-medium text-green-700">Pemasukan (+)</label>
                            </div>
                            <div class="flex items-center">
                                <input id="type_expense" name="type" type="radio" value="expense" {{ old('type', $defaultType) === 'expense' ? 'checked' : '' }} required class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300" onchange="filterCategories()">
                                <label for="type_expense" class="ml-2 block text-sm font-medium text-red-700">Pengeluaran (-)</label>
                            </div>
                        </div>
                        @error('type') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-span-1 md:col-span-2">
                        <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Kategori <span class="text-red-500">*</span></label>
                        <select name="category_id" id="category_id" required class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" data-type="{{ $category->type }}" {{ old('category_id', $transaction->category_id ?? '') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        <p class="text-xs text-gray-500 mt-1">Kategori yang muncul sesuai dengan tipe transaksi yang dipilih.</p>
                        @error('category_id') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-span-1 md:col-span-2">
                        <label for="amount" class="block text-sm font-medium text-gray-700 mb-1">Nominal (Rp) <span class="text-red-500">*</span></label>
                        <div class="relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">Rp</span>
                            </div>
                            <input type="number" name="amount" id="amount" value="{{ old('amount', $transaction->amount ?? '') }}" required min="0" step="1" class="pl-10 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="0">
                        </div>
                        @error('amount') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-span-1 md:col-span-2">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi / Catatan <span class="text-red-500">*</span></label>
                        <input type="text" name="description" id="description" value="{{ old('description', $transaction->description ?? '') }}" required class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Makan siang, Gaji bulanan, dll">
                        @error('description') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>
        </x-form>
    </x-ui.page-container>

    <script>
        function filterCategories() {
            const selectedType = document.querySelector('input[name="type"]:checked')?.value;
            if (!selectedType) return;
            const sel = document.getElementById('category_id');
            sel.querySelectorAll('option:not([value=""])').forEach(opt => {
                opt.style.display = opt.dataset.type === selectedType ? 'block' : 'none';
                if (opt.dataset.type !== selectedType && sel.value === opt.value) sel.value = '';
            });
        }
        document.addEventListener('DOMContentLoaded', filterCategories);
    </script>
</x-app-layout>
