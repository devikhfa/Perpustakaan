<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengguna extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'role_id',
        'nama_pengguna',
        'email',
        'password',
        'alamat',
        'status',
        'created_at',
        'updated_at'
    ];
}
