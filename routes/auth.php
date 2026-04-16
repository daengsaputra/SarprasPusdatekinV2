<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    // Menampilkan form login
    public function create()
    {
        return view('auth.login');  // pastikan ada file login.blade.php di resources/views/auth
    }

    // Proses login
    public function store(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Mencoba login
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();  // Regenerasi session untuk keamanan
            return redirect()->intended('/dashboard');  // Arahkan ke halaman dashboard setelah login
        }

        // Jika gagal login, kembali ke form login dengan pesan error
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    // Proses logout
    public function destroy(Request $request)
    {
        Auth::logout();  // Logout pengguna

        // Menghapus session dan token CSRF
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');  // Redirect ke halaman depan setelah logout
    }
}