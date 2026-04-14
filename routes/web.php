<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\UserPeminjamanController;
use App\Http\Controllers\AnggotaDashboardController;

Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.process');

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.process');
});

Route::get('/', [LandingController::class, 'index'])->name('page.index');
Route::get('/buku/detail/{id}', [LandingController::class, 'detail'])->name('buku.detail');

Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::middleware(['role:Admin'])->group(function () {

        Route::resource('anggota', AnggotaController::class);

        Route::resource('kategori', KategoriController::class);

        Route::resource('buku', BukuController::class);

        Route::resource('peminjaman', PeminjamanController::class);

        Route::post('peminjaman/detail/{detailId}/approve', [PeminjamanController::class, 'approveBuku'])->name('peminjaman.approve');
        Route::post('peminjaman/detail/{detailId}/tolak', [PeminjamanController::class, 'tolakBuku'])->name('peminjaman.tolak');

        Route::post('peminjaman/kembalikan/{detail}', [PeminjamanController::class, 'kembalikanBuku'])->name('peminjaman.kembalikan');

        Route::get('/pengembalian', [PeminjamanController::class, 'pengembalian'])->name('pengembalian.index');
        Route::get('pengembalian/{id}', [PeminjamanController::class, 'showPengembalian'])->name('pengembalian.show');
        
        Route::post('/peminjaman/reset', [PeminjamanController::class, 'reset'])
            ->name('peminjaman.reset');
    });
    
    Route::middleware(['role:Anggota'])->group(function () {
        Route::get('/dashboard-anggota', [AnggotaDashboardController::class, 'index'])->name('user.dashboard');

        Route::get('/peminjaman-aktif', [AnggotaDashboardController::class, 'peminjamanAktif'])->name('user.peminjaman.aktif');
        Route::get('/pengembalian-saya', [AnggotaDashboardController::class, 'pengembalian'])->name('user.peminjaman.pengembalian');

        Route::get('/peminjaman-saya/create', [UserPeminjamanController::class, 'create'])->name('user.peminjaman.create');
        Route::post('/peminjaman-saya/store', [UserPeminjamanController::class, 'store'])->name('user.peminjaman.store');
        Route::get('/peminjaman-saya/{id}', [AnggotaDashboardController::class, 'detailPeminjaman'])->name('user.peminjaman.detail');

        Route::post('/peminjaman-saya/kembalikan/{detail}', [UserPeminjamanController::class, 'kembalikanBuku'])
            ->name('user.peminjaman.kembalikan');

        Route::get('/peminjaman-saya', [UserPeminjamanController::class, 'index'])->name('user.peminjaman.index');

        Route::get('user/profile', [AnggotaController::class, 'profile'])->name('user.profile');
        
    });

});