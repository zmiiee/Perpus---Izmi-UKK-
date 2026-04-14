<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    use HasFactory;

    protected $fillable = [
        'kategori_id',
        'judul',
        'pengarang',
        'tahun_terbit',
        'deskripsi',
        'cover',
        'stok',
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function peminjamanDetails()
    {
        return $this->hasMany(PeminjamanDetail::class);
    }

    // Cek apakah buku sedang dipinjam
    public function isSedangDipinjam()
    {
        return $this->peminjamanDetails()
            ->where('status', 'dipinjam')
            ->exists();
    }
}