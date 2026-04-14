@extends('layouts.layout')

@section('content')
<main class="nxl-container">
    <div class="nxl-content">
        <div class="page-header">
            <div class="page-header-left d-flex align-items-center">
                <div class="page-header-title">
                    <h5 class="m-b-10">Edit Buku</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('buku.index') }}">Buku</a></li>
                    <li class="breadcrumb-item">Edit</li>
                </ul>
            </div>
        </div>

        <div class="main-content">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card stretch stretch-full">
                        <div class="card-header">
                            <h5 class="card-title">Form Edit Buku</h5>
                        </div>

                        <form action="{{ route('buku.update', $buku->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="card-body">

                                {{-- Judul --}}
                                <div class="row mb-4 align-items-center">
                                    <div class="col-lg-4">
                                        <label class="fw-semibold">Judul Buku</label>
                                    </div>
                                    <div class="col-lg-8">
                                        <input type="text" name="judul" class="form-control @error('judul') is-invalid @enderror"
                                            value="{{ old('judul', $buku->judul) }}" required>
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
                                            value="{{ old('pengarang', $buku->pengarang) }}" required>
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
                                            value="{{ old('tahun_terbit', $buku->tahun_terbit) }}" required>
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
               value="{{ old('stok', $buku->stok) }}" required>
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
                                                    {{ old('kategori_id', $buku->kategori_id) == $kategori->id ? 'selected' : '' }}>
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
                                            class="form-control @error('deskripsi') is-invalid @enderror">{{ old('deskripsi', $buku->deskripsi) }}</textarea>
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
                                        <input type="file" name="file_cover" class="form-control @error('file_cover') is-invalid @enderror">
                                        @error('file_cover')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                @if ($buku->cover)
                                    <img src="{{ asset('storage/covers/' . $buku->cover) }}" width="120" class="mb-2">
                                @endif
                            </div>
                            <div class="card-footer d-flex justify-content-end gap-2">
                                <a href="{{ route('buku.index') }}" class="btn btn-light">Batal</a>
                                <button class="btn btn-primary" type="submit">Simpan Perubahan</button>
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