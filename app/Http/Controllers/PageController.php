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

    public function about()
    {
        return view('about');
    }

    public function project()
    {
        return view('project', ['profil' => config('profile')]);
    }

    public function calculator(Request $request)
    {
        if ($request->hasAny(['angka1', 'angka2', 'operasi'])) {
            $data = $request->validate($this->rules());
            return redirect()->route('calculate', $data);
        }
        return view('calculator');
    }

    private function rules(): array
    {
        return [
            'angka1' => ['required', 'numeric', 'between:-1000000000000,1000000000000'],
            'angka2' => ['required', 'numeric', 'between:-1000000000000,1000000000000'],
            'operasi' => ['required', Rule::in(['tambah', 'kurang', 'kali', 'bagi'])],
        ];
    }

    public function calculate(string $angka1, string $angka2, string $operasi)
    {
        $validator = Validator::make(compact('angka1', 'angka2', 'operasi'), $this->rules());
        if ($validator->fails()) {
            return response()->view('calculator', ['pesan' => 'Masukkan dua angka antara -1 triliun dan 1 triliun serta operasi tambah, kurang, kali, atau bagi.'], 422);
        }
        if ($operasi === 'bagi' && (float) $angka2 == 0) {
            return response()->view('calculator', ['pesan' => 'Pembagian dengan nol tidak diperbolehkan.'], 422);
        }
        $hasil = match ($operasi) {
            'tambah' => $angka1 + $angka2,
            'kurang' => $angka1 - $angka2,
            'kali' => $angka1 * $angka2,
            'bagi' => $angka1 / $angka2,
        };
        return view('calculator', compact('angka1', 'angka2', 'operasi', 'hasil'));
    }
}
