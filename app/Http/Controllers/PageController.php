<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class PageController extends Controller
{
    public function index(Request $request)
    {
        $data = $request->validate(['user' => 'nullable|string|max:100']);
        $user = $data['user'] ?? config('profile.nama');
        $profil = config('profile');
        return view('home', compact('user', 'profil'));
    }

    public function profile()
    {
        $profil = config('profile');
        return view('profile', compact('profil'));
    }

    public function idea(Request $request)
    {
        $request->validate([
            'mode' => ['nullable', Rule::in(['light', 'dark'])],
            'permainan' => ['nullable', Rule::in(['pemula', 'mahir'])],
        ]);
        $dark = $request->query('mode') === 'dark';
        $permainan = $request->query('permainan') ?? 'mahir';
        $profil = config('profile');
        $alur = [
            ['judul' => 'Permintaan instruktur', 'isi' => 'Instruktur memilih pemain, sesi, dan mode permainan melalui antarmuka Livewire.'],
            ['judul' => 'Tool pemeriksaan metrik', 'isi' => 'Backend Laravel membaca data yang diizinkan dan menghitung kas, pemakaian bahan, serta pinjaman pada mode Mahir.'],
            ['judul' => 'Perencanaan dan analisis AI', 'isi' => 'LLM melalui Ollama atau Senopati AI merencanakan pemeriksaan, memanggil tool yang diizinkan, dan menjelaskan hasil berdasarkan bukti angka.'],
            ['judul' => 'Tinjauan hasil', 'isi' => 'Instruktur meninjau saran sebelum membahas strategi bersama pemain. Aplikasi desktop direncanakan dikemas dengan NativePHP.'],
        ];
        return view('idea', compact('profil', 'dark', 'permainan', 'alur'));
    }

    public function recommendations(Request $request)
    {
        $data = $request->validate([
            'mode' => ['nullable', Rule::in(['light', 'dark'])],
            'mode_permainan' => ['required', Rule::in(['pemula', 'mahir'])],
            'koin_awal' => ['required', 'integer', 'between:1,1000000'],
            'koin_akhir' => ['required', 'integer', 'between:0,1000000'],
            'bahan_terkumpul' => ['nullable', 'required_with:bahan_terpakai', 'integer', 'between:0,100000'],
            'bahan_terpakai' => ['nullable', 'required_with:bahan_terkumpul', 'integer', 'min:0', 'lte:bahan_terkumpul'],
            'sisa_pinjaman' => ['nullable', Rule::prohibitedIf($request->input('mode_permainan') !== 'mahir'), 'integer', 'between:0,1000000'],
        ], [
            'required' => ':attribute wajib diisi.',
            'integer' => ':attribute harus berupa bilangan bulat.',
            'between' => ':attribute harus antara :min dan :max.',
            'min' => ':attribute minimal :min.',
            'in' => 'Pilihan :attribute tidak valid.',
            'required_with' => 'Isi kedua jumlah bahan, atau kosongkan keduanya jika belum tersedia.',
            'lte' => 'Bahan terpakai tidak boleh melebihi bahan terkumpul.',
            'prohibited' => 'Pinjaman hanya berlaku pada mode Mahir.',
        ], [
            'mode_permainan' => 'Mode permainan', 'koin_awal' => 'Koin awal', 'koin_akhir' => 'Koin akhir',
            'bahan_terkumpul' => 'Bahan terkumpul', 'bahan_terpakai' => 'Bahan terpakai', 'sisa_pinjaman' => 'Sisa pinjaman',
        ]);

        // ponytail: tiga indikator deterministik untuk demo; integrasi LLM setelah kontrak metrik disepakati.
        $saran = [];
        if ($data['mode_permainan'] === 'mahir') {
            $pinjaman = $data['sisa_pinjaman'] ?? null;
            $saran[] = [
                'judul' => $pinjaman > 0 ? 'Prioritas · Pinjaman belum lunas' : 'Status pinjaman',
                'bukti' => $pinjaman === null ? 'Sisa pinjaman belum tersedia.' : "Sisa pokok pinjaman: {$pinjaman} koin.",
                'isi' => $pinjaman === null ? 'Lengkapi catatan pinjaman sebelum menilai kewajiban pemain.'
                    : ($pinjaman > 0 ? 'Rencanakan pelunasan dari kas dan pemasukan yang tersedia. Tinjau pengeluaran sebelum mengambil pinjaman baru.' : 'Tidak ada sisa pinjaman pada input ini. Tetap pertimbangkan kebutuhan dan cadangan kas.'),
            ];
        }
        $perubahan = round(($data['koin_akhir'] - $data['koin_awal']) / $data['koin_awal'] * 100, 2);
        $saran[] = [
            'judul' => 'Perubahan koin dari awal',
            'bukti' => "Koin awal {$data['koin_awal']}, koin akhir {$data['koin_akhir']}; perubahan {$perubahan}%.",
            'isi' => $data['koin_akhir'] < $data['koin_awal'] ? 'Kas menurun. Tinjau pengeluaran terbesar dan pertimbangkan aksi penghasil koin sebelum belanja tambahan.' : 'Kas tidak menurun dari awal. Tinjau juga sumber pemasukan dan kewajiban sebelum menyimpulkan hasil permainan.',
        ];
        $total = $data['bahan_terkumpul'] ?? null;
        $terpakai = $data['bahan_terpakai'] ?? null;
        $pemakaian = $total > 0 && $terpakai !== null ? round($terpakai / $total * 100, 2) : null;
        $saran[] = [
            'judul' => 'Persentase bahan yang terpakai',
            'bukti' => $pemakaian === null ? 'Persentase belum dapat dihitung; data kosong atau bahan terkumpul nol.' : "{$terpakai} dari {$total} kartu bahan terpakai ({$pemakaian}%).",
            'isi' => $pemakaian === null ? 'Lengkapi catatan bahan atau tunggu ada bahan yang diperoleh. Nilai belum tersedia tidak dianggap 0%.'
                : ($terpakai * 100 < $total * 60 ? 'Pemakaian bahan masih rendah. Cocokkan stok dengan pesanan berikutnya sebelum membeli bahan baru.' : 'Periksa bahan tersisa dan keuntungan pesanan untuk merencanakan pembelian berikutnya.'),
        ];
        return redirect()->route('idea', ['mode' => $data['mode'] ?? 'light', 'permainan' => $data['mode_permainan']])
            ->with('analitika', ['data' => $data, 'saran' => $saran])->withInput($request->except('_token'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|string|min:3|max:100',
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
        return redirect()->route('idea', ['mode' => $data['mode'] ?? 'light'])
            ->with('status', "Terima kasih, {$data['nama']}. Ide {$data['judul']} berhasil divalidasi.")
            ->with('ide', $data);
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
        $profil = config('profile');
        // Riwayat yang dapat diverifikasi dari pekerjaan PBKK, bukan transkrip akademik.
        $riwayat = [
            'Profil mahasiswa, MVC, dan routing melalui PageController.',
            'Parameter rute, named routes, dashboard, dan kalkulator IPK.',
        ];
        return view('profile', compact('profil', 'riwayat'));
    }

    public function agent(Request $request, string $tema = 'General Assistant Agent')
    {
        $data = $request->validate(['mode' => ['nullable', 'string', Rule::in(['pemula', 'mahir'])]], ['in' => 'Pilihan :attribute tidak valid.']);
        $mode = $data['mode'] ?? 'pemula';
        $profil = config('profile');
        $skenario = array_filter($profil['ai']['skenario'], fn ($item) => $item['mode'] === 'semua' || $item['mode'] === $mode);
        $deskripsi = $tema === config('profile.tema')
            ? config('profile.deskripsi')
            : "Rancangan asisten bertema {$tema}: menerima pertanyaan, merencanakan langkah, menggunakan tool yang diizinkan, lalu merangkum hasil untuk ditinjau pengguna.";
        return view('agent', compact('tema', 'deskripsi', 'profil', 'mode', 'skenario'));
    }

    public function ipkForm(Request $request)
    {
        if ($request->hasAny(['ip1', 'ip2'])) {
            $data = $request->validate(['ip1' => 'required|numeric|between:0,4', 'ip2' => 'required|numeric|between:0,4']);
            return redirect()->route('ipk.calculate', $data);
        }
        return view('ipk');
    }

    public function ipk(string $ip1, string $ip2)
    {
        $validator = Validator::make(compact('ip1', 'ip2'), ['ip1' => 'required|numeric|between:0,4', 'ip2' => 'required|numeric|between:0,4']);
        if ($validator->fails()) {
            return response()->view('ipk', ['pesan' => 'IP setiap semester harus berupa angka antara 0 dan 4.'], 422);
        }
        $jumlah = $ip1 + $ip2;
        $rata = number_format($jumlah / 2, 2, '.', '');
        return view('ipk', compact('ip1', 'ip2', 'jumlah', 'rata'));
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
            'mode_permainan' => ['nullable', 'required_with:indikator', Rule::in(['pemula', 'mahir'])],
            'indikator' => ['nullable', 'required_with:mode_permainan', Rule::in($request->input('mode_permainan') === 'mahir' ? ['kas', 'bahan', 'pinjaman'] : ['kas', 'bahan'])],
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
            'required_with' => 'Lengkapi mode dan indikator jika menyertakan konteks Narafin.',
            'string' => ':attribute harus berupa teks.',
            'nama.min' => 'Nama mahasiswa minimal 3 karakter.',
            'nama.max' => 'Nama mahasiswa maksimal 100 karakter.',
            'email.email' => 'Masukkan alamat email yang valid.',
            'email.regex' => 'Gunakan email ITS dengan akhiran @student.its.ac.id.',
            'email.max' => 'Email maksimal 254 karakter.',
            'kategori.in' => 'Pilih salah satu kategori masukan yang tersedia.',
            'pesan.min' => 'Isi pesan minimal 15 karakter.',
            'pesan.max' => 'Isi pesan maksimal 5000 karakter.',
            'captcha.integer' => 'Jawaban matematika harus berupa bilangan bulat.',
            'mode_permainan.in' => 'Pilih mode Pemula atau Mahir.',
            'indikator.in' => 'Pilih indikator yang sesuai mode. Pinjaman hanya berlaku pada Mahir.',
        ], ['nama' => 'Nama mahasiswa', 'email' => 'Email', 'kategori' => 'Kategori masukan', 'pesan' => 'Isi pesan', 'captcha' => 'Jawaban matematika', 'mode_permainan' => 'Mode permainan', 'indikator' => 'Indikator saran']);

        unset($data['captcha']);
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
