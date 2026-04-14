<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\PeminjamanDetail;
use App\Models\Anggota;
use Illuminate\Support\Facades\Auth;

class AnggotaDashboardController extends Controller
{
    /**
     * Dashboard utama Anggota
     * Menampilkan ringkasan peminjaman dan pengembalian
     */
    public function index()
    {
        $user = Auth::user();
        $anggota = Anggota::where('user_id', $user->id)->first();

        if (!$anggota) {
            return redirect()->route('dashboard')->with('error', 'Anda belum terdaftar sebagai anggota perpustakaan!');
        }

        // Hitung statistik
        // Hitung statistik - HANYA yang statusnya 'dipinjam'
$peminjamanAktif = PeminjamanDetail::whereHas('peminjaman', function($query) use ($anggota) {
    $query->where('anggota_id', $anggota->id);
})->where('status', 'dipinjam')->count(); // <--- Hapus 'terlambat' dari array whereIn

        $menungguPersetujuan = PeminjamanDetail::whereHas('peminjaman', function($query) use ($anggota) {
            $query->where('anggota_id', $anggota->id);
        })->where('status', 'menunggu')->count();

        $totalDenda = PeminjamanDetail::whereHas('peminjaman', function($query) use ($anggota) {
            $query->where('anggota_id', $anggota->id);
        })->sum('denda');

        $historiPeminjaman = Peminjaman::with(['details.buku'])
            ->where('anggota_id', $anggota->id)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('user.dashboard', compact(
            'peminjamanAktif',
            'menungguPersetujuan',
            'totalDenda',
            'historiPeminjaman'
        ));
    }

    /**
     * Halaman peminjaman aktif
     * Menampilkan buku yang sedang dipinjam dan menunggu persetujuan
     */
    /**
 * Halaman peminjaman aktif
 * SEKARANG: Hanya menampilkan yang benar-benar aktif (dipinjam & menunggu)
 */
public function peminjamanAktif()
{
    $user = Auth::user();
    $anggota = Anggota::where('user_id', $user->id)->first();

    if (!$anggota) {
        return redirect()->back()->with('error', 'Anda belum terdaftar!');
    }

    // Hanya ambil yang statusnya 'dipinjam' (yang belum lewat jatuh tempo/sedang dibawa)
    $peminjamanDipinjam = Peminjaman::with(['details.buku.kategori'])
        ->where('anggota_id', $anggota->id)
        ->whereHas('details', function($query) {
            $query->where('status', 'dipinjam');
        })
        ->orderBy('created_at', 'desc')
        ->get();

    // Ambil yang masih menunggu persetujuan admin
    $peminjamanMenunggu = Peminjaman::with(['details.buku.kategori'])
        ->where('anggota_id', $anggota->id)
        ->whereHas('details', function($query) {
            $query->where('status', 'menunggu');
        })
        ->orderBy('created_at', 'desc')
        ->get();

    // Variabel peminjamanTerlambat dikosongkan atau dihapus agar tidak tampil di view Aktif
    $peminjamanTerlambat = collect(); 

    return view('user.peminjaman.aktif', compact(
        'peminjamanDipinjam',
        'peminjamanTerlambat',
        'peminjamanMenunggu'
    ));
}

/**
 * Halaman pengembalian (Riwayat)
 * SEKARANG: Menampilkan dikembalikan, ditolak, DAN terlambat
 */
public function pengembalian()
{
    $user = Auth::user();
    $anggota = Anggota::where('user_id', $user->id)->first();

    $peminjamanSelesai = Peminjaman::with(['details.buku.kategori'])
        ->where('anggota_id', $anggota->id)
        ->whereHas('details', function($query) {
            // Tambahkan status 'terlambat' di sini agar masuk ke riwayat
            $query->whereIn('status', ['dikembalikan', 'ditolak', 'terlambat']);
        })
        ->orderBy('created_at', 'desc')
        ->paginate(10);

    return view('user.peminjaman.pengembalian', compact('peminjamanSelesai'));
}
    /**
     * Detail peminjaman dengan kemampuan kembalikan buku
     */
    public function detailPeminjaman($id)
    {
        $user = Auth::user();
        $anggota = Anggota::where('user_id', $user->id)->first();

        $peminjaman = Peminjaman::with(['anggota.user', 'details.buku.kategori'])
            ->where('anggota_id', $anggota->id)
            ->findOrFail($id);

        return view('user.peminjaman.detail', compact('peminjaman'));
    }
}