@props([
    'type' => 'text',
    'name',
    'id' => null,
    'value' => null,
    'label' => null,
    'placeholder' => null,
    'required' => false,
    'readonly' => false,
    'disabled' => false,
    'autofocus' => false,
    'errorBag' => 'default',
    'helpText' => null,
    'prefix' => null,
    'suffix' => null,
    'rows' => 4,
    'options' => [], // for select
    'multiple' => false,
])

@php
$inputId = $id ?? $name;
$error = $errors->has($name);
$inputClasses = "w-full rounded-lg border bg-[var(--bg-surface)] text-[var(--text-primary)] placeholder-[var(--text-muted)] 
    transition-all duration-200 ease-in-out
    focus:outline-none focus:ring-2 focus:ring-[var(--accent)] focus:border-[var(--accent)]
    disabled:opacity-60 disabled:cursor-not-allowed
    read-only:bg-[var(--bg-body)] read-only:cursor-default";

if ($error) {
    $inputClasses .= " border-red-500 focus:ring-red-500 focus:border-red-500";
} else {
    $inputClasses .= " border-[var(--border-subtle)]";
}

// Size-specific classes
if ($type === 'textarea') {
    $inputClasses .= " px-4 py-3 text-sm resize-y";
} elseif ($type === 'select') {
    $inputClasses .= " px-3 py-2.5 pr-10 text-sm";
} elseif ($type === 'checkbox' || $type === 'radio') {
    $inputClasses = "h-4 w-4 rounded border-[var(--border-subtle)] text-[var(--accent)] focus:ring-[var(--accent)] transition";
} else {
    $inputClasses .= " px-3 py-2.5 text-sm";
}
@endphp

<div class="w-full">
    @if($label && !in_array($type, ['checkbox', 'radio']))
        <label for="{{ $inputId }}" class="block text-sm font-medium text-[var(--text-secondary)] mb-1.5">
            {{ $label }}
            @if($required)
                <span class="text-[var(--danger)]">*</span>
            @endif
        </label>
    @endif

    @if($prefix || $suffix)
        <div class="relative rounded-md shadow-sm">
            @if($prefix)
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <span class="text-[var(--text-muted)] sm:text-sm">{{ $prefix }}</span>
                </div>
            @endif
    @endif

    @if($type === 'textarea')
        <textarea
            name="{{ $name }}"
            id="{{ $inputId }}"
            rows="{{ $rows }}"
            @if($placeholder) placeholder="{{ $placeholder }}" @endif
            @if($required) required @endif
            @if($readonly) readonly @endif
            @if($disabled) disabled @endif
            @if($autofocus) autofocus @endif
            {{ $attributes->merge(['class' => $inputClasses]) }}
        >{{ old($name, $value) }}</textarea>
    @elseif($type === 'select')
        <select
            name="{{ $name }}"
            id="{{ $inputId }}"
            @if($required) required @endif
            @if($readonly) readonly @endif
            @if($disabled) disabled @endif
            @if($autofocus) autofocus @endif
            @if($multiple) multiple @endif
            {{ $attributes->merge(['class' => $inputClasses]) }}
        >
            {{ $slot }}
        </select>
    @elseif($type === 'checkbox' || $type === 'radio')
        <div class="flex items-center">
            <input
                type="{{ $type }}"
                name="{{ $name }}"
                id="{{ $inputId }}"
                value="{{ $value ?? '1' }}"
                @if($required) required @endif
                @if($disabled) disabled @endif
                @if($autofocus) autofocus @endif
                @checked(old($name, $attributes->get('checked')))
                {{ $attributes->merge(['class' => $inputClasses]) }}
            />
            @if($label)
                <label for="{{ $inputId }}" class="ml-2 block text-sm text-[var(--text-secondary)] cursor-pointer select-none">
                    {{ $label }}
                    @if($required)
                        <span class="text-[var(--danger)]">*</span>
                    @endif
                </label>
            @endif
        </div>
    @else
        <input
            type="{{ $type }}"
            name="{{ $name }}"
            id="{{ $inputId }}"
            value="{{ old($name, $value) }}"
            @if($placeholder) placeholder="{{ $placeholder }}" @endif
            @if($required) required @endif
            @if($readonly) readonly @endif
            @if($disabled) disabled @endif
            @if($autofocus) autofocus @endif
            {{ $attributes->merge(['class' => $inputClasses]) }}
        />
    @endif

    @if($prefix || $suffix)
        @if($suffix)
            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                <span class="text-[var(--text-muted)] sm:text-sm">{{ $suffix }}</span>
            </div>
        @endif
        </div>
    @endif

    @if($helpText && !$error)
        <p class="mt-1.5 text-xs text-[var(--text-muted)]">{{ $helpText }}</p>
    @endif

    @if($error)
        <p class="mt-1.5 text-xs text-[var(--danger)] flex items-center gap-1">
            <i class="bx bx-error-circle"></i>
            {{ $errors->first($name) }}
        </p>
    @endif
</div>
