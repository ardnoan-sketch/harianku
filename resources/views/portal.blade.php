<x-app-layout>
    <x-ui.page-header title="Portal Utama" :breadcrumbs="['Home']" />

    <x-ui.page-container padding="normal">
            
            <div class="card-theme rounded-xl p-6 mb-6 border bg-[var(--bg-surface)] border-[var(--border-subtle)]">
                <h3 class="text-xl font-bold text-[var(--text-primary)]">Selamat Datang, {{ $user->name }}! 👋</h3>
                <p class="text-[var(--text-secondary)] mt-2">Silakan pilih modul aplikasi yang ingin Anda akses di bawah ini.</p>
                <div class="flex flex-wrap gap-2 mt-4">
                    @foreach($user->roles as $role)
                        <span class="bg-[var(--accent-muted-bg)] text-[var(--accent)] px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider border border-[var(--accent)] border-opacity-20">
                            {{ $role->name }}
                        </span>
                    @endforeach
                </div>
            </div>

            @if($modules->isEmpty())
                <div class="card-theme rounded-xl p-8 text-center border bg-[var(--bg-surface)] border-[var(--border-subtle)]">
                    <div class="w-20 h-20 bg-[var(--bg-body)] rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="bx bx-info-circle text-5xl text-[var(--text-muted)]"></i>
                    </div>
                    <p class="text-[var(--text-primary)] font-bold text-lg">Akses Terbatas</p>
                    <p class="text-[var(--text-muted)] mt-1">Anda belum memiliki akses ke modul manapun. Hubungi Administrator.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($modules as $module)
                        <a href="{{ Route::has($module->entry_route) ? route($module->entry_route) : (Route::has('productivity.' . $module->entry_route) ? route('productivity.' . $module->entry_route) : (Route::has('notes.' . $module->entry_route) ? route('notes.' . $module->entry_route) : '#')) }}" 
                           class="block group cursor-pointer"
                           style="isolation: isolate;">
                            <div class="relative h-full bg-gradient-to-br {{ $module->color_from }} {{ $module->color_to }} rounded-2xl p-8 text-white shadow-lg transition-transform duration-300 active:scale-95 group-hover:-translate-y-1 group-hover:shadow-xl overflow-hidden">
                                {{-- Decorative element --}}
                                <div class="absolute -right-6 -bottom-6 w-32 h-32 bg-white bg-opacity-10 rounded-full blur-2xl transition-transform duration-500 group-hover:scale-110"></div>
                                
                                <div class="relative flex flex-col h-full">
                                    <div class="w-14 h-14 bg-white bg-opacity-20 rounded-xl flex items-center justify-center mb-6 shadow-inner">
                                        <i class="{{ $module->icon_class }} text-3xl text-white"></i>
                                    </div>
                                    <h4 class="text-2xl font-black tracking-tight mb-2 uppercase">{{ $module->label }}</h4>
                                    @if($module->description)
                                        <p class="text-white text-opacity-80 text-sm leading-relaxed mb-6">{{ $module->description }}</p>
                                    @endif
                                    
                                    <div class="mt-auto flex items-center gap-2 font-bold text-xs uppercase tracking-widest text-white text-opacity-70 group-hover:text-opacity-100 transition-opacity">
                                        Masuk Modul
                                        <i class="bx bx-right-arrow-alt text-lg"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
    </x-ui.page-container>
</x-app-layout>
