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
     * Display a listing of the resource.
     */
    public function index()
    {
        // Cek session untuk semua method kecuali yang ditentukan
        if (!Session::has('user_id')) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu!');
        }
        
        $buku = Buku::join('kategoris', 'bukus.kategori_id', '=', 'kategoris.id')
            ->where('bukus.status', true)
            ->select('bukus.*', 'kategoris.nama_kategori as kategori')
            ->get();

        return view('buku.index', compact('buku'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategoris = Kategori::where('status', true) 
                            ->orderBy('nama_kategori')
                            ->get();
        
        return view('buku.create', compact('kategoris'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kategori_id' => 'required',
            'judul' => 'required|max:100',
            'penulis' => 'required|max:100',
            'penerbit' => 'required|max:100',
            'tahun_terbit' => 'required|digits:4|numeric',
            'qty' => 'required|numeric|min:0',
            'sampul' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ]);

        // upload sampul
        if ($request->hasFile('sampul')) {
            $fileName = 'sampul-' . uniqid() . '.' . $request->sampul->extension();
            $request->sampul->move(public_path('image'), $fileName);
        } else {
            $fileName = 'nophoto.jpg';
        }

        // simpan ke database
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
        
        // Redirect dengan pesan sukses
        return redirect()->route('buku.index')->with('success', 'Data buku berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $buku = Buku::join('kategoris', 'bukus.kategori_id', '=', 'kategoris.id')
            ->where('bukus.id', $id)
            ->select('bukus.*', 'kategoris.nama_kategori as kategori')
            ->firstOrFail();
            
        return view('buku.show', compact('buku'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $buku = Buku::findOrFail($id);
        $kategoris = Kategori::where('status', true)
                            ->orderBy('nama_kategori')
                            ->get();
        
        return view('buku.edit', compact('buku', 'kategoris'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'kategori_id' => 'required',
            'judul' => 'required|max:100',
            'penulis' => 'required|max:100',
            'penerbit' => 'required|max:100',
            'tahun_terbit' => 'required|digits:4|numeric',
            'qty' => 'required|numeric|min:0',
            'sampul' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ]);

        $buku = Buku::findOrFail($id);

        // upload sampul baru (kalau ada)
        if ($request->hasFile('sampul')) {
            $fileName = 'sampul-' . uniqid() . '.' . $request->sampul->extension();
            $request->sampul->move(public_path('image'), $fileName);

            // update nama file
            $buku->sampul = $fileName;
        }

        // update data lain
        $buku->kategori_id = $request->kategori_id;
        $buku->judul = $request->judul;
        $buku->penulis = $request->penulis;
        $buku->penerbit = $request->penerbit;
        $buku->tahun_terbit = $request->tahun_terbit;
        $buku->qty = $request->qty;
        $buku->updated_at = now();

        $buku->save();

        return redirect()->route('buku.index')->with('success', 'Data berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // $buku = Buku::findOrFail($id);
        // if ($buku->sampul && $buku->sampul != 'nophoto.jpg') {
        //     $path = public_path('image/' . $buku->sampul);
        //     if (file_exists($path)) {
        //         unlink($path);
        //     }
        // }

        // $buku->delete();
        $buku = Buku::findOrFail($id);

        $buku->status = false;
        $buku->updated_at = now();

        $buku->save();

        return redirect()->route('buku.index')->with('success', 'Data berhasil dihapus');
    }
}
