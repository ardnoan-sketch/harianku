@php
    $isEdit      = isset($employee);
    $action      = $isEdit ? route('hrd.employees.update', $employee->id) : route('hrd.employees.store');
    $method      = $isEdit ? 'PUT' : null;
    $pageTitle   = $isEdit ? "Edit Karyawan: {$employee->name}" : 'Tambah Karyawan Baru';
    $breadLast   = $isEdit ? 'Edit' : 'Tambah Baru';
    $submitLabel = $isEdit ? 'Update Karyawan' : 'Simpan Karyawan';
    $formDesc    = $isEdit ? 'Perbarui data lengkap pegawai.' : 'Tambahkan data lengkap pegawai baru.';
    $joinDate    = $isEdit ? $employee->join_date->format('Y-m-d') : date('Y-m-d');
@endphp
<x-app-layout>
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <x-ui.page-header :title="$pageTitle" :breadcrumbs="['HRD', ['label' => 'Karyawan', 'url' => route('hrd.employees.index')], $breadLast]" />
            <x-form :action="$action" :method="$method" cancelRoute="{{ route('hrd.employees.index') }}" :submitLabel="$submitLabel" title="Data Profil Karyawan" :description="$formDesc">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="col-span-1 md:col-span-2">
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                        <input type="text" name="name" id="name" value="{{ old('name', $employee->name ?? '') }}" required class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        @error('name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-span-1 md:col-span-2">
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Alamat Email <span class="text-red-500">*</span></label>
                        <input type="email" name="email" id="email" value="{{ old('email', $employee->email ?? '') }}" required class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        @error('email') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-span-1">
                        <label for="position" class="block text-sm font-medium text-gray-700 mb-1">Posisi / Jabatan <span class="text-red-500">*</span></label>
                        <input type="text" name="position" id="position" value="{{ old('position', $employee->position ?? '') }}" required placeholder="Mis: Staff IT" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        @error('position') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-span-1">
                        <label for="department" class="block text-sm font-medium text-gray-700 mb-1">Departemen <span class="text-red-500">*</span></label>
                        <input type="text" name="department" id="department" value="{{ old('department', $employee->department ?? '') }}" required placeholder="Mis: IT & Engineering" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        @error('department') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-span-1">
                        <label for="join_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Bergabung <span class="text-red-500">*</span></label>
                        <input type="date" name="join_date" id="join_date" value="{{ old('join_date', $joinDate) }}" required class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        @error('join_date') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-span-1">
                        <label for="base_salary" class="block text-sm font-medium text-gray-700 mb-1">Gaji Pokok (Rp) <span class="text-red-500">*</span></label>
                        <input type="number" name="base_salary" id="base_salary" value="{{ old('base_salary', isset($employee) ? (int)$employee->base_salary : '') }}" required min="0" step="1" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        @error('base_salary') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-span-1">
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status Karyawan <span class="text-red-500">*</span></label>
                        <select name="status" id="status" required class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="active" {{ old('status', $employee->status ?? '') == 'active' ? 'selected' : '' }}>Aktif</option>
                            <option value="inactive" {{ old('status', $employee->status ?? '') == 'inactive' ? 'selected' : '' }}>Non-Aktif</option>
                            <option value="on_leave" {{ old('status', $employee->status ?? '') == 'on_leave' ? 'selected' : '' }}>Cuti</option>
                        </select>
                        @error('status') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>
            </x-form>
        </div>
    </div>
</x-app-layout>
