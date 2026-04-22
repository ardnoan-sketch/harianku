<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center w-full">
            <div class="flex items-center gap-4">
                <a href="{{ route('notebooks.index') }}" class="text-[var(--text-muted)] hover:text-[var(--text-primary)]">
                    <i class="bx bx-arrow-back text-2xl"></i>
                </a>
                <h2 class="font-semibold text-xl text-[var(--text-primary)] leading-tight">
                    {{ $notebook->name }}
                </h2>
            </div>
            <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'new-item-modal')" class="inline-flex items-center px-4 py-2 bg-[var(--accent)] border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-[var(--accent-hover)] transition ease-in-out duration-150">
                Add Item
            </button>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @forelse($notebook->items as $item)
                <div class="card-theme rounded-xl p-6 border bg-[var(--bg-surface)] border-[var(--border-subtle)] flex flex-col">
                    <h3 class="font-bold text-lg text-[var(--text-primary)] mb-4 border-b border-[var(--border-subtle)] pb-2">{{ $item->title }}</h3>
                    <div class="text-sm text-[var(--text-secondary)] whitespace-pre-line flex-1">
                        {{ $item->content }}
                    </div>
                    <div class="mt-4 pt-2 text-[10px] text-[var(--text-muted)] italic text-right">
                        Added {{ $item->created_at->format('d M Y') }}
                    </div>
                </div>
            @empty
                <div class="col-span-full py-20 text-center">
                    <p class="text-[var(--text-muted)] italic">This notebook is empty.</p>
                </div>
            @endforelse
        </div>
    </div>

    <x-modal name="new-item-modal" focusable>
        <form method="post" action="{{ route('notebooks.items.store', $notebook) }}" class="p-6 bg-[var(--bg-surface)]">
            @csrf
            <h2 class="text-lg font-medium text-[var(--text-primary)]">Add Item to {{ $notebook->name }}</h2>
            
            <div class="mt-6">
                <x-input-label for="title" value="Item Title" class="text-[var(--text-primary)]" />
                <x-text-input id="title" name="title" type="text" class="mt-1 block w-full bg-[var(--bg-body)] border-[var(--border-subtle)] text-[var(--text-primary)]" required />
            </div>

            <div class="mt-4">
                <x-input-label for="content" value="Content" class="text-[var(--text-primary)]" />
                <textarea id="content" name="content" rows="6" class="block mt-1 w-full rounded-md border-[var(--border-subtle)] bg-[var(--bg-body)] text-[var(--text-primary)] focus:border-[var(--accent)] focus:ring-[var(--accent)]"></textarea>
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <x-secondary-button x-on:click="$dispatch('close')">Cancel</x-secondary-button>
                <x-primary-button class="bg-[var(--accent)]">Add Item</x-primary-button>
            </div>
        </form>
    </x-modal>
</x-app-layout>
