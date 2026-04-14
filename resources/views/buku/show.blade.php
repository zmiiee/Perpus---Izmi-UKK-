@extends('layouts.layout')

@section('content')
<main class="nxl-container">
    <div class="nxl-content">
        <div class="page-header">
            <div class="page-header-left d-flex align-items-center">
                <div class="page-header-title">
                    <h5 class="m-b-10">Detail Buku</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('buku.index') }}">Buku</a></li>
                    <li class="breadcrumb-item">Detail</li>
                </ul>
            </div>
        </div>

        <div class="main-content">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card stretch stretch-full">
                        <div class="card-header">
                            <h5 class="card-title">Informasi Buku</h5>
                        </div>

                        <div class="card-body">
                           <div class="row mb-3">
                                <div class="col-md-4 fw-bold">Cover</div>
                                <div class="col-md-8">
                                    @if($buku->cover)
                                        <img src="{{ asset('storage/' . $buku->cover) }}" alt="Cover {{ $buku->judul }}" width="250" class="img-thumbnail">
                                    @else
                                        <span class="text-muted">Tidak ada cover</span>
                                    @endif
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4 fw-bold">Judul</div>
                                <div class="col-md-8">: {{ $buku->judul }}</div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4 fw-bold">Pengarang</div>
                                <div class="col-md-8">: {{ $buku->pengarang }}</div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4 fw-bold">Tahun Terbit</div>
                                <div class="col-md-8">: {{ $buku->tahun_terbit }}</div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4 fw-bold">Kategori</div>
                                <div class="col-md-8">: {{ $buku->kategori->nama_kategori ?? '-' }}</div>
                            </div>

                            {{-- Tambah setelah baris Kategori --}}
<div class="row mb-3">
    <div class="col-md-4 fw-bold">Stok</div>
    <div class="col-md-8">
        : 
        @if($buku->stok > 0)
            <span class="badge bg-soft-success text-success">{{ $buku->stok }} tersedia</span>
        @else
            <span class="badge bg-soft-danger text-danger">Habis</span>
        @endif
    </div>
</div>

                            <div class="row mb-3">
                                <div class="col-md-4 fw-bold">Deskripsi</div>
                                <div class="col-md-8">: {{ $buku->deskripsi ?? '-' }}</div>
                            </div>

                        </div>

                        <div class="card-footer d-flex justify-content-end gap-2">
                            <a href="{{ route('buku.index') }}" class="btn btn-light">
                                Kembali
                            </a>
                            <a href="{{ route('buku.edit', $buku->id) }}" class="btn btn-primary">
                                Edit
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