<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-[var(--text-primary)] leading-tight">
            {{ __('My Day') }} - {{ $dailyLog->date->format('d M Y') }}
        </h2>
    </x-slot>

    <div class="py-6 space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            {{-- Morning Tasks --}}
            <div class="card-theme rounded-xl p-6 border shadow-sm flex flex-col h-full bg-[var(--bg-surface)] border-[var(--border-subtle)]">
                <div class="flex items-center gap-3 mb-4">
                    <div class="p-2 rounded-lg bg-orange-100 dark:bg-orange-900/30 text-orange-600">
                        <i class="bx bx-sun text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-[var(--text-primary)]">Morning</h3>
                </div>
                
                <div class="flex-1 space-y-3" id="morning-tasks">
                    @foreach($dailyLog->tasks->where('type', 'morning') as $task)
                        @include('notes.partials.task-item', ['task' => $task])
                    @endforeach
                </div>

                <div class="mt-6 pt-4 border-t border-[var(--border-subtle)]">
                    <x-task-input type="morning" :logId="$dailyLog->id" />
                </div>
            </div>

            {{-- Afternoon Tasks --}}
            <div class="card-theme rounded-xl p-6 border shadow-sm flex flex-col h-full bg-[var(--bg-surface)] border-[var(--border-subtle)]">
                <div class="flex items-center gap-3 mb-4">
                    <div class="p-2 rounded-lg bg-blue-100 dark:bg-blue-900/30 text-blue-600">
                        <i class="bx bx-cloud text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-[var(--text-primary)]">Afternoon</h3>
                </div>

                <div class="flex-1 space-y-3" id="afternoon-tasks">
                    @foreach($dailyLog->tasks->where('type', 'afternoon') as $task)
                        @include('notes.partials.task-item', ['task' => $task])
                    @endforeach
                </div>

                <div class="mt-6 pt-4 border-t border-[var(--border-subtle)]">
                    <x-task-input type="afternoon" :logId="$dailyLog->id" />
                </div>
            </div>

            {{-- Evening Tasks --}}
            <div class="card-theme rounded-xl p-6 border shadow-sm flex flex-col h-full bg-[var(--bg-surface)] border-[var(--border-subtle)]">
                <div class="flex items-center gap-3 mb-4">
                    <div class="p-2 rounded-lg bg-indigo-100 dark:bg-indigo-900/30 text-indigo-600">
                        <i class="bx bx-moon text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-[var(--text-primary)]">Evening</h3>
                </div>

                <div class="flex-1 space-y-3" id="evening-tasks">
                    @foreach($dailyLog->tasks->where('type', 'evening') as $task)
                        @include('notes.partials.task-item', ['task' => $task])
                    @endforeach
                </div>

                <div class="mt-6 pt-4 border-t border-[var(--border-subtle)]">
                    <x-task-input type="evening" :logId="$dailyLog->id" />
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function toggleTask(id, isCompleted) {
            fetch('{{ route('notes.task.toggle') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ id: id, is_completed: isCompleted })
            });
        }

        function addTask(type, logId) {
            const input = document.getElementById(`input-${type}`);
            const title = input.value.trim();
            if (!title) return;

            fetch('{{ route('notes.task.store') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    daily_log_id: logId,
                    type: type,
                    title: title
                })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    const container = document.getElementById(`${type}-tasks`);
                    const div = document.createElement('div');
                    div.className = 'flex items-center gap-3 p-2 rounded-lg hover:bg-[var(--bg-body)] transition-colors group';
                    div.innerHTML = `
                        <input type="checkbox" onchange="toggleTask(${data.task.id}, this.checked)"
                            class="w-5 h-5 rounded border-[var(--border-subtle)] text-[var(--accent)] focus:ring-[var(--accent)] cursor-pointer">
                        <span class="text-[var(--text-primary)] text-sm group-hover:translate-x-1 transition-transform">${data.task.title}</span>
                    `;
                    container.appendChild(div);
                    input.value = '';
                }
            });
        }
    </script>
    @endpush
</x-app-layout>
