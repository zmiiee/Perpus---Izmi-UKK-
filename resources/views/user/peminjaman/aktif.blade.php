@extends('layouts.layout')

@section('content')
<main class="nxl-container">
    <div class="nxl-content">
        <!-- Header -->
        <div class="page-header">
            <div class="d-flex align-items-center justify-content-between w-100">
                <div>
                    <h5 class="m-b-10">Peminjaman Aktif</h5>
                </div>
                <a href="{{ route('user.peminjaman.create') }}" class="btn btn-primary">
                    <i class="feather-plus me-2"></i>Pinjam Buku
                </a>
            </div>
        </div>

        <div class="main-content">
            <!-- Alert Messages -->
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

            <!-- Menunggu Persetujuan -->
            @if($peminjamanMenunggu->count() > 0)
            <div class="mb-4">
                <div class="card stretch stretch-full">
                    <div class="card-header border-bottom">
                        <h5 class="card-title mb-0">
                            <i class="feather-clock text-warning me-2"></i>Menunggu Persetujuan Admin
                        </h5>
                    </div>
                    <div class="card-body">
                        @foreach($peminjamanMenunggu as $peminjaman)
                        <div class="card mb-3 border">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        <h5 class="mb-2">Pengajuan Peminjaman Tanggal {{ $peminjaman->tanggal_pinjam->format('d/m/Y') }}</h5>
                                        <p class="text-muted small mb-2">
                                            Rencana Pengembalian: {{ $peminjaman->tanggal_kembali_rencana->format('d/m/Y') }} 
                                        </p>
                                        <div class="mt-3">
                                            @php
                                                $menuggingDetails = $peminjaman->details->where('status', 'menunggu');
                                            @endphp
                                            @foreach($menuggingDetails as $detail)
                                            <div class="mb-2 d-flex align-items-start">
                                                <i class="feather-book me-2 mt-1" style="color: #ff9800;"></i>
                                                <div>
                                                    <strong>{{ $detail->buku->judul }}</strong><br>
                                                    <small class="text-muted">{{ $detail->buku->pengarang }}</small>
                                                    <span class="badge bg-soft-warning text-warning ms-2">Menunggu Persetujuan</span>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="col-md-4 text-end">
                                        <a href="{{ route('user.peminjaman.detail', $peminjaman->id) }}" class="btn btn-primary">
                                            <i class="feather-eye me-1"></i>Lihat Detail
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            <!-- Terlambat -->
            @if($peminjamanTerlambat->count() > 0)
            <div class="mb-4">
                <div class="card stretch stretch-full border-danger">
                    <div class="card-header border-bottom border-danger bg-light">
                        <h5 class="card-title mb-0 text-danger">
                            <i class="feather-alert-triangle me-2"></i>Buku Terlambat
                        </h5>
                    </div>
                    <div class="card-body">
                        @foreach($peminjamanTerlambat as $peminjaman)
                        <div class="card mb-3 border border-danger">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        <h5 class="mb-2 text-danger">Peminjaman Tanggal {{ $peminjaman->tanggal_pinjam->format('d/m/Y') }}</h5>
                                        <p class="text-muted small mb-3">
                                            <strong>Rencana Pengembalian:</strong> {{ $peminjaman->tanggal_kembali_rencana->format('d/m/Y') }}
                                        </p>
                                        <div>
                                            @php
                                                $terlambatDetails = $peminjaman->details->where('status', 'terlambat');
                                            @endphp
                                            @foreach($terlambatDetails as $detail)
                                            <div class="mb-3 p-3 bg-light rounded">
                                                <div class="d-flex align-items-start">
                                                    <i class="feather-book me-2 mt-1" style="color: #dc3545;"></i>
                                                    <div class="flex-grow-1">
                                                        <strong>{{ $detail->buku->judul }}</strong><br>
                                                        <small class="text-muted">{{ $detail->buku->pengarang }}</small>
                                                        <span class="badge bg-soft-danger text-danger ms-2">Terlambat</span>
                                                        <p class="text-danger small mt-2 mb-0">
                                                            <strong>Denda: Rp {{ number_format($detail->denda, 0, ',', '.') }}</strong>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="col-md-4 text-end">
                                        <a href="{{ route('user.peminjaman.detail', $peminjaman->id) }}" class="btn btn-danger">
                                            <i class="feather-eye me-1"></i>Lihat Detail
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            <!-- Dipinjam (Aktif) -->
            @if($peminjamanDipinjam->count() > 0)
            <div class="mb-4">
                <div class="card stretch stretch-full border-success">
                    <div class="card-header border-bottom border-success bg-light">
                        <h5 class="card-title mb-0 text-success">
                            <i class="feather-book-open text-success me-2"></i>Sedang Dipinjam
                        </h5>
                    </div>
                    <div class="card-body">
                        @foreach($peminjamanDipinjam as $peminjaman)
                        <div class="card mb-3 border border-success">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        <h5 class="mb-2">Peminjaman Tanggal {{ $peminjaman->tanggal_pinjam->format('d/m/Y') }}</h5>
                                        <p class="text-muted small mb-3">
                                            <strong>Rencana Pengembalian:</strong> {{ $peminjaman->tanggal_kembali_rencana->format('d/m/Y') }}
                                        </p>
                                        <div>
                                            @php
                                                $dipinjamDetails = $peminjaman->details->where('status', 'dipinjam');
                                            @endphp
                                            @foreach($dipinjamDetails as $detail)
                                            <div class="mb-2 d-flex align-items-start">
                                                <i class="feather-book me-2 mt-1" style="color: #28a745;"></i>
                                                <div>
                                                    <strong>{{ $detail->buku->judul }}</strong><br>
                                                    <small class="text-muted">{{ $detail->buku->pengarang }}</small>
                                                    <span class="badge bg-soft-success text-success ms-2">Sedang Dipinjam</span>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="col-md-4 text-end">
                                        <a href="{{ route('user.peminjaman.detail', $peminjaman->id) }}" class="btn btn-success">
                                            <i class="feather-eye me-1"></i>Lihat Detail & Kembalikan
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            <!-- Empty State -->
            @if($peminjamanDipinjam->count() == 0 && $peminjamanTerlambat->count() == 0 && $peminjamanMenunggu->count() == 0)
            <div class="alert alert-info text-center" role="alert">
                <i class="feather-info me-2"></i>
                Tidak ada peminjaman aktif. <a href="{{ route('user.peminjaman.create') }}">Pinjam buku sekarang!</a>
            </div>
            @endif

        </div>

        @include('layouts.footer')
    </div>
</main>
@endsection