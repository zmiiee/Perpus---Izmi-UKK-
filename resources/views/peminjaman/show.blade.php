@extends('layouts.layout')

@section('content')
<main class="nxl-container">
    <div class="nxl-content">
        <div class="page-header">
            <div class="page-header-left d-flex align-items-center">
                <div class="page-header-title">
                    <h5 class="m-b-10">Detail Peminjaman</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('peminjaman.index') }}">Peminjaman</a></li>
                    <li class="breadcrumb-item">Detail</li>
                </ul>
            </div>
        </div>

        <div class="main-content">
            @if(session('success'))
                <div class="alert alert-success mb-3">{{ session('success') }}</div>
            @endif

            <div class="row">
                {{-- Info Peminjam & Peminjaman --}}
                <div class="col-lg-4">
                    <div class="card stretch stretch-full mb-3">
                        <div class="card-header">
                            <h5 class="card-title">Informasi Peminjam</h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-5 fw-bold">Nama</div>
                                <div class="col-7">: {{ $peminjaman->anggota->user->name }}</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-5 fw-bold">NIS</div>
                                <div class="col-7">: {{ $peminjaman->anggota->nis }}</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-5 fw-bold">Kelas</div>
                                <div class="col-7">: {{ $peminjaman->anggota->kelas }}</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-5 fw-bold">No. Telp</div>
                                <div class="col-7">: {{ $peminjaman->anggota->no_tlp }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="card stretch stretch-full">
                        <div class="card-header">
                            <h5 class="card-title">Informasi Peminjaman</h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-6 fw-bold">Tgl Pinjam</div>
                                <div class="col-6">: {{ $peminjaman->tanggal_pinjam->format('d/m/Y') }}</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-6 fw-bold">Rencana Kembali</div>
                                <div class="col-6">: {{ $peminjaman->tanggal_kembali_rencana->format('d/m/Y') }}</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-6 fw-bold">Total Buku</div>
                                <div class="col-6">: {{ $peminjaman->details->count() }} buku</div>
                            </div>
                            @php
    $totalDenda = $peminjaman->details->sum('denda');
@endphp

@if($totalDenda > 0)
    <div class="alert alert-danger mt-3">
        <strong>Total Denda: Rp {{ number_format($totalDenda, 0, ',', '.') }}</strong>
    </div>
@endif
                        </div>
                    </div>
                </div>

                {{-- Daftar Buku --}}
                <div class="col-lg-8">
                    <div class="card stretch stretch-full">
                        <div class="card-header">
                            <h5 class="card-title">Daftar Buku yang Dipinjam</h5>
                        </div>
                        <div class="card-body">
                            @foreach($peminjaman->details as $detail)
                            <div class="card mb-3 border">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-md-8">
                                            <h5 class="mb-2">{{ $detail->buku->judul }}</h5>
                                            <p class="text-muted mb-2">
                                                <small>
                                                    Pengarang: {{ $detail->buku->pengarang }}<br>
                                                    Kategori: {{ $detail->buku->kategori->nama_kategori }}
                                                </small>
                                            </p>
                                            
                                            @if($detail->status == 'menunggu')
    <span class="badge bg-soft-warning text-warning">Menunggu Persetujuan</span>
    <div class="mt-2 d-flex gap-2 justify-content-end">
        <form action="{{ route('peminjaman.approve', $detail->id) }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-sm btn-success">
                <i class="feather-check me-1"></i> Setujui
            </button>
        </form>
        <form action="{{ route('peminjaman.tolak', $detail->id) }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-sm btn-danger">
                <i class="feather-x me-1"></i> Tolak
            </button>
        </form>
    </div>
@elseif($detail->status == 'dipinjam')
    <span class="badge bg-soft-info text-info">Sedang Dipinjam</span>
    {{-- tombol kembalikan tetap sama --}}
@elseif($detail->status == 'ditolak')
    <span class="badge bg-soft-danger text-danger">Ditolak</span>

@elseif($detail->status == 'terlambat')
    <span class="badge bg-soft-warning text-warning">Terlambat</span>

@elseif($detail->status == 'dikembalikan')
    <span class="badge bg-soft-success text-success">Sudah Dikembalikan</span>
@endif
                                        </div>

                                        @if($detail->denda > 0)
    <div class="mt-2">
        <span class="badge bg-soft-danger text-danger">
            Denda: Rp {{ number_format($detail->denda, 0, ',', '.') }}
        </span>
    </div>
@endif
                                        <div class="col-md-4 text-end">
                                            @if($detail->status == 'dipinjam')
                                                <button type="button" class="btn btn-sm btn-primary" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#modalKembalikan{{ $detail->id }}">
                                                    <i class="feather-check me-1"></i> Kembalikan
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <div class="card-footer d-flex justify-content-end gap-2">
                            <a href="{{ route('peminjaman.index') }}" class="btn btn-light">Kembali</a>
                            <a href="{{ route('peminjaman.edit', $peminjaman->id) }}" class="btn btn-primary">Edit</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('layouts.footer')
    </div>
</main>

{{-- Modal di luar main-content --}}
@foreach($peminjaman->details as $detail)
<div class="modal fade" id="modalKembalikan{{ $detail->id }}" tabindex="-1" aria-labelledby="modalLabel{{ $detail->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('peminjaman.kembalikan', $detail->id) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel{{ $detail->id }}">Kembalikan Buku</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="fw-bold">{{ $detail->buku->judul }}</p>
                    
                    <div class="mb-3">
                        <label class="form-label">Tanggal Pengembalian <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal_kembali_actual" 
                               class="form-control" value="{{ date('Y-m-d') }}" required>
                    </div>

                    <div class="alert alert-info">
                        <small>
                            <strong>Info:</strong><br>
                            Rencana Kembali: {{ $peminjaman->tanggal_kembali_rencana->format('d/m/Y') }}<br>
                            Denda Rp 1.000/hari jika terlambat
                        </small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach
@endsection