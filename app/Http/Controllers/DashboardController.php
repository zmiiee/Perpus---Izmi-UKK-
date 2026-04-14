<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\PeminjamanDetail;
use App\Models\User; 

class DashboardController extends Controller
{
    public function index()
{
    $totalBuku = Buku::count();
    $totalAnggota = User::where('role', 'Anggota')->count();
    $totalDipinjam = PeminjamanDetail::where('status', 'dipinjam')->count();

    $statusDipinjam    = PeminjamanDetail::where('status', 'dipinjam')->count();
    $statusDikembalikan = PeminjamanDetail::where('status', 'dikembalikan')->count();
    $statusTerlambat   = PeminjamanDetail::where('status', 'terlambat')->count();

    return view('dashboard', compact(
        'totalBuku', 'totalAnggota', 'totalDipinjam',
        'statusDipinjam', 'statusDikembalikan', 'statusTerlambat'
    ));
}
}