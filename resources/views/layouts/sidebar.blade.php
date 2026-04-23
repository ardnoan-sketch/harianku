@php
    $currentModule = request()->is('admin*')
        ? 'admin'
        : (request()->is('finance*')
            ? 'finance'
            : (request()->is('hrd*') ? 'hrd' : (request()->is('productivity*') ? 'productivity' : 'portal')));

    $menus = \App\Models\Menu::whereNull('parent_id')
        ->where('module', $currentModule)
        ->orderBy('order_no')
        ->with('children')
        ->get();

    // Helper function to check if a menu or any of its children is active
    $isMenuActive = function($menu) {
        if (request()->routeIs($menu->url_or_route)) {
            return true;
        }
        foreach ($menu->children as $child) {
            if (request()->routeIs($child->url_or_route)) {
                return true;
            }
        }
        return false;
    };
@endphp

<aside
    class="flex flex-col transition-all duration-300 ease-in-out shrink-0 h-full overflow-hidden text-[var(--text-primary)] border-r bg-[var(--sidebar-bg)] border-[var(--sidebar-border)]"
    :class="{
        'w-64': sidebarState === 'full',
        'w-20': sidebarState === 'mini',
        'w-0': sidebarState === 'hidden'
    }"
>
    <div class="h-16 flex items-center justify-center whitespace-nowrap overflow-hidden border-b border-[var(--sidebar-logo-border)]">
        <a href="{{ route('portal') }}" class="flex items-center gap-3">
            <x-application-logo class="w-8 h-8 fill-current text-[var(--accent)]" />
            <span class="font-bold text-xl tracking-wider uppercase transition-opacity duration-300 text-[var(--text-primary)]"
                :class="{'opacity-100': sidebarState === 'full', 'opacity-0 hidden': sidebarState === 'mini'}">
                {{ config('app.name') }}
            </span>
        </a>
    </div>

    <div class="flex-1 overflow-y-auto py-4 space-y-1 scrollbar-hide" x-data="{ search: '' }">

        <div class="px-5 mt-2 mb-4 text-[11px] font-bold uppercase tracking-widest transition-opacity duration-300 whitespace-nowrap flex items-center text-[var(--sidebar-muted)]"
            :class="{'opacity-100': sidebarState === 'full', 'opacity-0 hidden': sidebarState === 'mini'}">
            <span class="w-2 h-2 rounded-full mr-2 bg-[var(--accent)]"></span>
            {{ ucfirst($currentModule) }} Menu
        </div>

        <div class="px-4 mb-6 transition-opacity duration-300"
            :class="{'opacity-100 block': sidebarState === 'full', 'opacity-0 hidden': sidebarState === 'mini'}">
            <div class="relative flex items-center">
                <i class="bx bx-search absolute left-3 text-[var(--sidebar-muted)] text-lg"></i>
                <input type="text" x-model="search" placeholder="Cari menu..."
                    class="w-full text-sm rounded-lg py-2.5 pl-10 pr-4 transition-all bg-[var(--sidebar-input-bg)] text-[var(--text-primary)] placeholder-[var(--sidebar-muted)] border border-[var(--sidebar-input-border)] focus:border-[var(--accent)] focus:ring-1 focus:ring-[var(--accent)]">
            </div>
        </div>

        <ul class="space-y-1 px-2">
            @foreach($menus as $menu)
                @if(!$menu->permission_name || auth()->user()->can($menu->permission_name))
                    @php
                        $searchTerms = strtolower($menu->name);
                        $menuActive = $isMenuActive($menu);
                        foreach($menu->children as $child) {
                            $searchTerms .= ' ' . strtolower($child->name);
                        }
                    @endphp
                    <li x-data="{ open: {{ $menuActive ? 'true' : 'false' }} }"
                        x-init="$watch('search', val => { if(val !== '' && '{{ $searchTerms }}'.includes(val.toLowerCase())) { open = true; } })"
                        x-show="search === '' || '{{ $searchTerms }}'.includes(search.toLowerCase())"
                        class="mb-1">

                        @if($menu->children->count() > 0)
                            <button type="button" @click="open = !open; if(sidebarState==='mini') sidebarState='full'"
                                class="w-full flex items-center justify-between p-3 rounded-lg transition-all active:scale-[0.98] group cursor-pointer {{ $menuActive ? 'bg-[var(--sidebar-active)] text-white shadow-sm' : 'hover:bg-[var(--sidebar-hover)] text-[var(--text-primary)]' }}"
                                :class="{'px-3': sidebarState === 'full', 'px-0 justify-center': sidebarState === 'mini'}"
                            >
                                <div class="flex items-center gap-3">
                                    @if($menu->icon_type === 'class')
                                        <i class="{{ $menu->icon_value }} text-xl {{ $menuActive ? 'text-white' : 'text-[var(--sidebar-muted)] group-hover:text-[var(--text-primary)]' }}"></i>
                                    @else
                                        <img src="{{ Storage::url($menu->icon_value) }}" class="w-6 h-6 object-contain filter {{ $menuActive ? 'grayscale-0' : 'grayscale group-hover:grayscale-0' }}" alt="">
                                    @endif

                                    <span class="font-medium whitespace-nowrap transition-opacity duration-300"
                                        :class="{'opacity-100 block': sidebarState === 'full', 'opacity-0 hidden': sidebarState === 'mini'}">
                                        {{ $menu->name }}
                                    </span>
                                </div>
                                <i class="bx bx-chevron-down transition-transform duration-300 {{ $menuActive ? 'text-white rotate-180' : 'text-[var(--sidebar-muted)]' }}"
                                   :class="{'rotate-180': open, 'hidden': sidebarState === 'mini'}"></i>
                            </button>

                            <ul x-show="open && sidebarState === 'full'"
                                x-collapse
                                class="mt-1 space-y-1 pl-11 pr-2 py-1">
                                @foreach($menu->children as $child)
                                    @if(!$child->permission_name || auth()->user()->can($child->permission_name))
                                    @php $childActive = request()->routeIs($child->url_or_route); @endphp
                                    <li x-show="search === '' || '{{ strtolower($child->name) }}'.includes(search.toLowerCase())"
                                        class="leading-none">
                                        <a href="{{ $child->url_or_route ? (Route::has($child->url_or_route) ? route($child->url_or_route) : url($child->url_or_route)) : '#' }}"
                                           class="block px-3 py-2 rounded-lg text-sm transition-all {{ $childActive ? 'bg-[var(--sidebar-active)] bg-opacity-20 text-[var(--sidebar-active)] font-medium' : 'text-[var(--sidebar-muted)] hover:text-[var(--text-primary)] hover:bg-[var(--sidebar-hover)]' }}">
                                            {{ $child->name }}
                                        </a>
                                    </li>
                                    @endif
                                @endforeach
                            </ul>
                        @else
                            <a href="{{ $menu->url_or_route ? (Route::has($menu->url_or_route) ? route($menu->url_or_route) : url($menu->url_or_route)) : '#' }}"
                               class="flex items-center gap-3 p-3 rounded-lg transition-all active:scale-[0.98] group {{ $menuActive ? 'bg-[var(--sidebar-active)] hover:bg-[var(--sidebar-active-hover)] text-white shadow-sm' : 'hover:bg-[var(--sidebar-hover)] text-[var(--text-primary)]' }}"
                                :class="{'px-3': sidebarState === 'full', 'px-0 justify-center': sidebarState === 'mini'}"
                               title="{{ $menu->name }}"
                            >
                                @if($menu->icon_type === 'class')
                                    <i class="{{ $menu->icon_value }} text-xl {{ $menuActive ? 'text-white' : 'text-[var(--sidebar-muted)] group-hover:text-[var(--text-primary)]' }}"></i>
                                @else
                                    <img src="{{ Storage::url($menu->icon_value) }}" class="w-6 h-6 object-contain filter {{ $menuActive ? 'grayscale-0' : 'grayscale group-hover:grayscale-0' }}" alt="">
                                @endif

                                <span class="font-medium whitespace-nowrap transition-opacity duration-300"
                                    :class="{'opacity-100 block': sidebarState === 'full', 'opacity-0 hidden': sidebarState === 'mini'}">
                                    {{ $menu->name }}
                                </span>
                            </a>
                        @endif
                    </li>
                @endif
            @endforeach
        </ul>
    </div>
</aside>
