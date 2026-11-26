<section class="chat-card scan-card">
    <h2 class="chat-label">Periksa berkas</h2>
    <p class="chat-muted">Hitung baris dan sidik jari SHA-256 dokumen teks.</p>
    <form wire:submit="scan" class="scan-form">
        <label for="document" class="chat-muted">TXT atau MD · maks. 2 MB</label>
        <input id="document" type="file" wire:model="document" accept=".txt,.md" required>
        <button class="chat-secondary" wire:loading.attr="disabled">Periksa</button>
        <span wire:loading class="chat-muted" role="status">Memproses berkas…</span>
    </form>
    @error('document') <p class="error" role="alert">{{ $message }}</p> @enderror
    @if($status)
        <div class="scan-result" @if(!isset($status['error']) && $status['progress'] < 100) wire:poll.1s @endif role="status">
            <strong>{{ $scan['name'] }}</strong>
            @if(isset($status['error']))
                <p>Pemeriksaan gagal. Silakan unggah kembali.</p>
            @else
                <progress value="{{ $status['progress'] }}" max="100" aria-label="Progres pemeriksaan"></progress>
                @if(isset($status['hash']))
                    <p>{{ $status['lines'] }} baris · {{ number_format($status['bytes'], 0, ',', '.') }} byte</p>
                    <details><summary>SHA-256</summary><code>{{ $status['hash'] }}</code></details>
                @else
                    <p>{{ $status['progress'] }}% diperiksa</p>
                @endif
            @endif
        </div>
    @endif
</section>
