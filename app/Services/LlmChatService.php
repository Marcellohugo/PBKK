<?php

namespace App\Services;

use Generator;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use RuntimeException;
use Throwable;

class LlmChatService
{
    private const UNAVAILABLE = 'Layanan AI sedang tidak tersedia. Silakan coba lagi nanti.';

    public function complete(string $prompt): array
    {
        foreach ($this->providers() as $provider) {
            try {
                $data = $this->request($provider, $prompt, false)->json();

                if ($provider === 'ollama') {
                    if (($data['done'] ?? false) !== true) {
                        throw new RuntimeException(self::UNAVAILABLE);
                    }

                    $answer = $data['message']['content'] ?? null;
                    $tokens = $this->ollamaTokens($data);
                } else {
                    $answer = $data['choices'][0]['message']['content'] ?? null;
                    $tokens = $this->tokenCount($data['usage']['total_tokens'] ?? null);
                }

                return $this->result($provider, $answer, $data['model'] ?? null, $tokens);
            } catch (Throwable) {
                Log::warning('LLM request failed.', ['provider' => $provider]);
            }
        }

        throw new RuntimeException(self::UNAVAILABLE);
    }

    public function stream(string $prompt): Generator
    {
        $emitted = false;

        foreach ($this->providers() as $provider) {
            try {
                $response = $this->request($provider, $prompt, true);
                $answer = '';
                $model = null;
                $tokens = null;
                $finished = false;
                $terminated = false;

                foreach ($this->frames($response, $provider) as $frame) {
                    if ($frame === '[DONE]') {
                        $terminated = true;
                        break;
                    }

                    $data = json_decode($frame, true, 512, JSON_THROW_ON_ERROR);
                    if (! is_array($data) || isset($data['error'])) {
                        throw new RuntimeException(self::UNAVAILABLE);
                    }

                    $model = $data['model'] ?? $model;
                    if ($provider === 'ollama') {
                        $delta = $data['message']['content'] ?? '';
                        $finished = ($data['done'] ?? false) === true;
                        if ($finished) {
                            $tokens = $this->ollamaTokens($data);
                        }
                    } else {
                        $delta = $data['choices'][0]['delta']['content'] ?? '';
                        $finished = $finished || isset($data['choices'][0]['finish_reason']);
                        if (isset($data['usage']['total_tokens'])) {
                            $tokens = $this->tokenCount($data['usage']['total_tokens']);
                        }
                    }

                    if (! is_string($delta)) {
                        throw new RuntimeException(self::UNAVAILABLE);
                    }

                    if ($delta !== '') {
                        $answer .= $delta;
                        $emitted = true;
                        yield ['delta' => $delta];
                    }

                    if ($provider === 'ollama' && $finished) {
                        break;
                    }
                }

                if (! $finished || ($provider === 'senopati' && ! $terminated)) {
                    throw new RuntimeException(self::UNAVAILABLE);
                }

                yield $this->result($provider, $answer, $model, $tokens);

                return;
            } catch (Throwable) {
                Log::warning('LLM stream failed.', ['provider' => $provider, 'partial' => $emitted]);
                if ($emitted) {
                    throw new RuntimeException(self::UNAVAILABLE);
                }
            }
        }

        throw new RuntimeException(self::UNAVAILABLE);
    }

    private function providers(): array
    {
        $providers = ['ollama'];
        if (config('llm.senopati.url') && config('llm.senopati.key') && config('llm.senopati.model')) {
            $providers[] = 'senopati';
        }

        return $providers;
    }

    private function request(string $provider, string $prompt, bool $stream): Response
    {
        $client = Http::acceptJson()
            ->connectTimeout((int) config('llm.connect_timeout', 3))
            ->timeout((int) config('llm.timeout', 120))
            ->withOptions(['stream' => $stream, 'read_timeout' => (int) config('llm.timeout', 120)]);
        $payload = [
            'model' => config("llm.{$provider}.model"),
            'messages' => [
                ['role' => 'system', 'content' => config('llm.system_prompt')],
                ['role' => 'user', 'content' => $prompt],
            ],
            'stream' => $stream,
        ];

        if ($provider === 'ollama') {
            $url = rtrim(config('llm.ollama.url'), '/').'/api/chat';
            $payload['options'] = ['temperature' => 0.2, 'num_predict' => (int) config('llm.max_tokens', 512)];
            $payload['think'] = false;
        } else {
            $url = rtrim(config('llm.senopati.url'), '/');
            if (! str_ends_with($url, '/chat/completions')) {
                $url .= '/chat/completions';
            }
            $client = $client->withToken(config('llm.senopati.key'));
            $payload['temperature'] = 0.2;
            $payload['max_tokens'] = (int) config('llm.max_tokens', 512);
            if ($stream) {
                $payload['stream_options'] = ['include_usage' => true];
            }
        }

        return $client->post($url, $payload)->throw();
    }

    private function frames(Response $response, string $provider): Generator
    {
        $body = $response->toPsrResponse()->getBody();
        $buffer = '';
        $event = [];
        $deadline = microtime(true) + (int) config('llm.timeout', 120);

        try {
            while (! $body->eof()) {
                if (microtime(true) > $deadline) {
                    throw new RuntimeException(self::UNAVAILABLE);
                }

                $buffer .= $body->read(1024);
                if (strlen($buffer) > 1048576) {
                    throw new RuntimeException(self::UNAVAILABLE);
                }

                while (($end = strpos($buffer, "\n")) !== false) {
                    $line = rtrim(substr($buffer, 0, $end), "\r");
                    $buffer = substr($buffer, $end + 1);
                    if ($provider === 'ollama') {
                        if (trim($line) !== '') {
                            yield $line;
                        }
                    } elseif ($line === '') {
                        if ($event !== []) {
                            yield implode("\n", $event);
                            $event = [];
                        }
                    } elseif (str_starts_with($line, 'data:')) {
                        $event[] = ltrim(substr($line, 5), ' ');
                    }
                }
            }

            if ($provider === 'ollama' && trim($buffer) !== '') {
                yield $buffer;
            } elseif ($provider === 'senopati' && $event !== []) {
                yield implode("\n", $event);
            }
        } finally {
            $body->close();
        }
    }

    private function result(string $provider, mixed $answer, mixed $model, ?int $tokens): array
    {
        $model ??= config("llm.{$provider}.model");
        if (! is_string($answer) || trim($answer) === '' || ! is_string($model) || $model === '' || mb_strlen($model) > 255) {
            throw new RuntimeException(self::UNAVAILABLE);
        }

        return [
            'answer' => $answer,
            'model' => $model,
            'tokens_used' => $tokens,
            'provider' => $provider,
        ];
    }

    private function ollamaTokens(array $data): ?int
    {
        $prompt = $this->tokenCount($data['prompt_eval_count'] ?? null);
        $answer = $this->tokenCount($data['eval_count'] ?? null);

        return $prompt !== null && $answer !== null ? $prompt + $answer : null;
    }

    private function tokenCount(mixed $tokens): ?int
    {
        return is_int($tokens) && $tokens >= 0 ? $tokens : null;
    }
}
