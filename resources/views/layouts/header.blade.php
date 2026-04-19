<header class="h-16 shrink-0 flex items-center justify-between px-4 sm:px-6 z-10 shadow-sm border-b bg-[var(--header-bg)] border-[var(--header-border)]">
    <div class="flex items-center gap-2">
        @if(!request()->routeIs('portal'))
        <button type="button" @click="sidebarState = (sidebarState === 'full' ? 'mini' : (sidebarState === 'mini' ? 'hidden' : 'full'))"
                class="text-[var(--header-icon)] hover:text-[var(--header-icon-hover)] p-2 rounded-md transition-colors focus:outline-none flex items-center justify-center hover:bg-[var(--header-icon-hover-bg)]">
            <i class="text-2xl transition-transform duration-300"
               :class="{
                   'bx bx-menu': sidebarState === 'hidden',
                   'bx bx-menu-alt-left': sidebarState === 'full',
                   'bx bx-grid-alt': sidebarState === 'mini'
               }"></i>
        </button>
        @endif

        @if(!request()->routeIs('portal'))
        <div class="ml-2 hidden sm:flex space-x-2">
            <a href="{{ route('portal') }}" class="text-sm flex items-center gap-1 font-medium px-3 py-1.5 rounded-full transition-colors bg-[var(--portal-pill-bg)] text-[var(--portal-pill-text)] hover:opacity-90">
                <i class="bx bx-arrow-back"></i> Back to Portal
            </a>
        </div>
        @endif
    </div>

    <div class="flex items-center gap-3 sm:gap-4">
        @auth
            @if(isset($selectableThemeModes) && $selectableThemeModes->isNotEmpty())
                <form method="POST" action="{{ route('preferences.theme') }}" class="hidden md:flex items-center gap-2" title="Tema tampilan">
                    @csrf
                    @method('PATCH')
                    <label for="header_theme_mode" class="sr-only">Tema</label>
                    <select id="header_theme_mode" name="theme_mode_id" onchange="this.form.submit()"
                        class="text-xs sm:text-sm rounded-md border shadow-sm py-1.5 pl-2 pr-8 max-w-[10rem] sm:max-w-xs bg-[var(--bg-surface)] border-[var(--border-subtle)] text-[var(--text-secondary)] focus:ring-[var(--accent)] focus:border-[var(--accent)]">
                        @foreach($selectableThemeModes as $mode)
                            <option value="{{ $mode->id }}" @selected($activeThemeMode && (int) $activeThemeMode->id === (int) $mode->id)>
                                {{ $mode->name }}
                            </option>
                        @endforeach
                    </select>
                </form>
            @endif
        @endauth

        <x-dropdown align="right" width="48">
            <x-slot name="trigger">
                <button type="button" class="inline-flex items-center px-3 py-2 border text-sm leading-4 font-medium rounded-md focus:outline-none transition ease-in-out duration-150 bg-[var(--bg-surface)] border-[var(--border-subtle)] text-[var(--text-secondary)] hover:text-[var(--text-primary)]">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-sm" style="background: var(--user-avatar-bg); color: var(--user-avatar-text);">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <span class="hidden md:block">{{ Auth::user()->name }}</span>
                    </div>
                    <div class="ms-1">
                        <i class="bx bx-chevron-down text-lg"></i>
                    </div>
                </button>
            </x-slot>

            <x-slot name="content">
                @if(isset($selectableThemeModes) && $selectableThemeModes->isNotEmpty())
                    <div class="md:hidden px-4 py-2 border-b border-gray-100">
                        <form method="POST" action="{{ route('preferences.theme') }}" class="space-y-1">
                            @csrf
                            @method('PATCH')
                            <label class="text-xs text-gray-500">Tema</label>
                            <select name="theme_mode_id" onchange="this.form.submit()" class="w-full text-sm rounded-md border-gray-300 shadow-sm">
                                @foreach($selectableThemeModes as $mode)
                                    <option value="{{ $mode->id }}" @selected($activeThemeMode && (int) $activeThemeMode->id === (int) $mode->id)>{{ $mode->name }}</option>
                                @endforeach
                            </select>
                        </form>
                    </div>
                @endif
                <x-dropdown-link :href="route('profile.edit')">
                    <i class="bx bx-user mr-2"></i> {{ __('Profile') }}
                </x-dropdown-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-dropdown-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        <i class="bx bx-log-out mr-2"></i> {{ __('Log Out') }}
                    </x-dropdown-link>
                </form>
            </x-slot>
        </x-dropdown>
    </div>
</header>
