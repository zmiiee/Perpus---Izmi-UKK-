<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\PeminjamanDetail;
use App\Models\Anggota;
use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PeminjamanController extends Controller
{
    public function index(Request $request)
{
    $search = $request->search;
    $peminjaman = Peminjaman::with(['anggota.user', 'details.buku'])
        ->whereHas('details', function($query) {
            $query->whereIn('status', ['menunggu', 'dipinjam']);
        })
        ->when($search, function ($query) use ($search) {
            $query->whereHas('anggota.user', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        })
        ->orderBy('created_at', 'desc')
        ->paginate(10);

    return view('peminjaman.index', compact('peminjaman'));
}

    public function create()
    {
        $anggota = Anggota::with('user')->get();
        $buku = Buku::with('kategori')->get();

        return view('peminjaman.create', compact('anggota', 'buku'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'anggota_id' => 'required|exists:anggotas,id',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali_rencana' => 'required|date|after:tanggal_pinjam',
            'buku_ids' => 'required|array|min:1',
            'buku_ids.*' => 'exists:bukus,id',
        ]);

        DB::beginTransaction();
        try {
            // Buat peminjaman utama
            $peminjaman = Peminjaman::create([
                'anggota_id' => $request->anggota_id,
                'tanggal_pinjam' => $request->tanggal_pinjam,
                'tanggal_kembali_rencana' => $request->tanggal_kembali_rencana,
            ]);

            // Buat detail untuk setiap buku
            foreach ($request->buku_ids as $bukuId) {

    $buku = Buku::find($bukuId);

    // ❗ VALIDASI STOK
    if ($buku->stok <= 0) {
        throw new \Exception('Stok buku habis!');
    }

    // 🔥 KURANGI STOK
    $buku->decrement('stok', 1);

    // simpan detail
    PeminjamanDetail::create([
        'peminjaman_id' => $peminjaman->id,
        'buku_id' => $bukuId,
        'status' => 'dipinjam'
    ]);
}

            DB::commit();
            return redirect()->route('peminjaman.index')
                ->with('success', 'Peminjaman berhasil ditambahkan!');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $peminjaman = Peminjaman::with(['anggota.user', 'details.buku.kategori'])
            ->findOrFail($id);

        return view('peminjaman.show', compact('peminjaman'));
    }

    public function edit($id)
    {
        $peminjaman = Peminjaman::with('details')->findOrFail($id);
        $anggota = Anggota::with('user')->get();
        $buku = Buku::with('kategori')->get();

        return view('peminjaman.edit', compact('peminjaman', 'anggota', 'buku'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'anggota_id' => 'required|exists:anggotas,id',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali_rencana' => 'required|date|after:tanggal_pinjam',
        ]);

        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->update($request->only([
            'anggota_id',
            'tanggal_pinjam',
            'tanggal_kembali_rencana',
        ]));

        return redirect()->route('peminjaman.index')
            ->with('success', 'Peminjaman berhasil diupdate!');
    }

    public function approveBuku(Request $request, $detailId)
{
    DB::beginTransaction();
    try {
        $detail = PeminjamanDetail::findOrFail($detailId);

        if ($detail->status !== 'menunggu') {
            return back()->with('error', 'Status sudah diproses!');
        }

        $buku = Buku::find($detail->buku_id);

        // ❗ cek stok dulu
        if ($buku->stok <= 0) {
            return back()->with('error', 'Stok buku habis!');
        }

        // update status
        $detail->update([
            'status' => 'dipinjam'
        ]);

        // 🔥 KURANGI STOK
        $buku->decrement('stok', 1);

        DB::commit();
        return back()->with('success', 'Peminjaman disetujui!');
    } catch (\Exception $e) {
        DB::rollback();
        return back()->with('error', $e->getMessage());
    }
}

public function tolakBuku(Request $request, $detailId)
{
    $detail = PeminjamanDetail::findOrFail($detailId);

    if ($detail->status !== 'menunggu') {
        return back()->with('error', 'Status pengajuan ini sudah diproses!');
    }

    $detail->update(['status' => 'ditolak']);

    return back()->with('success', 'Pengajuan peminjaman berhasil ditolak!');
}

    public function kembalikanBuku(Request $request, $detailId)
{
    $request->validate([
        'tanggal_kembali_actual' => 'required|date',
    ]);

    $detail = PeminjamanDetail::findOrFail($detailId);

    // 🔥 VALIDASI STATUS
    if ($detail->status !== 'dipinjam') {
        return back()->with('error', 'Buku ini sudah dikembalikan atau tidak valid!');
    }

    $tanggalRencana = $detail->peminjaman->tanggal_kembali_rencana;
    $tanggalActual = \Carbon\Carbon::parse($request->tanggal_kembali_actual);

    $denda = 0;

    if ($tanggalActual->greaterThan($tanggalRencana)) {
        $hariTerlambat = $tanggalRencana->diffInDays($tanggalActual);
        $denda = $hariTerlambat * 1000;
        $status = 'terlambat';
    } else {
        $status = 'dikembalikan';
    }

    // update detail
    $detail->update([
        'status' => $status,
        'tanggal_kembali_actual' => $request->tanggal_kembali_actual,
        'denda' => $denda,
    ]);

    // 🔥 TAMBAH STOK (PASTI KEJALAN SEKALI)
    $buku = Buku::find($detail->buku_id);
    $buku->increment('stok', 1);

    return back()->with('success', 
        'Buku berhasil dikembalikan!' . 
        ($denda > 0 ? ' Denda: Rp ' . number_format($denda, 0, ',', '.') : '')
    );
}

    public function destroy($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->delete();

        return redirect()->route('peminjaman.index')
            ->with('success', 'Peminjaman berhasil dihapus!');
    }

    public function pengembalian(Request $request)
{
    $search = $request->search;
    $pengembalian = PeminjamanDetail::with(['peminjaman.anggota.user', 'buku'])
        ->whereIn('status', ['dikembalikan', 'terlambat'])
        ->when($search, function ($query) use ($search) {
            $query->whereHas('buku', function($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%");
            })->orWhereHas('peminjaman.anggota.user', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        })
        ->orderBy('updated_at', 'desc')
        ->paginate(10);

    return view('pengembalian.index', compact('pengembalian'));
}

    public function showPengembalian($id)
    {
        $detail = PeminjamanDetail::with(['peminjaman.anggota.user', 'buku.kategori'])
            ->findOrFail($id);

        return view('pengembalian.show', compact('detail'));
    }
 
    public function reset()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::table('peminjaman_details')->truncate();
        DB::table('peminjamen')->truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        return back()->with('success', 'Semua data peminjaman berhasil direset!');
    }
}