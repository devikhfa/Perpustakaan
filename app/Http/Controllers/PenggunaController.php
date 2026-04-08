<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PenggunaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pengguna = Pengguna::where('status', true)->get();
        return view('pengguna.index', compact('pengguna'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pengguna.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_pengguna' => 'required|string|max:255',
            'email' => 'required|email|unique:penggunas,email',
            'password' => 'required|min:6',
            'alamat' => 'required|string',
            'status' => 'required|boolean',
        ]);

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
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pengguna = Pengguna::findOrFail($id);
        return view('pengguna.detail', compact('pengguna'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $pengguna = Pengguna::findOrFail($id);
        return view('pengguna.edit', compact('pengguna'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $pengguna = Pengguna::findOrFail($id);

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

        // update password kalau diisi
        if ($request->password) {
            $pengguna->update([
                'password' => bcrypt($request->password)
            ]);
        }

        return redirect()->route('pengguna.index')->with('success', 'Data berhasil diupdate');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pengguna = Pengguna::findOrFail($id);
        $pengguna->delete();

        return redirect()->route('pengguna.index')->with('success', 'Data berhasil dihapus');
    }

    public function profile()
    {
        $user = Pengguna::find(Session::get('user_id'));

        return view('pengguna.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Pengguna::find(Session::get('user_id'));

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User tidak ditemukan'
            ]);
        }

        $request->validate([
            'nama_pengguna' => 'required|string|max:255',
            'email' => 'required|email|unique:penggunas,email,' . $user->id,
            'alamat' => 'nullable|string'
        ]);

        $user->update([
            'nama_pengguna' => $request->nama_pengguna,
            'email' => $request->email,
            'alamat' => $request->alamat
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Profile berhasil diupdate'
        ]);
    }
}
