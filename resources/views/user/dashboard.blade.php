@extends('layouts.layout')

@section('content')
<main class="nxl-container">
    <div class="nxl-content">
        <!-- Header -->
        <div class="page-header">
            <div class="d-flex align-items-center justify-content-between w-100">
                <div>
                    <p class="fw-bold mb-0">Selamat datang, {{ Auth::user()->name }}!</p>
                </div>
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

            <!-- Statistics Cards -->
            <div class="row mb-4">
                <div class="col-md-6 col-lg-3">
                    <div class="card stretch stretch-full">
                        <div class="card-body text-center">
                            <div class="mb-3">
                                <i class="feather-book" style="font-size: 32px; color: #0066cc;"></i>
                            </div>
                            <h6 class="text-muted mb-2">Buku Dipinjam</h6>
                            <h3 class="mb-0">{{ $peminjamanAktif }}</h3>
                        </div>
                        <div class="card-footer pt-0 pb-3">
                            <a href="{{ route('user.peminjaman.aktif') }}" class="btn btn-sm btn-link">Lihat Detail →</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="card stretch stretch-full">
                        <div class="card-body text-center">
                            <div class="mb-3">
                                <i class="feather-clock" style="font-size: 32px; color: #ff9800;"></i>
                            </div>
                            <h6 class="text-muted mb-2">Menunggu Persetujuan</h6>
                            <h3 class="mb-0">{{ $menungguPersetujuan }}</h3>
                        </div>
                        <div class="card-footer pt-0 pb-3">
                            <a href="{{ route('user.peminjaman.aktif') }}" class="btn btn-sm btn-link">Lihat Detail →</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="card stretch stretch-full">
                        <div class="card-body text-center">
                            <div class="mb-3">
                                <i class="feather-alert-triangle" style="font-size: 32px; color: #dc3545;"></i>
                            </div>
                            <h6 class="text-muted mb-2">Total Denda</h6>
                            <h3 class="mb-0">Rp {{ number_format($totalDenda, 0, ',', '.') }}</h3>
                        </div>
                        <div class="card-footer pt-0 pb-3">
                            <a href="{{ route('user.peminjaman.pengembalian') }}" class="btn btn-sm btn-link">Lihat Detail →</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="card stretch stretch-full">
                        <div class="card-body text-center">
                            <div class="mb-3">
                                <i class="feather-check-square" style="font-size: 32px; color: #28a745;"></i>
                            </div>
                            <h6 class="text-muted mb-2">Riwayat</h6>
                            <h3 class="mb-0">{{ $historiPeminjaman->count() }}</h3>
                        </div>
                        <div class="card-footer pt-0 pb-3">
                            <a href="{{ route('user.peminjaman.pengembalian') }}" class="btn btn-sm btn-link">Lihat Detail →</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card stretch stretch-full">
                        <div class="card-header">
                            <h5 class="card-title">Akses Cepat</h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-6 col-lg-3">
                                    <a href="{{ route('user.peminjaman.create') }}" class="btn btn-outline-info btn-block w-100" style="padding: 12px;">
                                        <i class="feather-plus me-2"></i>
                                        Pinjam Baru
                                    </a>
                                </div>
                                <div class="col-md-6 col-lg-3">
                                    <a href="{{ route('user.peminjaman.aktif') }}" class="btn btn-outline-primary btn-block w-100" style="padding: 12px;">
                                        <i class="feather-book-open me-2"></i>
                                        Peminjaman Aktif
                                    </a>
                                </div>
                                <div class="col-md-6 col-lg-3">
                                    <a href="{{ route('user.peminjaman.pengembalian') }}" class="btn btn-outline-success btn-block w-100" style="padding: 12px;">
                                        <i class="feather-check-circle me-2"></i>
                                        Riwayat
                                    </a>
                                </div>
                                <div class="col-md-6 col-lg-3">
                                    <a href="{{ route('page.index') }}" class="btn btn-outline-secondary btn-block w-100" style="padding: 12px;">
                                        <i class="feather-search me-2"></i>
                                        Cari Buku
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            @if($historiPeminjaman->count() > 0)
            <div class="row">
                <div class="col-12">
                    <div class="card stretch stretch-full">
                        <div class="card-header">
                            <h5 class="card-title">Aktivitas Terakhir</h5>
                        </div>
                        <div class="card-body">
                            <div class="timeline">
                                @foreach($historiPeminjaman as $peminjaman)
                                <div class="timeline-item mb-3 pb-3" style="border-bottom: 1px solid #e5e5e5;">
                                    <div class="d-flex align-items-start">
                                        <div class="flex-shrink-0 me-3">
                                            <div class="avatar bg-light rounded-circle" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                                <i class="feather-book"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="d-flex justify-content-between align-items-start">
                                                <div>
                                                    <h6 class="mb-1">Peminjaman {{ $peminjaman->details->count() }} buku</h6>
                                                    <p class="text-muted small mb-1">
                                                        Tanggal Pinjam: {{ $peminjaman->tanggal_pinjam->format('d/m/Y') }} - Rencana Kembali: {{ $peminjaman->tanggal_kembali_rencana->format('d/m/Y') }}
                                                    </p>
                                                    <p class="text-muted small">
                                                        @php
                                                            $statuses = $peminjaman->details->pluck('status')->unique();
                                                            $statusLabels = [];
                                                            foreach ($statuses as $status) {
                                                                if ($status == 'menunggu') $statusLabels[] = 'Menunggu';
                                                                elseif ($status == 'dipinjam') $statusLabels[] = 'Dipinjam';
                                                                elseif ($status == 'dikembalikan') $statusLabels[] = 'Dikembalikan';
                                                                elseif ($status == 'terlambat') $statusLabels[] = 'Terlambat';
                                                                elseif ($status == 'ditolak') $statusLabels[] = 'Ditolak';
                                                            }
                                                        @endphp
                                                        Status: {{ implode(', ', $statusLabels) }}
                                                    </p>
                                                </div>
                                                <a href="{{ route('user.peminjaman.detail', $peminjaman->id) }}" class="btn btn-sm btn-light">
                                                    Lihat
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="card-footer">
                            <a href="{{ route('user.peminjaman.pengembalian') }}" class="btn btn-sm btn-primary p-3">Lihat Semua Riwayat</a>
                        </div>
                    </div>
                </div>
            </div>
            @else
            <div class="row">
                <div class="col-12">
                    <div class="alert alert-info text-center" role="alert">
                        <i class="feather-info me-2"></i>
                        Belum ada riwayat peminjaman. <a href="{{ route('user.peminjaman.create') }}">Mulai pinjam buku sekarang!</a>
                    </div>
                </div>
            </div>
            @endif
        </div>

        @include('layouts.footer')
    </div>
</main>
@endsection