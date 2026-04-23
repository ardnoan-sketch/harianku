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
    $inputClass = 'w-full rounded-md shadow-sm sm:text-sm bg-[var(--bg-surface)] border-[var(--border-subtle)] text-[var(--text-primary)] focus:ring-[var(--accent)] focus:border-[var(--accent)]';
@endphp
<x-app-layout>
    <x-ui.page-header :title="$pageTitle" :breadcrumbs="['Administrator', ['label' => 'Tema & Warna', 'url' => route('admin.theme-modes.index')], $breadLast]" />

    <x-ui.page-container narrow padding="normal">
            <x-form :action="$action" :method="$method" cancelRoute="{{ route('admin.theme-modes.index') }}" :submitLabel="$submitLabel">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="col-span-1">
                        <label class="block text-sm font-medium text-[var(--text-secondary)] mb-1">Slug <span class="text-[var(--danger)]">*</span></label>
                        <input type="text" name="slug" value="{{ old('slug', $themeMode->slug ?? '') }}" class="{{ $inputClass }} font-mono" required pattern="[a-z0-9]+(?:-[a-z0-9]+)*" placeholder="mis. ocean-blue">
                        <p class="text-xs text-[var(--text-muted)] mt-1">Huruf kecil, angka, dan strip. Dipakai sebagai <code class="text-xs text-[var(--text-primary)]">data-theme</code> di HTML.</p>
                    </div>
                    <div class="col-span-1">
                        <label class="block text-sm font-medium text-[var(--text-secondary)] mb-1">Nama tampilan <span class="text-[var(--danger)]">*</span></label>
                        <input type="text" name="name" value="{{ old('name', $themeMode->name ?? '') }}" class="{{ $inputClass }}" required>
                    </div>
                    <div class="col-span-full">
                        <label class="block text-sm font-medium text-[var(--text-secondary)] mb-1">Deskripsi</label>
                        <input type="text" name="description" value="{{ old('description', $themeMode->description ?? '') }}" class="{{ $inputClass }}">
                    </div>
                    <div class="col-span-1">
                        <label class="block text-sm font-medium text-[var(--text-secondary)] mb-1">Urutan <span class="text-[var(--danger)]">*</span></label>
                        <input type="number" name="sort_order" value="{{ old('sort_order', $themeMode->sort_order ?? 0) }}" class="{{ $inputClass }}" required min="0">
                    </div>
                    <div class="col-span-1">
                        <label class="block text-sm font-medium text-[var(--text-secondary)] mb-1">Aktif <span class="text-[var(--danger)]">*</span></label>
                        <select name="is_active" class="{{ $inputClass }}" required>
                            @php $ia = (string) old('is_active', ($isEdit ? ($themeMode->is_active ? '1' : '0') : '1')); @endphp
                            <option value="1" {{ $ia === '1' ? 'selected' : '' }}>Ya</option>
                            <option value="0" {{ $ia === '0' ? 'selected' : '' }}>Tidak</option>
                        </select>
                    </div>
                    <div class="col-span-1">
                        <label class="block text-sm font-medium text-[var(--text-secondary)] mb-1">Bisa dipilih user <span class="text-[var(--danger)]">*</span></label>
                        <select name="is_user_selectable" class="{{ $inputClass }}" required>
                            @php $ius = (string) old('is_user_selectable', ($isEdit ? ($themeMode->is_user_selectable ? '1' : '0') : '1')); @endphp
                            <option value="1" {{ $ius === '1' ? 'selected' : '' }}>Ya</option>
                            <option value="0" {{ $ius === '0' ? 'selected' : '' }}>Tidak</option>
                        </select>
                    </div>
                    <div class="col-span-full">
                        <label class="block text-sm font-medium text-[var(--text-secondary)] mb-1">Override warna (JSON opsional)</label>
                        <textarea name="css_tokens" rows="10" class="{{ $inputClass }} font-mono text-xs" placeholder='{"--bg-main":"#0f172a","--accent":"#818cf8"}'>{{ $tokensJson }}</textarea>
                        <p class="text-xs text-[var(--text-muted)] mt-1">Kosongkan agar memakai preset default dari stylesheet untuk slug <code class="text-[var(--text-primary)]">light</code>, <code class="text-[var(--text-primary)]">night</code>, atau <code class="text-[var(--text-primary)]">retro</code>. Isi JSON untuk menimpa variabel CSS (misalnya setelah pilih tema, warna disimpan per user lewat preferensi).</p>
                        <details class="mt-2 text-xs text-[var(--text-muted)] border border-[var(--border-subtle)] rounded-md p-3 bg-[var(--header-icon-hover-bg)]">
                            <summary class="cursor-pointer font-medium text-[var(--text-secondary)]">Kunci variabel yang umum dipakai</summary>
                            <p class="mt-2 font-mono leading-relaxed break-all">
                                --font-ui, --bg-body, --bg-main, --bg-surface, --text-primary, --text-secondary, --text-muted, --border-subtle,
                                --accent, --accent-hover, --accent-muted-bg, --table-row-hover, --table-row-bg, --danger, --danger-hover,
                                --header-icon-hover-bg, --sidebar-bg, --sidebar-hover, --sidebar-active
                            </p>
                        </details>
                    </div>
                </div>
        </x-form>
    </x-ui.page-container>
</x-app-layout>
