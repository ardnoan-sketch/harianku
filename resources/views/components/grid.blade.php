@props([
    'title' => null,
    'description' => null,
    'createRoute' => null,
    'createLabel' => 'Tambah Baru',
    'searchRoute' => null,
    'searchPlaceholder' => 'Cari data...',
    'headers' => [],
    'sortable' => [], // Array of column keys that are sortable
    'pagination' => null,
    'emptyTitle' => 'Tidak ada data',
    'emptyDescription' => 'Data yang Anda cari tidak ditemukan.',
    'emptyIcon' => 'bx-inbox',
    'showCheckbox' => false, // Enable row selection
])

<div class="card-theme overflow-hidden sm:rounded-lg border">
    <!-- Header: Title, Description & Actions -->
    <div class="p-5 border-b flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-[var(--header-icon-hover-bg)]">
        <div>
            @if($title)
                <h3 class="text-lg font-semibold text-[var(--text-primary)]">{{ $title }}</h3>
            @endif
            @if($description)
                <p class="text-sm text-[var(--text-muted)] mt-1">{{ $description }}</p>
            @endif
        </div>
        @if($createRoute)
            <div>
                <a href="{{ $createRoute }}" class="inline-flex items-center justify-center px-4 py-2 bg-[var(--accent)] text-white rounded-md font-medium text-sm hover:bg-[var(--accent-hover)] transition gap-2 shadow-sm">
                    <i class="bx bx-plus text-lg"></i> {{ $createLabel }}
                </a>
            </div>
        @endif
    </div>

    <!-- Filters & Search -->
    <div class="p-4 border-b bg-[var(--bg-surface)]">
        <form action="{{ $searchRoute ?? url()->current() }}" method="GET" class="flex flex-col sm:flex-row sm:items-end gap-4">
            
            @if(isset($filters))
                {{ $filters }}
            @endif

            <!-- Default Search -->
            <div class="flex-1 min-w-[200px]">
                <label class="block text-xs font-medium text-[var(--text-muted)] mb-1.5">Pencarian</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="bx bx-search text-[var(--text-muted)]"></i>
                    </div>
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ request('search') }}" 
                        placeholder="{{ $searchPlaceholder }}" 
                        class="pl-10 w-full bg-[var(--bg-surface)] border border-[var(--border-subtle)] text-[var(--text-primary)] rounded-lg shadow-sm text-sm 
                               focus:outline-none focus:ring-2 focus:ring-[var(--accent)] focus:border-[var(--accent)] transition-all duration-200"
                    >
                </div>
            </div>

            <!-- Filter Buttons -->
            <div class="flex gap-2">
                <button type="submit" class="inline-flex items-center gap-1.5 bg-[var(--accent)] text-white px-4 py-2.5 rounded-lg text-sm font-medium hover:bg-[var(--accent-hover)] transition shadow-sm">
                    <i class="bx bx-filter-alt"></i> Filter
                </button>
                <a href="{{ $searchRoute ?? url()->current() }}" class="inline-flex items-center gap-1.5 bg-[var(--header-icon-hover-bg)] text-[var(--text-secondary)] px-4 py-2.5 rounded-lg text-sm font-medium hover:bg-[var(--sidebar-hover)] transition border border-[var(--border-subtle)]">
                    <i class="bx bx-reset"></i> Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left border-collapse">
            <thead class="text-xs text-[var(--text-secondary)] uppercase bg-[var(--header-icon-hover-bg)] border-b border-[var(--border-subtle)]">
                <tr>
                    @if($showCheckbox)
                        <th scope="col" class="px-4 py-3.5 w-10">
                            <input type="checkbox" class="h-4 w-4 rounded border-[var(--border-subtle)] text-[var(--accent)] focus:ring-[var(--accent)] cursor-pointer">
                        </th>
                    @endif
                    @foreach($headers as $key => $header)
                        @php
                            $isSortable = in_array($key, $sortable);
                            $currentSort = request('sort');
                            $currentDirection = request('direction', 'asc');
                        @endphp
                        <th scope="col" class="px-6 py-3.5 font-semibold tracking-wider whitespace-nowrap @if($loop->first) pl-6 @endif @if($loop->last) pr-6 @endif">
                            @if($isSortable)
                                <a href="{{ url()->current() }}?{{ http_build_query(array_merge(request()->except(['sort', 'direction']), ['sort' => $key, 'direction' => $currentSort === $key && $currentDirection === 'asc' ? 'desc' : 'asc'])) }}" 
                                   class="group inline-flex items-center gap-1 hover:text-[var(--accent)] transition-colors">
                                    {{ $header }}
                                    <span class="inline-flex flex-col text-[10px] leading-none text-[var(--text-muted)] group-hover:text-[var(--accent)]">
                                        <i class="bx bxs-up-arrow{{ $currentSort === $key && $currentDirection === 'asc' ? ' text-[var(--accent)]' : '' }}" style="font-size: 8px;"></i>
                                        <i class="bx bxs-down-arrow{{ $currentSort === $key && $currentDirection === 'desc' ? ' text-[var(--accent)]' : '' }}" style="font-size: 8px;"></i>
                                    </span>
                                </a>
                            @else
                                {{ $header }}
                            @endif
                        </th>
                    @endforeach
                </tr>
            </thead>
            <tbody class="divide-y divide-[var(--border-subtle)]" x-data="{ selectedRows: [] }">
                {{ $slot }}
            </tbody>
        </table>
    </div>

    <!-- Empty State (if provided) -->
    @if(isset($empty) && $pagination && $pagination->isEmpty())
        <div class="p-12 text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-[var(--header-icon-hover-bg)] border border-[var(--border-subtle)] text-[var(--text-muted)] mb-4">
                <i class="bx {{ $emptyIcon }} text-3xl"></i>
            </div>
            <h4 class="text-lg font-semibold text-[var(--text-primary)] mb-1">{{ $emptyTitle }}</h4>
            <p class="text-sm text-[var(--text-muted)] max-w-sm mx-auto">{{ $emptyDescription }}</p>
            @if($createRoute)
                <div class="mt-4">
                    <a href="{{ $createRoute }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-[var(--accent)] hover:text-[var(--accent-hover)] transition">
                        <i class="bx bx-plus"></i>
                        {{ $createLabel }}
                    </a>
                </div>
            @endif
        </div>
    @endif

    <!-- Pagination -->
    @if($pagination && !$pagination->isEmpty())
        <div class="p-4 border-t border-[var(--border-subtle)] bg-[var(--header-icon-hover-bg)] flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="text-sm text-[var(--text-muted)]">
                Menampilkan
                <span class="font-medium text-[var(--text-primary)]">{{ $pagination->firstItem() ?? 0 }}</span>
                &ndash;
                <span class="font-medium text-[var(--text-primary)]">{{ $pagination->lastItem() ?? 0 }}</span>
                dari
                <span class="font-medium text-[var(--text-primary)]">{{ $pagination->total() }}</span>
                data
                <span class="hidden sm:inline">(Halaman {{ $pagination->currentPage() }} / {{ $pagination->lastPage() }})</span>
            </div>
            <div class="theme-pagination">
                {{ $pagination->links() }}
            </div>
        </div>
    @endif
</div>

