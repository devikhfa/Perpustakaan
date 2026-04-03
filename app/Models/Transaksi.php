<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'peminjam_id',
        'buku_id',
        'tgl_pinjam',
        'tgl_jatuh_tempo',
        'tgl_dikembalikan',
        'catatan',
        'status_transaksi',
        'status',
        'created_by',
        'updated_by'
    ];
    
    protected $casts = [
        'tgl_pinjam' => 'date',
        'tgl_jatuh_tempo' => 'date',
        'tgl_dikembalikan' => 'date',
    ];
    
    public function peminjam()
    {
        return $this->belongsTo(Pengguna::class, 'peminjam_id', 'id');
    }
    
    public function buku()
    {
        return $this->belongsTo(Buku::class, 'buku_id', 'id');
    }
    
    public function createdBy()
    {
        return $this->belongsTo(Pengguna::class, 'created_by', 'id');
    }
    
    public function updatedBy()
    {
        return $this->belongsTo(Pengguna::class, 'updated_by', 'id');
    }
}