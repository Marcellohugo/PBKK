<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class PageController extends Controller
{
    public function index(Request $request)
    {
        $data = $request->validate(['user' => 'nullable|string|max:100']);
        return view('home', ['user' => $data['user'] ?? null, 'profil' => config('profile')]);
    }

    public function profile()
    {
        $profil = config('profile');
        $riwayat = [
            'Merancang ruang kerja untuk meninjau pertanyaan riset dan kesiapan literatur.',
            'Menambahkan autentikasi serta daftar proyek riset milik setiap pengguna.',
        ];
        return view('profile', compact('profil', 'riwayat'));
    }

    public function idea(Request $request)
    {
        $request->validate([
            'mode' => ['nullable', Rule::in(['light', 'dark'])],
        ]);
        $dark = $request->query('mode') === 'dark';
        $alur = [
            ['judul' => 'Pertanyaan riset', 'isi' => 'Tulis pertanyaan yang hendak dijawab dan pilih sumber awal.'],
            ['judul' => 'Inventaris sumber', 'isi' => 'Catat jumlah artikel dan PDF yang sudah dikumpulkan.'],
            ['judul' => 'Tinjauan kesiapan', 'isi' => 'Aplikasi menampilkan langkah berikutnya berdasarkan input yang tersedia.'],
            ['judul' => 'Simpan proyek', 'isi' => 'Masuk ke akun untuk menyimpan rencana dan meninjau proyek Anda.'],
        ];
        $plan = $request->session()->get('research_plan');
        $draft = $request->session()->get('research_idea');
        return view('idea', compact('dark', 'alur', 'plan', 'draft'));
    }

    public function recommendations(Request $request)
    {
        $data = $request->validate([
            'mode' => ['nullable', Rule::in(['light', 'dark'])],
            'pertanyaan_riset' => ['required', 'string', 'min:15', 'max:1000'],
            'mode_riset' => ['required', Rule::in(['dokumen_lokal', 'penelusuran_literatur'])],
            'jumlah_artikel' => ['required', 'integer', 'between:0,1000'],
            'jumlah_pdf' => ['required', 'integer', 'between:0,1000'],
        ], [
            'required' => ':attribute wajib diisi.',
            'integer' => ':attribute harus berupa bilangan bulat.',
            'between' => ':attribute harus antara :min dan :max.',
            'min' => ':attribute minimal :min karakter.',
            'max' => ':attribute maksimal :max karakter.',
            'in' => 'Pilihan :attribute tidak valid.',
        ], [
            'pertanyaan_riset' => 'Pertanyaan riset', 'mode_riset' => 'Sumber riset',
            'jumlah_artikel' => 'Jumlah artikel', 'jumlah_pdf' => 'Jumlah PDF',
        ]);

        $total = $data['jumlah_artikel'] + $data['jumlah_pdf'];
        $saran = [
            [
                'judul' => $total === 0 ? 'Mulai inventaris literatur' : 'Inventaris literatur tersedia',
                'bukti' => "{$data['jumlah_artikel']} artikel dan {$data['jumlah_pdf']} PDF dicatat ({$total} sumber).",
                'isi' => $total === 0
                    ? 'Cari artikel yang menjawab pertanyaan riset, lalu catat asal dan tahun terbitnya.'
                    : 'Periksa relevansi dan mutu setiap sumber sebelum memasukkannya ke matriks literatur.',
            ],
            [
                'judul' => $data['mode_riset'] === 'dokumen_lokal' ? 'Periksa dokumen lokal' : 'Rencanakan penelusuran literatur',
                'bukti' => $data['mode_riset'] === 'dokumen_lokal' ? 'Mode sumber: dokumen lokal.' : 'Mode sumber: penelusuran literatur.',
                'isi' => $data['mode_riset'] === 'dokumen_lokal'
                    ? 'Pastikan PDF yang akan ditinjau tersedia dan dapat dibaca sebelum menyusun ringkasan.'
                    : 'Susun kata kunci pencarian dan simpan metadata sumber yang ditemukan.',
            ],
            [
                'judul' => 'Tinjau bukti sebelum menyimpulkan',
                'bukti' => "Pertanyaan riset: {$data['pertanyaan_riset']}",
                'isi' => 'Bandingkan metode dan hasil sumber yang relevan. Kandidat celah riset perlu dukungan kutipan yang dapat diperiksa.',
            ],
        ];
        $request->session()->put('research_plan', ['data' => $data, 'saran' => $saran]);
        return redirect()->to(route('idea', ['mode' => $data['mode'] ?? 'light']).'#hasil');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => $request->user() ? 'nullable|string|min:3|max:100' : 'required|string|min:3|max:100',
            'judul' => 'required|string|min:5|max:150',
            'deskripsi' => 'required|string|min:15|max:3000',
            'mode' => ['nullable', Rule::in(['light', 'dark'])],
        ], [
            'required' => ':attribute wajib diisi.',
            'string' => ':attribute harus berupa teks.',
            'min' => ':attribute minimal :min karakter.',
            'max' => ':attribute maksimal :max karakter.',
            'in' => 'Pilihan :attribute tidak valid.',
        ], ['nama' => 'Nama pengusul', 'judul' => 'Judul ide', 'deskripsi' => 'Deskripsi', 'mode' => 'mode']);
        if (! $request->user()) {
            $request->session()->put('research_idea', $data);
            $next = $request->session()->has('research_plan')
                ? 'Masuk untuk menyimpannya.'
                : 'Tinjau rencana riset untuk melanjutkan penyimpanan.';
            return redirect()->route('idea', ['mode' => $data['mode'] ?? 'light'])
                ->with('status', "Terima kasih, {$data['nama']}. Ide riset {$data['judul']} berhasil divalidasi. {$next}")
                ->with('ide', $data);
        }

        $plan = $request->session()->get('research_plan.data');
        if (! $plan) {
            return redirect()->route('idea', ['mode' => $data['mode'] ?? 'light'])
                ->withErrors(['judul' => 'Tinjau rencana riset terlebih dahulu sebelum menyimpan proyek.'])
                ->withInput();
        }

        $project = $request->user()->projects()->create([
            'judul' => $data['judul'],
            'deskripsi' => $data['deskripsi'],
            'tema_agent' => config('profile.tema'),
            'pertanyaan_riset' => $plan['pertanyaan_riset'],
            'mode_riset' => $plan['mode_riset'],
            'jumlah_artikel' => $plan['jumlah_artikel'],
            'jumlah_pdf' => $plan['jumlah_pdf'],
        ]);
        $request->session()->forget(['research_plan', 'research_idea']);

        return redirect()->route('dashboard.home')->with('status', "Proyek {$project->judul} berhasil disimpan.");
    }
    public function about() { return view('about'); }

    public function project() { return view('project', ['profil' => config('profile')]); }

    public function calculator(Request $request)
    {
        if ($request->hasAny(['angka1', 'angka2', 'operasi'])) {
            return redirect()->route('calculate', $request->validate($this->calculatorRules()));
        }
        return view('calculator');
    }

    private function calculatorRules(): array
    {
        return [
            'angka1' => ['required', 'numeric', 'between:-1000000000000,1000000000000'],
            'angka2' => ['required', 'numeric', 'between:-1000000000000,1000000000000'],
            'operasi' => ['required', Rule::in(['tambah', 'kurang', 'kali', 'bagi'])],
        ];
    }

    public function calculate(string $angka1, string $angka2, string $operasi)
    {
        if (Validator::make(compact('angka1', 'angka2', 'operasi'), $this->calculatorRules())->fails()) {
            return response()->view('calculator', ['pesan' => 'Masukkan dua angka valid serta operasi tambah, kurang, kali, atau bagi.'], 422);
        }
        if ($operasi === 'bagi' && (float) $angka2 == 0) {
            return response()->view('calculator', ['pesan' => 'Pembagian dengan nol tidak diperbolehkan.'], 422);
        }
        $hasil = match ($operasi) {
            'tambah' => $angka1 + $angka2, 'kurang' => $angka1 - $angka2,
            'kali' => $angka1 * $angka2, 'bagi' => $angka1 / $angka2,
        };
        return view('calculator', compact('angka1', 'angka2', 'operasi', 'hasil'));
    }

    public function student(string $nrp)
    {
        if ($nrp !== config('profile.nrp')) {
            return $this->notFound();
        }
        return $this->profile();
    }

    public function agent(Request $request, string $tema = 'General Assistant Agent')
    {
        $data = $request->validate(['mode' => ['nullable', 'string', Rule::in(['jelajah', 'telaah'])]], ['in' => 'Pilihan :attribute tidak valid.']);
        $mode = $data['mode'] ?? 'jelajah';
        $profil = config('profile');
        $skenario = array_filter($profil['ai']['skenario'], fn ($item) => $item['mode'] === 'semua' || $item['mode'] === $mode);
        $deskripsi = $tema === config('profile.tema')
            ? config('profile.deskripsi')
            : "Skenario asisten bertema {$tema}: menerima pertanyaan, merencanakan langkah, menggunakan tool yang diizinkan, lalu merangkum hasil untuk ditinjau pengguna.";
        return view('agent', compact('tema', 'deskripsi', 'profil', 'mode', 'skenario'));
    }

    public function ipkForm(Request $request)
    {
        if ($request->hasAny(['ip1', 'ip2'])) {
            $data = $request->validate(['ip1' => 'required|numeric|between:0,4', 'ip2' => 'required|numeric|between:0,4']);
            return redirect()->to(route('ipk.calculate', $data).'#ipk');
        }
        return redirect()->to(route('calculator').'#ipk');
    }

    public function ipk(string $ip1, string $ip2)
    {
        $validator = Validator::make(compact('ip1', 'ip2'), ['ip1' => 'required|numeric|between:0,4', 'ip2' => 'required|numeric|between:0,4']);
        if ($validator->fails()) {
            return response()->view('calculator', ['ipkPesan' => 'IP setiap semester harus berupa angka antara 0 dan 4.'], 422);
        }
        $jumlah = $ip1 + $ip2;
        $rata = number_format($jumlah / 2, 2, '.', '');
        return view('calculator', compact('ip1', 'ip2', 'jumlah', 'rata'));
    }

    public function notFound()
    {
        return response()->view('errors.404', [], 404);
    }
    private const KATEGORI = ['Akademik', 'Sarana Prasarana', 'Kegiatan Mahasiswa'];

    public function feedbackCreate(Request $request)
    {
        if (! $request->session()->has('captcha')) {
            $request->session()->put('captcha', [random_int(1, 20), random_int(1, 20)]);
        }
        return view('feedback', [
            'profil' => config('profile'),
            'kategori' => self::KATEGORI,
            'captcha' => $request->session()->get('captcha'),
        ]);
    }

    public function feedbackStore(Request $request)
    {
        $captcha = $request->session()->get('captcha');
        $data = $request->validate([
            'konteks' => ['nullable', Rule::in(['proyek', 'dokumen', 'literatur', 'agen', 'laporan'])],
            'nama' => ['required', 'string', 'min:3', 'max:100'],
            'email' => ['required', 'string', 'email:rfc', 'max:254', 'regex:/@student\.its\.ac\.id\z/i'],
            'kategori' => ['required', Rule::in(self::KATEGORI)],
            'pesan' => ['required', 'string', 'min:15', 'max:5000'],
            'captcha' => ['required', 'integer', function ($attribute, $value, $fail) use ($captcha) {
                if (! is_array($captcha) || (int) $value !== array_sum($captcha)) {
                    $fail('Jawaban matematika salah atau sesi telah kedaluwarsa. Silakan coba lagi.');
                }
            }],
        ], [
            'required' => ':attribute wajib diisi.',
            'string' => ':attribute harus berupa teks.',
            'nama.min' => 'Nama pengirim minimal 3 karakter.',
            'nama.max' => 'Nama pengirim maksimal 100 karakter.',
            'email.email' => 'Masukkan alamat email yang valid.',
            'email.regex' => 'Gunakan email ITS dengan akhiran @student.its.ac.id.',
            'email.max' => 'Email maksimal 254 karakter.',
            'kategori.in' => 'Pilih salah satu kategori masukan yang tersedia.',
            'pesan.min' => 'Isi pesan minimal 15 karakter.',
            'pesan.max' => 'Isi pesan maksimal 5000 karakter.',
            'captcha.integer' => 'Jawaban matematika harus berupa bilangan bulat.',
            'konteks.in' => 'Pilih konteks riset yang tersedia.',
        ], ['nama' => 'Nama pengirim', 'email' => 'Email', 'kategori' => 'Kategori masukan', 'pesan' => 'Isi pesan', 'captcha' => 'Jawaban matematika', 'konteks' => 'Konteks riset']);

        unset($data['captcha']);
        DB::table('feedback')->insert([...$data, 'created_at' => now(), 'updated_at' => now()]);
        $request->session()->forget('captcha');
        return redirect()->route('feedback.success')->with('feedback', $data);
    }

    public function feedbackSuccess(Request $request)
    {
        $feedback = $request->session()->get('feedback');
        if (! $feedback) {
            return redirect()->route('feedback.create');
        }
        return view('success', compact('feedback'));
    }
}
