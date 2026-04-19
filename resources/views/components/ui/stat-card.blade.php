@props(['title', 'value', 'icon', 'color' => 'indigo', 'description' => null])

@php
    $bgColors = [
        'indigo' => 'bg-indigo-50',
        'blue'   => 'bg-blue-50',
        'green'  => 'bg-green-50',
        'red'    => 'bg-red-50',
        'yellow' => 'bg-yellow-50',
        'purple' => 'bg-purple-50',
    ];

    $textColors = [
        'indigo' => 'text-indigo-600',
        'blue'   => 'text-blue-600',
        'green'  => 'text-green-600',
        'red'    => 'text-red-600',
        'yellow' => 'text-yellow-600',
        'purple' => 'text-purple-600',
    ];

    $bgColor = $bgColors[$color] ?? $bgColors['indigo'];
    $textColor = $textColors[$color] ?? $textColors['indigo'];
@endphp

<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 hover:shadow-md transition-shadow">
    <div class="flex items-center">
        <div class="p-3 rounded-full {{ $bgColor }} {{ $textColor }} mr-4">
            <i class="bx {{ $icon }} text-2xl"></i>
        </div>
        <div>
            <p class="mb-1 text-sm font-medium text-gray-500 uppercase tracking-wide">{{ $title }}</p>
            <p class="text-2xl font-bold text-gray-800">{{ $value }}</p>
            @if($description)
                <p class="text-xs text-gray-400 mt-1">{{ $description }}</p>
            @endif
        </div>
    </div>
</div>
