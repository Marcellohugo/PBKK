@extends('layouts.app')
@section('title', 'Rencana Proyek Agentic AI')
@section('content')
<p class="eyebrow muted">Usulan tema kelompok</p><h1>{{ $profil['tema'] }}</h1>
<p class="lead my-4">{{ $profil['deskripsi'] }}</p>
<article class="card p-4"><h2 class="h4">Rancangan alur</h2><ol class="mb-0"><li>Pengguna memilih database yang berwenang diperiksa.</li><li>Tool membaca metrik dan hasil pemeriksaan melalui akses read-only.</li><li>LLM merangkum temuan dan mengusulkan perbaikan.</li><li>Pengguna meninjau rekomendasi sebelum melakukan perubahan.</li></ol></article>
<p class="muted mt-4">Rencana teknologi: Laravel, Livewire, Ollama atau Senopati AI, dan NativePHP. Halaman ini merupakan rancangan awal; integrasi AI dikerjakan pada proyek akhir.</p>
@endsection
