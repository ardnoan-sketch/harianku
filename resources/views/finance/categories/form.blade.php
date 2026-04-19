@php
    $isEdit      = isset($category);
    $action      = $isEdit ? route('finance.categories.update', $category->id) : route('finance.categories.store');
    $method      = $isEdit ? 'PUT' : null;
    $pageTitle   = $isEdit ? "Edit Kategori: {$category->name}" : 'Tambah Kategori';
    $breadLast   = $isEdit ? 'Edit' : 'Tambah Baru';
    $submitLabel = $isEdit ? 'Update Kategori' : 'Simpan Kategori';
    $formTitle   = $isEdit ? 'Ubah Data Kategori' : 'Data Kategori';
    $formDesc    = $isEdit ? 'Ubah nama atau tipe kategori.' : 'Buat kategori khusus Anda sendiri untuk membedakan transaksi.';
@endphp
<x-app-layout>
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <x-ui.page-header :title="$pageTitle" :breadcrumbs="['Finance', ['label' => 'Kategori', 'url' => route('finance.categories.index')], $breadLast]" />
            <x-form :action="$action" :method="$method" cancelRoute="{{ route('finance.categories.index') }}" :submitLabel="$submitLabel" :title="$formTitle" :description="$formDesc">
                <div class="grid grid-cols-1 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Kategori <span class="text-red-500">*</span></label>
                        <input type="text" name="name" id="name" value="{{ old('name', $category->name ?? '') }}" required placeholder="Gaji, Makanan, Transportasi, dll" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        @error('name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tipe Kategori <span class="text-red-500">*</span></label>
                        <div class="flex items-center gap-6">
                            <div class="flex items-center">
                                <input id="type_income" name="type" type="radio" value="income" {{ old('type', $category->type ?? '') === 'income' ? 'checked' : '' }} required class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300">
                                <label for="type_income" class="ml-2 block text-sm font-medium text-green-700">Pemasukan (+)</label>
                            </div>
                            <div class="flex items-center">
                                <input id="type_expense" name="type" type="radio" value="expense" {{ old('type', $category->type ?? '') === 'expense' ? 'checked' : '' }} required class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300">
                                <label for="type_expense" class="ml-2 block text-sm font-medium text-red-700">Pengeluaran (-)</label>
                            </div>
                        </div>
                        @error('type') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>
            </x-form>
        </div>
    </div>
</x-app-layout>
