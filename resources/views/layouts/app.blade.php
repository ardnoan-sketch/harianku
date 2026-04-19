<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="{{ $activeThemeSlug ?? 'light' }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link href="https://fonts.bunny.net/css?family=press-start-2p:400&display=swap" rel="stylesheet" />

        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

        @if(!empty($activeThemeMode?->css_tokens) && is_array($activeThemeMode->css_tokens))
            <style>
                html[data-theme="{{ e($activeThemeSlug) }}"] {
                    @foreach($activeThemeMode->css_tokens as $prop => $val)
                        {{ e($prop) }}: {!! e($val) !!};
                    @endforeach
                }
            </style>
        @endif

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="theme-shell antialiased relative" style="font-family: var(--font-ui, Figtree, ui-sans-serif, system-ui, sans-serif)" x-data="{ sidebarState: localStorage.getItem('sidebarState') || 'full' }" x-init="$watch('sidebarState', val => localStorage.setItem('sidebarState', val))">
        @if(($activeThemeSlug ?? '') === 'retro')
            <div class="pointer-events-none fixed inset-0 z-[100] theme-retro-scanlines opacity-40" aria-hidden="true"></div>
        @endif

        <div class="flex h-screen overflow-hidden bg-[var(--bg-body)] text-[var(--text-primary)]">
            @if(!request()->routeIs('portal'))
                @include('layouts.sidebar')
            @endif

            <div class="flex flex-col flex-1 w-full overflow-hidden">
                @include('layouts.header')

                <main class="flex-1 overflow-y-auto p-4 md:p-6 bg-[var(--bg-main)]">
                    @isset($header)
                        <div class="mb-6 flex justify-between items-center">
                            {{ $header }}
                        </div>
                    @endisset

                    {{ $slot }}
                </main>

                <footer class="theme-footer shrink-0 py-4 px-6 text-sm text-center border-t bg-[var(--footer-bg)] border-[var(--footer-border)] text-[var(--footer-text)]">
                    &copy; {{ date('Y') }} {{ config('app.name', 'Harianku') }}. All rights reserved. <br>
                    <span class="text-xs opacity-80">Built with Laravel & Tailwind CSS</span>
                </footer>
            </div>
        </div>
    </body>
</html>
