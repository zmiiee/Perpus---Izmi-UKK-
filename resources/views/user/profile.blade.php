@extends('layouts.layout')

@section('content')
<style>
    .nxl-content {
        margin-left: 280px; /* Sesuaikan dengan lebar sidebar Anda */
        transition: all 0.3s ease;
    }
    
    /* Menghapus margin sidebar di layar kecil agar responsif */
    @media (max-width: 1024px) {
        .nxl-content {
            margin-left: 0;
        }
    }

    /* Tambahan agar card tidak terlalu menempel satu sama lain */
    .profile-card {
        margin-bottom: 1.5rem;
    }
</style>

<div class="nxl-content">
    <div class="main-content">
        <div class="page-header px-4 py-3 border-bottom bg-white d-flex justify-content-between align-items-center">
            <h2 class="fs-4 fw-bold mb-0">Profil Anggota</h2>
            <span class="badge bg-primary px-3 py-2 text-capitalize">
                {{ auth()->user()->role }}
            </span>
        </div>

        <div class="p-4">
            <div class="row">
                
                <div class="col-12 profile-card">
                    <div class="card shadow-sm border-0 p-5">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-4" style="width: 80px; height: 80px; font-size: 28px; flex-shrink: 0;">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <div>
                                <h4 class="fw-bold mb-1">{{ auth()->user()->name }}</h4>
                                <p class="text-muted mb-1">{{ auth()->user()->email }}</p>
                                <span class="badge bg-light text-dark border">{{ $anggota->kelas }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-white border-bottom py-3">
                            <h5 class="mb-0 fw-bold">Informasi Detail</h5>
                        </div>
                        <div class="card-body">
                            <div class="row py-2 border-bottom">
                                <div class="col-sm-3 text-muted">Nomor Induk Siswa (NIS)</div>
                                <div class="col-sm-9 fw-semibold text-primary">{{ $anggota->nis }}</div>
                            </div>
                            <div class="row py-2 border-bottom">
                                <div class="col-sm-3 text-muted">Kelas</div>
                                <div class="col-sm-9">{{ $anggota->kelas }}</div>
                            </div>
                            <div class="row py-2 border-bottom">
                                <div class="col-sm-3 text-muted">Jenis Kelamin</div>
                                <div class="col-sm-9">{{ $anggota->jenis_kelamin }}</div>
                            </div>
                            <div class="row py-2 border-bottom">
                                <div class="col-sm-3 text-muted">Nomor Telepon</div>
                                <div class="col-sm-9 text-success">{{ $anggota->no_tlp }}</div>
                            </div>
                            <div class="row py-2">
                                <div class="col-sm-3 text-muted">Tanggal Bergabung</div>
                                <div class="col-sm-9">
                                    {{ $anggota->created_at->format('d F Y') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection