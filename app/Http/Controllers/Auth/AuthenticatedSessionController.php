<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(Request $request): View
    {
        if ($request->query('next') === 'research') {
            $mode = $request->session()->get('research_plan.data.mode', 'light');
            $request->session()->put('url.intended', route('idea', ['mode' => $mode]).'#simpan-proyek');
        }

        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $home = $request->user()->hasAnyRole(['Admin', 'Staf'])
            ? route('admin.dashboard', absolute: false)
            : route('dashboard.home', absolute: false);

        return redirect()->intended($home);
    }

    public function demo(Request $request, string $role): RedirectResponse
    {
        abort_unless(app()->environment('local') && in_array($request->ip(), ['127.0.0.1', '::1'], true), 404);

        $email = match ($role) {
            'admin' => 'admin@researchmate.local',
            'staf' => 'staf@researchmate.local',
            default => abort(404),
        };
        $user = User::where('email', $email)->firstOrFail();
        abort_unless($user->hasRole(ucfirst($role)), 403);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->intended(route('admin.dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
