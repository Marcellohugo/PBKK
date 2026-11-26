<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use RuntimeException;
use Throwable;

class ScanResearchFile implements ShouldQueue
{
    use Queueable;

    public function __construct(public int $userId, public string $scanId, public string $path) {}

    public function handle(): void
    {
        $disk = Storage::disk('local');
        $size = max(1, $disk->size($this->path));
        $file = $disk->readStream($this->path);
        if (! is_resource($file)) {
            throw new RuntimeException('Berkas belum dapat dibaca.');
        }

        $bytes = 0;
        $lines = 0;
        $last = '';
        $hash = hash_init('sha256');
        try {
            while (! feof($file)) {
                $chunk = fread($file, 65536);
                if ($chunk === false) {
                    throw new RuntimeException('Gagal membaca berkas.');
                }
                if ($chunk !== '') {
                    $bytes += strlen($chunk);
                    $lines += substr_count($chunk, "\n");
                    $last = substr($chunk, -1);
                    hash_update($hash, $chunk);
                    $this->status(['progress' => min(99, (int) (100 * $bytes / $size))]);
                }
            }
            $this->status(['progress' => 100, 'lines' => $lines + (int) ($last !== '' && $last !== "\n"),
                'bytes' => $bytes, 'hash' => hash_final($hash)]);
        } finally {
            fclose($file);
        }
        $disk->delete($this->path);
    }

    public function failed(?Throwable $error): void
    {
        $this->status(['error' => true]);
        Storage::disk('local')->delete($this->path);
    }

    private function status(array $data): void
    {
        Cache::put("scan:{$this->userId}:{$this->scanId}", $data, now()->addHour());
    }
}
