<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Anggota extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nis',
        'kelas',
        'no_tlp',
        'jenis_kelamin'
    ];

public function user(): BelongsTo
{
    return $this->belongsTo(User::class, 'user_id');
}

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class);
    }
}