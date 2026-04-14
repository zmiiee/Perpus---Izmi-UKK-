<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\PeminjamanDetail;
use App\Models\Anggota;
use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class UserPeminjamanController extends Controller
{
    /**
     * Form peminjaman buku
     */
   public function create()
{
    $user = Auth::user();
    $anggota = Anggota::where('user_id', $user->id)->first();

    if (!$anggota) {
        return redirect()->back()->with('error', 'Anda belum terdaftar!');
    }

    // Hanya anggap buku "Menunggu" atau "Dipinjam" (yang masih di tangan user) sebagai status "Sedang Dipinjam"
    $bukuSedangDipinjam = PeminjamanDetail::whereHas('peminjaman', function($query) use ($anggota) {
            $query->where('anggota_id', $anggota->id);
        })
        ->whereIn('status', ['dipinjam', 'menunggu']) // 'terlambat' sudah tidak ada di sini
        ->pluck('buku_id')
        ->toArray();

    $buku = Buku::with('kategori')->where('stok', '>', 0)->get();

    return view('user.peminjaman.create', compact('buku', 'bukuSedangDipinjam'));
}
    /**
     * Simpan peminjaman baru
     */
    public function store(Request $request)
{
    $user = Auth::user();
    $anggota = Anggota::where('user_id', $user->id)->first();

    // 1. Hitung jumlah buku yang SAAT INI sedang dipinjam (status dipinjam atau menunggu)
    $jumlahBukuAktif = PeminjamanDetail::whereHas('peminjaman', function($query) use ($anggota) {
            $query->where('anggota_id', $anggota->id);
        })
        ->whereIn('status', ['dipinjam', 'menunggu'])
        ->count();

    $maksimalPinjam = 3;
    $sisaKuota = $maksimalPinjam - $jumlahBukuAktif;

    // 2. Validasi input dasar
    $request->validate([
        'tanggal_pinjam' => 'required|date',
        'tanggal_kembali_rencana' => 'required|date|after:tanggal_pinjam',
        'buku_ids' => "required|array|min:1|max:$sisaKuota", // Max dinamis sesuai sisa kuota
        'buku_ids.*' => 'exists:bukus,id',
    ], [
        'buku_ids.max' => "Anda sudah meminjam $jumlahBukuAktif buku. Sisa kuota peminjaman Anda adalah $sisaKuota buku.",
        'buku_ids.required' => 'Pilih minimal 1 buku untuk dipinjam',
    ]);

    // 3. Cek apakah user mencoba meminjam buku yang SAMA dengan yang sedang dipinjam
    $bukuSedangDipinjam = PeminjamanDetail::whereHas('peminjaman', function($query) use ($anggota) {
            $query->where('anggota_id', $anggota->id);
        })
        ->whereIn('status', ['dipinjam', 'menunggu'])
        ->pluck('buku_id')
        ->toArray();

    foreach ($request->buku_ids as $idTerpilih) {
        if (in_array($idTerpilih, $bukuSedangDipinjam)) {
            $bukuSama = Buku::find($idTerpilih);
            return redirect()->back()->with('error', 'Buku "' . $bukuSama->judul . '" masih dalam status peminjaman Anda.');
        }
    }

    // 4. Cek stok buku (Logic tetap sama)
    foreach ($request->buku_ids as $bukuId) {
        $buku = Buku::find($bukuId);
        if ($buku->stok <= 0) {
            return redirect()->back()->with('error', 'Buku ' . $buku->judul . ' tidak tersedia!');
        }
    }

    // 5. Proses Simpan (Logic tetap sama)
    DB::beginTransaction();
    try {
        $peminjaman = Peminjaman::create([
            'anggota_id' => $anggota->id,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'tanggal_kembali_rencana' => $request->tanggal_kembali_rencana,
        ]);

        foreach ($request->buku_ids as $bukuId) {
            PeminjamanDetail::create([
                'peminjaman_id' => $peminjaman->id,
                'buku_id' => $bukuId,
                'status' => 'menunggu',
            ]);
        }

        DB::commit();
        return redirect()->route('user.peminjaman.aktif')
            ->with('success', 'Pengajuan peminjaman berhasil!');
    } catch (\Exception $e) {
        DB::rollback();
        return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
    }
}

    /**
     * Kembalikan buku
     */
    public function kembalikanBuku(Request $request, $detailId)
    {
        $request->validate([
            'tanggal_kembali_actual' => 'required|date',
        ], [
            'tanggal_kembali_actual.required' => 'Tanggal pengembalian harus diisi',
        ]);

        $detail = PeminjamanDetail::findOrFail($detailId);
        
        // Pastikan buku ini milik user yang login
        $user = Auth::user();
        $anggota = Anggota::where('user_id', $user->id)->first();
        
        if ($detail->peminjaman->anggota_id != $anggota->id) {
            return back()->with('error', 'Buku ini bukan milik Anda!');
        }

        // Pastikan buku masih dipinjam
        if ($detail->status != 'dipinjam' && $detail->status != 'terlambat') {
            return back()->with('error', 'Buku ini sudah dikembalikan!');
        }
        
        // Hitung denda
        $denda = 0;
        $tanggalRencana = $detail->peminjaman->tanggal_kembali_rencana;
        $tanggalActual = \Carbon\Carbon::parse($request->tanggal_kembali_actual);

        // Cek apakah terlambat
        if ($tanggalActual->greaterThan($tanggalRencana)) {
            $hariTerlambat = $tanggalRencana->diffInDays($tanggalActual);
            $denda = $hariTerlambat * 1000; // Rp 1000 per hari
            $status = 'terlambat';
        } else {
            $status = 'dikembalikan';
        }

        DB::beginTransaction();
        try {
            $detail->update([
                'status' => $status,
                'tanggal_kembali_actual' => $request->tanggal_kembali_actual,
                'denda' => $denda,
            ]);

            // Increment stok buku
            $buku = Buku::find($detail->buku_id);
            $buku->increment('stok', 1);

            DB::commit();

            $pesan = 'Buku berhasil dikembalikan!';
            if ($denda > 0) {
                $pesan .= ' Denda: Rp ' . number_format($denda, 0, ',', '.');
            }

            return back()->with('success', $pesan);
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Legacy: untuk kompatibilitas
     */
    public function index()
    {
        return redirect()->route('user.peminjaman.aktif');
    }

    public function show($id)
    {
        return redirect()->route('user.peminjaman.detail', $id);
    }
}