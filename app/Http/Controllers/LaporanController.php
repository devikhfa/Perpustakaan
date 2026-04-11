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
    public function peminjaman()
    {
        // Ambil data transaksi dengan status dipinjam (status = 1 atau true)
        $transaksis = Transaksi::join('penggunas', 'transaksis.peminjam_id', '=', 'penggunas.id')
            ->join('bukus', 'transaksis.buku_id', '=', 'bukus.id')
            ->where('transaksis.status', true)

            // ambil data yang diperlukan saja
            ->select(
                'transaksis.*', 
                'penggunas.nama_pengguna', 
                'penggunas.email',
                'penggunas.alamat',
                'bukus.judul'
            )

            // urutkan dari data terbaru
            ->orderBy('transaksis.created_at', 'desc')
            ->get();
        
        // Statistik untuk ditampilkan di laporan/dashboard
        $totalBuku = Buku::count(); // total semua buku
        $totalAnggota = Pengguna::count(); // total user/anggota
        $totalPinjaman = Transaksi::where('status', true)->count(); // total transaksi aktif
        $totalDenda = Transaksi::sum('denda'); // total denda keseluruhan
        
        // Kirim semua data ke view laporan
        return view('laporan.peminjaman', compact(
            'transaksis',
            'totalBuku',
            'totalAnggota',
            'totalPinjaman',
            'totalDenda'
        ));
    }
}