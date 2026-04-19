@php
    $isEdit = isset($themeMode);
    $action = $isEdit ? route('admin.theme-modes.update', $themeMode) : route('admin.theme-modes.store');
    $method = $isEdit ? 'PUT' : null;
    $pageTitle = $isEdit ? 'Edit mode: '.$themeMode->name : 'Tambah mode tema';
    $breadLast = $isEdit ? 'Edit' : 'Baru';
    $submitLabel = $isEdit ? 'Simpan perubahan' : 'Simpan';
    $tokensJson = old('css_tokens');
    if ($tokensJson === null) {
        $tokensJson = ($isEdit && $themeMode->css_tokens)
            ? json_encode($themeMode->css_tokens, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)
            : '';
    }
@endphp
<x-app-layout>
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <x-ui.page-header :title="$pageTitle" :breadcrumbs="['Administrator', ['label' => 'Tema', 'url' => route('admin.theme-modes.index')], $breadLast]" />
            <x-form :action="$action" :method="$method" cancelRoute="{{ route('admin.theme-modes.index') }}" :submitLabel="$submitLabel">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="col-span-1">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Slug <span class="text-red-500">*</span></label>
                        <input type="text" name="slug" value="{{ old('slug', $themeMode->slug ?? '') }}" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm font-mono" required pattern="[a-z0-9]+(?:-[a-z0-9]+)*" placeholder="mis. ocean-blue">
                        <p class="text-xs text-gray-500 mt-1">Huruf kecil, angka, dan strip. Dipakai sebagai <code class="text-xs">data-theme</code> di HTML.</p>
                    </div>
                    <div class="col-span-1">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama tampilan <span class="text-red-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name', $themeMode->name ?? '') }}" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                    </div>
                    <div class="col-span-full">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                        <input type="text" name="description" value="{{ old('description', $themeMode->description ?? '') }}" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>
                    <div class="col-span-1">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Urutan <span class="text-red-500">*</span></label>
                        <input type="number" name="sort_order" value="{{ old('sort_order', $themeMode->sort_order ?? 0) }}" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required min="0">
                    </div>
                    <div class="col-span-1">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Aktif <span class="text-red-500">*</span></label>
                        <select name="is_active" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                            @php $ia = (string) old('is_active', ($isEdit ? ($themeMode->is_active ? '1' : '0') : '1')); @endphp
                            <option value="1" {{ $ia === '1' ? 'selected' : '' }}>Ya</option>
                            <option value="0" {{ $ia === '0' ? 'selected' : '' }}>Tidak</option>
                        </select>
                    </div>
                    <div class="col-span-1">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Bisa dipilih user <span class="text-red-500">*</span></label>
                        <select name="is_user_selectable" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                            @php $ius = (string) old('is_user_selectable', ($isEdit ? ($themeMode->is_user_selectable ? '1' : '0') : '1')); @endphp
                            <option value="1" {{ $ius === '1' ? 'selected' : '' }}>Ya</option>
                            <option value="0" {{ $ius === '0' ? 'selected' : '' }}>Tidak</option>
                        </select>
                    </div>
                    <div class="col-span-full">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Token CSS (JSON opsional)</label>
                        <textarea name="css_tokens" rows="8" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm font-mono text-xs" placeholder='{"--bg-app":"#0f172a","--accent":"#38bdf8"}'>{{ $tokensJson }}</textarea>
                        <p class="text-xs text-gray-500 mt-1">Kosongkan untuk hanya memakai stylesheet bawaan (<code>light</code>, <code>night</code>, <code>retro</code>). Mode slug baru hampir selalu perlu token di sini.</p>
                    </div>
                </div>
            </x-form>
        </div>
    </div>
</x-app-layout>
