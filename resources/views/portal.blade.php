<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Portal Utama
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
                <h3 class="text-xl font-bold">Selamat Datang, {{ $user->name }}! 👋</h3>
                <p class="text-gray-600 mt-2">Silakan pilih modul aplikasi yang ingin Anda akses di bawah ini.</p>
                <p class="text-sm text-gray-400 mt-1">Anda memiliki role: 
                    @foreach($user->roles as $role)
                        <span class="bg-indigo-100 text-indigo-700 px-2 py-0.5 rounded-full text-xs font-medium">{{ $role->name }}</span>
                    @endforeach
                </p>
            </div>

            @if($modules->isEmpty())
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 text-center">
                    <i class="bx bx-info-circle text-4xl text-yellow-400"></i>
                    <p class="mt-2 text-yellow-700 font-medium">Anda belum memiliki akses ke modul manapun.</p>
                    <p class="text-sm text-yellow-600 mt-1">Hubungi Administrator untuk mendapatkan akses.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($modules as $module)
                        <a href="{{ Route::has($module->entry_route) ? route($module->entry_route) : '#' }}" class="block group">
                            <div class="bg-gradient-to-br {{ $module->color_from }} {{ $module->color_to }} rounded-xl p-6 text-white shadow-lg transform transition-all duration-300 group-hover:scale-105 group-hover:shadow-xl">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center mb-4">
                                            <i class="{{ $module->icon_class }} text-2xl text-white"></i>
                                        </div>
                                        <h4 class="text-xl font-bold">{{ $module->label }}</h4>
                                        @if($module->description)
                                            <p class="text-white text-opacity-80 mt-2 text-sm leading-relaxed">{{ $module->description }}</p>
                                        @endif
                                    </div>
                                    <i class="bx bx-chevron-right text-2xl text-white text-opacity-60 group-hover:text-opacity-100 group-hover:translate-x-1 transition-transform duration-300 mt-1"></i>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
