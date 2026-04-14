@extends('layouts.layout')

@section('content')
<main class="nxl-container">
    <div class="nxl-content">
        <div class="page-header">
            <div class="page-header-left d-flex align-items-center">
                <div class="page-header-title">
                    <h5 class="m-b-10">Detail User</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('anggota.index') }}">User</a>
                    </li>
                    <li class="breadcrumb-item">Detail</li>
                </ul>
            </div>
        </div>

        <div class="main-content">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card stretch stretch-full">
                        <div class="card-header">
                            <h5 class="card-title">Informasi User</h5>
                        </div>

                        <div class="card-body">
                            {{-- Informasi Akun --}}
                            <h6 class="fw-bold mb-3">Informasi Akun</h6>

                            <div class="row mb-3">
                                <div class="col-lg-4 fw-semibold">Nama Lengkap</div>
                                <div class="col-lg-8">: {{ $anggota->user->name }}</div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-lg-4 fw-semibold">Email</div>
                                <div class="col-lg-8">: {{ $anggota->user->email }}</div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-lg-4 fw-semibold">Role</div>
                                <div class="col-lg-8">: {{ $anggota->user->role }}</div>
                            </div>

                            <hr class="my-4">

                            {{-- Informasi Anggota --}}
                            <h6 class="fw-bold mb-3">Informasi Anggota</h6>

                            <div class="row mb-3">
                                <div class="col-lg-4 fw-semibold">NIS</div>
                                <div class="col-lg-8">: {{ $anggota->nis }}</div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-lg-4 fw-semibold">Kelas</div>
                                <div class="col-lg-8">: {{ $anggota->kelas }}</div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-lg-4 fw-semibold">No. Telepon</div>
                                <div class="col-lg-8">: {{ $anggota->no_tlp }}</div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-lg-4 fw-semibold">Jenis Kelamin</div>
                                <div class="col-lg-8">: {{ $anggota->jenis_kelamin }}</div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-lg-4 fw-semibold">Tanggal Dibuat</div>
                                <div class="col-lg-8">
                                    : {{ $anggota->created_at->format('d M Y') }}
                                </div>
                            </div>
                        </div>

                        <div class="card-footer d-flex justify-content-end gap-2">
                            <a href="{{ route('anggota.index') }}" class="btn btn-light">
                                Kembali
                            </a>
                            <a href="{{ route('anggota.edit', $anggota->id) }}" class="btn btn-primary">
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