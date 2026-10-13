# Alur ResearchMate

ResearchMate berfokus pada proyek riset akademik. Peneliti merumuskan pertanyaan, mengumpulkan artikel dan PDF, membandingkan temuan, menilai kandidat celah riset, lalu menyusun laporan yang rujukannya dapat dibuka ulang. Konsep agen meliputi Planner, Discovery, Analysis, Synthesis, Research Gap, dan Verification.

Aplikasi PBKK saat ini mengimplementasikan autentikasi, daftar proyek pribadi, formulir masukan, dan tinjauan rencana awal berbasis aturan. Tinjauan menerima pertanyaan riset, jumlah artikel/PDF, dan mode sumber. Hasil hanya menyarankan langkah persiapan; aplikasi ini tidak membaca isi PDF, menelusuri indeks ilmiah, menghasilkan matriks literatur otomatis, atau memanggil model bahasa. Pernyataan kandidat celah riset tetap perlu diverifikasi terhadap sumber asli.

Database PostgreSQL menyimpan pengguna, proyek, dan masukan. Data proyek contoh tersedia dari seeder; pembuatan dan penyuntingan proyek melalui UI belum tersedia.
