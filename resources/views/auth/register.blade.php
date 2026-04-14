<!DOCTYPE html>
<html lang="zxx">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Literasee | Register </title>
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('duralux/assets/images/favicon.ico')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('duralux/assets/css/bootstrap.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('duralux/assets/vendors/css/vendors.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('duralux/assets/css/theme.min.css')}}">
</head>

<body>
    <main class="auth-minimal-wrapper">
        <div class="auth-minimal-inner">
            <div class="minimal-card-wrapper">
                <div class="card mb-4 mt-5 mx-4 mx-sm-0 position-relative">
                    <div class="card-body p-sm-5">
                        <h2 class="fs-20 fw-bolder mb-4">Register</h2>
                        <h4 class="fs-13 fw-bold mb-2">Buat akun baru</h4>
                        <p class="fs-12 fw-medium text-muted">Silakan isi formulir di bawah ini untuk menjadi anggota perpustakaan.</p>
                        
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('register.process') }}" class="w-100 mt-4 pt-2">
                            @csrf
                            <div class="mb-3">
                                <input type="text" name="name" class="form-control" placeholder="Nama Lengkap" value="{{ old('name') }}" required>
                            </div>
                            <div class="mb-3">
                                <input type="email" name="email" class="form-control" placeholder="Email" value="{{ old('email') }}" required>
                            </div>
                            <div class="mb-3">
                                <input type="text" name="nis" class="form-control" placeholder="NIS" value="{{ old('nis') }}" required>
                            </div>
                            <div class="mb-3">
                                <input type="text" name="kelas" class="form-control" placeholder="Kelas (contoh: XII RPL 1)" value="{{ old('kelas') }}" required>
                            </div>
                            <div class="mb-3">
                                <input type="text" name="no_tlp" class="form-control" placeholder="Nomor Telepon" value="{{ old('no_tlp') }}" required>
                            </div>
                            <div class="mb-3">
                                <select name="jenis_kelamin" class="form-control" required>
                                    <option value="" disabled {{ old('jenis_kelamin') ? '' : 'selected' }}>Pilih Jenis Kelamin</option>
                                    <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                            </div>
                            <div class="mb-4">
                                <input type="password" name="password" class="form-control" placeholder="Password (minimal 6 karakter)" required>
                            </div>
                            <div class="mt-4">
                                <button type="submit" class="btn btn-lg btn-primary w-100">Daftar Sekarang</button>
                            </div>
                        </form>
                      
                        <div class="mt-5 text-muted">
                            <span>Sudah punya akun?</span>
                            <a href="{{ route('login') }}" class="fw-bold">Login di sini</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>