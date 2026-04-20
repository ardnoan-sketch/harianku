@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'bg-[var(--bg-surface)] border-[var(--border-subtle)] text-[var(--text-primary)] focus:border-[var(--accent)] focus:ring-[var(--accent)] rounded-md shadow-sm']) }}>
