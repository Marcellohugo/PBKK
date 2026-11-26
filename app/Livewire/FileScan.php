<?php

namespace App\Livewire;

use App\Jobs\ScanResearchFile;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithFileUploads;
use Throwable;

class FileScan extends Component
{
    use WithFileUploads;

    public $document;

    public function scan(): void
    {
        $this->validate(['document' => ['required', 'file', 'extensions:txt,md', 'mimetypes:text/*', 'max:2048']], [
            'document.*' => 'Pilih berkas teks .txt atau .md hingga 2 MB.',
        ]);

        $user = auth()->id();
        if (RateLimiter::tooManyAttempts("scan-start:$user", 6)) {
            $this->addError('document', 'Coba kembali dalam satu menit.');

            return;
        }
        RateLimiter::hit("scan-start:$user");
        $id = (string) Str::uuid();
        $path = $this->document->storeAs('research-scans', $id, 'local');
        if (! $path) {
            $this->addError('document', 'Berkas belum dapat disimpan.');

            return;
        }
        try {
            Cache::put("scan:$user:$id", ['progress' => 0], now()->addHour());
            ScanResearchFile::dispatch($user, $id, $path)->onConnection('database');
            Cache::put("latest-scan:$user", ['id' => $id, 'name' => $this->document->getClientOriginalName()], now()->addHour());
            $this->reset('document');
        } catch (Throwable $error) {
            Storage::disk('local')->delete($path);
            report($error);
            $this->addError('document', 'Pemeriksaan belum bisa dimulai. Coba lagi.');
        }
    }

    public function render(): View
    {
        $user = auth()->id();
        $scan = Cache::get("latest-scan:$user");
        $status = $scan ? Cache::get("scan:$user:".$scan['id']) : null;

        return view('livewire.file-scan', compact('scan', 'status'));
    }
}
