<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChatRequest;
use App\Http\Resources\ChatResource;
use App\Models\User;
use App\Services\LlmChatService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Throwable;

class ChatController extends Controller
{
    public function store(ChatRequest $request, LlmChatService $llm): ChatResource|JsonResponse
    {
        $prompt = $request->validated('prompt');

        try {
            return $this->save($request->user(), $prompt, $llm->complete($prompt));
        } catch (Throwable $e) {
            report($e);

            return response()->json(['status' => 'error', 'message' => 'Layanan AI belum tersedia. Coba lagi nanti.'], 503);
        }
    }

    public function stream(ChatRequest $request, LlmChatService $llm): StreamedResponse
    {
        $prompt = $request->validated('prompt');
        $user = $request->user();

        return response()->stream(function () use ($user, $prompt, $llm, $request): void {
            try {
                foreach ($llm->stream($prompt) as $part) {
                    if (array_key_exists('delta', $part)) {
                        $this->event('delta', $part);
                    } else {
                        $resource = $this->save($user, $prompt, $part);
                        $this->event('done', ['status' => 'success', 'data' => $resource->resolve($request)]);
                    }
                }
            } catch (Throwable $e) {
                report($e);
                $this->event('error', ['status' => 'error', 'message' => 'Jawaban tidak selesai. Silakan coba lagi.']);
            }
        }, 200, [
            'Content-Type' => 'text/event-stream',
            'Cache-Control' => 'no-cache, no-transform',
            'X-Accel-Buffering' => 'no',
        ]);
    }

    private function save(User $user, string $prompt, array $result): ChatResource
    {
        return new ChatResource($user->chatLogs()->create([
            'prompt' => $prompt,
            'ai_response' => $result['answer'],
            'model_used' => $result['model'],
            'tokens_used' => $result['tokens_used'],
            'provider' => $result['provider'],
        ]));
    }

    private function event(string $name, array $data): void
    {
        echo 'event: '.$name."\n";
        echo 'data: '.json_encode($data, JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR)."\n\n";

        if (ob_get_level() > 0) {
            ob_flush();
        }
        flush();
    }
}
