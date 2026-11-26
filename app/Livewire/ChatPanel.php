<?php

namespace App\Livewire;

use App\Services\LlmChatService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\Component;
use Throwable;

class ChatPanel extends Component
{
    #[Locked]
    public string $conversationId;

    #[Locked]
    public string $turnId;

    public string $prompt = '';

    public function mount(): void
    {
        $this->selectThread(auth()->user()->conversations()->latest('updated_at')->orderByDesc('id')->value('id'));
    }

    #[On('select-thread')]
    public function selectThread(?string $id = null): void
    {
        $this->conversationId = $id === null
            ? (string) Str::uuid()
            : auth()->user()->conversations()->findOrFail($id)->id;
        $this->turnId = (string) Str::uuid();
        $this->reset('prompt');
        $this->resetValidation();
    }

    public function send(): void
    {
        $this->prompt = trim($this->prompt);
        $this->validate(['prompt' => ['required', 'string', 'max:1000']], [
            'prompt.required' => 'Tulis pertanyaan terlebih dahulu.',
            'prompt.max' => 'Pertanyaan maksimal 1.000 karakter.',
        ]);

        $turn = DB::transaction(function () {
            $threads = auth()->user()->conversations();
            $threads->firstOrCreate(['id' => $this->conversationId], ['title' => Str::limit($this->prompt, 85)]);
            $thread = $threads->lockForUpdate()->findOrFail($this->conversationId);
            $last = $thread->messages()->latest('id')->first();
            if ($last?->role === 'user' || $thread->messages()->where('turn_id', $this->turnId)->exists()) {
                return null;
            }

            $thread->messages()->create(['role' => 'user', 'turn_id' => $this->turnId, 'content' => $this->prompt]);
            $thread->touch();

            return $this->turnId;
        });

        if ($turn !== null) {
            $this->reset('prompt');
            $this->turnId = (string) Str::uuid();
            $this->dispatch('history-updated');
            $this->dispatch('generate-reply', turn: $turn)->self();
            $this->dispatch('chat-scroll');
        }
    }

    #[On('generate-reply')]
    public function answer(string $turn, LlmChatService $llm): void
    {
        $thread = auth()->user()->conversations()->findOrFail($this->conversationId);
        $lock = Cache::lock('chat-reply:'.$thread->id, 3 * max(30, (int) config('llm.timeout')) + 30);
        if (! $lock->get()) {
            $this->addError('reply', 'Jawaban sedang diproses. Buka kembali percakapan sebentar lagi.');

            return;
        }

        try {
            $message = $thread->messages()->latest('id')->first();
            if ($message?->role !== 'user' || $message->turn_id !== $turn) {
                return;
            }
            $limit = 'workspace-chat:'.auth()->id();
            if (RateLimiter::tooManyAttempts($limit, 10)) {
                $this->addError('reply', 'Batas pengiriman tercapai. Coba lagi dalam satu menit.');

                return;
            }
            RateLimiter::hit($limit, 60);
            $this->resetValidation('reply');
            $history = $thread->messages()->where('id', '<', $message->id)->latest('id')->limit(12)
                ->get(['role', 'content'])->reverse()->values()->toArray();

            foreach ($llm->stream($message->content, $history) as $part) {
                if (isset($part['delta'])) {
                    $this->stream(content: e($part['delta']), to: 'reply');
                } else {
                    DB::transaction(function () use ($thread, $message, $part) {
                        $thread->messages()->firstOrCreate(['turn_id' => $message->turn_id, 'role' => 'assistant'], [
                            'content' => $part['answer'], 'model' => $part['model'],
                        ]);
                        $thread->touch();
                    });
                }
            }
            $this->dispatch('history-updated');
            $this->dispatch('chat-scroll');
        } catch (Throwable $error) {
            report($error);
            $this->addError('reply', 'Jawaban belum selesai. Pertanyaan tersimpan dan dapat dicoba lagi.');
        } finally {
            $lock->release();
        }
    }

    public function render(): View
    {
        $thread = auth()->user()->conversations()->find($this->conversationId);
        $messages = $thread?->messages()->orderBy('id')->get() ?? collect();
        $blocks = [];
        $codeMessageId = null;
        $explanation = '';
        $fence = '/^```([\w+#.-]*)[^\S\n]*\R(.*?)^```[^\S\n]*$/ms';
        foreach ($messages->where('role', 'assistant')->reverse() as $message) {
            if (preg_match_all($fence, $message->content, $blocks, PREG_SET_ORDER)) {
                $codeMessageId = $message->id;
                $explanation = trim(preg_replace($fence, '', $message->content));
                break;
            }
        }

        return view('livewire.chat-panel', compact('thread', 'messages', 'blocks', 'codeMessageId', 'explanation'));
    }
}
