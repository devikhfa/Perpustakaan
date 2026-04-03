<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function datapeminjaman()
    {
        $transaksi = Transaksi::join('penggunas', 'transaksis.peminjam_id', '=', 'penggunas.id')
            ->join('bukus', 'transaksis.buku_id', '=', 'bukus.id')
            ->where('transaksis.status', true)
            ->select('transaksis.*', 'penggunas.nama_pengguna', 'bukus.judul')
            ->get();

        return view('transaksi.datapeminjaman', compact('transaksi'));
    }
    public function riwayatpeminjaman()
    {
        $transaksi = Transaksi::join('penggunas', 'transaksis.peminjam_id', '=', 'penggunas.id')
            ->join('bukus', 'transaksis.buku_id', '=', 'bukus.id')
            ->where('transaksis.status', true)
            ->where('transaksis.peminjam_id', 1)
            ->select('transaksis.*', 'penggunas.nama_pengguna', 'bukus.judul')
            ->get();
        return view('transaksi.riwayatpeminjaman', compact('transaksi'));
    }
    public function detailtransaksi(string $id)
    {
        $transaksi = Transaksi::join('penggunas', 'transaksis.peminjam_id', '=', 'penggunas.id')
            ->join('bukus', 'transaksis.buku_id', '=', 'bukus.id')
            ->join('kategoris', 'bukus.kategori_id', '=', 'kategoris.id')
            ->where('transaksis.id', $id)
            ->select('transaksis.*', 'penggunas.nama_pengguna', 'penggunas.email', 'penggunas.alamat', 'bukus.judul', 'bukus.penulis', 'bukus.penerbit', 'bukus.tahun_terbit', 'kategoris.nama_kategori')
            ->firstOrFail();

        return view('transaksi.detailtransaksi', compact('transaksi'));
    }
}
