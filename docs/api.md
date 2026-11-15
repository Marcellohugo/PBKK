# ResearchMate Chat API

URL lokal: `http://127.0.0.1:8011`. Seluruh request memakai `Content-Type: application/json` dan `Accept: application/json`. API selalu mengembalikan error JSON, termasuk ketika header `Accept` terlewat. Gunakan HTTPS ketika diakses di luar mesin lokal.

## Autentikasi

`POST /api/login` menerima kredensial akun yang sudah terdaftar. Akun peneliti lokal dari seeder dapat digunakan untuk demo.

```json
{
  "email": "dosenpbkk@its.ac.id",
  "password": "demo12345"
}
```

```json
{
  "access_token": "1|TOKEN_HANYA_DITAMPILKAN_SAAT_DIBUAT",
  "token_type": "Bearer",
  "expires_at": "2026-11-15T10:30:00+00:00"
}
```

Token memiliki ability `chat` dan kedaluwarsa satu jam setelah penerbitan. Server hanya menyimpan hash token. Simpan token secara aman; jangan masukkan token nyata ke repository atau koleksi Postman yang dibagikan. Login dibatasi lima request per menit per alamat IP.

Request chat dan pencabutan token harus menyertakan:

```http
Authorization: Bearer TOKEN_ANDA
```

`DELETE /api/token` mencabut token yang sedang digunakan dan mengembalikan `204 No Content`. Request berikutnya menggunakan token tersebut ditolak dengan `401`.

## Jawaban JSON

`POST /api/chat-ai` dilindungi `auth:sanctum` dan ability `chat`. Body hanya membutuhkan `prompt`: wajib, string, tidak kosong, maksimal 1000 karakter. Model dan provider ditentukan konfigurasi server.

```json
{
  "prompt": "Bagaimana menyusun pertanyaan riset tentang pembelajaran adaptif?"
}
```

Contoh respons sukses `201 Created` melalui `ChatResource`:

```json
{
  "status": "success",
  "data": {
    "session_id": 12,
    "model_used": "qwen3:14b",
    "prompt": "Bagaimana menyusun pertanyaan riset tentang pembelajaran adaptif?",
    "ai_response": "Tentukan populasi, metode pembelajaran, hasil yang diukur, dan pembandingnya.",
    "tokens_used": 96,
    "provider": "ollama",
    "timestamp": "2026-11-15 09:30:00"
  }
}
```

`session_id` adalah ID rekaman chat, bukan sesi percakapan multi-turn. Setiap prompt diproses mandiri bersama system prompt ResearchMate. `tokens_used` adalah jumlah token input dan output dari statistik provider, atau `null` jika tidak tersedia. Riwayat menyimpan `user_id` dari identitas token, bukan dari request klien. Prompt dan jawaban lengkap disimpan hanya ketika jawaban selesai; keluaran parsial tidak dianggap sukses.

## Streaming SSE

`POST /api/chat-ai/stream` menerima body dan token yang sama. Klien membaca `Content-Type: text/event-stream` secara bertahap menggunakan streaming HTTP, bukan `EventSource` GET. Setiap frame dipisahkan baris kosong. Header `X-Accel-Buffering: no` dan `Cache-Control: no-cache, no-transform` membantu mencegah buffering proxy.

```text
event: delta
data: {"delta":"Tentukan populasi"}

event: delta
data: {"delta":", metode, dan hasil."}

event: done
data: {"status":"success","data":{"session_id":13,"model_used":"qwen3:14b","prompt":"Bagaimana menyusun pertanyaan riset?","ai_response":"Tentukan populasi, metode, dan hasil.","tokens_used":52,"provider":"ollama","timestamp":"2026-11-15 09:31:00"}}

```

`delta` berisi teks nyata dari provider saat diproduksi. `done` menandakan jawaban selesai dan berhasil tersimpan. Jika koneksi provider terputus atau pencatatan gagal setelah streaming dimulai, HTTP tetap `200` karena header sudah terkirim, tetapi frame akhirnya adalah error:

