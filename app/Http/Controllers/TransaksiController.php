<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Buku;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class TransaksiController extends Controller
{
    /**
     * Menampilkan semua data peminjaman (admin)
     */
    public function datapeminjaman()
    {
        // Ambil semua transaksi yang masih aktif
        $transaksi = Transaksi::join('penggunas', 'transaksis.peminjam_id', '=', 'penggunas.id')
            ->join('bukus', 'transaksis.buku_id', '=', 'bukus.id')
            ->where('transaksis.status', true)
            ->select('transaksis.*', 'penggunas.nama_pengguna', 'bukus.judul')
            ->get();

        return view('transaksi.datapeminjaman', compact('transaksi'));
    }

    /**
     * Menampilkan riwayat peminjaman user login
     */
    public function riwayatpeminjaman()
    {
        // Ambil transaksi berdasarkan user yang login
        $transaksi = Transaksi::join('penggunas', 'transaksis.peminjam_id', '=', 'penggunas.id')
            ->join('bukus', 'transaksis.buku_id', '=', 'bukus.id')
            ->where('transaksis.status', true)
            ->where('transaksis.peminjam_id', Session::get('user_id'))
            ->select('transaksis.*', 'penggunas.nama_pengguna', 'bukus.judul')
            ->get();

        return view('transaksi.riwayatpeminjaman', compact('transaksi'));
    }

    /**
     * Detail transaksi peminjaman
     */
    public function detailtransaksi(string $id)
    {
        // Ambil detail transaksi + relasi user, buku, kategori
        $transaksi = Transaksi::join('penggunas', 'transaksis.peminjam_id', '=', 'penggunas.id')
            ->join('bukus', 'transaksis.buku_id', '=', 'bukus.id')
            ->join('kategoris', 'bukus.kategori_id', '=', 'kategoris.id')
            ->where('transaksis.id', $id)
            ->select(
                'transaksis.*',
                'penggunas.nama_pengguna',
                'penggunas.email',
                'penggunas.alamat',
                'bukus.judul',
                'bukus.penulis',
                'bukus.penerbit',
                'bukus.tahun_terbit',
                'kategoris.nama_kategori'
            )
            ->firstOrFail();

        return view('transaksi.detailtransaksi', compact('transaksi'));
    }

    /**
     * Proses pengembalian buku oleh user
     */
    public function kembalikan(string $id)
    {
        try {
            DB::beginTransaction();

            // ambil data transaksi
            $transaksi = Transaksi::findOrFail($id);

            // cek jika sudah dikembalikan / sedang proses
            if ($transaksi->status_transaksi == 2 || $transaksi->status_transaksi == 3) {
                return response()->json([
                    'success' => false,
                    'message' => 'Buku sudah dalam proses pengembalian atau sudah dikembalikan'
                ], 400);
            }

            // cek apakah terlambat
            $isTerlambat = now() > $transaksi->tgl_jatuh_tempo;
            $denda = 0;

            // hitung denda jika terlambat
            if ($isTerlambat) {
                $hariTerlambat = now()->startOfDay()
                    ->diffInDays($transaksi->tgl_jatuh_tempo->startOfDay());

                $denda = abs($hariTerlambat) * 2000; // denda per hari
            }

            // update status pengembalian
            $transaksi->status_transaksi = 2; // proses pengembalian
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

    /**
     * Verifikasi pengembalian buku oleh admin
     */
    public function verifikasiKembali(string $id)
    {
        try {
            DB::beginTransaction();

            $transaksi = Transaksi::findOrFail($id);

            // cek jika sudah diverifikasi
            if ($transaksi->status_transaksi == 3) {
                return response()->json([
                    'success' => false,
                    'message' => 'Buku sudah diverifikasi sebelumnya'
                ], 400);
            }

            // cek harus sudah proses pengembalian
            if ($transaksi->status_transaksi != 2) {
                return response()->json([
                    'success' => false,
                    'message' => 'Buku belum dalam proses pengembalian'
                ], 400);
            }

            // ubah status jadi selesai
            $transaksi->status_transaksi = 3;
            $transaksi->updated_by = 1;
            $transaksi->updated_at = now();
            $transaksi->save();

            // tambah stok buku kembali
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

    /**
     * Hapus data transaksi
     */
    public function destroy($id)
    {
        $transaksi = Transaksi::find($id);

        // cek apakah data ada
        if (!$transaksi) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ]);
        }

        // hapus permanen
        $transaksi->delete();

        return response()->json([
            'success' => true,
            'message' => 'Transaksi berhasil dihapus'
        ]);
    }
}