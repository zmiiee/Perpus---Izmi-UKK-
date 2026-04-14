@extends('layouts.layout')

@section('content')
<main class="nxl-container">
    <div class="nxl-content">
        <div class="page-header">
            <div class="page-header-left d-flex align-items-center">
                <div class="page-header-title">
                    <h5 class="m-b-10">Tambah Buku</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('buku.index') }}">Buku</a></li>
                    <li class="breadcrumb-item">Tambah</li>
                </ul>
            </div>
        </div>

        <div class="main-content">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card stretch stretch-full">
                        <div class="card-header">
                            <h5 class="card-title">Form Tambah Buku</h5>
                        </div>

                        <form action="{{ route('buku.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">

                                {{-- Judul --}}
                                <div class="row mb-4 align-items-center">
                                    <div class="col-lg-4">
                                        <label class="fw-semibold">Judul Buku</label>
                                    </div>
                                    <div class="col-lg-8">
                                        <input type="text" name="judul" class="form-control @error('judul') is-invalid @enderror"
                                            value="{{ old('judul') }}" required>
                                        @error('judul')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Pengarang --}}
                                <div class="row mb-4 align-items-center">
                                    <div class="col-lg-4">
                                        <label class="fw-semibold">Pengarang</label>
                                    </div>
                                    <div class="col-lg-8">
                                        <input type="text" name="pengarang" class="form-control @error('pengarang') is-invalid @enderror"
                                            value="{{ old('pengarang') }}" required>
                                        @error('pengarang')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Tahun Terbit --}}
                                <div class="row mb-4 align-items-center">
                                    <div class="col-lg-4">
                                        <label class="fw-semibold">Tahun Terbit</label>
                                    </div>
                                    <div class="col-lg-8">
                                        <input type="number" name="tahun_terbit" class="form-control @error('tahun_terbit') is-invalid @enderror"
                                            value="{{ old('tahun_terbit') }}" required>
                                        @error('tahun_terbit')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Stok --}}
<div class="row mb-4 align-items-center">
    <div class="col-lg-4">
        <label class="fw-semibold">Stok Buku</label>
    </div>
    <div class="col-lg-8">
        <input type="number" name="stok" min="0"
               class="form-control @error('stok') is-invalid @enderror"
               value="{{ old('stok', 0) }}" required>
        @error('stok')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
</div>

                                {{-- Kategori --}}
                                <div class="row mb-4 align-items-center">
                                    <div class="col-lg-4">
                                        <label class="fw-semibold">Kategori</label>
                                    </div>
                                    <div class="col-lg-8">
                                        <select name="kategori_id" class="form-control @error('kategori_id') is-invalid @enderror" required>
                                            <option value="">-- Pilih Kategori --</option>
                                            @foreach ($kategoris as $kategori)
                                                <option value="{{ $kategori->id }}"
                                                    {{ old('kategori_id') == $kategori->id ? 'selected' : '' }}>
                                                    {{ $kategori->nama_kategori }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('kategori_id')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Deskripsi --}}
                                <div class="row mb-4 align-items-center">
                                    <div class="col-lg-4">
                                        <label class="fw-semibold">Deskripsi</label>
                                    </div>
                                    <div class="col-lg-8">
                                        <textarea name="deskripsi" rows="4"
                                            class="form-control @error('deskripsi') is-invalid @enderror">{{ old('deskripsi') }}</textarea>
                                        @error('deskripsi')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-4 align-items-center">
                                    <div class="col-lg-4">
                                        <label class="fw-semibold">Cover Buku</label>
                                    </div>
                                    <div class="col-lg-8">
                                        <input type="file" name="file_cover" class="form-control @error('cover') is-invalid @enderror">
                                        @error('cover')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                            </div>
                            <div class="card-footer d-flex gap-2 justify-content-end">
                                <a href="{{ route('buku.index') }}" class="btn btn-light">Batal</a>
                                <button type="submit" class="btn btn-primary">Simpan</button>
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