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
     * Display a listing of the resource.
     */
    public function peminjaman()
    {
        // Ambil data transaksi dengan status dipinjam (status = 1 atau true)
        $transaksis = Transaksi::join('penggunas', 'transaksis.peminjam_id', '=', 'penggunas.id')
            ->join('bukus', 'transaksis.buku_id', '=', 'bukus.id')
            ->where('transaksis.status', true)
            ->select(
                'transaksis.*', 
                'penggunas.nama_pengguna', 
                'penggunas.email',
                'penggunas.alamat',
                'bukus.judul'
            )
            ->orderBy('transaksis.created_at', 'desc')
            ->get();
        
        // Hitung statistik untuk dashboard
        $totalBuku = Buku::count();
        $totalAnggota = Pengguna::count();
        $totalPinjaman = Transaksi::where('status', true)->count();
        $totalDenda = Transaksi::sum('denda');
        
        return view('laporan.peminjaman', compact('transaksis', 'totalBuku', 'totalAnggota', 'totalPinjaman', 'totalDenda'));
    }
}
