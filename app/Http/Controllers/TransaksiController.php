<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Buku;
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
    
    public function kembalikan(string $id)
    {
        try {
            DB::beginTransaction();
            
            $transaksi = Transaksi::findOrFail($id);
            
            if ($transaksi->status_transaksi == 2 || $transaksi->status_transaksi == 3) {
                return response()->json([
                    'success' => false,
                    'message' => 'Buku sudah dalam proses pengembalian atau sudah dikembalikan'
                ], 400);
            }
            
            $isTerlambat = now() > $transaksi->tgl_jatuh_tempo;
            $denda = 0;
            
            if ($isTerlambat) {
                $hariTerlambat = now()->startOfDay()->diffInDays($transaksi->tgl_jatuh_tempo->startOfDay());
                $denda = abs($hariTerlambat) * 2000;
            }
            
            $transaksi->status_transaksi = 2;
            $transaksi->tgl_dikembalikan = now();
            $transaksi->denda = $denda;
            $transaksi->updated_by = 1;
            $transaksi->updated_at = now();
            $transaksi->save();
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Buku berhasil dikembalikan, menunggu verifikasi',
                'data' => [
                    'denda' => $denda,
                    'tgl_dikembalikan' => $transaksi->tgl_dikembalikan
                ]
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengembalikan buku: ' . $e->getMessage()
            ], 500);
        }
    }

    public function verifikasiKembali(string $id)
    {
        try {
            DB::beginTransaction();
            
            $transaksi = Transaksi::findOrFail($id);
            
            if ($transaksi->status_transaksi == 3) {
                return response()->json([
                    'success' => false,
                    'message' => 'Buku sudah diverifikasi sebelumnya'
                ], 400);
            }
            
            if ($transaksi->status_transaksi != 2) {
                return response()->json([
                    'success' => false,
                    'message' => 'Buku belum dalam proses pengembalian'
                ], 400);
            }
            
            $transaksi->status_transaksi = 3;
            $transaksi->updated_by = 1;
            $transaksi->updated_at = now();
            $transaksi->save();
            
            $buku = Buku::find($transaksi->buku_id);
            $buku->increment('qty');
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Pengembalian buku diverifikasi, stok buku bertambah'
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal verifikasi: ' . $e->getMessage()
            ], 500);
        }
    }
}
