@props(['type', 'logId'])

<div class="flex gap-2">
    <input type="text" id="input-{{ $type }}" placeholder="Tambah task baru..."
        class="flex-1 text-sm bg-transparent border-none focus:ring-0 text-[var(--text-primary)] placeholder-[var(--text-muted)]"
        onkeydown="if(event.key === 'Enter') addTask('{{ $type }}', {{ $logId }})">
    <button onclick="addTask('{{ $type }}', {{ $logId }})"
        class="p-1 rounded-md hover:bg-[var(--bg-body)] text-[var(--text-muted)] hover:text-[var(--accent)] transition-colors">
        <i class="bx bx-plus-circle text-xl"></i>
    </button>
</div>
