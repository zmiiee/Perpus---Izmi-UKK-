@extends('layouts.layout')

@section('content')
<main class="nxl-container">
    <div class="nxl-content">
        <div class="page-header">
            <div class="page-header-left d-flex align-items-center">
                <div class="page-header-title">
                    <h5 class="m-b-10">Edit Peminjaman</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('peminjaman.index') }}">Peminjaman</a></li>
                    <li class="breadcrumb-item">Edit</li>
                </ul>
            </div>
        </div>

        <div class="main-content">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card stretch stretch-full">
                        <div class="card-header">
                            <h5 class="card-title">Form Edit Peminjaman</h5>
                        </div>

                        @if($errors->any())
                            <div class="alert alert-danger mx-4 mt-3">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('peminjaman.update', $peminjaman->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="card-body">

                                {{-- Peminjam --}}
                                <div class="row mb-4 align-items-center">
                                    <div class="col-lg-4">
                                        <label class="fw-semibold">Peminjam <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-lg-8">
                                        <select name="anggota_id" class="form-control @error('anggota_id') is-invalid @enderror" required>
                                            <option value="">-- Pilih Anggota --</option>
                                            @foreach($anggota as $item)
                                                <option value="{{ $item->id }}" 
                                                    {{ (old('anggota_id', $peminjaman->anggota_id) == $item->id) ? 'selected' : '' }}>
                                                    {{ $item->user->name }} ({{ $item->nis }} - {{ $item->kelas }})
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('anggota_id')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Tanggal Pinjam --}}
                                <div class="row mb-4 align-items-center">
                                    <div class="col-lg-4">
                                        <label class="fw-semibold">Tanggal Pinjam <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-lg-8">
                                        <input type="date" name="tanggal_pinjam" 
                                               class="form-control @error('tanggal_pinjam') is-invalid @enderror"
                                               value="{{ old('tanggal_pinjam', $peminjaman->tanggal_pinjam->format('Y-m-d')) }}" 
                                               required>
                                        @error('tanggal_pinjam')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Tanggal Rencana Kembali --}}
                                <div class="row mb-4 align-items-center">
                                    <div class="col-lg-4">
                                        <label class="fw-semibold">Tanggal Rencana Kembali <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-lg-8">
                                        <input type="date" name="tanggal_kembali_rencana" 
                                               class="form-control @error('tanggal_kembali_rencana') is-invalid @enderror"
                                               value="{{ old('tanggal_kembali_rencana', $peminjaman->tanggal_kembali_rencana->format('Y-m-d')) }}" 
                                               required>
                                        @error('tanggal_kembali_rencana')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Info Buku yang Dipinjam --}}
                                <div class="row mb-4 align-items-start">
                                    <div class="col-lg-4">
                                        <label class="fw-semibold">Buku yang Dipinjam</label>
                                        <small class="text-muted d-block">Buku tidak bisa diubah</small>
                                    </div>
                                    <div class="col-lg-8">
                                        <div class="border rounded p-3 bg-light">
                                            @foreach($peminjaman->details as $detail)
                                                <div class="d-flex align-items-center mb-2 pb-2 {{ !$loop->last ? 'border-bottom' : '' }}">
                                                    <i class="feather-book me-2 text-primary"></i>
                                                    <div class="flex-grow-1">
                                                        <strong>{{ $detail->buku->judul }}</strong><br>
                                                        <small class="text-muted">{{ $detail->buku->pengarang }} - {{ $detail->buku->kategori->nama_kategori }}</small>
                                                    </div>
                                                    <div>
                                                        @if($detail->status == 'dipinjam')
                                                            <span class="badge bg-soft-warning text-warning">Dipinjam</span>
                                                        @elseif($detail->status == 'dikembalikan')
                                                            <span class="badge bg-soft-success text-success">Dikembalikan</span>
                                                        @else
                                                            <span class="badge bg-soft-danger text-danger">Terlambat</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        <small class="text-muted mt-2 d-block">
                                            <i class="feather-info me-1"></i>
                                            Untuk mengubah buku, silakan hapus peminjaman ini dan buat peminjaman baru.
                                        </small>
                                    </div>
                                </div>

                            </div>
                            <div class="card-footer d-flex gap-2 justify-content-end">
                                <a href="{{ route('peminjaman.index') }}" class="btn btn-light">Batal</a>
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>

        @include('layouts.footer')
    </div>
</main>
@endsection