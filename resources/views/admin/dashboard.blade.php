@extends('adminlte::page')

@section('title', 'Dashboard Riset · ResearchMate')

@section('content_header')
    <div class="d-flex flex-wrap align-items-center justify-content-between">
        <div>
            <h1 class="mb-1">Dashboard Riset</h1>
            <p class="text-muted mb-0">Pantau proyek dan aktivitas ResearchMate.</p>
        </div>
        <div class="d-flex align-items-center mt-2 mt-sm-0">
            <span class="badge bg-primary me-3">{{ auth()->user()->getRoleNames()->join(', ') }}</span>
            <a class="btn btn-outline-primary btn-sm me-2" href="{{ route('dashboard.home') }}">Proyek Saya</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="btn btn-outline-secondary btn-sm" type="submit">Keluar</button>
            </form>
        </div>
    </div>
@stop

@section('content')
    @if(session('status'))
        <div class="alert alert-success" role="status">{{ session('status') }}</div>
    @endif

    <div class="row">
        <div class="col-sm-6 col-md-4">
            <x-adminlte-small-box :title="$userCount" text="Pengguna" icon="bi bi-people" theme="info" />
        </div>
        <div class="col-sm-6 col-md-4">
            <x-adminlte-small-box :title="$projectCount" text="Proyek riset" icon="bi bi-folder2-open" theme="success" />
        </div>
        <div class="col-sm-6 col-md-4">
            <x-adminlte-small-box :title="$feedbackCount" text="Masukan" icon="bi bi-chat-dots" theme="warning" />
        </div>
    </div>

    <div id="daftar-proyek" class="card">
        <div class="card-header">
            <div class="d-flex flex-wrap align-items-center justify-content-between">
                <h2 class="card-title fw-bold mb-2 mb-sm-0">Daftar proyek riset</h2>
                <form method="GET" action="{{ route('admin.dashboard') }}" class="d-flex align-items-center flex-wrap gap-2">
                    <label for="project-search" class="visually-hidden">Cari proyek atau pemilik</label>
                    <input id="project-search" name="q" value="{{ $search }}" maxlength="100" class="form-control form-control-sm" placeholder="Cari proyek atau pemilik">
                    <button class="btn btn-primary btn-sm" type="submit">Cari</button>
                    @if($search !== null && $search !== '')<a class="btn btn-link btn-sm" href="{{ route('admin.dashboard') }}">Reset</a>@endif
                </form>
            </div>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover mb-0">
                <caption class="visually-hidden">Daftar proyek riset, pemilik, dan tanggal pembuatan</caption>
                <thead><tr><th scope="col">Proyek</th><th scope="col">Pemilik</th><th scope="col">Dibuat</th>
                    @can('projects.delete')
                        @if(auth()->user()->hasRole('Admin'))<th scope="col">Aksi</th>@endif
                    @endcan
                </tr></thead>
                <tbody>
                    @forelse($projects as $project)
                        <tr>
                            <td><strong>{{ $project->judul }}</strong><br><small class="text-muted">{{ $project->tema_agent }}</small></td>
                            <td>{{ $project->user->name }}<br><small class="text-muted">{{ $project->user->email }}</small></td>
                            <td><time datetime="{{ $project->created_at->toDateString() }}">{{ $project->created_at->translatedFormat('d M Y') }}</time></td>
                            @can('projects.delete')
                            @if(auth()->user()->hasRole('Admin'))
                                <td>
                                    <form method="POST" action="{{ route('admin.projects.destroy', $project) }}" onsubmit="return confirm('Hapus proyek ini secara permanen?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-outline-danger btn-sm" type="submit" aria-label="Hapus proyek {{ $project->judul }}">Hapus Data</button>
                                    </form>
                                </td>
                            @endif
                            @endcan
                        </tr>
                    @empty
                        <tr><td colspan="{{ auth()->user()->hasRole('Admin') && auth()->user()->can('projects.delete') ? 4 : 3 }}" class="text-center text-muted py-4">{{ $search !== null && $search !== '' ? 'Tidak ada proyek yang cocok dengan pencarian.' : 'Belum ada proyek riset.' }}</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($projects->hasPages())
            <div class="card-footer pb-0">{{ $projects->links('pagination::bootstrap-5') }}</div>
        @endif
    </div>
@stop
