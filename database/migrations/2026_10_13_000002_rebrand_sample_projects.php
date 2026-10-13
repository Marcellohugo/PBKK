<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $examples = [
            'Narafin AI Coach — Saran Analitika Pemain' => ['Pemetaan literatur pembelajaran adaptif', 'Menata pertanyaan riset, sumber artikel, dan kandidat celah penelitian untuk ditinjau ulang.'],
            'Analitika Sesi Cashflowpoly' => ['Verifikasi bukti pada penelitian kesehatan digital', 'Membandingkan metode studi dan menyusun ringkasan dengan rujukan yang dapat diperiksa.'],
            'Pemantau kas sesi' => ['Pemetaan literatur kesehatan digital', 'Meninjau metode dan temuan artikel tentang layanan kesehatan berbasis digital.'],
            'Asisten pemakaian bahan' => ['Telaah sistem rekomendasi akademik', 'Membandingkan pendekatan rekomendasi dan mengevaluasi kualitas bukti penelitian.'],
            'Coach strategi pinjaman' => ['Analisis celah riset pembelajaran adaptif', 'Menyusun matriks literatur untuk mencari pertanyaan yang belum terjawab.'],
            'Ringkasan sesi pemain' => ['Verifikasi sumber perubahan iklim', 'Mengumpulkan dan memeriksa sumber untuk laporan riset yang dapat ditelusuri.'],
        ];

        foreach ($examples as $oldTitle => [$title, $description]) {
            DB::table('projects')->where('judul', $oldTitle)->update(['judul' => $title, 'deskripsi' => $description]);
        }
    }

    public function down(): void
    {
        // Existing research project data remains valid after rollback.
    }
};
