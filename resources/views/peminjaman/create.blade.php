@extends('layouts.layout')

@section('content')
<main class="nxl-container">
    <div class="nxl-content">
        <div class="page-header">
            <div class="page-header-left d-flex align-items-center">
                <div class="page-header-title">
                    <h5 class="m-b-10">Tambah Peminjaman</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('peminjaman.index') }}">Peminjaman</a></li>
                    <li class="breadcrumb-item">Tambah</li>
                </ul>
            </div>
        </div>

        <div class="main-content">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card stretch stretch-full">
                        <div class="card-header">
                            <h5 class="card-title">Form Tambah Peminjaman</h5>
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

                        <form action="{{ route('peminjaman.store') }}" method="POST">
                            @csrf
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
                                                <option value="{{ $item->id }}" {{ old('anggota_id') == $item->id ? 'selected' : '' }}>
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
                                        <input type="date" name="tanggal_pinjam" class="form-control @error('tanggal_pinjam') is-invalid @enderror"
                                            value="{{ old('tanggal_pinjam', date('Y-m-d')) }}" required>
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
                                        <input type="date" name="tanggal_kembali_rencana" class="form-control @error('tanggal_kembali_rencana') is-invalid @enderror"
                                            value="{{ old('tanggal_kembali_rencana') }}" required>
                                        @error('tanggal_kembali_rencana')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Pilih Buku --}}
                                <div class="row mb-4 align-items-start">
                                    <div class="col-lg-4">
                                        <label class="fw-semibold">Pilih Buku <span class="text-danger">*</span></label>
                                        <small class="text-muted d-block">Pilih minimal 1 buku</small>
                                    </div>
                                    <div class="col-lg-8">
                                        <div class="border rounded p-3" style="max-height: 300px; overflow-y: auto;">
                                            @foreach($buku as $item)
    @php
        $disabled = $item->stok == 0;
    @endphp

    <div class="form-check mb-2 {{ $disabled ? 'opacity-50' : '' }}">
        <input class="form-check-input" type="checkbox" 
               name="buku_ids[]" value="{{ $item->id }}" 
               id="buku{{ $item->id }}"
               {{ $disabled ? 'disabled' : '' }}
               {{ is_array(old('buku_ids')) && in_array($item->id, old('buku_ids')) ? 'checked' : '' }}>

        <label class="form-check-label" for="buku{{ $item->id }}">
            <strong>{{ $item->judul }}</strong> - {{ $item->pengarang }}

            <small class="text-muted">
                ({{ $item->kategori->nama_kategori }})
            </small>

            {{-- 🔥 STATUS --}}
            @if($item->stok == 0)
                <span class="badge bg-danger ms-2">Stok Habis</span>
            @else
                <span class="badge bg-soft-success text-success ms-2">
                    Stok: {{ $item->stok }}
                </span>
            @endif
        </label>
    </div>
@endforeach
                                        </div>
                                        @error('buku_ids')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                            </div>
                            <div class="card-footer d-flex gap-2 justify-content-end">
                                <a href="{{ route('peminjaman.index') }}" class="btn btn-light">Batal</a>
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