@props([
    'fullWidth' => false,
    'narrow' => false,
    'padding' => 'normal', // 'none', 'small', 'normal', 'large'
    'spaceY' => true,
])

@php
$sizes = [
    'none' => '',
    'small' => 'py-4',
    'normal' => 'py-6 md:py-8',
    'large' => 'py-8 md:py-12',
];

$paddingClass = $sizes[$padding] ?? $sizes['normal'];

$widthClass = $narrow 
    ? 'max-w-3xl mx-auto' 
    : ($fullWidth 
        ? 'w-full' 
        : 'max-w-7xl mx-auto');
@endphp

<div {{ $attributes->merge(['class' => "$paddingClass $widthClass px-4 sm:px-6 lg:px-8"]) }}>
    @if($spaceY)
        <div class="space-y-6">
            {{ $slot }}
        </div>
    @else
        {{ $slot }}
    @endif
</div>
