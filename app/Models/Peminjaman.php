<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjamen';

    protected $fillable = [
        'anggota_id',
        'tanggal_pinjam',
        'tanggal_kembali_rencana',
    ];

    protected $casts = [
        'tanggal_pinjam' => 'date',
        'tanggal_kembali_rencana' => 'date',
    ];

    public function anggota()
    {
        return $this->belongsTo(Anggota::class);
    }

    public function details()
    {
        return $this->hasMany(PeminjamanDetail::class);
    }

    // Helper method untuk cek semua buku sudah dikembalikan
    public function isAllReturned()
    {
        return $this->details()->where('status', '!=', 'dikembalikan')->count() === 0;
    }
}