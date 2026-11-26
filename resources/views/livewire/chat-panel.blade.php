<div class="chat-main">
    <section class="chat-card chat-room">
        <header class="room-heading">
            <span class="chat-monogram" aria-hidden="true">R</span>
            <div><p class="chat-label">Asisten riset</p><h2>{{ $thread?->title ?? 'Percakapan baru' }}</h2></div>
        </header>
        <div class="chat-transcript" wire:key="transcript-{{ $conversationId }}" x-data x-init="$el.scrollTop = $el.scrollHeight"
             x-on:chat-scroll.window="$nextTick(() => $el.scrollTop = $el.scrollHeight)" aria-label="Pesan percakapan">
            @forelse($messages as $message)
                <article class="chat-message {{ $message->role === 'user' ? 'from-user' : 'from-ai' }}" wire:key="msg-{{ $message->id }}">
                    <span class="message-author">{{ $message->role === 'user' ? 'Anda' : 'ResearchMate' }}</span>
                    @if($message->id === $codeMessageId)
                        <p>{{ $explanation }}<a class="code-link" href="#cuplikan-kode">Lihat cuplikan kode →</a></p>
                    @else
                        <p>{{ $message->content }}</p>
                    @endif
                    @if($message->model)<small>{{ $message->model }}</small>@endif
                </article>
            @empty
                <div class="chat-welcome">
                    <h3>Mulai dari pertanyaan riset Anda</h3>
                    <p>Gunakan salah satu contoh atau tulis pertanyaan sendiri.</p>
                    @foreach(['Bagaimana menyusun pertanyaan riset?', 'Buat contoh kode Python untuk membaca CSV.'] as $example)
                        <button type="button" class="prompt-example" x-on:click="$wire.prompt = @js($example); document.getElementById('chat-prompt')?.focus()">{{ $example }}</button>
                    @endforeach
                </div>
            @endforelse
            @if($messages->last()?->role === 'user')
                <div class="chat-message from-ai" wire:loading>
                    <span class="message-author">ResearchMate</span>
                    <p wire:stream="reply" class="stream-text"></p>
                </div>
            @endif
        </div>
        <div class="chat-composer">
            @error('reply')<p class="error" role="alert">{{ $message }}</p>@enderror
            @if($messages->last()?->role === 'user')
                <span wire:loading class="chat-muted" role="status">ResearchMate sedang menulis…</span>
                <button type="button" class="chat-secondary" wire:loading.remove wire:click="answer('{{ $messages->last()->turn_id }}')">Lanjutkan jawaban</button>
            @else
                <form wire:submit="send" x-data>
                    <label for="chat-prompt" class="chat-label">Pertanyaan Anda</label>
                    <textarea id="chat-prompt" wire:model="prompt" rows="2" required maxlength="1000" placeholder="Tulis pesan untuk ResearchMate…"></textarea>
                    @error('prompt')<p class="error" role="alert">{{ $message }}</p>@enderror
                    <div class="composer-actions"><span>Maks. 1.000 karakter</span>
                        <button type="submit" class="chat-send" wire:loading.attr="disabled"><span wire:loading.remove>Kirim pesan ↑</span><span wire:loading>Mengirim…</span></button>
                    </div>
                </form>
            @endif
        </div>
    </section>
    <section class="code-panel" id="cuplikan-kode" aria-label="Cuplikan kode">
        <div class="code-heading"><span aria-hidden="true">&lt;/&gt;</span><h2>Cuplikan kode</h2></div>
        @forelse($blocks as $block)
            <div class="code-block" wire:key="code-{{ $conversationId }}-{{ $loop->index }}-{{ md5($block[0]) }}">
                <h3>{{ $block[1] ?: 'teks' }}</h3>
                <research-code wire:ignore><pre><code data-syntax="{{ $block[1] }}">{{ rtrim($block[2]) }}</code></pre></research-code>
            </div>
        @empty
            <p>Kode dari jawaban asisten akan muncul di sini.</p>
        @endforelse
    </section>
</div>
