<div class="flex items-center gap-3 p-2 rounded-lg hover:bg-[var(--bg-body)] transition-colors group">
    <input type="checkbox" {{ $task->is_completed ? 'checked' : '' }} 
        onchange="toggleTask({{ $task->id }}, this.checked)"
        class="w-5 h-5 rounded border-[var(--border-subtle)] text-[var(--accent)] focus:ring-[var(--accent)] cursor-pointer">
    <span class="text-[var(--text-primary)] text-sm group-hover:translate-x-1 transition-transform {{ $task->is_completed ? 'line-through opacity-50' : '' }}">
        {{ $task->title }}
    </span>
</div>
