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
        $role = Session::get('user_role');

        if ($role == 1) {
            // Kepala → Petugas
            $pengguna = Pengguna::where('status', true)
                ->where('role_id', 2)
                ->get();
        } 
        elseif ($role == 2) {
            // Petugas → Anggota
            $pengguna = Pengguna::where('status', true)
                ->where('role_id', 3)
                ->get();
        } 
        else {
            // Anggota → dirinya sendiri
            $pengguna = Pengguna::where('id', Session::get('user_id'))
                ->get();
        }

        return view('pengguna.index', compact('pengguna'));
    }

    /**
     * Menampilkan form tambah pengguna
     */
    public function create()
{
    if (Session::get('user_role') != 1) {
        abort(403, 'Hanya Kepala yang boleh tambah petugas');
    }

    return view('pengguna.create');
}

    /**
     * Menyimpan data pengguna baru
     */
    public function store(Request $request)
{
    if (Session::get('user_role') != 1) {
        abort(403);
    }

    $request->validate([
        'nama_pengguna' => 'required|string|max:255',
        'email' => 'required|email|unique:penggunas,email',
        'password' => 'required|min:6',
        'alamat' => 'required|string',
        'status' => 'required|boolean',
    ]);

    Pengguna::create([
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
    if (Session::get('user_role') != 1) {
        abort(403);
    }

    $pengguna = Pengguna::findOrFail($id);

    if ($pengguna->role_id != 2) {
        abort(403, 'Hanya boleh edit petugas');
    }

    return view('pengguna.edit', compact('pengguna'));
}
    /**
     * Update data pengguna
     */
    public function update(Request $request, string $id)
{
    if (Session::get('user_role') != 1) {
        abort(403);
    }

    $pengguna = Pengguna::findOrFail($id);

    if ($pengguna->role_id != 2) {
        abort(403);
    }

    $request->validate([
        'nama_pengguna' => 'required|string|max:255',
        'email' => 'required|email|unique:penggunas,email,' . $id,
        'password' => 'nullable|min:6',
        'alamat' => 'required|string',
        'status' => 'required|boolean',
    ]);

    $pengguna->update([
        'nama_pengguna' => $request->nama_pengguna,
        'email' => $request->email,
        'alamat' => $request->alamat,
        'status' => $request->status,
    ]);

    if ($request->password) {
        $pengguna->update([
            'password' => bcrypt($request->password)
        ]);
    }

    return redirect()->route('pengguna.index');
}

    /**
     * Menghapus pengguna
     */
    public function destroy(string $id)
    {
        if (Session::get('user_role') != 1) {
            abort(403);
        }

        $pengguna = Pengguna::findOrFail($id);

        if ($pengguna->role_id != 2) {
            abort(403, 'Hanya boleh hapus petugas');
        }

        $pengguna->delete();

        return back();
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