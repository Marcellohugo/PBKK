<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PageController extends Controller
{
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
}
