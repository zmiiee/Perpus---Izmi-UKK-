@extends('layouts.layout')

@section('content')
<main class="nxl-container">
    <div class="nxl-content">
        <div class="page-header">
            <div class="page-header-left d-flex align-items-center">
                <div class="page-header-title">
                    <h5 class="m-b-10">Detail Pengembalian</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('pengembalian.index') }}">Pengembalian</a></li>
                    <li class="breadcrumb-item">Detail</li>
                </ul>
            </div>
        </div>

        <div class="main-content">
            <div class="row">
                {{-- Info Peminjam --}}
                <div class="col-lg-4">
                    <div class="card stretch stretch-full mb-3">
                        <div class="card-header">
                            <h5 class="card-title">Informasi Peminjam</h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-5 fw-bold">Nama</div>
                                <div class="col-7">: {{ $detail->peminjaman->anggota->user->name }}</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-5 fw-bold">NIS</div>
                                <div class="col-7">: {{ $detail->peminjaman->anggota->nis }}</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-5 fw-bold">Kelas</div>
                                <div class="col-7">: {{ $detail->peminjaman->anggota->kelas }}</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-5 fw-bold">No. Telp</div>
                                <div class="col-7">: {{ $detail->peminjaman->anggota->no_tlp }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="card stretch stretch-full">
                        <div class="card-header">
                            <h5 class="card-title">Informasi Waktu</h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-6 fw-bold">Tgl Pinjam</div>
                                <div class="col-6">: {{ $detail->peminjaman->tanggal_pinjam->format('d/m/Y') }}</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-6 fw-bold">Rencana Kembali</div>
                                <div class="col-6">: {{ $detail->peminjaman->tanggal_kembali_rencana->format('d/m/Y') }}</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-6 fw-bold">Tgl Kembali</div>
                                <div class="col-6">: {{ $detail->tanggal_kembali_actual->format('d/m/Y') }}</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-6 fw-bold">Durasi Pinjam</div>
                                <div class="col-6">
                                    @php
                                        $durasi = $detail->peminjaman->tanggal_pinjam->diffInDays($detail->tanggal_kembali_actual);
                                    @endphp
                                    : {{ $durasi }} hari
                                </div>
                            </div>
                            @if($detail->status == 'terlambat')
                                <div class="row mb-3">
                                    <div class="col-6 fw-bold">Keterlambatan</div>
                                    <div class="col-6">
                                        @php
                                            $terlambat = $detail->peminjaman->tanggal_kembali_rencana->diffInDays($detail->tanggal_kembali_actual);
                                        @endphp
                                        : <span class="text-danger fw-bold">{{ $terlambat }} hari</span>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Info Buku & Denda --}}
                <div class="col-lg-8">
                    <div class="card stretch stretch-full mb-3">
                        <div class="card-header">
                            <h5 class="card-title">Informasi Buku</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3 text-center">
                                    @if($detail->buku->cover)
                                        <img src="{{ asset('storage/' . $detail->buku->cover) }}" 
                                             class="img-fluid rounded" 
                                             alt="{{ $detail->buku->judul }}"
                                             style="max-height: 250px;">
                                    @else
                                        <div class="bg-light rounded d-flex align-items-center justify-content-center" 
                                             style="height: 250px;">
                                            <i class="feather-book" style="font-size: 60px;"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-md-9">
                                    <h4 class="mb-3">{{ $detail->buku->judul }}</h4>
                                    
                                    <div class="row mb-2">
                                        <div class="col-4 fw-bold">Pengarang</div>
                                        <div class="col-8">: {{ $detail->buku->pengarang }}</div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-4 fw-bold">Kategori</div>
                                        <div class="col-8">: {{ $detail->buku->kategori->nama_kategori }}</div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-4 fw-bold">Tahun Terbit</div>
                                        <div class="col-8">: {{ $detail->buku->tahun_terbit }}</div>
                                    </div>
                                    
                                    @if($detail->buku->deskripsi)
                                    <div class="row mt-3">
                                        <div class="col-12">
                                            <div class="fw-bold mb-2">Deskripsi:</div>
                                            <p class="text-muted">{{ $detail->buku->deskripsi }}</p>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card stretch stretch-full">
                        <div class="card-header">
                            <h5 class="card-title">Informasi Pengembalian</h5>
                        </div>
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <div class="row mb-3">
                                        <div class="col-4 fw-bold">Status Pengembalian</div>
                                        <div class="col-8">
                                            @if($detail->status == 'terlambat')
                                                <span class="badge bg-soft-danger text-danger fs-6">
                                                    <i class="feather-alert-circle me-1"></i> Terlambat
                                                </span>
                                            @else
                                                <span class="badge bg-soft-success text-success fs-6">
                                                    <i class="feather-check-circle me-1"></i> Tepat Waktu
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-4 fw-bold">Denda</div>
                                        <div class="col-8">
                                            @if($detail->denda > 0)
                                                <h4 class="text-danger mb-0">Rp {{ number_format($detail->denda, 0, ',', '.') }}</h4>
                                                <small class="text-muted">
                                                    ({{ $detail->peminjaman->tanggal_kembali_rencana->diffInDays($detail->tanggal_kembali_actual) }} hari × Rp 1.000)
                                                </small>
                                            @else
                                                <h4 class="text-success mb-0">Rp 0</h4>
                                                <small class="text-muted">Tidak ada denda</small>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 text-center">
                                    @if($detail->denda > 0)
                                        <div class="alert alert-danger mb-0">
                                            <i class="feather-alert-triangle fs-1 mb-2"></i>
                                            <h5>Perlu Dibayar</h5>
                                            <p class="mb-0">Denda harus dilunasi</p>
                                        </div>
                                    @else
                                        <div class="alert alert-success mb-0">
                                            <i class="feather-check-circle fs-1 mb-2"></i>
                                            <h5>Lunas</h5>
                                            <p class="mb-0">Tidak ada denda</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="card-footer d-flex justify-content-between">
                            <a href="{{ route('pengembalian.index') }}" class="btn btn-light">
                                <i class="feather-arrow-left me-1"></i> Kembali
                            </a>
                            <a href="{{ route('peminjaman.show', $detail->peminjaman->id) }}" class="btn btn-primary">
                                <i class="feather-eye me-1"></i> Lihat Semua Peminjaman
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('layouts.footer')
    </div>
</main>
@endsection