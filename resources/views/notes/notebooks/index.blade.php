<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center w-full">
            <h2 class="font-semibold text-xl text-[var(--text-primary)] leading-tight">
                {{ __('My Notebooks') }}
            </h2>
            <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'new-notebook-modal')" class="inline-flex items-center px-4 py-2 bg-[var(--accent)] border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-[var(--accent-hover)] transition ease-in-out duration-150">
                New Notebook
            </button>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @forelse($notebooks as $notebook)
                <a href="{{ route('notes.notebooks.show', $notebook) }}" class="card-theme rounded-xl p-6 border bg-[var(--bg-surface)] border-[var(--border-subtle)] hover:shadow-xl transition-all duration-300 group">
                    <div class="flex flex-col items-center text-center">
                        <div class="p-4 rounded-2xl bg-yellow-100 dark:bg-yellow-900/30 text-yellow-600 mb-4 group-hover:scale-110 transition-transform">
                            <i class="bx bxs-folder-open text-4xl"></i>
                        </div>
                        <h3 class="font-bold text-[var(--text-primary)]">{{ $notebook->name }}</h3>
                        <p class="text-xs text-[var(--text-muted)] mt-1 uppercase tracking-tighter">{{ $notebook->items_count }} items</p>
                    </div>
                </a>
            @empty
                <div class="col-span-full py-20 text-center">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-[var(--bg-surface)] border border-[var(--border-subtle)] text-[var(--text-muted)] mb-4">
                        <i class="bx bx-folder text-3xl"></i>
                    </div>
                    <p class="text-[var(--text-muted)] italic">No notebooks yet. Organize your notes!</p>
                </div>
            @endforelse
        </div>
    </div>

    <x-modal name="new-notebook-modal" focusable>
        <form method="post" action="{{ route('notes.notebooks.store') }}" class="p-6 bg-[var(--bg-surface)]">
            @csrf
            <h2 class="text-lg font-medium text-[var(--text-primary)]">Create New Notebook</h2>
            <div class="mt-6">
                <x-input-label for="name" value="Notebook Name" class="text-[var(--text-primary)]" />
                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full bg-[var(--bg-body)] border-[var(--border-subtle)] text-[var(--text-primary)]" required />
            </div>
            <div class="mt-6 flex justify-end gap-3">
                <x-secondary-button x-on:click="$dispatch('close')">Cancel</x-secondary-button>
                <x-primary-button class="bg-[var(--accent)]">Create</x-primary-button>
            </div>
        </form>
    </x-modal>
</x-app-layout>
