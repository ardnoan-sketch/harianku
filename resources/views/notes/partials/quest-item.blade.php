<div class="flex items-center justify-between p-4 rounded-xl border border-[var(--border-subtle)] hover:bg-[var(--bg-body)] transition-all group {{ $quest->is_completed ? 'opacity-60' : '' }}">
    <div class="flex items-center gap-4">
        <button onclick="toggleQuest({{ $quest->id }})" 
            class="w-6 h-6 rounded-full border-2 flex items-center justify-center transition-colors {{ $quest->is_completed ? 'bg-[var(--accent)] border-[var(--accent)] text-white' : 'border-[var(--border-subtle)] text-transparent hover:border-[var(--accent)]' }}">
            <i class="bx bx-check text-sm"></i>
        </button>
        <div>
            <p class="font-semibold text-[var(--text-primary)] {{ $quest->is_completed ? 'line-through' : '' }}">{{ $quest->title }}</p>
            <div class="flex items-center gap-2 mt-1">
                <span class="text-[10px] uppercase font-bold px-2 py-0.5 rounded bg-[var(--bg-body)] text-[var(--text-muted)] border border-[var(--border-subtle)]">
                    {{ $quest->period }}
                </span>
            </div>
        </div>
    </div>
    
    @if($quest->is_completed)
        <span class="text-[var(--accent)] text-xs font-bold uppercase tracking-widest">Completed</span>
    @endif
</div>