```text
event: error
data: {"status":"error","message":"Jawaban tidak selesai. Silakan coba lagi."}

```

Klien harus menunggu `done` sebelum memperlakukan jawaban sebagai riwayat tersimpan. Koneksi terputus tanpa `done` juga berarti jawaban belum selesai.

## Konfigurasi provider

| Variabel | Isi |
| --- | --- |
| `OLLAMA_URL` | URL dasar Ollama, bawaan `http://127.0.0.1:11434`; server menambahkan `/api/chat` |
| `OLLAMA_MODEL` | Model terpasang, bawaan `qwen3:14b`; boleh diganti model lokal yang tersedia |
| `LLM_TIMEOUT` | Batas waktu request/provider dalam detik, bawaan 120 |
| `LLM_MAX_TOKENS` | Batas keluaran model, bawaan 512 |
| `SENOPATI_URL` | URL penuh endpoint chat completions yang kompatibel OpenAI dari layanan ITS |
| `SENOPATI_API_KEY` | Token akses ITS, disimpan hanya pada konfigurasi server |
| `SENOPATI_MODEL` | Nama model yang tersedia bagi akun ITS |

Fallback Senopati aktif hanya jika ketiga variabel Senopati diisi. Aplikasi mengirim payload `messages`, `model`, dan `stream` serta header Bearer ke URL tersebut. System prompt ResearchMate meminta jawaban akademik yang ringkas, membedakan bukti dari dugaan, dan melarang referensi buatan.

Jika Ollama mati, memberi error, atau menghasilkan respons yang tidak valid sebelum teks pertama, aplikasi mencoba Senopati. Setelah satu delta terkirim, aplikasi tidak berpindah provider agar teks dari dua jawaban tidak tercampur. Tanpa fallback terkonfigurasi, kegagalan ditampilkan sebagai `503` untuk JSON atau event `error` untuk SSE. Endpoint/token Senopati nyata harus diperoleh dari ITS; pengujian terisolasi menggunakan provider fixture dan tidak membuktikan koneksi layanan ITS.

## Error dan batas request

| Status | Makna |
| --- | --- |
| `401` | Token tidak ada, salah, kedaluwarsa, atau dicabut; juga kredensial login salah |
| `403` | Token tidak memiliki ability `chat` |
| `422` | Input tidak lolos FormRequest, misalnya prompt bukan string atau lebih dari 1000 karakter |
| `429` | Batas request terlampaui; kedua endpoint chat berbagi batas 10 request per menit per pengguna |
| `503` | Provider AI tidak tersedia atau hasil JSON tidak dapat diselesaikan/disimpan |

Tanpa token, `POST /api/chat-ai` ditolak sebelum memanggil provider:

```json
{"message":"Unauthenticated."}
```

Contoh kegagalan layanan JSON:

```json
{"status":"error","message":"Layanan AI belum tersedia. Coba lagi nanti."}
```

## Demo dan pengujian

Impor [koleksi Postman](postman/researchmate-w11.postman_collection.json). Jalankan request tanpa token untuk melihat `401`, login untuk menyimpan token pada variabel koleksi, lalu jalankan chat JSON/SSE dan pencabutan token. Ganti `base_url`, email, dan password sesuai lingkungan. Hapus nilai token sebelum mengekspor koleksi.

```powershell
python tests/api_check.py --php C:\path\to\php.exe
```

Tes ini membuat database SQLite sementara dan server provider HTTP fixture. Cakupannya meliputi penolakan tanpa token, validasi, atribusi pengguna dan statistik token, SSE bertahap, fallback, kegagalan provider tanpa riwayat sukses, serta pencabutan token. Instalasi aplikasi tetap menggunakan PostgreSQL sesuai konfigurasi bawaan.
