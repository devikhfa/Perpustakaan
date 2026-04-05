<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KatalogController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LaporanController;

route::get("/buku", [BukuController::class, 'index'])->name('buku.index');
route::get("/buku/create", [BukuController::class, 'create'])->name('buku.create');
route::post("/buku/store", [BukuController::class, 'store'])->name('buku.store');
route::get('/buku/edit/{id}', [BukuController::class, 'edit'])->name('buku.edit');
route::put('/buku/update/{id}', [BukuController::class, 'update'])->name('buku.update');
Route::delete('/buku/{id}', [BukuController::class, 'destroy'])->name('buku.destroy');
Route::get('/buku/show/{id}', [BukuController::class, 'show'])->name('buku.show');


route::get("/kategori", [KategoriController::class, 'index'])->name('kategori.index');
route::get("/kategori/create", [KategoriController::class, 'create'])->name('kategori.create');
route::post("/kategori/store", [KategoriController::class, 'store'])->name('kategori.store');
route::get('/kategori/edit/{id}', [KategoriController::class, 'edit'])->name('kategori.edit');
route::put('/kategori/update/{id}', [KategoriController::class, 'update'])->name('kategori.update');
Route::delete('/kategori/{id}', [KategoriController::class, 'destroy'])->name('kategori.destroy');


route::get("/pengguna", [PenggunaController::class, 'index'])->name('pengguna.index');
route::get("/pengguna/create", [PenggunaController::class, 'create'])->name('pengguna.create');
route::post("/pengguna/store", [PenggunaController::class, 'store'])->name('pengguna.store');
route::get('/pengguna/edit/{id}', [PenggunaController::class, 'edit'])->name('pengguna.edit');
route::put('/pengguna/update/{id}', [PenggunaController::class, 'update'])->name('pengguna.update');
Route::delete('/katepenggunagori/{id}', [PenggunaController::class, 'destroy'])->name('pengguna.destroy');
route::get('/pengguna/detail/{id}', [PenggunaController::class, 'show'])->name('pengguna.detail');

route::get("/katalog", [KatalogController::class, 'index'])->name('katalog.index');
route::get("/katalog/detail/{id}", [KatalogController::class, 'detail'])->name('katalog.detail');
route::get("/katalog/pinjam/{id}", [KatalogController::class, 'pinjam'])->name('katalog.pinjam');
route::post("/katalog/store", [KatalogController::class, 'store'])->name('katalog.store');

route::get("/data-peminjaman", [TransaksiController::class, 'datapeminjaman'])->name('transaksi.datapeminjaman');
route::get("/riwayat-peminjaman", [TransaksiController::class, 'riwayatpeminjaman'])->name('transaksi.riwayatpeminjaman');
route::get("/detail-transaksi/{id}", [TransaksiController::class, 'detailtransaksi'])->name('transaksi.detailtransaksi');
Route::put('/kembalikan/{id}', [TransaksiController::class, 'kembalikan'])->name('transaksi.kembalikan');
Route::put('/verifikasi-kembali/{id}', [TransaksiController::class, 'verifikasiKembali'])->name('transaksi.verifikasi');

route::get("/laporan/peminjaman", [LaporanController::class, 'peminjaman'])->name('laporan.peminjaman');

Route::get('/masuk', function () {
    return view('auth.masuk');
})->name('masuk');

Route::post('/masuk', [AuthController::class, 'auth.masuk']);

Route::get('/daftar', function () {
    return view('auth.daftar');
})->name('daftar');

Route::post('/daftar', [AuthController::class, 'auth.daftar']);

Route::get('/pinjam', function () {
    return view('buku.pinjam');
})->name('buku.pinjam');