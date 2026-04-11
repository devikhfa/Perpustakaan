<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengguna;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    // Menampilkan halaman login
    public function masuk()
    {
         // Jika sudah login, redirect ke dashboard
        if (Session::has('user_id')) {
            // Jika sudah login, redirect ke halaman katalog
            return redirect()->route('katalog.index');
        }

        // Jika belum login, tampilkan halaman login
        return view('auth.masuk');
    }

    // Menampilkan halaman daftar (register)
    public function daftar()
    {
        // Mengecek apakah user sudah login
        if (Session::has('user_id')) {
            // Jika sudah login, redirect ke katalog
            return redirect()->route('katalog.index');
        }

        // Jika belum login, tampilkan halaman register
        return view('auth.daftar');
    }

    // Proses login
    public function login(Request $request)
    {
        // Validasi input dari form login
        $request->validate([
            'email' => 'required|email', // email wajib & harus format email
            'password' => 'required|min:4' // password minimal 4 karakter
        ], [
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 4 karakter'
        ]);

        // Cari user berdasarkan email
        $user = Pengguna::where('email', $request->email)->first();

        // Cek user dan password
        if ($user && Hash::check($request->password, $user->password)) {

            // Cek status user (misal: 1 = aktif, 0 = nonaktif)
            if ($user->status != 1) {
                return redirect()->back()
                    ->with('error', 'Akun Anda tidak aktif. Hubungi administrator!')
                    ->withInput();
            }

            // Menyimpan data user ke dalam session
            Session::put('user_id', $user->id);
            Session::put('user_nama', $user->nama_pengguna);
            Session::put('user_email', $user->email);
            Session::put('user_alamat', $user->alamat);
            Session::put('user_role', $user->role_id);
            Session::put('user_status', $user->status);
            Session::put('login_at', now());

            // Redirect ke dashboard atau halaman sebelumnya
            if (Session::has('url_intended')) {
                $url = Session::get('url_intended');
                Session::forget('url_intended');
                return redirect($url);
            }

            return redirect()->route('katalog.index')->with('success', 'Selamat datang, ' . $user->nama_pengguna . '!');
        }

        // Jika login gagal (email/password salah)
        return redirect()->back()
            ->with('error', 'Email atau password salah!')
            ->withInput();
    }

    // Proses registrasi user baru
    public function register(Request $request)
    {
        // Validasi input form registrasi
        $request->validate([
            'nama_pengguna' => 'required|string|max:100',
            'email' => 'required|email|unique:penggunas,email',
            'password' => 'required|min:4|confirmed',
            'alamat' => 'nullable|string'
        ], [
            'nama_pengguna.required' => 'Nama lengkap wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 4 karakter',
            'password.confirmed' => 'Konfirmasi password tidak sesuai'
        ]);

        // Menyimpan user baru ke database
        $user = Pengguna::create([
            'role_id' => 3, // default role (misal: user biasa)
            'nama_pengguna' => $request->nama_pengguna,
            'email' => $request->email,
            'password' => Hash::make($request->password), // password di-hash
            'alamat' => $request->alamat,
            'status' => true // status aktif
        ]);

        // Auto login setelah registrasi
        Session::put('user_id', $user->id);
        Session::put('user_nama', $user->nama_pengguna);
        Session::put('user_email', $user->email);
        Session::put('user_alamat', $user->alamat);
        Session::put('user_role', $user->role_id);
        Session::put('user_status', $user->status);
        Session::put('login_at', now());

        return redirect()->route('katalog.index')
            ->with('success', 'Registrasi berhasil! Selamat datang, ' . $user->nama_pengguna . '!');
    }

    // Proses logout
    public function logout(Request $request)
    {
        // Menghapus semua data session
        Session::flush();
        
        // Menghapus session Laravel & regenerate token untuk keamanan
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success', 'Anda telah logout.');
    }

    // Cek apakah user sudah login (untuk middleware)
    public static function checkAuth()
    {
        return Session::has('user_id');
    }

    // Fungsi untuk mengambil data user yang sedang login
    public static function getUser()
    {
        if (Session::has('user_id')) {
            return (object)[
                'id' => Session::get('user_id'),
                'nama' => Session::get('user_nama'),
                'email' => Session::get('user_email'),
                'role' => Session::get('user_role'),
                'status' => Session::get('user_status')
            ];
        }

        // Jika tidak login, return null
        return null;
    }
}