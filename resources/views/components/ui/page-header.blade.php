@props(['title', 'breadcrumbs' => []])

<div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
    <div>
        <h2 class="text-2xl font-bold text-gray-800 leading-tight">
            {{ $title }}
        </h2>
        
        @if(count($breadcrumbs) > 0)
            <nav class="flex text-sm text-gray-500 mt-1" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2">
                    <li class="inline-flex items-center">
                        <a href="{{ route('portal') }}" class="inline-flex items-center hover:text-indigo-600 transition-colors">
                            <i class="bx bx-home mr-1 text-lg"></i>
                            Portal
                        </a>
                    </li>
                    @foreach($breadcrumbs as $breadcrumb)
                        <li>
                            <div class="flex items-center">
                                <i class="bx bx-chevron-right text-gray-400 text-lg mx-1"></i>
                                @if(isset($breadcrumb['url']))
                                    <a href="{{ $breadcrumb['url'] }}" class="hover:text-indigo-600 transition-colors">{{ $breadcrumb['label'] }}</a>
                                @else
                                    <span class="text-gray-400 font-medium">{{ $breadcrumb['label'] ?? $breadcrumb }}</span>
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
