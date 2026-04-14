@extends('layouts.layout')

@section('content')
<main class="nxl-container">
    <div class="nxl-content">
        <div class="page-header">
            <div class="d-flex align-items-center justify-content-between w-100">
                <div>
                    <h5 class="m-b-10">Riwayat Pengembalian</h5>
                </div>
            </div>
        </div>

        <div class="main-content">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                    <i class="feather-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                    <i class="feather-alert-circle me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($peminjamanSelesai->count() > 0)
                <div class="row">
                    @foreach($peminjamanSelesai as $peminjaman)
                    <div class="col-12 mb-4">
                        <div class="card stretch stretch-full">
                            <div class="card-body">
                                <div class="row">
                                    
                                    <div class="col-md-8 border-end">
                                        <div class="d-flex align-items-center mb-3">
                                            <h5 class="mb-0 flex-grow-1">
                                                Peminjaman {{ $peminjaman->tanggal_pinjam->format('d/m/Y') }}
                                            </h5>
                                        </div>
                                        
                                        <p class="text-muted small mb-3">
                                            <strong>Tanggal Pinjam:</strong> {{ $peminjaman->tanggal_pinjam->format('d/m/Y') }} | 
                                            <strong>Rencana Kembali:</strong> {{ $peminjaman->tanggal_kembali_rencana->format('d/m/Y') }}
                                        </p>

                                        <div class="mt-3">
                                            @php
                                                $selesaiDetails = $peminjaman->details->whereIn('status', ['dikembalikan', 'ditolak', 'terlambat']);
                                            @endphp

                                            @foreach($selesaiDetails as $detail)
                                            <div class="mb-3 p-3 bg-light rounded">
                                                <div class="row align-items-center">
                                                    <div class="col-auto">
                                                        @if($detail->status == 'dikembalikan')
                                                            <span class="badge bg-soft-success text-success">Dikembalikan</span>
                                                        @elseif($detail->status == 'terlambat')
                                                            <span class="badge bg-soft-danger text-danger">Terlambat</span>
                                                        @else
                                                            <span class="badge bg-soft-secondary text-secondary">Ditolak</span>
                                                        @endif
                                                    </div>

                                                    <div class="col flex-grow-1">
                                                        <strong>{{ $detail->buku->judul }}</strong><br>
                                                        <small class="text-muted">{{ $detail->buku->pengarang }}</small>
                                                    </div>

                                                    <div class="col-auto text-end">
                                                        @if($detail->status == 'dikembalikan' || $detail->status == 'terlambat')
                                                            @if($detail->tanggal_kembali_actual)
                                                                <p class="text-muted small mb-1">{{ $detail->tanggal_kembali_actual->format('d/m/Y') }}</p>
                                                            @endif
                                                            
                                                            @if($detail->denda > 0)
                                                                <p class="text-danger small mb-0"><strong>Denda: Rp {{ number_format($detail->denda, 0, ',', '.') }}</strong></p>
                                                            @else
                                                                <p class="text-success small mb-0"><strong>Tepat Waktu</strong></p>
                                                            @endif
                                                        @else
                                                            <span class="badge bg-soft-danger text-danger">Ditolak</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div> <div class="col-md-4">
                                        <div class="p-2">
                                            <h6 class="card-title mb-4">Ringkasan Transaksi</h6>
                                            
                                            <div class="mb-4">
                                                <p class="text-muted small mb-1">Total Buku Dipinjam</p>
                                                <h4 class="mb-0">{{ $peminjaman->details->count() }} Buku</h4>
                                            </div>

                                            @php
                                                $totalDendaPeminjaman = $peminjaman->details->sum('denda');
                                                $dikembalikanCount = $peminjaman->details->where('status', 'dikembalikan')->count();
                                                $terlambatCount = $peminjaman->details->where('status', 'terlambat')->count();
                                                $ditolakCount = $peminjaman->details->where('status', 'ditolak')->count();
                                            @endphp

                                            <div class="mb-4">
                                                <p class="text-muted small mb-1">Total Denda Keseluruhan</p>
                                                <h4 class="mb-0 {{ $totalDendaPeminjaman > 0 ? 'text-danger' : 'text-success' }}">
                                                    Rp {{ number_format($totalDendaPeminjaman, 0, ',', '.') }}
                                                </h4>
                                            </div>

                                            <hr>

                                            <div class="row text-center mt-3">
                                                <div class="col-4">
                                                    <p class="text-muted small mb-1">Kembali</p>
                                                    <h5 class="text-success mb-0">{{ $dikembalikanCount }}</h5>
                                                </div>
                                                <div class="col-4 border-start border-end">
                                                    <p class="text-muted small mb-1">Telat</p>
                                                    <h5 class="text-danger mb-0">{{ $terlambatCount }}</h5>
                                                </div>
                                                <div class="col-4">
                                                    <p class="text-muted small mb-1">Ditolak</p>
                                                    <h5 class="text-secondary mb-0">{{ $ditolakCount }}</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div> </div> </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                @if($peminjamanSelesai->hasPages())
                <div class="row mt-4">
                    <div class="col-12">
                        <nav>{{ $peminjamanSelesai->links() }}</nav>
                    </div>
                </div>
                @endif

            @else
                <div class="alert alert-info text-center" role="alert">
                    <i class="feather-info me-2"></i>
                    Belum ada riwayat pengembalian. <a href="{{ route('user.peminjaman.create') }}">Mulai pinjam buku!</a>
                </div>
            @endif
        </div>

        @include('layouts.footer')
    </div>
</main>
@endsection