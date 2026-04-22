<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-[var(--text-primary)] leading-tight">
            {{ __('Quest System') }}
        </h2>
    </x-slot>

    <div class="py-6 space-y-6">
        {{-- Progress Indicator --}}
        <div class="card-theme rounded-xl p-6 border shadow-sm bg-[var(--bg-surface)] border-[var(--border-subtle)]">
            <div class="flex justify-between items-center mb-2">
                <span class="text-sm font-medium text-[var(--text-muted)] uppercase tracking-wider">Overall Progress</span>
                <span class="text-lg font-bold text-[var(--accent)]">{{ $progress }}%</span>
            </div>
            <div class="w-full bg-[var(--bg-body)] rounded-full h-3 overflow-hidden">
                <div class="bg-[var(--accent)] h-full transition-all duration-500" style="width: {{ $progress }}%"></div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            {{-- Main Quests --}}
            <div class="card-theme rounded-xl p-6 border shadow-sm bg-[var(--bg-surface)] border-[var(--border-subtle)]">
                <div class="flex justify-between items-center mb-6">
                    <div class="flex items-center gap-3">
                        <div class="p-2 rounded-lg bg-purple-100 dark:bg-purple-900/30 text-purple-600">
                            <i class="bx bxs-star text-2xl"></i>
                        </div>
                        <h3 class="text-lg font-bold text-[var(--text-primary)]">Main Quests</h3>
                    </div>
                    <button onclick="openQuestModal('main')" class="text-sm text-[var(--accent)] hover:underline">Add New</button>
                </div>

                <div class="space-y-4">
                    @forelse($mainQuests as $quest)
                        @include('notes.partials.quest-item', ['quest' => $quest])
                    @empty
                        <p class="text-[var(--text-muted)] text-center py-4 italic">No main quests yet.</p>
                    @endforelse
                </div>
            </div>

            {{-- Side Quests --}}
            <div class="card-theme rounded-xl p-6 border shadow-sm bg-[var(--bg-surface)] border-[var(--border-subtle)]">
                <div class="flex justify-between items-center mb-6">
                    <div class="flex items-center gap-3">
                        <div class="p-2 rounded-lg bg-green-100 dark:bg-green-900/30 text-green-600">
                            <i class="bx bx-leaf text-2xl"></i>
                        </div>
                        <h3 class="text-lg font-bold text-[var(--text-primary)]">Side Quests</h3>
                    </div>
                    <button onclick="openQuestModal('side')" class="text-sm text-[var(--accent)] hover:underline">Add New</button>
                </div>

                <div class="space-y-4">
                    @forelse($sideQuests as $quest)
                        @include('notes.partials.quest-item', ['quest' => $quest])
                    @empty
                        <p class="text-[var(--text-muted)] text-center py-4 italic">No side quests yet.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    {{-- Modal for New Quest --}}
    <x-modal name="new-quest-modal" focusable>
        <form method="post" action="{{ route('notes.quests.store') }}" class="p-6 bg-[var(--bg-surface)]">
            @csrf
            <input type="hidden" name="type" id="quest-type-input">
            <h2 class="text-lg font-medium text-[var(--text-primary)]">
                Add New <span id="quest-type-label"></span> Quest
            </h2>

            <div class="mt-6">
                <x-input-label for="title" value="Quest Title" class="text-[var(--text-primary)]" />
                <x-text-input id="title" name="title" type="text" class="mt-1 block w-full bg-[var(--bg-body)] border-[var(--border-subtle)] text-[var(--text-primary)]" required />
            </div>

            <div class="mt-6">
                <x-input-label for="period" value="Period" class="text-[var(--text-primary)]" />
                <select name="period" id="period" class="mt-1 block w-full rounded-md border-[var(--border-subtle)] bg-[var(--bg-body)] text-[var(--text-primary)] focus:border-[var(--accent)] focus:ring-[var(--accent)]">
                    <option value="today">Today</option>
                    <option value="week">This Week</option>
                </select>
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <x-secondary-button x-on:click="$dispatch('close')">Cancel</x-secondary-button>
                <x-primary-button class="bg-[var(--accent)]">Create Quest</x-primary-button>
            </div>
        </form>
    </x-modal>

    @push('scripts')
    <script>
        function openQuestModal(type) {
            document.getElementById('quest-type-input').value = type;
            document.getElementById('quest-type-label').textContent = type.charAt(0).toUpperCase() + type.slice(1);
            window.dispatchEvent(new CustomEvent('open-modal', { detail: 'new-quest-modal' }));
        }

        function toggleQuest(id) {
            fetch(`/productivity/quests/${id}/toggle`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    location.reload(); // Quickest way to update progress bar and UI
                }
            });
        }
    </script>
    @endpush
</x-app-layout>
