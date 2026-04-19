@props(['type' => 'success', 'message' => null])

@php
    $typeClasses = [
        'success' => 'bg-green-50 border-green-200 text-green-800',
        'error'   => 'bg-red-50 border-red-200 text-red-800',
        'warning' => 'bg-yellow-50 border-yellow-200 text-yellow-800',
        'info'    => 'bg-blue-50 border-blue-200 text-blue-800',
    ];

    $iconClasses = [
        'success' => 'bx-check-circle text-green-500',
        'error'   => 'bx-x-circle text-red-500',
        'warning' => 'bx-error text-yellow-500',
        'info'    => 'bx-info-circle text-blue-500',
    ];

    $activeClass = $typeClasses[$type] ?? $typeClasses['info'];
    $iconClass = $iconClasses[$type] ?? $iconClasses['info'];
@endphp

@if ($message || session($type))
    <div {{ $attributes->merge(['class' => "p-4 mb-4 border rounded-lg flex items-start gap-3 $activeClass"]) }} role="alert" x-data="{ show: true }" x-show="show" x-transition>
        <i class="bx {{ $iconClass }} text-xl mt-0.5"></i>
        <div class="flex-1 text-sm font-medium">
            {{ $message ?? session($type) }}
        </div>
        <button type="button" @click="show = false" class="text-gray-400 hover:text-gray-600 transition-colors">
            <i class="bx bx-x text-xl"></i>
        </button>
    </div>
@endif
