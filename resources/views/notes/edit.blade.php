<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-[var(--text-primary)] leading-tight">
            {{ __('Edit Note') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-2xl mx-auto">
            <div class="card-theme rounded-xl overflow-hidden border bg-[var(--bg-surface)] border-[var(--border-subtle)] p-6">
                <form method="POST" action="{{ route('notes.notes.update', $note) }}">
                    @csrf
                    @method('PATCH')

                    <div>
                        <x-input-label for="title" :value="__('Title')" class="text-[var(--text-primary)]" />
                        <x-text-input id="title" class="block mt-1 w-full bg-[var(--bg-body)] border-[var(--border-subtle)] text-[var(--text-primary)]" type="text" name="title" :value="old('title', $note->title)" required autofocus />
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="type" :value="__('Type')" class="text-[var(--text-primary)]" />
                        <select name="type" id="type" class="block mt-1 w-full rounded-md border-[var(--border-subtle)] bg-[var(--bg-body)] text-[var(--text-primary)] focus:border-[var(--accent)] focus:ring-[var(--accent)]">
                            <option value="general_note" {{ $note->type === 'general_note' ? 'selected' : '' }}>General Note</option>
                            <option value="daily_note" {{ $note->type === 'daily_note' ? 'selected' : '' }}>Daily Note</option>
                        </select>
                        <x-input-error :messages="$errors->get('type')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="content" :value="__('Content')" class="text-[var(--text-primary)]" />
                        <textarea id="content" name="content" rows="10" class="block mt-1 w-full rounded-md border-[var(--border-subtle)] bg-[var(--bg-body)] text-[var(--text-primary)] focus:border-[var(--accent)] focus:ring-[var(--accent)]" placeholder="Write your thoughts here...">{{ old('content', $note->content) }}</textarea>
                        <x-input-error :messages="$errors->get('content')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end mt-6 gap-4">
                        <a href="{{ route('notes.notes.index') }}" class="text-sm text-[var(--text-muted)] hover:text-[var(--text-primary)] transition-colors">
                            {{ __('Cancel') }}
                        </a>
                        <x-primary-button class="bg-[var(--accent)]">
                            {{ __('Update Note') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
