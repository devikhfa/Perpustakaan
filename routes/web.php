<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KatalogController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LaporanController;

route::get("/buku/create", [BukuController::class, 'create'])->name('buku.create');
route::post("/buku/store", [BukuController::class, 'store'])->name('buku.store');
route::get('/buku/edit/{id}', [BukuController::class, 'edit'])->name('buku.edit');
route::put('/buku/update/{id}', [BukuController::class, 'update'])->name('buku.update');
Route::delete('/buku/{id}', [BukuController::class, 'destroy'])->name('buku.destroy');
Route::get('/buku/show/{id}', [BukuController::class, 'show'])->name('buku.show');

route::get("/kategori/create", [KategoriController::class, 'create'])->name('kategori.create');
route::post("/kategori/store", [KategoriController::class, 'store'])->name('kategori.store');
route::get('/kategori/edit/{id}', [KategoriController::class, 'edit'])->name('kategori.edit');
route::put('/kategori/update/{id}', [KategoriController::class, 'update'])->name('kategori.update');
Route::delete('/kategori/{id}', [KategoriController::class, 'destroy'])->name('kategori.destroy');

route::get("/pengguna/create", [PenggunaController::class, 'create'])->name('pengguna.create');
route::post("/pengguna/store", [PenggunaController::class, 'store'])->name('pengguna.store');
route::get('/pengguna/edit/{id}', [PenggunaController::class, 'edit'])->name('pengguna.edit');
route::put('/pengguna/update/{id}', [PenggunaController::class, 'update'])->name('pengguna.update');
Route::delete('/pengguna/{id}', [PenggunaController::class, 'destroy'])->name('pengguna.destroy');
route::get('/pengguna/detail/{id}', [PenggunaController::class, 'show'])->name('pengguna.detail');
Route::get('/profile', [PenggunaController::class, 'profile'])->name('pengguna.profile');
Route::post('/profile/update', [PenggunaController::class, 'updateProfile'])->name('pengguna.profile.update');

route::get("/katalog/detail/{id}", [KatalogController::class, 'detail'])->name('katalog.detail');
route::get("/katalog/pinjam/{id}", [KatalogController::class, 'pinjam'])->name('katalog.pinjam');
route::post("/katalog/store", [KatalogController::class, 'store'])->name('katalog.store');

route::get("/riwayat-peminjaman", [TransaksiController::class, 'riwayatpeminjaman'])->name('transaksi.riwayatpeminjaman');
route::get("/detail-transaksi/{id}", [TransaksiController::class, 'detailtransaksi'])->name('transaksi.detailtransaksi');
Route::put('/kembalikan/{id}', [TransaksiController::class, 'kembalikan'])->name('transaksi.kembalikan');
Route::put('/verifikasi-kembali/{id}', [TransaksiController::class, 'verifikasiKembali'])->name('transaksi.verifikasi');
Route::delete('/transaksi/{id}', [TransaksiController::class, 'destroy'])->name('transaksi.destroy');

Route::get('/login', [AuthController::class, 'masuk'])->name('login');
Route::get('/register', [AuthController::class, 'daftar'])->name('register');
Route::post('/login-proses', [AuthController::class, 'login'])->name('login.proses');
Route::post('/register-proses', [AuthController::class, 'register'])->name('register.proses');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth.session'])->group(function () {
    route::get("/buku", [BukuController::class, 'index'])->name('buku.index');
    route::get("/kategori", [KategoriController::class, 'index'])->name('kategori.index');
    route::get("/pengguna", [PenggunaController::class, 'index'])->name('pengguna.index');
    route::get("/katalog", [KatalogController::class, 'index'])->name('katalog.index');
    route::get("/data-peminjaman", [TransaksiController::class, 'datapeminjaman'])->name('transaksi.datapeminjaman');
    route::get("/laporan/peminjaman", [LaporanController::class, 'peminjaman'])->name('laporan.peminjaman');
});