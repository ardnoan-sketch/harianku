@props(['title' => null, 'description' => null])

<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
    @if($title || $description)
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
            <div>
                @if($title)
                    <h3 class="text-lg font-semibold text-gray-800">{{ $title }}</h3>
                @endif
                @if($description)
                    <p class="text-sm text-gray-500 mt-1">{{ $description }}</p>
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
