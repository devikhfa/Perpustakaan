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
        'denda',
        'catatan',
        'status_transaksi',
        'status',
        'created_by',
        'updated_by'
    ];
    
    protected $casts = [
        'tgl_pinjam' => 'datetime',
        'tgl_jatuh_tempo' => 'datetime',
        'tgl_dikembalikan' => 'datetime',
        'denda' => 'integer',
    ];
    
    const STATUS_DIPINJAM = 1;
    const STATUS_MENUNGGU_VERIFIKASI = 2;
    const STATUS_SELESAI = 3;

    public function getStatusTextAttribute()
    {
        return match($this->status_transaksi) {
            self::STATUS_DIPINJAM => 'Dipinjam',
            self::STATUS_MENUNGGU_VERIFIKASI => 'Menunggu Verifikasi',
            self::STATUS_SELESAI => 'Selesai',
            default => 'Unknown'
        };
    }

    public function getStatusBadgeAttribute()
    {
        return match($this->status_transaksi) {
            self::STATUS_DIPINJAM => '<span class="badge badge-primary">Dipinjam</span>',
            self::STATUS_MENUNGGU_VERIFIKASI => '<span class="badge badge-warning">Menunggu Verifikasi</span>',
            self::STATUS_SELESAI => '<span class="badge badge-success">Selesai</span>',
            default => '<span class="badge badge-secondary">Unknown</span>'
        };
    }
    
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