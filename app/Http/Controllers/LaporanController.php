<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Buku;
use App\Models\Pengguna;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    /**
     * Menampilkan laporan peminjaman buku
     */
    public function peminjaman(Request $request)
    {
         // Ambil data transaksi dengan status dipinjam (status = 1 atau true)
        $query = Transaksi::join('penggunas', 'transaksis.peminjam_id', '=', 'penggunas.id')
            ->join('bukus', 'transaksis.buku_id', '=', 'bukus.id')
            ->where('transaksis.status', true)
            // ambil data yang diperlukan saja
            ->select(
                'transaksis.*', 
                'penggunas.nama_pengguna', 
                'penggunas.email',
                'penggunas.alamat',
                'bukus.judul'
            );

        //Filter Tanggal
        if ($request->dari && $request->sampai) {
            $filter = $request->filter ?? 'tgl_pinjam';

            $query->whereBetween($filter, [
                $request->dari,
                $request->sampai
            ]);
        }

            // urutkan dari data terbaru
            $transaksis = $query->orderBy('transaksis.created_at', 'desc')
            ->get();

        // Statistik untuk ditampilkan di laporan/dashboard
        $totalBuku = Buku::count(); // total semua buku
        $totalPetugas = Pengguna::where('role_id', 2)->count();
        $totalAnggota = Pengguna::where('role_id', 3)->count();
        $totalPinjaman = Transaksi::where('status', true)->count();// total transaksi aktif
        $totalDenda = Transaksi::sum('denda'); // total denda keseluruhan
        
        // Kirim semua data ke view laporan
        return view('laporan.peminjaman', compact(
            'transaksis',
            'totalBuku',
            'totalPetugas',
            'totalAnggota',
            'totalPinjaman',
            'totalDenda'
        ));
    }
}