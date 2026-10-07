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
            ['Pemantau kas sesi', 'Menjelaskan perubahan koin dan membantu instruktur menemukan titik keputusan penting.'],
            ['Asisten pemakaian bahan', 'Menganalisis stok serta persentase bahan terpakai untuk menilai efisiensi pesanan.'],
            ['Coach strategi pinjaman', 'Menghubungkan sisa kewajiban dengan kas yang tersedia pada mode Mahir.'],
            ['Ringkasan sesi pemain', 'Merangkum metrik dan menyusun pertanyaan tindak lanjut untuk diskusi instruktur.'],
        ]);

        return [
            'user_id' => User::factory(),
            'judul' => $topic[0],
            'deskripsi' => $topic[1],
            'tema_agent' => fake()->randomElement(['Ollama', 'Senopati AI', 'OpenAI']),
        ];
    }
}
