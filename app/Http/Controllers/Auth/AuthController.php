<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Alur autentikasi aplikasi (guard: pub_login).
 *
 *  GET  /login    -> login()    : tampilkan form login
 *  POST /doLogin  -> doLogin()  : proses autentikasi
 *  GET  /logout   -> doLogout() : hapus session & kembali ke login
 *
 * Cara session user disimpan:
 *  - Driver session diatur di config/session.php (default: file,
 *    tersimpan di storage/framework/sessions, lifetime via .env
 *    SESSION_LIFETIME).
 *  - Saat login sukses, Laravel menyimpan id user di session dengan key
 *    milik guard pub_login. Session id di-regenerate (anti session
 *    fixation) dan hash password disimpan ke session sebagai pembanding
 *    (auto-logout jika password diganti dari tempat lain).
 */
class AuthController extends Controller
{
    /**
     * Tampilkan halaman login. Jika sudah login, langsung ke dashboard.
     */
    public function login(Request $request)
    {
        if (Auth::guard('pub_login')->user()) {
            return redirect()->route('dashboard');
        }

        return view('auth.login');
    }

    /**
     * Proses login.
     */
    public function doLogin(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string|max:255',
            'password' => 'required|string',
        ]);

        $remember = $request->has('remember');

        if (!Auth::guard('pub_login')->attempt($credentials, $remember)) {
            return redirect()
                ->route('login')
                ->withInput($request->only('username'))
                ->with('error', 'Username atau password salah.');
        }

        $user = Auth::guard('pub_login')->user();

        // Regenerate session id setelah login (wajib, anti session fixation)
        $request->session()->regenerate();

        // Simpan hash password di session - dipakai middleware
        // AuthenticateSession untuk logout otomatis jika password berubah
        $request->session()->put('password_hash_pub_login', $user->getAuthPassword());

        // Catat waktu login terakhir
        $user->update(['tgl_akses' => date('Y-m-d H:i:s')]);

        // Di project asli, redirect bisa berbeda per role (previllage).
        // Contoh:
        // if ($user->previllage === 'Supplier') return redirect()->route('...');
        return redirect()->route('dashboard');
    }

    /**
     * Logout: catat effdate, hapus session, regenerate CSRF token.
     */
    public function doLogout(Request $request)
    {
        $user = Auth::guard('pub_login')->user();

        if ($user) {
            $user->update(['effdate' => date('Y-m-d H:i:s')]);
        }

        Auth::guard('pub_login')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
