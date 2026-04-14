@extends('layouts.layout')

@section('content')
<main class="nxl-container">
    <div class="nxl-content">
        <div class="page-header">
            <div class="page-header-left d-flex align-items-center">
                <div class="page-header-title">
                    <h5 class="m-b-10">Edit User</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('anggota.index') }}">User</a>
                    </li>
                    <li class="breadcrumb-item">Edit</li>
                </ul>
            </div>
        </div>

        <div class="main-content">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card stretch stretch-full">
                        <div class="card-header">
                            <h5 class="card-title">Form Edit User</h5>
                        </div>

                        <form action="{{ route('anggota.update', $anggota->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="card-body">
                                <h6 class="fw-bold mb-3">Informasi User</h6>

                                {{-- Nama --}}
                                <div class="row mb-4 align-items-center">
                                    <div class="col-lg-4">
                                        <label class="fw-semibold">Nama Lengkap</label>
                                    </div>
                                    <div class="col-lg-8">
                                        <input type="text" name="name"
                                            class="form-control @error('name') is-invalid @enderror"
                                            value="{{ old('name', $anggota->user->name) }}" required>
                                        @error('name')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Email --}}
                                <div class="row mb-4 align-items-center">
                                    <div class="col-lg-4">
                                        <label class="fw-semibold">Email</label>
                                    </div>
                                    <div class="col-lg-8">
                                        <input type="email" name="email"
                                            class="form-control @error('email') is-invalid @enderror"
                                            value="{{ old('email', $anggota->user->email) }}" required>
                                        @error('email')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <hr class="my-4">
                                <h6 class="fw-bold mb-3">Informasi Anggota</h6>

                                {{-- NIS --}}
                                <div class="row mb-4 align-items-center">
                                    <div class="col-lg-4">
                                        <label class="fw-semibold">NIS</label>
                                    </div>
                                    <div class="col-lg-8">
                                        <input type="text" name="nis"
                                            class="form-control @error('nis') is-invalid @enderror"
                                            value="{{ old('nis', $anggota->nis) }}" required>
                                        @error('nis')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Kelas --}}
                                <div class="row mb-4 align-items-center">
                                    <div class="col-lg-4">
                                        <label class="fw-semibold">Kelas</label>
                                    </div>
                                    <div class="col-lg-8">
                                        <input type="text" name="kelas"
                                            class="form-control @error('kelas') is-invalid @enderror"
                                            value="{{ old('kelas', $anggota->kelas) }}" required>
                                        @error('kelas')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                {{-- No Telp --}}
                                <div class="row mb-4 align-items-center">
                                    <div class="col-lg-4">
                                        <label class="fw-semibold">No. Telepon</label>
                                    </div>
                                    <div class="col-lg-8">
                                        <input type="text" name="no_tlp"
                                            class="form-control @error('no_tlp') is-invalid @enderror"
                                            value="{{ old('no_tlp', $anggota->no_tlp) }}" required>
                                        @error('no_tlp')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Jenis Kelamin --}}
                                <div class="row mb-4 align-items-center">
                                    <div class="col-lg-4">
                                        <label class="fw-semibold">Jenis Kelamin</label>
                                    </div>
                                    <div class="col-lg-8">
                                        <select name="jenis_kelamin"
                                            class="form-control @error('jenis_kelamin') is-invalid @enderror"
                                            required>
                                            <option value="">Pilih</option>
                                            <option value="Laki-laki"
                                                {{ old('jenis_kelamin', $anggota->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>
                                                Laki-laki
                                            </option>
                                            <option value="Perempuan"
                                                {{ old('jenis_kelamin', $anggota->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>
                                                Perempuan
                                            </option>
                                        </select>
                                        @error('jenis_kelamin')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer d-flex justify-content-end gap-2">
                                <a href="{{ route('anggota.index') }}" class="btn btn-light">
                                    Batal
                                </a>
                                <button class="btn btn-primary" type="submit">
                                    Simpan Perubahan
                                </button>
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
