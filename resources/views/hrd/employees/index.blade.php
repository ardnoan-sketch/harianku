<x-app-layout>
    <x-ui.page-header title="Data Karyawan" :breadcrumbs="['HRD', 'Karyawan']" />

    <x-ui.page-container padding="normal">
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
                        <label class="block text-xs font-medium text-[var(--text-muted)] mb-1">Status</label>
                        <select name="status" class="w-full rounded-md shadow-sm text-sm bg-[var(--bg-surface)] border-[var(--border-subtle)] text-[var(--text-primary)] focus:ring-[var(--accent)] focus:border-[var(--accent)]">
                            <option value="">Semua Status</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Non-Aktif</option>
                            <option value="on_leave" {{ request('status') == 'on_leave' ? 'selected' : '' }}>Cuti</option>
                        </select>
                    </div>
                </x-slot>

                @forelse($employees as $employee)
                    <tr class="hover:bg-[var(--table-row-hover)] transition">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-[var(--text-primary)]">{{ $employee->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-[var(--text-secondary)]">{{ $employee->email }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-[var(--text-secondary)]">{{ $employee->position }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-[var(--text-secondary)]">{{ $employee->department }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-[var(--text-secondary)]">
                            Rp {{ number_format($employee->base_salary, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-[var(--text-secondary)]">
                            {{ $employee->join_date->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-[var(--text-secondary)]">
                            {{ $employee->status === 'active' ? 'Aktif' : ($employee->status === 'inactive' ? 'Non-Aktif' : 'Cuti') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="{{ route('hrd.employees.edit', $employee->id) }}" class="text-[var(--accent)] hover:opacity-90 mr-3"><i class="bx bx-edit text-lg"></i></a>
                            <form action="{{ route('hrd.employees.destroy', $employee->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus karyawan ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-[var(--danger)] hover:text-[var(--danger-hover)]"><i class="bx bx-trash text-lg"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-6 py-8 text-center text-sm text-[var(--text-muted)]">
                            Tidak ada data karyawan ditemukan.
                        </td>
                    </tr>
                @endforelse
        </x-grid>
    </x-ui.page-container>
</x-app-layout>
