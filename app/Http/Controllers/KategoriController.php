<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kategori = Kategori::where('status', true)->get();
        return view('kategori.index', compact('kategori'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('kategori.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|max:100'
        ]);

        // simpan ke database
        DB::table('kategoris')->insert([
            'nama_kategori' => $request->nama_kategori,
            'deskripsi' => $request->deskripsi,
            'status' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        // Redirect dengan pesan sukses
        return redirect()->route('kategori.index')->with('success', 'Data kategori berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $kategori = Kategori::findOrFail($id);
        return view('kategori.edit', compact('kategori'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kategori' => 'required|max:100'
        ]);

        $kategori = Kategori::findOrFail($id);

        $kategori->nama_kategori = $request->nama_kategori;
        $kategori->deskripsi = $request->deskripsi;
        $kategori->update_at = now();

        $kategori->save();

        return redirect()->route('kategori.index')->with('success', 'Data berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $kategori = Kategori::findOrFail($id);

        $kategori->status = false;
        $kategori->update_at = now();

        $kategori->save();

        return redirect()->route('kategori.index')->with('success', 'Data berhasil dihapus');
    }
}
