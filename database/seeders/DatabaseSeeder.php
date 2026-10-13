<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory(15)->create()->each(fn (User $user) => Project::factory(2)->for($user)->create());

        $demo = User::factory()->create([
            'name' => 'Marco Marcello Hugo',
            'email' => 'dosenpbkk@its.ac.id',
            'password' => 'demo12345',
        ]);

        $demo->projects()->create([
            'judul' => 'Pemetaan literatur pembelajaran adaptif',
            'deskripsi' => 'Menata pertanyaan riset, sumber artikel, dan kandidat celah penelitian untuk ditinjau ulang.',
            'tema_agent' => 'Ollama',
        ]);
        $demo->projects()->create([
            'judul' => 'Verifikasi bukti pada penelitian kesehatan digital',
            'deskripsi' => 'Membandingkan metode studi dan menyusun ringkasan dengan rujukan yang dapat diperiksa.',
            'tema_agent' => 'Senopati AI',
        ]);
    }
}
