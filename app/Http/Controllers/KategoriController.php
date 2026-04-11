<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    /**
     * Menampilkan semua kategori aktif
     */
    public function index()
    {
        // Ambil kategori yang statusnya aktif (soft delete manual)
        $kategori = Kategori::where('status', true)->get();

        return view('kategori.index', compact('kategori'));
    }

    /**
     * Menampilkan form tambah kategori
     */
    public function create()
    {
        return view('kategori.create');
    }

    /**
     * Menyimpan data kategori baru
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama_kategori' => 'required|max:100'
        ]);

        // Simpan data ke database (pakai Query Builder)
        DB::table('kategoris')->insert([
            'nama_kategori' => $request->nama_kategori,
            'deskripsi' => $request->deskripsi,
            'status' => true, // default aktif
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        // Redirect ke index dengan pesan sukses
        return redirect()->route('kategori.index')->with('success', 'Data kategori berhasil ditambahkan!');
    }

    /**
     * Tidak digunakan (bisa untuk detail kategori jika mau dikembangkan)
     */
    public function show(string $id)
    {
        // ambil data kategori berdasarkan ID
        $kategori = Kategori::findOrFail($id);

        // kirim ke view detail
        return view('kategori.detail', compact('kategori'));
    }
    /**
     * Menampilkan form edit kategori
     */
    public function edit(string $id)
    {
        // Ambil data kategori berdasarkan ID
        $kategori = Kategori::findOrFail($id);

        // Kirim ke view edit
        return view('kategori.edit', compact('kategori'));
    }

    /**
     * Update data kategori
     */
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'nama_kategori' => 'required|max:100'
        ]);

        // Cari data kategori
        $kategori = Kategori::findOrFail($id);

        // Update data
        $kategori->nama_kategori = $request->nama_kategori;
        $kategori->deskripsi = $request->deskripsi;
        $kategori->updated_at = now();

        // Simpan perubahan
        $kategori->save();

        return redirect()->route('kategori.index')
            ->with('success', 'Data berhasil diupdate');
    }

    /**
     * Hapus kategori (soft delete manual)
     */
    public function destroy(string $id)
    {
        // Ambil data kategori
        $kategori = Kategori::findOrFail($id);

        // Soft delete manual (tidak benar-benar hapus)
        $kategori->status = false;

        $kategori->updated_at = now();

        // simpan perubahan
        $kategori->save();

        return redirect()->route('kategori.index')->with('success', 'Data berhasil dihapus');
    }
}