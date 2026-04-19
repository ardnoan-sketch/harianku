<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <x-ui.page-header title="Data Karyawan" :breadcrumbs="['HRD', 'Karyawan']" />
            <x-ui.alert type="success" />
            <x-ui.alert type="error" />

            <x-grid 
                title="Data Karyawan" 
                description="Kelola data pegawai, posisi, dan departemen di perusahaan Anda."
                createRoute="{{ route('hrd.employees.create') }}"
                createLabel="Tambah Karyawan"
                :headers="['Nama', 'Email', 'Posisi', 'Departemen', 'Gaji Pokok', 'Tgl Gabung', 'Status', 'Aksi']"
                :pagination="$employees"
            >
                <x-slot name="filters">
                    <div class="w-full sm:w-auto">
                        <label class="block text-xs font-medium text-gray-500 mb-1">Status</label>
                        <select name="status" class="w-full border-gray-300 rounded-md shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">Semua Status</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Non-Aktif</option>
                            <option value="on_leave" {{ request('status') == 'on_leave' ? 'selected' : '' }}>Cuti</option>
                        </select>
                    </div>
                </x-slot>

                @forelse($employees as $employee)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $employee->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $employee->email }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $employee->position }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $employee->department }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            Rp {{ number_format($employee->base_salary, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            {{ $employee->join_date->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            {{ $employee->status === 'active' ? 'Aktif' : ($employee->status === 'inactive' ? 'Non-Aktif' : 'Cuti') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="{{ route('hrd.employees.edit', $employee->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-3"><i class="bx bx-edit text-lg"></i></a>
                            <form action="{{ route('hrd.employees.destroy', $employee->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus karyawan ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900"><i class="bx bx-trash text-lg"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-6 py-8 text-center text-sm text-gray-500">
                            Tidak ada data karyawan ditemukan.
                        </td>
                    </tr>
                @endforelse
            </x-grid>
        </div>
    </div>
</x-app-layout>
