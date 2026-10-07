<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Project> */
class ProjectFactory extends Factory
{
    protected $model = Project::class;

    public function definition(): array
    {
        $topic = fake()->randomElement([
            ['Tutor AI untuk latihan algoritma', 'Membimbing mahasiswa memahami langkah penyelesaian soal dan memberi umpan balik atas kode.'],
            ['Asisten riset literatur', 'Merangkum paper, menelusuri sitasi, dan menyusun pertanyaan untuk telaah dosen.'],
            ['Agen evaluasi permainan edukasi', 'Menganalisis metrik sesi permainan dan menyarankan strategi berdasarkan data.'],
            ['Pendamping belajar adaptif', 'Menyesuaikan rencana belajar dari hasil kuis dan perkembangan mingguan mahasiswa.'],
        ]);

        return [
            'user_id' => User::factory(),
            'judul' => $topic[0],
            'deskripsi' => $topic[1],
            'tema_agent' => fake()->randomElement(['Ollama', 'Senopati AI', 'OpenAI']),
        ];
    }
}
