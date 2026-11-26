@extends('layouts.app')
@section('title', 'Chat riset')
@section('content')
<header class="mb-6">
    <p class="eyebrow">ResearchMate AI</p>
    <h1 class="mt-1 text-3xl font-extrabold tracking-tight text-slate-900">Chat riset</h1>
    <p class="mt-2 text-sm text-slate-600">Diskusikan metode, telaah literatur, atau kode analisis bersama asisten riset.</p>
</header>
<div class="chat-workspace">
    <aside class="chat-tools" aria-label="Alat riset">
        <livewire:chat-history />
        <livewire:file-scan />
    </aside>
    <livewire:chat-panel />
</div>
@endsection
