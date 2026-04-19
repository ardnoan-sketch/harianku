@props([
    'title' => null,
    'description' => null,
    'createRoute' => null,
    'createLabel' => 'Tambah Baru',
    'searchRoute' => null,
    'searchPlaceholder' => 'Search data...',
    'headers' => [],
    'pagination' => null
])

<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
    <!-- Header: Title, Description & Actions -->
    <div class="p-5 border-b border-gray-200 flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-gray-50">
        <div>
            @if($title)
                <h3 class="text-lg font-semibold text-gray-800">{{ $title }}</h3>
            @endif
            @if($description)
                <p class="text-sm text-gray-500 mt-1">{{ $description }}</p>
            @endif
        </div>
        @if($createRoute)
            <div>
                <a href="{{ $createRoute }}" class="inline-flex items-center justify-center px-4 py-2 bg-indigo-600 text-white rounded-md font-medium text-sm hover:bg-indigo-700 transition gap-2 shadow-sm">
                    <i class="bx bx-plus text-lg"></i> {{ $createLabel }}
                </a>
            </div>
        @endif
    </div>

    <!-- Filters & Search -->
    <div class="p-4 border-b border-gray-200 bg-white">
        <form action="{{ $searchRoute ?? url()->current() }}" method="GET" class="flex flex-col sm:flex-row sm:items-end gap-4">
            
            @if(isset($filters))
                {{ $filters }}
            @endif

            <!-- Default Search -->
            <div class="flex-1 min-w-[200px]">
                <label class="block text-xs font-medium text-gray-500 mb-1">Search</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="bx bx-search text-gray-400"></i>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ $searchPlaceholder }}" class="pl-10 w-full border-gray-300 rounded-md shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500">
                </div>
            </div>

            <!-- Filter Buttons -->
            <div class="flex gap-2">
                <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-gray-700 transition shadow-sm">Filter</button>
                <a href="{{ $searchRoute ?? url()->current() }}" class="bg-gray-100 text-gray-600 px-4 py-2 rounded-md text-sm font-medium hover:bg-gray-200 transition">Reset</a>
            </div>
        </form>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-600 border-collapse">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b border-gray-200">
                <tr>
                    @foreach($headers as $header)
                        <th scope="col" class="px-6 py-4 font-semibold tracking-wider whitespace-nowrap">{{ $header }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                {{ $slot }}
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($pagination)
        <div class="p-4 border-t border-gray-200 bg-gray-50 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div class="text-sm text-gray-500">
                Showing
                <span class="font-medium text-gray-700">{{ $pagination->firstItem() ?? 0 }}</span>
                &ndash;
                <span class="font-medium text-gray-700">{{ $pagination->lastItem() ?? 0 }}</span>
                of
                <span class="font-medium text-gray-700">{{ $pagination->total() }}</span>
                records
                (Page {{ $pagination->currentPage() }} / {{ $pagination->lastPage() }})
            </div>
            <div>
                {{ $pagination->links() }}
            </div>
        </div>
    @endif
</div>
