@props([
    'title' => null,
    'description' => null,
    'action',
    'method' => 'POST',
    'cancelRoute' => null,
    'submitLabel' => 'Save'
])

<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
    @if($title || $description)
        <div class="px-6 py-5 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
            <div>
                @if($title)
                    <h3 class="text-lg font-semibold text-gray-800">{{ $title }}</h3>
                @endif
                @if($description)
                    <p class="text-sm text-gray-500 mt-1">{{ $description }}</p>
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

            <div class="pt-6 mt-6 flex justify-end gap-3 border-t border-gray-200">
                @if($cancelRoute)
                    <a href="{{ $cancelRoute }}" class="px-4 py-2 bg-white border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 transition">Cancel</a>
                @endif
                <button type="submit" class="px-4 py-2 bg-indigo-600 border border-transparent rounded-md shadow-sm text-sm font-medium text-white hover:bg-indigo-700 transition">
                    {{ $submitLabel }}
                </button>
            </div>
        </form>
    </div>
</div>
