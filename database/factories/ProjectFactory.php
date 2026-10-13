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
            ['Pemetaan literatur kesehatan digital', 'Meninjau metode dan temuan artikel tentang layanan kesehatan berbasis digital.'],
            ['Telaah sistem rekomendasi akademik', 'Membandingkan pendekatan rekomendasi dan mengevaluasi kualitas bukti penelitian.'],
            ['Analisis celah riset pembelajaran adaptif', 'Menyusun matriks literatur untuk mencari pertanyaan yang belum terjawab.'],
            ['Verifikasi sumber perubahan iklim', 'Mengumpulkan dan memeriksa sumber untuk laporan riset yang dapat ditelusuri.'],
        ]);

        return [
            'user_id' => User::factory(),
            'judul' => $topic[0],
            'deskripsi' => $topic[1],
            'tema_agent' => fake()->randomElement(['Ollama', 'Senopati AI', 'OpenAI']),
        ];
    }
}
