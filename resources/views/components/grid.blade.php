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
                <label class="block text-xs font-medium text-[var(--text-muted)] mb-1">Search</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="bx bx-search text-[var(--text-muted)]"></i>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ $searchPlaceholder }}" class="pl-10 w-full bg-[var(--bg-surface)] border-[var(--border-subtle)] text-[var(--text-primary)] rounded-md shadow-sm text-sm focus:ring-[var(--accent)] focus:border-[var(--accent)]">
                </div>
            </div>

            <!-- Filter Buttons -->
            <div class="flex gap-2">
                <button type="submit" class="bg-[var(--text-secondary)] text-[var(--bg-surface)] px-4 py-2 rounded-md text-sm font-medium hover:opacity-90 transition shadow-sm">Filter</button>
                <a href="{{ $searchRoute ?? url()->current() }}" class="bg-[var(--header-icon-hover-bg)] text-[var(--text-secondary)] px-4 py-2 rounded-md text-sm font-medium hover:opacity-80 transition">Reset</a>
            </div>
        </form>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left border-collapse">
            <thead class="text-xs text-[var(--text-primary)] uppercase bg-[var(--header-icon-hover-bg)] border-b border-[var(--border-subtle)]">
                <tr>
                    @foreach($headers as $header)
                        <th scope="col" class="px-6 py-4 font-semibold tracking-wider whitespace-nowrap">{{ $header }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody class="divide-y divide-[var(--border-subtle)] [&_tr]:bg-[var(--table-row-bg)]">
                {{ $slot }}
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($pagination)
        <div class="p-4 border-t border-[var(--border-subtle)] bg-[var(--header-icon-hover-bg)] flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div class="text-sm text-[var(--text-muted)]">
                Showing
                <span class="font-medium text-[var(--text-primary)]">{{ $pagination->firstItem() ?? 0 }}</span>
                &ndash;
                <span class="font-medium text-[var(--text-primary)]">{{ $pagination->lastItem() ?? 0 }}</span>
                of
                <span class="font-medium text-[var(--text-primary)]">{{ $pagination->total() }}</span>
                records
                (Page {{ $pagination->currentPage() }} / {{ $pagination->lastPage() }})
            </div>
            <div class="theme-pagination">
                {{ $pagination->links() }}
            </div>
        </div>
    @endif
</div>

