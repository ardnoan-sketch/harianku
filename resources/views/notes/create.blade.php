<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-[var(--text-primary)] leading-tight">
            {{ __('Create New Note') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-2xl mx-auto">
            <div class="card-theme rounded-xl overflow-hidden border bg-[var(--bg-surface)] border-[var(--border-subtle)] p-6">
                <form method="POST" action="{{ route('notes.store') }}">
                    @csrf

                    <div>
                        <x-input-label for="title" :value="__('Title')" class="text-[var(--text-primary)]" />
                        <x-text-input id="title" class="block mt-1 w-full bg-[var(--bg-body)] border-[var(--border-subtle)] text-[var(--text-primary)]" type="text" name="title" required autofocus />
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="type" :value="__('Type')" class="text-[var(--text-primary)]" />
                        <select name="type" id="type" class="block mt-1 w-full rounded-md border-[var(--border-subtle)] bg-[var(--bg-body)] text-[var(--text-primary)] focus:border-[var(--accent)] focus:ring-[var(--accent)]">
                            <option value="general_note">General Note</option>
                            <option value="daily_note">Daily Note</option>
                        </select>
                        <x-input-error :messages="$errors->get('type')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="content" :value="__('Content')" class="text-[var(--text-primary)]" />
                        <textarea id="content" name="content" rows="10" class="block mt-1 w-full rounded-md border-[var(--border-subtle)] bg-[var(--bg-body)] text-[var(--text-primary)] focus:border-[var(--accent)] focus:ring-[var(--accent)]" placeholder="Write your thoughts here..."></textarea>
                        <x-input-error :messages="$errors->get('content')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end mt-6 gap-4">
                        <a href="{{ route('notes.index') }}" class="text-sm text-[var(--text-muted)] hover:text-[var(--text-primary)] transition-colors">
                            {{ __('Cancel') }}
                        </a>
                        <x-primary-button class="bg-[var(--accent)]">
                            {{ __('Save Note') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
