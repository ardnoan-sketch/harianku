<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Administrator Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-xl font-bold mb-4">Sistem Administrasi</h3>
                    <p>Selamat datang di panel admin. Di sini Anda bisa mengelola pengguna, role, dan memonitor aktivitas sistem (Log).</p>
                    
                    <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="border rounded p-4 border-indigo-200 bg-indigo-50">
                            <h4 class="font-bold text-indigo-700">Total Pengguna</h4>
                            <p class="text-2xl mt-2">{{ \App\Models\User::count() }} User Terdaftar</p>
                        </div>
                        <div class="border rounded p-4 border-purple-200 bg-purple-50">
                            <h4 class="font-bold text-purple-700">Status Server</h4>
                            <p class="text-2xl mt-2 text-green-600">Online & Stabil</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
