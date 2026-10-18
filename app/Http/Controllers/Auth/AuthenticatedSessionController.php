<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->validate([
            'role' => ['required', 'in:siswa,guru'],
        ]);

        $request->authenticate();

        // Akun harus sesuai dengan tab yang dipilih (Siswa / Guru)
       if (Auth::user()->role === 'guru') {
    return redirect()->route('guru.nilai');
}

return redirect()->intended(route('dashboard', absolute: false));
        $request->session()->regenerate();

        // Sementara siswa dan guru ke dashboard yang sama.
        // Nanti bisa dipisah, misalnya guru ke route('guru.dashboard').
        return redirect()->intended(route('dashboard', absolute: false));
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