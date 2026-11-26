<section class="chat-card chat-history">
    <h2 class="chat-label">Percakapan saya</h2>
    <button type="button" class="chat-new" wire:click="$dispatch('select-thread', { id: null })"><span aria-hidden="true">＋</span> Percakapan baru</button>
    <div class="chat-history-list">
        @forelse($threads as $thread)
            <button class="chat-thread" type="button" wire:key="thread-{{ $thread->id }}" wire:click="$dispatch('select-thread', { id: '{{ $thread->id }}' })">{{ $thread->title }}</button>
        @empty
            <p class="chat-muted">Percakapan tersimpan setelah pertanyaan pertama.</p>
        @endforelse
    </div>
</section>
