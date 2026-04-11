<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class BukuController extends Controller
{
    /**
     * Menampilkan semua data buku
     */
    public function index()
    {
        // Cek apakah user sudah login
        if (!Session::has('user_id')) {
            return redirect()->route('login')
                ->with('error', 'Silakan login terlebih dahulu!');
        }
        
        // Mengambil data buku yang masih aktif (status = true)
        // sekaligus join dengan tabel kategori
        $buku = Buku::join('kategoris', 'bukus.kategori_id', '=', 'kategoris.id')
            ->where('bukus.status', true)
            ->select('bukus.*', 'kategoris.nama_kategori as kategori')
            ->get();

        // Kirim data ke view
        return view('buku.index', compact('buku'));
    }

    /**
     * Menampilkan form tambah buku
     */
    public function create()
    {
        // Ambil semua kategori yang aktif
        $kategoris = Kategori::where('status', true) 
                            ->orderBy('nama_kategori')
                            ->get();
        return view('buku.create', compact('kategoris'));
    }

    /**
     * Menyimpan data buku baru ke database
     */
    public function store(Request $request)
    {
        // Validasi input form tambah buku
        $request->validate([
            'kategori_id' => 'required',
            'judul' => 'required|max:100',
            'penulis' => 'required|max:100',
            'penerbit' => 'required|max:100',
            'tahun_terbit' => 'required|digits:4|numeric',
            'qty' => 'required|numeric|min:0',
            'sampul' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ]);

        // Proses upload file sampul buku
        if ($request->hasFile('sampul')) {
            $fileName = 'sampul-' . uniqid() . '.' . $request->sampul->extension();
            $request->sampul->move(public_path('image'), $fileName);
        } else {
            // jika tidak upload gambar, pakai default
            $fileName = 'nophoto.jpg';
        }

        // Simpan data ke database menggunakan Query Builder
        DB::table('bukus')->insert([
            'kategori_id' => $request->kategori_id,
            'judul' => $request->judul,
            'penulis' => $request->penulis,
            'penerbit' => $request->penerbit,
            'tahun_terbit' => $request->tahun_terbit,
            'qty' => $request->qty,
            'sampul' => $fileName,
            'status' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('buku.index')
            ->with('success', 'Data buku berhasil ditambahkan!');
    }

    /**
     * Menampilkan detail satu buku
     */
    public function show(string $id)
    {
        // Ambil data buku berdasarkan ID + join kategori
        $buku = Buku::join('kategoris', 'bukus.kategori_id', '=', 'kategoris.id')
            ->where('bukus.id', $id)
            ->select('bukus.*', 'kategoris.nama_kategori as kategori')
            ->firstOrFail();
            
        // Kirim ke view detail
        return view('buku.show', compact('buku'));
    }

    /**
     * Menampilkan form edit buku
     */
    public function edit(string $id)
    {
        // Ambil data buku berdasarkan ID
        $buku = Buku::findOrFail($id);

        // Ambil semua kategori aktif untuk dropdown
        $kategoris = Kategori::where('status', true)
                            ->orderBy('nama_kategori')
                            ->get();
        
        // Kirim ke view edit
        return view('buku.edit', compact('buku', 'kategoris'));
    }

    /**
     * Update data buku
     */
    public function update(Request $request, $id)
    {
        // Validasi input update
        $request->validate([
            'kategori_id' => 'required',
            'judul' => 'required|max:100',
            'penulis' => 'required|max:100',
            'penerbit' => 'required|max:100',
            'tahun_terbit' => 'required|digits:4|numeric',
            'qty' => 'required|numeric|min:0',
            'sampul' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ]);

        // Cari data buku
        $buku = Buku::findOrFail($id);

        // Jika ada upload sampul baru
        if ($request->hasFile('sampul')) {
            $fileName = 'sampul-' . uniqid() . '.' . $request->sampul->extension();
            $request->sampul->move(public_path('image'), $fileName);

            // update field sampul
            $buku->sampul = $fileName;
        }

        // Update data buku lainnya
        $buku->kategori_id = $request->kategori_id;
        $buku->judul = $request->judul;
        $buku->penulis = $request->penulis;
        $buku->penerbit = $request->penerbit;
        $buku->tahun_terbit = $request->tahun_terbit;
        $buku->qty = $request->qty;
        $buku->updated_at = now();

        // simpan perubahan
        $buku->save();

        return redirect()->route('buku.index')
            ->with('success', 'Data berhasil diupdate');
    }

    /**
     * Hapus data buku (soft delete manual)
     */
    public function destroy(string $id)
    {
        // Ambil data buku
        $buku = Buku::findOrFail($id);

        // Soft delete manual: ubah status jadi false (tidak dihapus permanen)
        $buku->status = false;
        $buku->updated_at = now();

        // simpan perubahan
        $buku->save();

        return redirect()->route('buku.index')
            ->with('success', 'Data berhasil dihapus');
    }
}