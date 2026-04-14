<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Anggota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash; // Tambahkan ini

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            if (Auth::user()->role === 'Admin') {
                return redirect()->route('dashboard');
            }

            return redirect()->route('page.index'); 
        }

        return back()->withErrors([
            'email' => 'Email atau password salah',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    // --- TAMBAHKAN KODE DI BAWAH INI ---

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'nis' => 'required|unique:anggotas',
            'kelas' => 'required|string',
            'no_tlp' => 'required|string',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan'
        ]);

        // 2. Buat data di tabel Users
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'Anggota'
        ]);

        // 3. Buat data di tabel Anggotas dengan mengambil id user yang baru dibuat
        Anggota::create([
            'user_id' => $user->id,
            'nis' => $request->nis,
            'kelas' => $request->kelas,
            'no_tlp' => $request->no_tlp,
            'jenis_kelamin' => $request->jenis_kelamin
        ]);

        // 4. Langsung login-kan pengguna setelah berhasil mendaftar (opsional)
        Auth::login($user);

        // 5. Arahkan ke halaman katalog buku
        return redirect()->route('page.index')->with('success', 'Registrasi berhasil!');
    }
}