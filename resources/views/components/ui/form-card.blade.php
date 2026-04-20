@props(['title' => null, 'description' => null])

<div class="card-theme overflow-hidden sm:rounded-lg mb-6 border">
    @if($title || $description)
        <div class="px-6 py-4 border-b bg-[var(--header-icon-hover-bg)] flex justify-between items-center">
            <div>
                @if($title)
                    <h3 class="text-lg font-semibold text-[var(--text-primary)]">{{ $title }}</h3>
                @endif
                @if($description)
                    <p class="text-sm text-[var(--text-muted)] mt-1">{{ $description }}</p>
                @endif
            </div>
            @if(isset($actions))
                <div>
                    {{ $actions }}
                </div>
            @endif
        </div>
    @endif
    
    <div class="p-6">
        {{ $slot }}
    </div>
</div>

