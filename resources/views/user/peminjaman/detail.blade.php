@extends('layouts.layout')

@section('content')
<main class="nxl-container">
    <div class="nxl-content">
        <!-- Header -->
        <div class="page-header">
            <div class="page-header-left d-flex align-items-center">
                <div class="page-header-title">
                    <h5 class="m-b-10">Detail Peminjaman</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('user.peminjaman.aktif') }}">Peminjaman Aktif</a></li>
                    <li class="breadcrumb-item">Detail</li>
                </ul>
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

            <div class="row">
                <!-- Info Peminjaman -->
                <div class="col-lg-4">
                    <div class="card stretch stretch-full mb-4">
                        <div class="card-header">
                            <h5 class="card-title">Informasi Peminjaman</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="text-muted small">ID Peminjaman</label>
                                <p class="mb-0"><strong>{{ $peminjaman->id }}</strong></p>
                            </div>
                            <hr>
                            <div class="mb-3">
                                <label class="text-muted small">Tanggal Pinjam</label>
                                <p class="mb-0"><strong>{{ $peminjaman->tanggal_pinjam->format('d/m/Y') }}</strong></p>
                            </div>
                            <div class="mb-3">
                                <label class="text-muted small">Rencana Pengembalian</label>
                                <p class="mb-0"><strong>{{ $peminjaman->tanggal_kembali_rencana->format('d/m/Y') }}</strong></p>
                            </div>
                            <hr>
                            <div class="mb-3">
                                <label class="text-muted small">Total Buku</label>
                                <p class="mb-0"><strong>{{ $peminjaman->details->count() }} buku</strong></p>
                            </div>
                            <div class="mb-3">
                                <label class="text-muted small">Total Denda</label>
                                @php
                                    $totalDenda = $peminjaman->details->sum('denda');
                                @endphp
                                <p class="mb-0">
                                    <strong class="{{ $totalDenda > 0 ? 'text-danger' : 'text-success' }}">
                                        Rp {{ number_format($totalDenda, 0, ',', '.') }}
                                    </strong>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Daftar Buku -->
                <div class="col-lg-8">
                    <div class="card stretch stretch-full">
                        <div class="card-header">
                            <h5 class="card-title">Daftar Buku Peminjaman</h5>
                        </div>
                        <div class="card-body">
                            @if($peminjaman->details->count() > 0)
                                @foreach($peminjaman->details as $detail)
                                <div class="card mb-3 border">
                                    <div class="card-body">
                                        <div class="row">
                                            <!-- Gambar Buku -->
                                            <div class="col-md-2">
                                                @if($detail->buku->cover)
                                                    <img src="{{ asset('storage/' . $detail->buku->cover) }}" 
                                                         alt="{{ $detail->buku->judul }}"
                                                         class="img-fluid rounded" style="max-height: 150px; object-fit: cover;">
                                                @else
                                                    <div class="bg-light rounded d-flex align-items-center justify-content-center" 
                                                         style="height: 150px;">
                                                        <i class="feather-book" style="font-size: 40px;"></i>
                                                    </div>
                                                @endif
                                            </div>

                                            <!-- Info Buku -->
                                            <div class="col-md-7">
                                                <h5 class="mb-2">{{ $detail->buku->judul }}</h5>
                                                <p class="text-muted small mb-2">
                                                    <strong>Pengarang:</strong> {{ $detail->buku->pengarang }}<br>
                                                    <strong>Kategori:</strong> {{ $detail->buku->kategori->nama_kategori }}<br>
                                                </p>

                                                <!-- Status Badge dan Info -->
                                                @if($detail->status == 'menunggu')
                                                    <span class="badge bg-soft-warning text-warning">Menunggu Persetujuan</span>
                                                    <p class="mt-2 mb-0">
                                                        <small class="text-muted">Pengajuan Anda sedang diproses oleh admin.</small>
                                                    </p>
                                                @elseif($detail->status == 'ditolak')
                                                    <span class="badge bg-soft-danger text-danger">Ditolak</span>
                                                    <p class="mt-2 mb-0">
                                                        <small class="text-muted">Pengajuan peminjaman buku ini ditolak oleh admin.</small>
                                                    </p>
                                                @elseif($detail->status == 'dipinjam')
                                                    <span class="badge bg-soft-success text-success">Sedang Dipinjam</span>
                                                    <p class="mt-2 mb-0">
                                                        <small class="text-muted">Segera kembalikan sebelum {{ $peminjaman->tanggal_kembali_rencana->format('d/m/Y') }}</small>
                                                    </p>
                                                @elseif($detail->status == 'terlambat')
                                                    <span class="badge bg-soft-danger text-danger">Terlambat</span>
                                                    @if($detail->tanggal_kembali_actual)
                                                        <p class="mt-2 mb-0">
                                                            <small>
                                                                Dikembalikan: {{ $detail->tanggal_kembali_actual->format('d/m/Y') }}<br>
                                                                <span class="text-danger fw-bold">Denda: Rp {{ number_format($detail->denda, 0, ',', '.') }}</span>
                                                            </small>
                                                        </p>
                                                    @endif
                                                @else
                                                    <span class="badge bg-soft-info text-info">Sudah Dikembalikan</span>
                                                    <p class="mt-2 mb-0">
                                                        <small>
                                                            Dikembalikan: {{ $detail->tanggal_kembali_actual ? $detail->tanggal_kembali_actual->format('d/m/Y') : 'N/A' }}
                                                            @if($detail->denda > 0)
                                                                <br><span class="text-danger">Denda: Rp {{ number_format($detail->denda, 0, ',', '.') }}</span>
                                                            @endif
                                                        </small>
                                                    </p>
                                                @endif
                                            </div>

                                            <!-- Action Button -->
                                            <div class="col-md-3 text-end d-flex flex-column justify-content-center">
    @if(in_array($detail->status, ['dipinjam', 'terlambat']) && is_null($detail->tanggal_kembali_actual))
        <button type="button" class="btn btn-primary btn-sm mb-2" 
                data-bs-toggle="modal" 
                data-bs-target="#modalKembalikan{{ $detail->id }}">
            <i class="feather-check me-1"></i> Kembalikan Buku
        </button>
    @else
        <div class="text-center">
            @if($detail->status == 'menunggu')
                <span class="badge bg-light text-warning border">Menunggu Verifikasi</span>
            @elseif($detail->status == 'ditolak')
                <span class="badge bg-light text-danger border">Ditolak</span>
            @else
                <span class="text-success small fw-bold">
                    <i class="feather-check-circle me-1"></i> Transaksi Selesai
                </span>
            @endif
        </div>
    @endif
