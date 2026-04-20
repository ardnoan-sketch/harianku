@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm text-[var(--text-secondary)]']) }}>
    {{ $value ?? $slot }}
</label>
