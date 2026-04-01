<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class KatalogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $buku = Buku::join('kategoris', 'bukus.kategori_id', '=', 'kategoris.id')
            ->where('bukus.status', true)
            ->where('bukus.qty', '>', 0)
            ->select('bukus.*', 'kategoris.nama_kategori as kategori')
            ->get();

        return view('katalog.index', compact('buku'));
    }

    public function detail(string $id)
    {
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
        $buku = Buku::join('kategoris', 'bukus.kategori_id', '=', 'kategoris.id')
            ->where('bukus.id', $id)
            ->select('bukus.*', 'kategoris.nama_kategori as kategori')
            ->firstOrFail();

        return view('katalog.pinjam', compact('buku'));
    }

}
