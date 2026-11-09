<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        abort_unless($request->user()->hasAnyRole(['Admin', 'Staf']), 403);

        $search = $request->validate(['q' => ['nullable', 'string', 'max:100']])['q'] ?? null;
        $projects = Project::with('user')
            ->when($search !== null && $search !== '', fn (Builder $query) => $query->where(function (Builder $query) use ($search) {
                $query->whereLike('judul', "%{$search}%")
                    ->orWhereLike('deskripsi', "%{$search}%")
                    ->orWhereHas('user', fn (Builder $user) => $user
                        ->whereLike('name', "%{$search}%")
                        ->orWhereLike('email', "%{$search}%"));
            }))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.dashboard', [
            'projects' => $projects,
            'search' => $search,
            'userCount' => User::count(),
            'projectCount' => Project::count(),
            'feedbackCount' => DB::table('feedback')->count(),
        ]);
    }

    public function destroy(Request $request, Project $project): RedirectResponse
    {
        abort_unless($request->user()->hasRole('Admin') && $request->user()->can('projects.delete'), 403);

        $project->delete();

        return redirect()->route('admin.dashboard')->with('status', 'Proyek berhasil dihapus.');
    }
}
