<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeminjamanDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'peminjaman_id',
        'buku_id',
        'status',
        'tanggal_kembali_actual',
        'denda',
    ];

    protected $casts = [
        'tanggal_kembali_actual' => 'date',
    ];

    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class);
    }

    public function buku()
    {
        return $this->belongsTo(Buku::class);
    }

    // Helper method untuk hitung denda
    public function hitungDenda($hargaPerHari = 1000)
    {
        if ($this->status !== 'dikembalikan' || !$this->tanggal_kembali_actual) {
            return 0;
        }

        $tanggalRencana = $this->peminjaman->tanggal_kembali_rencana;
        $tanggalActual = $this->tanggal_kembali_actual;

        if ($tanggalActual->gt($tanggalRencana)) {
            $hariTerlambat = $tanggalActual->diffInDays($tanggalRencana);
            return $hariTerlambat * $hargaPerHari;
        }

        return 0;
    }
}