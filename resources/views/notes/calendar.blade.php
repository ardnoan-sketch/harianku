<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-[var(--text-primary)] leading-tight">
            {{ __('Activity Calendar') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="card-theme rounded-xl overflow-hidden border bg-[var(--bg-surface)] border-[var(--border-subtle)]">
            <div class="p-6 border-b border-[var(--border-subtle)] flex justify-between items-center">
                <h3 class="text-lg font-bold text-[var(--text-primary)]" id="calendar-month-year"></h3>
                <div class="flex gap-2">
                    <button onclick="changeMonth(-1)" class="p-2 rounded-lg hover:bg-[var(--bg-body)] text-[var(--text-primary)] border border-[var(--border-subtle)]">
                        <i class="bx bx-chevron-left"></i>
                    </button>
                    <button onclick="changeMonth(1)" class="p-2 rounded-lg hover:bg-[var(--bg-body)] text-[var(--text-primary)] border border-[var(--border-subtle)]">
                        <i class="bx bx-chevron-right"></i>
                    </button>
                </div>
            </div>
            
            <div class="p-6">
                <div class="grid grid-cols-7 gap-px bg-[var(--border-subtle)] border border-[var(--border-subtle)] rounded-lg overflow-hidden">
                    {{-- Day headers --}}
                    @foreach(['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $day)
                        <div class="bg-[var(--bg-body)] p-3 text-center text-xs font-bold uppercase tracking-widest text-[var(--text-muted)]">
                            {{ $day }}
                        </div>
                    @endforeach

                    {{-- Calendar cells --}}
                    <div id="calendar-grid" class="contents">
                        {{-- Filled by JS --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Day Detail Modal --}}
    <x-modal name="day-detail-modal" focusable>
        <div class="p-6 bg-[var(--bg-surface)]">
            <h2 class="text-xl font-bold text-[var(--text-primary)] mb-4" id="modal-date-title"></h2>
            <div id="modal-content" class="space-y-4">
                {{-- Loaded via AJAX --}}
            </div>
            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">Close</x-secondary-button>
            </div>
        </div>
    </x-modal>

    @push('scripts')
    <script>
        let currentYear = new Date().getFullYear();
        let currentMonth = new Date().getMonth();
        const activeDates = {!! json_encode($activeDates) !!};

        function renderCalendar() {
            const firstDay = new Date(currentYear, currentMonth, 1).getDay();
            const daysInMonth = new Date(currentYear, currentMonth + 1, 0).getDate();
            const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
            
            document.getElementById('calendar-month-year').textContent = `${monthNames[currentMonth]} ${currentYear}`;
            
            const grid = document.getElementById('calendar-grid');
            grid.innerHTML = '';

            // Blank days
            for (let i = 0; i < firstDay; i++) {
                const div = document.createElement('div');
                div.className = 'bg-[var(--bg-surface)] h-24 sm:h-32';
                grid.appendChild(div);
            }

            // Days with dates
            for (let day = 1; day <= daysInMonth; day++) {
                const dateStr = `${currentYear}-${String(currentMonth + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
                const isActive = activeDates.includes(dateStr);
                const isToday = new Date().toISOString().split('T')[0] === dateStr;

                const div = document.createElement('div');
                div.className = `bg-[var(--bg-surface)] h-24 sm:h-32 p-2 border-b border-r border-[var(--border-subtle)] hover:bg-[var(--bg-body)] transition-colors cursor-pointer relative group`;
                div.onclick = () => loadDayDetail(dateStr);
                
                div.innerHTML = `
                    <span class="text-sm font-bold ${isToday ? 'bg-[var(--accent)] text-white w-7 h-7 flex items-center justify-center rounded-full' : 'text-[var(--text-muted)]'}">${day}</span>
                    ${isActive ? '<div class="absolute bottom-2 left-1/2 -translate-x-1/2 w-1.5 h-1.5 rounded-full bg-[var(--accent)] shadow-[0_0_8px_var(--accent)]"></div>' : ''}
                `;
                grid.appendChild(div);
            }
        }

        function changeMonth(delta) {
            currentMonth += delta;
            if (currentMonth < 0) {
                currentMonth = 11;
                currentYear--;
            } else if (currentMonth > 11) {
                currentMonth = 0;
                currentYear++;
            }
            renderCalendar();
        }

        function loadDayDetail(date) {
            document.getElementById('modal-date-title').textContent = date;
            document.getElementById('modal-content').innerHTML = '<p class="text-center py-4 text-[var(--text-muted)] animate-pulse">Loading activity...</p>';
            window.dispatchEvent(new CustomEvent('open-modal', { detail: 'day-detail-modal' }));

            fetch(`{{ route('notes.myday') }}?date=${date}`, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(res => res.json())
            .then(data => {
                let html = '';
                if (data.tasks.length === 0) {
                    html = '<p class="text-[var(--text-muted)] italic">No activity recorded for this day.</p>';
                } else {
                    const types = ['morning', 'afternoon', 'evening'];
                    types.forEach(type => {
                        const typeTasks = data.tasks.filter(t => t.type === type);
                        if (typeTasks.length > 0) {
                            html += `<div class="mb-4">
                                <h4 class="text-xs font-bold uppercase text-[var(--text-muted)] mb-2 tracking-widest">${type}</h4>
                                <div class="space-y-1">
                                    ${typeTasks.map(t => `
                                        <div class="flex items-center gap-2 text-sm text-[var(--text-primary)]">
                                            <i class="bx ${t.is_completed ? 'bx-check-circle text-[var(--accent)]' : 'bx-circle text-[var(--text-muted)]'}"></i>
                                            <span class="${t.is_completed ? 'line-through opacity-50' : ''}">${t.title}</span>
                                        </div>
                                    `).join('')}
                                </div>
                            </div>`;
                        }
                    });
                }
                document.getElementById('modal-content').innerHTML = html;
            });
        }

        document.addEventListener('DOMContentLoaded', renderCalendar);
    </script>
    @endpush
</x-app-layout>
