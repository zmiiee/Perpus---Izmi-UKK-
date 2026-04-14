@extends('layouts.layout')

@section('content')
<main class="nxl-container">
    <div class="nxl-content">
        <div class="page-header">
            <div class="page-header-left d-flex align-items-center">
                <div class="page-header-title">
                    <h5 class="m-b-10">Tambah Kategori</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('kategori.index') }}">Kategori</a>
                    </li>
                    <li class="breadcrumb-item">Tambah</li>
                </ul>
            </div>
        </div>

        <div class="main-content">
            <div class="card stretch stretch-full">
                <div class="card-header">
                    <h5 class="card-title">Form Tambah Kategori</h5>
                </div>

                <form action="{{ route('kategori.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="row mb-4 align-items-center">
                            <div class="col-lg-4">
                                <label class="fw-semibold">Nama Kategori</label>
                            </div>
                            <div class="col-lg-8">
                                <input type="text" name="nama_kategori"
                                    class="form-control @error('nama_kategori') is-invalid @enderror"
                                    value="{{ old('nama_kategori') }}" required>
                                @error('nama_kategori')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="card-footer d-flex justify-content-end gap-2">
                        <a href="{{ route('kategori.index') }}" class="btn btn-light">Batal</a>
                        <button class="btn btn-primary">
                            <i class="feather-save me-2"></i>Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
        @include('layouts.footer')
    </div>
</main>
@endsection
