@extends('layouts.layout')

@section('content')
    <main class="nxl-container">
        <div class="nxl-content">
            <div class="page-header">
                <div class="page-header-left d-flex align-items-center">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Tambah User</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('anggota.index')}}">User</a></li>
                        <li class="breadcrumb-item">Tambah</li>
                    </ul>
                </div>
            </div>
            
            <div class="main-content">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card stretch stretch-full">
                            <div class="card-header">
                                <h5 class="card-title">Form Tambah User</h5>
                            </div>
                            
                            <form action="{{route('anggota.store')}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    <!-- Informasi Akun -->
                                    <div class="mb-4">
                                        <h6 class="fw-bold mb-3">Informasi Akun</h6>
                                    </div>
                                    
                                    <div class="row mb-4 align-items-center">
                                        <div class="col-lg-4">
                                            <label for="nameInput" class="fw-semibold">Nama Lengkap: <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-lg-8">
                                            <div class="input-group">
                                                <div class="input-group-text"><i class="feather-user"></i></div>
                                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                                       id="nameInput" name="name" placeholder="Masukkan nama lengkap" 
                                                       value="{{old('name')}}" required>
                                            </div>
                                            @error('name')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-4 align-items-center">
                                        <div class="col-lg-4">
                                            <label for="emailInput" class="fw-semibold">Email: <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-lg-8">
                                            <div class="input-group">
                                                <div class="input-group-text"><i class="feather-mail"></i></div>
                                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                                       id="emailInput" name="email" placeholder="Masukkan email" 
                                                       value="{{old('email')}}" required>
                                            </div>
                                            @error('email')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-4 align-items-center">
                                        <div class="col-lg-4">
                                            <label for="passwordInput" class="fw-semibold">Password: <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-lg-8">
                                            <div class="input-group">
                                                <div class="input-group-text"><i class="feather-lock"></i></div>
                                                <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                                       id="passwordInput" name="password" placeholder="Masukkan password" required>
                                            </div>
                                            @error('password')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-4 align-items-center">
                                        <div class="col-lg-4">
                                            <label for="passwordConfirmInput" class="fw-semibold">Konfirmasi Password: <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-lg-8">
                                            <div class="input-group">
                                                <div class="input-group-text"><i class="feather-lock"></i></div>
                                                <input type="password" class="form-control" 
                                                       id="passwordConfirmInput" name="password_confirmation" 
                                                       placeholder="Konfirmasi password" required>
                                            </div>
                                        </div>
                                    </div>
                                        <div class="row mb-4 align-items-center">
                                            <div class="col-lg-4">
                                                <label for="nisInput" class="fw-semibold">NIS: <span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-lg-8">
                                                <div class="input-group">
                                                    <div class="input-group-text"><i class="feather-hash"></i></div>
                                                    <input type="text" class="form-control @error('nis') is-invalid @enderror" 
                                                           id="nisInput" name="nis" placeholder="Masukkan NIS" 
                                                           value="{{old('nis')}}">
                                                </div>
                                                @error('nis')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-4 align-items-center">
                                            <div class="col-lg-4">
                                                <label for="kelasInput" class="fw-semibold">Kelas: <span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-lg-8">
                                                <div class="input-group">
                                                    <div class="input-group-text"><i class="feather-book"></i></div>
                                                    <input type="text" class="form-control @error('kelas') is-invalid @enderror" 
                                                           id="kelasInput" name="kelas" placeholder="Contoh: XII RPL 1" 
                                                           value="{{old('kelas')}}">
                                                </div>
                                                @error('kelas')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-4 align-items-center">
                                            <div class="col-lg-4">
                                                <label for="noTlpInput" class="fw-semibold">No. Telepon: <span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-lg-8">
                                                <div class="input-group">
                                                    <div class="input-group-text"><i class="feather-phone"></i></div>
                                                    <input type="text" class="form-control @error('no_tlp') is-invalid @enderror" 
                                                           id="noTlpInput" name="no_tlp" placeholder="Contoh: 08123456789" 
                                                           value="{{old('no_tlp')}}">
                                                </div>
                                                @error('no_tlp')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-4 align-items-center">
                                            <div class="col-lg-4">
                                                <label class="fw-semibold">Jenis Kelamin: <span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-lg-8">
                                                <select class="form-control @error('jenis_kelamin') is-invalid @enderror" name="jenis_kelamin">
                                                    <option value="">Pilih Jenis Kelamin</option>
                                                    <option value="Laki-laki" {{old('jenis_kelamin') == 'Laki-laki' ? 'selected' : ''}}>Laki-laki</option>
                                                    <option value="Perempuan" {{old('jenis_kelamin') == 'Perempuan' ? 'selected' : ''}}>Perempuan</option>
                                                </select>
                                                @error('jenis_kelamin')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer d-flex gap-2 justify-content-end">
                                        <a href="{{route('anggota.index')}}" class="btn btn-light">
                                            <i class="feather-x me-2"></i>Batal
                                        </a>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="feather-save me-2"></i>Simpan
                                        </button>
                                    </div>
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