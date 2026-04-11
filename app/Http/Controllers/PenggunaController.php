<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PenggunaController extends Controller
{
    /**
     * Menampilkan semua data pengguna aktif
     */
    public function index()
    {
        // Ambil pengguna yang masih aktif
        $pengguna = Pengguna::where('status', true)->get();
        return view('pengguna.index', compact('pengguna'));
    }

    /**
     * Menampilkan form tambah pengguna
     */
    public function create()
    {
        return view('pengguna.create');
    }

    /**
     * Menyimpan data pengguna baru
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama_pengguna' => 'required|string|max:255',
            'email' => 'required|email|unique:penggunas,email',
            'password' => 'required|min:6',
            'alamat' => 'required|string',
            'status' => 'required|boolean',
        ]);

        // Simpan data pengguna baru
        \App\Models\Pengguna::create([
            'role_id' => 2,
            'nama_pengguna' => $request->nama_pengguna,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'alamat' => $request->alamat,
            'status' => $request->status,
        ]);

        return redirect()->route('pengguna.index')->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Menampilkan detail pengguna
     */
    public function show(string $id)
    {
        $pengguna = Pengguna::findOrFail($id);

        return view('pengguna.detail', compact('pengguna'));
    }

    /**
     * Menampilkan form edit pengguna
     */
    public function edit(string $id)
    {
        $pengguna = Pengguna::findOrFail($id);

        return view('pengguna.edit', compact('pengguna'));
    }

    /**
     * Update data pengguna
     */
    public function update(Request $request, string $id)
    {
        // cari data user
        $pengguna = Pengguna::findOrFail($id);

        // validasi input
        $request->validate([
            'nama_pengguna' => 'required|string|max:255',
            'email' => 'required|email|unique:penggunas,email,' . $id,
            'password' => 'nullable|min:6',
            'alamat' => 'required|string',
            'status' => 'required|boolean',
        ]);

        // update data dasar
        $pengguna->update([
            'nama_pengguna' => $request->nama_pengguna,
            'email' => $request->email,
            'alamat' => $request->alamat,
            'status' => $request->status,
            'foto' => null // reset foto (kalau tidak ada upload baru)
        ]);

        // update password kalau diisi
        if ($request->password) {
            $pengguna->update([
                'password' => bcrypt($request->password)
            ]);
        }

        return redirect()->route('pengguna.index')->with('success', 'Data berhasil diupdate');
    }

    /**
     * Menghapus pengguna
     */
    public function destroy(string $id)
    {
        $pengguna = Pengguna::findOrFail($id);

        // hapus data user dari database (hard delete)
        $pengguna->delete();

        return redirect()->route('pengguna.index')->with('success', 'Data berhasil dihapus');
    }

    /**
     * Menampilkan profile user yang sedang login
     */
    public function profile()
    {
        // ambil user dari session login
        $user = Pengguna::find(Session::get('user_id'));

        return view('pengguna.profile', compact('user'));
    }

    /**
     * Update profile user login
     */
    public function updateProfile(Request $request)
    {
        $user = Pengguna::find(Session::get('user_id'));

        // cek user valid atau tidak
         if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User tidak ditemukan'
            ]);
        }

        // validasi profile
        $request->validate([
            'nama_pengguna' => 'required|string|max:255',
            'email' => 'required|email|unique:penggunas,email,' . $user->id,
            'alamat' => 'nullable|string',
            'password' => 'nullable|min:6'
        ]);

        // data yang akan diupdate
        $data = [
            'nama_pengguna' => $request->nama_pengguna,
            'email' => $request->email,
            'alamat' => $request->alamat,
        ];

        // jika password diisi, update juga password
        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        // simpan update
        $user->update($data);

        // update session email biar sinkron
        Session::put('user_email', $user->email);

        // response JSON (biasanya untuk AJAX)
        return response()->json([
            'success' => true,
            'message' => 'Profile berhasil diupdate'
        ]);
    }

    /**
     * Update foto profile user
     */
    public function updateFoto(Request $request)
    {
        $user = Pengguna::find(Session::get('user_id'));

        // cek upload file
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');

            // simpan ke storage public
            $path = $file->store('foto_profile', 'public');

            // update database
            $user->foto = $path;
            $user->save();
        }

        return back();
    }
}