</div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            @endif
                        </div>

                        <div class="card-footer">
                            <a href="{{ route('user.peminjaman.aktif') }}" class="btn btn-light">
                                <i class="feather-arrow-left me-1"></i>Kembali
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('layouts.footer')
    </div>
</main>

<!-- Modal Kembalikan Buku -->
@foreach($peminjaman->details as $detail)
    {{-- Tombol dan Modal hanya ada jika statusnya belum dikembalikan --}}
    @if(in_array($detail->status, ['dipinjam', 'terlambat']) && is_null($detail->tanggal_kembali_actual))
    <div class="modal fade" id="modalKembalikan{{ $detail->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('user.peminjaman.kembalikan', $detail->id) }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="feather-check-circle me-2" style="color: #28a745;"></i>
                            Konfirmasi Pengembalian
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <h6 class="mb-2">{{ $detail->buku->judul }}</h6>
                            <p class="text-muted small mb-0">{{ $detail->buku->pengarang }}</p>
                        </div>
                        <div class="card bg-light mb-3">
                            <div class="card-body">
                                <p class="small mb-2">
                                    <strong>Rencana Kembali:</strong><br>
                                    {{ $peminjaman->tanggal_kembali_rencana->format('d/m/Y') }}
                                </p>
                                <p class="small mb-0">
                                    <strong>Denda:</strong><br>
                                    Rp 1.000 per hari (jika terlambat)
                                </p>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tanggal Pengembalian <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_kembali_actual" 
                                   class="form-control" 
                                   value="{{ date('Y-m-d') }}" 
                                   required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Kembalikan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
@endforeach

@endsection