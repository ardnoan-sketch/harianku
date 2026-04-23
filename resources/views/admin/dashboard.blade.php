<x-app-layout>
    <x-ui.page-header title="Administrator Dashboard" :breadcrumbs="['Administrator', 'Dashboard']" />

    <x-ui.page-container padding="normal">
        <x-ui.stat-card 
            title="Total Pengguna" 
            :value="\App\Models\User::count()" 
            icon="bx-group" 
            description="User terdaftar di sistem"
        />

        <div class="card-theme rounded-xl p-6 border">
            <h3 class="text-xl font-bold text-[var(--text-primary)] mb-4">Sistem Administrasi</h3>
            <p class="text-[var(--text-secondary)]">
                Selamat datang di panel admin. Di sini Anda bisa mengelola pengguna, role, menu, modul, dan tema aplikasi.
            </p>

            <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <a href="{{ route('admin.users.index') }}" class="group card-theme rounded-xl p-4 border hover:shadow-md transition-all">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-[var(--accent-muted-bg)] flex items-center justify-center text-[var(--accent)]">
                            <i class="bx bx-user text-xl"></i>
                        </div>
                        <div>
                            <p class="text-xs text-[var(--text-muted)] uppercase font-semibold">Users</p>
                            <p class="text-lg font-bold text-[var(--text-primary)]">Manajemen</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('admin.menus.index') }}" class="group card-theme rounded-xl p-4 border hover:shadow-md transition-all">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-[var(--accent-muted-bg)] flex items-center justify-center text-[var(--accent)]">
                            <i class="bx bx-menu text-xl"></i>
                        </div>
                        <div>
                            <p class="text-xs text-[var(--text-muted)] uppercase font-semibold">Menu</p>
                            <p class="text-lg font-bold text-[var(--text-primary)]">Sidebar</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('admin.modules.index') }}" class="group card-theme rounded-xl p-4 border hover:shadow-md transition-all">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-[var(--accent-muted-bg)] flex items-center justify-center text-[var(--accent)]">
                            <i class="bx bx-cube text-xl"></i>
                        </div>
                        <div>
                            <p class="text-xs text-[var(--text-muted)] uppercase font-semibold">Modul</p>
                            <p class="text-lg font-bold text-[var(--text-primary)]">Aplikasi</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('admin.theme-modes.index') }}" class="group card-theme rounded-xl p-4 border hover:shadow-md transition-all">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-[var(--accent-muted-bg)] flex items-center justify-center text-[var(--accent)]">
                            <i class="bx bx-palette text-xl"></i>
                        </div>
                        <div>
                            <p class="text-xs text-[var(--text-muted)] uppercase font-semibold">Tema</p>
                            <p class="text-lg font-bold text-[var(--text-primary)]">Tampilan</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </x-ui.page-container>
</x-app-layout>
