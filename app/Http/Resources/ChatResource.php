<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ChatResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'session_id' => $this->id,
            'model_used' => $this->model_used,
            'prompt' => $this->prompt,
            'ai_response' => $this->ai_response,
            'tokens_used' => $this->tokens_used,
            'provider' => $this->provider,
            'timestamp' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }

    public function with(Request $request): array
    {
        return ['status' => 'success'];
    }
}
