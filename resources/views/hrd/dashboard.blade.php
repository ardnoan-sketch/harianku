<x-app-layout>
    <x-ui.page-header title="HRD Dashboard" :breadcrumbs="['HRD', 'Dashboard']" />

    <x-ui.page-container padding="normal">

            <!-- Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <x-ui.stat-card title="Total Karyawan" value="24" icon="bx-group" color="indigo" />
                <x-ui.stat-card title="Hadir Hari Ini" value="21" icon="bx-user-check" color="green" description="3 Tidak Hadir" />
                <x-ui.stat-card title="Pengajuan Cuti" value="2" icon="bx-calendar-exclamation" color="yellow" description="Menunggu Persetujuan" />
            </div>

            <!-- Coming Soon Notice -->
            <div class="bg-indigo-50 border border-indigo-200 rounded-lg p-8 text-center">
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-indigo-100 mb-4">
                    <i class="bx bx-cog text-3xl text-indigo-600 animate-spin-slow"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Modul HRD Sedang Dalam Pengembangan</h3>
                <p class="text-gray-600 max-w-2xl mx-auto mb-6">
                    Halaman ini adalah pratinjau dari Modul HRD. Fitur manajemen karyawan, absensi, dan penggajian akan segera hadir di versi mendatang menggunakan fondasi UI modular yang telah dibangun.
                </p>
                
                <div class="flex justify-center gap-4">
                    <span class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700">
                        <i class="bx bx-group mr-2 text-indigo-500"></i> Manajemen Karyawan
                    </span>
                    <span class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700">
                        <i class="bx bx-calendar-check mr-2 text-green-500"></i> Sistem Absensi
                    </span>
                    <span class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700">
                        <i class="bx bx-money mr-2 text-yellow-500"></i> Penggajian (Payroll)
                    </span>
                </div>
        </div>
    </x-ui.page-container>
</x-app-layout>
