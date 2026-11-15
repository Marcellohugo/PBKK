<?php

return [
    'ollama' => [
        'url' => env('OLLAMA_URL', 'http://127.0.0.1:11434'),
        'model' => env('OLLAMA_MODEL', 'qwen3:14b'),
    ],
    'senopati' => [
        'url' => env('SENOPATI_URL'),
        'key' => env('SENOPATI_API_KEY'),
        'model' => env('SENOPATI_MODEL'),
    ],
    'timeout' => (int) env('LLM_TIMEOUT', 120),
    'connect_timeout' => 3,
    'max_tokens' => (int) env('LLM_MAX_TOKENS', 512),
    'system_prompt' => 'Anda adalah ResearchMate, asisten riset akademik. Bantu merumuskan pertanyaan, menilai metode, dan merencanakan telaah literatur. Jawab ringkas dalam bahasa Indonesia. Jangan mengarang referensi, kutipan, data, atau mengaku telah membaca dokumen yang tidak diberikan. Bedakan bukti dari dugaan dan sarankan verifikasi pada sumber asli.',
];
