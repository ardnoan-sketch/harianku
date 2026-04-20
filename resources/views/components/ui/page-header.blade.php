@props(['title', 'breadcrumbs' => []])

<div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
    <div>
        <h2 class="text-2xl font-bold text-[var(--text-primary)] leading-tight">
            {{ $title }}
        </h2>
        
        @if(count($breadcrumbs) > 0)
            <nav class="flex text-sm text-[var(--text-muted)] mt-1" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2">
                    <li class="inline-flex items-center">
                        <a href="{{ route('portal') }}" class="inline-flex items-center text-[var(--text-secondary)] hover:text-[var(--accent)] transition-colors">
                            <i class="bx bx-home mr-1 text-lg"></i>
                            Portal
                        </a>
                    </li>
                    @foreach($breadcrumbs as $breadcrumb)
                        <li>
                            <div class="flex items-center">
                                <i class="bx bx-chevron-right text-[var(--text-muted)] text-lg mx-1"></i>
                                @if(isset($breadcrumb['url']))
                                    <a href="{{ $breadcrumb['url'] }}" class="text-[var(--text-secondary)] hover:text-[var(--accent)] transition-colors">{{ $breadcrumb['label'] }}</a>
                                @else
                                    <span class="text-[var(--text-muted)] font-medium">{{ $breadcrumb['label'] ?? $breadcrumb }}</span>
                                @endif
                            </div>
                        </li>
                    @endforeach
                </ol>
            </nav>
        @endif
    </div>

    @if(isset($actions))
        <div class="flex items-center gap-3">
            {{ $actions }}
        </div>
    @endif
</div>
