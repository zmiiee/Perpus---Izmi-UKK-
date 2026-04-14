@extends('layouts.layout')

@section('content')
<main class="nxl-container">
    <div class="nxl-content">
        <div class="page-header">
            <div class="page-header-left d-flex align-items-center">
                <div class="page-header-title">
                    <h5 class="m-b-10">Pinjam Buku</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('user.peminjaman.index') }}">Peminjaman Saya</a></li>
                    <li class="breadcrumb-item">Pinjam Buku</li>
                </ul>
            </div>
        </div>

        <div class="main-content">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card stretch stretch-full">
                        <div class="card-header">
                            <h5 class="card-title">Form Peminjaman Buku</h5>
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

                        @if(session('error'))
                            <div class="alert alert-danger mx-4 mt-3">{{ session('error') }}</div>
                        @endif

                        <form action="{{ route('user.peminjaman.store') }}" method="POST">
                            @csrf
                            <div class="card-body">

                                <div class="alert alert-info">
                                    <strong>Informasi:</strong>
                                    <ul class="mb-0">
                                        <li>Maksimal meminjam 3 buku sekaligus</li>
                                        <li>Durasi peminjaman maksimal 7 hari</li>
                                        <li>Denda keterlambatan Rp 1.000/hari/buku</li>
                                        @if(count($bukuSedangDipinjam) > 0)
                                        <li class="text-danger">Anda sedang meminjam {{ count($bukuSedangDipinjam) }} buku yang belum dikembalikan</li>
                                        @endif
                                    </ul>
                                </div>

                                {{-- Tanggal Pinjam --}}
                                <div class="row mb-4 align-items-center">
                                    <div class="col-lg-4">
                                        <label class="fw-semibold">Tanggal Pinjam <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-lg-8">
                                        <input type="date" name="tanggal_pinjam" class="form-control @error('tanggal_pinjam') is-invalid @enderror"
                                            value="{{ old('tanggal_pinjam', date('Y-m-d')) }}" required readonly>
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
                                            value="{{ old('tanggal_kembali_rencana', date('Y-m-d', strtotime('+7 days'))) }}" 
                                            min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                            max="{{ date('Y-m-d', strtotime('+7 days')) }}"
                                            required>
                                        <small class="text-muted">Maksimal 7 hari dari hari ini</small>
                                        @error('tanggal_kembali_rencana')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Pilih Buku --}}
                                <div class="row mb-4 align-items-start">
                                    <div class="col-lg-4">
                                        <label class="fw-semibold">Pilih Buku <span class="text-danger">*</span></label>
                                        <small class="text-muted d-block">Pilih 1-3 buku</small>
                                    </div>
                                    <div class="col-lg-8">
                                        <div class="border rounded p-3" style="max-height: 400px; overflow-y: auto;">
                                            @foreach($buku as $item)
    @php
        $sedangDipinjam = in_array($item->id, $bukuSedangDipinjam);
        $disabled = $sedangDipinjam || $item->stok == 0;
    @endphp

    <div class="form-check mb-3 {{ $disabled ? 'opacity-50' : '' }}">
        <input class="form-check-input buku-checkbox" type="checkbox" 
               name="buku_ids[]" value="{{ $item->id }}" 
               id="buku{{ $item->id }}"
               {{ $disabled ? 'disabled' : '' }}
               {{ is_array(old('buku_ids')) && in_array($item->id, old('buku_ids')) ? 'checked' : '' }}>
                                                    <label class="form-check-label w-100" for="buku{{ $item->id }}">
                                                        <div class="d-flex">
                                                            @if($item->cover)
                                                                <img src="{{ asset('storage/' . $item->cover) }}" 
                                                                     width="60" height="80" class="me-3" style="object-fit: cover;">
                                                            @else
                                                                <div class="bg-light me-3 d-flex align-items-center justify-content-center" 
                                                                     style="width: 60px; height: 80px;">
                                                                    <i class="feather-book"></i>
                                                                </div>
                                                            @endif
                                                            <div class="flex-grow-1">
                                                                <strong>{{ $item->judul }}</strong>

@if($sedangDipinjam)
    <span class="badge bg-soft-warning text-warning ms-2">Sedang Anda Pinjam</span>
@elseif($item->stok == 0)
    <span class="badge bg-danger ms-2">Stok Habis</span>
@else
    <span class="badge bg-soft-success text-success ms-2">Stok: {{ $item->stok }}</span>
@endif
                                                                <br>
                                                                <small class="text-muted">
                                                                    {{ $item->pengarang }}<br>
                                                                    {{ $item->kategori->nama_kategori }} • {{ $item->tahun_terbit }}
                                                                </small>
                                                            </div>
                                                        </div>
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
                                <a href="{{ route('user.peminjaman.index') }}" class="btn btn-light">Batal</a>
                                <button type="submit" class="btn btn-primary">Ajukan Peminjaman</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
        @include('layouts.footer')
    </div>
</main>

<div class="modal fade" id="kuotaModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title text-white">Batas Peminjaman</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center p-4">
                <i class="feather-info text-warning mb-3" style="font-size: 3rem;"></i>
                <p id="kuotaMessage" class="fs-14 fw-medium"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary w-100" data-bs-dismiss="modal">Mengerti</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Inisialisasi Modal Bootstrap
    const modalElement = document.getElementById('kuotaModal');
    const kuotaModal = new bootstrap.Modal(modalElement);
    const messageEl = document.getElementById('kuotaMessage');
    
    const checkboxes = document.querySelectorAll('.buku-checkbox:not([disabled])');
    
    // Ambil data limit dari PHP
    const jumlahAktif = {{ count($bukuSedangDipinjam) }};
    const maxBolehDipilih = 3 - jumlahAktif;

    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const checkedCount = document.querySelectorAll('.buku-checkbox:checked:not([disabled])').length;
            
            if (checkedCount > maxBolehDipilih) {
                // Batalkan centang yang barusan diklik
                this.checked = false;
                
                // Set isi pesan modal secara dinamis
                if (maxBolehDipilih <= 0) {
                    messageEl.innerText = 'Anda sudah mencapai batas maksimal peminjaman (3 buku). Silakan kembalikan buku yang sedang dipinjam terlebih dahulu.';
                } else {
                    messageEl.innerText = 'Batas maksimal peminjaman adalah 3 buku. Karena Anda sedang meminjam ' + jumlahAktif + ' buku, Anda hanya bisa menambah ' + maxBolehDipilih + ' buku lagi.';
                }

                // Tampilkan Modal
                kuotaModal.show();
            }
        });
    });
});
</script>
@endsection