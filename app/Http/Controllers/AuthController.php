<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    // public function masuk(Request $request)
    // {
    //     $data = $request->validate([
    //         'email' => 'required|email',
    //         'password' => 'required',
    //     ]);

    //     if (\Auth::attempt($data)) {
    //         return redirect()->route('pengguna.index');
    //     }

    //     return back()->with('error', 'Email atau password salah');
    // }

    // public function register(Request $request)
    // {
    //     $data = $request->validate([
    //         'nama_pengguna' => 'required|string|max:255',
    //         'email' => 'required|email|unique:penggunas,email',
    //         'password' => 'required|min:6',
    //     ]);

    //     \App\Models\Pengguna::create([
    //         'nama_pengguna' => $data['nama_pengguna'],
    //         'email' => $data['email'],
    //         'password' => bcrypt($data['password']),
    //         'status' => 1,
    //         'alamat' => '-', // default kalau belum ada
    //     ]);

    //     return redirect()->route('login')->with('success', 'Berhasil daftar, silakan login');
    // }
}
