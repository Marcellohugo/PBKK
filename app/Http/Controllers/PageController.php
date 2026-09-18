<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PageController extends Controller
{
    private const KATEGORI = ['Akademik', 'Sarana Prasarana', 'Kegiatan Mahasiswa'];

    public function create(Request $request)
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

    public function store(Request $request)
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

    public function success(Request $request)
    {
        $feedback = $request->session()->get('feedback');
        if (! $feedback) {
            return redirect()->route('feedback.create');
        }
        return view('success', compact('feedback'));
    }
}
