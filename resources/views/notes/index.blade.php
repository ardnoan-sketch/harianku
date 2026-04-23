<x-app-layout>
    <x-ui.page-header title="My Notes" :breadcrumbs="['Productivity', 'Notes']">
        <x-slot:actions>
            <a href="{{ route('notes.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-[var(--accent)] text-white rounded-lg font-medium text-sm hover:bg-[var(--accent-hover)] transition shadow-sm">
                <i class="bx bx-plus text-lg"></i> New Note
            </a>
        </x-slot:actions>
    </x-ui.page-header>

    <x-ui.page-container padding="normal">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($notes as $note)
                <div class="card-theme rounded-xl overflow-hidden border bg-[var(--bg-surface)] border-[var(--border-subtle)] flex flex-col group hover:shadow-lg transition-all duration-300">
                    <div class="p-5 flex-1">
                        <div class="flex justify-between items-start mb-4">
                            <span class="text-[10px] uppercase font-bold px-2 py-0.5 rounded bg-[var(--bg-body)] text-[var(--text-muted)] border border-[var(--border-subtle)]">
                                {{ str_replace('_', ' ', $note->type) }}
                            </span>
                            <div class="flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                <a href="{{ route('notes.edit', $note) }}" class="text-[var(--text-muted)] hover:text-[var(--accent)]">
                                    <i class="bx bx-edit-alt"></i>
                                </a>
                                <form action="{{ route('notes.destroy', $note) }}" method="POST" onsubmit="return confirm('Hapus catatan ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-[var(--text-muted)] hover:text-red-500">
                                        <i class="bx bx-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                        <h3 class="text-lg font-bold text-[var(--text-primary)] mb-2">{{ $note->title }}</h3>
                        <p class="text-sm text-[var(--text-muted)] line-clamp-4">{{ $note->content }}</p>
                    </div>
                    <div class="px-5 py-3 bg-[var(--bg-body)] border-t border-[var(--border-subtle)] flex justify-between items-center">
                        <span class="text-[10px] text-[var(--text-muted)] italic">{{ $note->created_at->diffForHumans() }}</span>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-20 text-center">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-[var(--bg-surface)] border border-[var(--border-subtle)] text-[var(--text-muted)] mb-4">
                        <i class="bx bx-note text-3xl"></i>
                    </div>
                    <p class="text-[var(--text-muted)] italic">No notes found. Create your first one!</p>
                </div>
            @endforelse
        </div>

        @if($notes->hasPages())
            <div class="mt-8 theme-pagination">
                {{ $notes->links() }}
            </div>
        @endif
    </x-ui.page-container>
</x-app-layout>
