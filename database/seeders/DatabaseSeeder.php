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
            'judul' => 'Narafin AI Coach — Saran Analitika Pemain',
            'deskripsi' => 'Asisten untuk meninjau kas, pemakaian bahan, dan pinjaman pemain Cashflowpoly berdasarkan bukti angka.',
            'tema_agent' => 'Ollama',
        ]);
        $demo->projects()->create([
            'judul' => 'Portofolio Akademik PBKK',
            'deskripsi' => 'Rangkuman eksplorasi routing, Blade, validasi, autentikasi, dan relasi data proyek.',
            'tema_agent' => 'Senopati AI',
        ]);
    }
}
