<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PageController extends Controller
{
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

    public function index()
    {
        return view('home', ['profil' => config('profile')]);
    }

    public function profile(string $nrp)
    {
        if ($nrp !== config('profile.nrp')) {
            return $this->notFound();
        }
        $profil = config('profile');
        // Riwayat yang dapat diverifikasi dari pekerjaan PBKK, bukan transkrip akademik.
        $riwayat = [
            'Pertemuan 1: profil mahasiswa, MVC, dan routing melalui PageController.',
            'Pertemuan 2: parameter rute, named routes, dashboard, dan kalkulator IPK.',
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
