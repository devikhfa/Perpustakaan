<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Transaksi;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class KatalogController extends Controller
{
    /**
     * Menampilkan daftar katalog buku
     */
    public function index(Request $request)
    {
        // Cek apakah user sudah login
        if (!Session::has('user_id')) {
            return redirect()->route('login')
                ->with('error', 'Silakan login terlebih dahulu!');
        }

        // Ambil data buku yang tersedia (aktif & stok > 0)
        $buku = Buku::join('kategoris', 'bukus.kategori_id', '=', 'kategoris.id')
            ->where('bukus.status', true)
            ->where('bukus.qty', '>', 0)
            ->select('bukus.*', 'kategoris.nama_kategori as kategori')

            // fitur search (pencarian judul atau kategori)
            ->when($request->search, function ($query) use ($request) {
                $query->where(function ($q) use ($request) {
                    $q->where('bukus.judul', 'like', '%' . $request->search . '%')
                      ->orWhere('kategoris.nama_kategori', 'like', '%' . $request->search . '%');
                });
            })
            // FILTER KATEGORI
            ->when($request->kategori, function ($query) use ($request) {
                $query->where('bukus.kategori_id', $request->kategori);
            })
            ->get();

        $kategoris = \App\Models\Kategori::orderBy('nama_kategori')->get();
        $pinjamAktif = Transaksi::where('peminjam_id', Session::get('user_id'))
            ->where('status_transaksi', '!=', 3) // belum selesai
            ->count();

        return view('katalog.index', compact('buku', 'pinjamAktif', 'kategoris'));
    }

    /**
     * Menampilkan detail buku
     */
    public function detail(string $id)
    {
        // Cek login
        if (!Session::has('user_id')) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu!');
        }

        // Ambil detail buku berdasarkan ID
        $buku = Buku::join('kategoris', 'bukus.kategori_id', '=', 'kategoris.id')
            ->where('bukus.status', true)
            ->where('bukus.qty', '>', 0)
            ->where('bukus.id', '=', $id)
            ->select('bukus.*', 'kategoris.nama_kategori as kategori')
            ->get();

        return view('katalog.detail', compact('buku'));
    }

    /**
     * Halaman form peminjaman buku
     */
    public function pinjam(string $id)
    {
        // Cek login user
        if (!Session::has('user_id')) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu!');
        }

        // Ambil data buku untuk dipinjam
        $buku = Buku::with('kategori')->findOrFail($id);

        return view('katalog.pinjam', compact('buku'));
    }

    /**
     * Proses transaksi peminjaman buku
     */
    public function store(Request $request)
    {
        $pinjamAktif = Transaksi::where('peminjam_id', $request->peminjam_id)
            ->where('status_transaksi', '!=', 3)
            ->count();

        if ($pinjamAktif >= 3) {
            return redirect()->route('katalog.index')
                ->with('error', 'Batas maksimal peminjaman 3 buku. Kembalikan buku dulu!');
        }
        // Validasi input transaksi
        $request->validate([
            'peminjam_id' => 'required|exists:penggunas,id',
            'buku_id' => 'required|exists:bukus,id',
            'tgl_pinjam' => 'required|date',
            'tgl_jatuh_tempo' => 'required|date|after_or_equal:tgl_pinjam',
            'catatan' => 'nullable|string',
        ], [
            'peminjam_id.required' => 'Peminjam harus dipilih',
            'peminjam_id.exists' => 'Data peminjam tidak ditemukan',
            'buku_id.required' => 'Buku harus dipilih',
            'buku_id.exists' => 'Data buku tidak ditemukan',
            'tgl_pinjam.required' => 'Tanggal pinjam harus diisi',
            'tgl_pinjam.date' => 'Format tanggal pinjam tidak valid',
            'tgl_jatuh_tempo.required' => 'Tanggal jatuh tempo harus diisi',
            'tgl_jatuh_tempo.date' => 'Format tanggal jatuh tempo tidak valid',
            'tgl_jatuh_tempo.after_or_equal' => 'Tanggal jatuh tempo harus setelah atau sama dengan tanggal pinjam',
        ]);
        try {
            // mulai transaksi database (biar aman dari error)
            DB::beginTransaction();
            
            // lock data buku supaya aman dari double booking
            $buku = Buku::where('id', $request->buku_id)
                ->lockForUpdate()
                ->first();

            // cek stok buku
            if ($buku->qty <= 0) {
                throw new \Exception('Stok buku tidak mencukupi!');
            }

            // simpan data transaksi peminjaman
            $transaksi = Transaksi::create([
                'peminjam_id' => $request->peminjam_id,
                'buku_id' => $request->buku_id,
                'catatan' => $request->catatan,
                'status_transaksi' => 1, // 1 = dipinjam
                'status' => true,

                // tracking user (sementara hardcode admin/user id 1)
                'created_by' => 1,
                'created_at' => now()
            ]);
            
            // kurangi stok buku setelah dipinjam
            $buku->decrement('qty');
            
            // commit transaksi jika semua sukses
            DB::commit();
            
            return redirect()->route('katalog.index')
                ->with('success', 'Transaksi berhasil dibuat! Buku berhasil dipinjam.');
                
        } catch (\Exception $e) {
            // rollback jika terjadi error
            DB::rollBack();
            
            return redirect()->back()
                ->with('error', 'Gagal membuat transaksi: ' . $e->getMessage())
                ->withInput();
        }
    }
}