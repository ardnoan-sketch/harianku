@props([
    'title' => null,
    'description' => null,
    'action',
    'method' => 'POST',
    'cancelRoute' => null,
    'submitLabel' => 'Save'
])

<div class="card-theme overflow-hidden sm:rounded-lg border">
    @if($title || $description)
        <div class="px-6 py-5 border-b bg-[var(--header-icon-hover-bg)] flex justify-between items-center">
            <div>
                @if($title)
                    <h3 class="text-lg font-semibold text-[var(--text-primary)]">{{ $title }}</h3>
                @endif
                @if($description)
                    <p class="text-sm text-[var(--text-muted)] mt-1">{{ $description }}</p>
                @endif
            </div>
        </div>
    @endif
    
    <div class="p-6">
        <form action="{{ $action }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if(strtoupper($method) !== 'POST')
                @method($method)
            @endif
            
            <div class="space-y-6">
                {{ $slot }}
            </div>

            <div class="pt-6 mt-6 flex justify-end gap-3 border-t border-[var(--border-subtle)]">
                @if($cancelRoute)
                    <a href="{{ $cancelRoute }}" class="px-4 py-2 bg-[var(--bg-surface)] border border-[var(--border-subtle)] rounded-md shadow-sm text-sm font-medium text-[var(--text-secondary)] hover:bg-[var(--header-icon-hover-bg)] transition">Cancel</a>
                @endif
                <button type="submit" class="px-4 py-2 bg-[var(--accent)] border border-transparent rounded-md shadow-sm text-sm font-medium text-white hover:bg-[var(--accent-hover)] transition">
                    {{ $submitLabel }}
                </button>
            </div>
        </form>
    </div>
</div>

