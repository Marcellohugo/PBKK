<?php

use App\Models\Project;
use App\Models\User;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Facades\DB;

require __DIR__.'/../vendor/autoload.php';
$app = require __DIR__.'/../bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

function check(bool $ok, string $message): void
{
    if (! $ok) {
        fwrite(STDERR, "FAIL W6: {$message}\n");
        exit(1);
    }
}

check(User::where('email', 'like', '%@student.its.ac.id')->has('projects', '=', 2)->count() >= 15, 'Seeder mahasiswa/proyek tidak lengkap.');
$demo = User::where('email', 'dosenpbkk@its.ac.id')->firstOrFail();
check($demo->projects()->count() === 2, 'Portofolio demo tidak lengkap.');

$project = new Project;
$project->fill(['judul' => 'Uji', 'user_id' => $demo->id, 'api_key_secure' => 'rahasia']);
check(! $project->isDirty('user_id') && ! $project->isDirty('api_key_secure'), 'Kolom sensitif dapat diisi massal.');

DB::beginTransaction();
try {
    $project = $demo->projects()->create(['judul' => 'Uji enkripsi']);
    check($project->fresh()->tema_agent === 'Ollama', 'Default tema_agent tidak berlaku.');
    $project->api_key_secure = 'rahasia';
    $project->save();
    $raw = DB::table('projects')->where('id', $project->id)->value('api_key_secure');
    check($raw !== 'rahasia' && $project->fresh()->api_key_secure === 'rahasia', 'API key tidak terenkripsi.');

    $demoId = $demo->id;
    $demo->delete();
    check(! Project::where('user_id', $demoId)->exists(), 'Cascade delete tidak berlaku.');
} finally {
    DB::rollBack();
}

echo "PASS W6: seed, relasi, mass assignment, enkripsi, default, cascade\n";
