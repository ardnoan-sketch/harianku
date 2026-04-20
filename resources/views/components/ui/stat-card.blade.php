@props(['title', 'value', 'icon', 'color' => 'indigo', 'description' => null])

@php
    $colorMaps = [
        'indigo' => ['bg' => 'rgba(79, 70, 229, 0.1)', 'text' => '#4f46e5'],
        'blue'   => ['bg' => 'rgba(37, 99, 235, 0.1)', 'text' => '#2563eb'],
        'green'  => ['bg' => 'rgba(22, 163, 74, 0.1)', 'text' => '#16a34a'],
        'red'    => ['bg' => 'rgba(220, 38, 38, 0.1)', 'text' => '#dc3838'],
        'yellow' => ['bg' => 'rgba(202, 138, 4, 0.1)', 'text' => '#ca8a04'],
        'purple' => ['bg' => 'rgba(147, 51, 234, 0.1)', 'text' => '#9333ea'],
    ];

    $selectedColor = $colorMaps[$color] ?? $colorMaps['indigo'];
@endphp

<div class="card-theme overflow-hidden sm:rounded-lg p-6 hover:shadow-md transition-shadow border">
    <div class="flex items-center">
        <div class="p-3 rounded-full mr-4" style="background-color: {{ $selectedColor['bg'] }}; color: {{ $selectedColor['text'] }};">
            <i class="bx {{ $icon }} text-2xl"></i>
        </div>
        <div>
            <p class="mb-1 text-xs font-medium text-[var(--text-muted)] uppercase tracking-widest">{{ $title }}</p>
            <p class="text-2xl font-bold text-[var(--text-primary)]">{{ $value }}</p>
            @if($description)
                <p class="text-xs text-[var(--text-muted)] opacity-80 mt-1">{{ $description }}</p>
            @endif
        </div>
    </div>
</div>

