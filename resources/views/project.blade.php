@extends('layouts.app')
@section('title', 'Rencana Proyek Agentic AI')
@section('content')
<p class="eyebrow muted">{{ $profil['ai']['fase'] }}</p><h1>{{ $profil['tema'] }}</h1>
<p class="lead my-4">{{ $profil['deskripsi'] }}</p>
<article class="card p-4 mb-4"><h2 class="h4">Berangkat dari Saran Narafin</h2><p>Pada Analitika Pemain Cashflowpoly, setiap indikator memiliki penjelasan dan saran. Rencana AI ini menghubungkan beberapa indikator agar pemain memahami penyebab hasilnya dan langkah permainan berikutnya.</p><p class="mb-0">Contoh: kas menurun sementara bahan masih tersisa. Saran perlu mengarahkan pemain memakai persediaan untuk pesanan, sambil meninjau pengeluaran.</p></article>
<article class="card p-4"><h2 class="h4">Rancangan alur</h2><ol class="mb-0"><li>Pilih pemain, sesi, dan mode Pemula atau Mahir.</li><li>Aplikasi menghitung metrik dari catatan permainan; data kosong tetap ditandai belum tersedia.</li><li>LLM direncanakan merangkai bukti kas, bahan, dan pinjaman menjadi saran kontekstual.</li><li>Instruktur meninjau saran sebelum membahas strategi bersama pemain.</li></ol></article>
<div class="alert alert-info mt-4" role="status"><strong>Capaian rancangan:</strong> {{ $profil['ai']['capaian'] }}</div>
<p class="muted">Tahap ini baru rancangan. Integrasi LLM belum berjalan. Referensi: <a href="{{ $profil['ai']['sumber'] }}" target="_blank" rel="noopener">Narafin · Analitika Pemain, bagian Saran</a> (memerlukan login).</p>
@endsection
