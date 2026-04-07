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
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!Session::has('user_id')) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu!');
        }

        $buku = Buku::join('kategoris', 'bukus.kategori_id', '=', 'kategoris.id')
            ->where('bukus.status', true)
            ->where('bukus.qty', '>', 0)
            ->select('bukus.*', 'kategoris.nama_kategori as kategori')
            ->get();

        return view('katalog.index', compact('buku'));
    }

    public function detail(string $id)
    {
        if (!Session::has('user_id')) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu!');
        }

        $buku = Buku::join('kategoris', 'bukus.kategori_id', '=', 'kategoris.id')
            ->where('bukus.status', true)
            ->where('bukus.qty', '>', 0)
            ->where('bukus.id', '=', $id)
            ->select('bukus.*', 'kategoris.nama_kategori as kategori')
            ->get();

        return view('katalog.detail', compact('buku'));
    }

    public function pinjam(string $id)
    {
        if (!Session::has('user_id')) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu!');
        }
        $buku = Buku::join('kategoris', 'bukus.kategori_id', '=', 'kategoris.id')
            ->where('bukus.id', $id)
            ->select('bukus.*', 'kategoris.nama_kategori as kategori')
            ->firstOrFail();

        return view('katalog.pinjam', compact('buku'));
    }

    public function store(Request $request)
    {
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
            DB::beginTransaction();
            
            $buku = Buku::where('id', $request->buku_id)->lockForUpdate()->first();

            if ($buku->qty <= 0) {
                throw new \Exception('Stok buku tidak mencukupi!');
            }
            $transaksi = Transaksi::create([
                'peminjam_id' => $request->peminjam_id,
                'buku_id' => $request->buku_id,
                'tgl_pinjam' => $request->tgl_pinjam,
                'tgl_jatuh_tempo' => $request->tgl_jatuh_tempo,
                'catatan' => $request->catatan,
                'status_transaksi' => 1,
                'status' => true,
                // 'created_by' => Auth::id(),
                // 'updated_by' => Auth::id(),
                'created_by' => 1,
                'created_at' => now()
            ]);
            
            $buku->decrement('qty');
            
            DB::commit();
            
            return redirect()->route('katalog.index')
                ->with('success', 'Transaksi berhasil dibuat! Buku berhasil dipinjam.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->back()
                ->with('error', 'Gagal membuat transaksi: ' . $e->getMessage())
                ->withInput();
        }
    }
}
