<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\SemesterController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MataPelajaranController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\PenugasanGuruController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return redirect()->route('login');
});

// Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [ForgotPasswordController::class, 'reset'])->name('password.update');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});



// Dashboard Admin (hanya role admin)
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return 'Dashboard Admin - Coming Soon';
    })->name('admin.dashboard');
});

// Dashboard Guru (hanya role guru)
Route::middleware(['auth', 'role:guru'])->prefix('guru')->group(function () {
    Route::get('/dashboard', function () {
        return 'Dashboard Guru - Coming Soon';
    })->name('guru.dashboard');
});

// Dashboard Guru BK (hanya role guru_bk)
Route::middleware(['auth', 'role:guru_bk'])->prefix('guru-bk')->group(function () {
    Route::get('/dashboard', function () {
        return 'Dashboard Guru BK - Coming Soon';
    })->name('guru-bk.dashboard');
});

Route::middleware(['auth', 'role:admin'])->prefix('master')->group(function () {
    Route::get('/tahun-ajaran-semester', [SemesterController::class, 'index'])->name('master.semester.index');
    Route::post('/tahun-ajaran', [SemesterController::class, 'storeTahunAjaran'])->name('master.tahun-ajaran.store');
    Route::post('/semester', [SemesterController::class, 'storeSemester'])->name('master.semester.store');
    Route::patch('/semester/{semester}/aktifkan', [SemesterController::class, 'aktifkan'])->name('master.semester.aktifkan');
    Route::get('/mata-pelajaran', [MataPelajaranController::class, 'index'])->name('master.mata-pelajaran.index');
Route::post('/mata-pelajaran', [MataPelajaranController::class, 'store'])->name('master.mata-pelajaran.store');
Route::patch('/mata-pelajaran/{mataPelajaran}', [MataPelajaranController::class, 'update'])->name('master.mata-pelajaran.update');
Route::delete('/mata-pelajaran/{mataPelajaran}', [MataPelajaranController::class, 'destroy'])->name('master.mata-pelajaran.destroy');

Route::get('/kelas', [KelasController::class, 'index'])->name('master.kelas.index');
Route::post('/kelas', [KelasController::class, 'store'])->name('master.kelas.store');
Route::patch('/kelas/{kelas}', [KelasController::class, 'update'])->name('master.kelas.update');
Route::delete('/kelas/{kelas}', [KelasController::class, 'destroy'])->name('master.kelas.destroy');

Route::get('/siswa', [SiswaController::class, 'index'])->name('master.siswa.index');
Route::post('/siswa', [SiswaController::class, 'store'])->name('master.siswa.store');
Route::patch('/siswa/{siswa}', [SiswaController::class, 'update'])->name('master.siswa.update');
Route::delete('/siswa/{siswa}', [SiswaController::class, 'destroy'])->name('master.siswa.destroy');

Route::get('/penugasan-guru', [PenugasanGuruController::class, 'index'])->name('master.penugasan-guru.index');
Route::post('/penugasan-guru', [PenugasanGuruController::class, 'store'])->name('master.penugasan-guru.store');
Route::delete('/penugasan-guru/{penugasanGuru}', [PenugasanGuruController::class, 'destroy'])->name('master.penugasan-guru.destroy');

Route::get('/users', [UserController::class, 'index'])->name('master.users.index');
Route::post('/users', [UserController::class, 'store'])->name('master.users.store');
Route::patch('/users/{user}', [UserController::class, 'update'])->name('master.users.update');
Route::patch('/users/{user}/reset-password', [UserController::class, 'resetPassword'])->name('master.users.reset-password');
Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('master.users.destroy');
});