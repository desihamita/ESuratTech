<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\DivisiController;
use App\Http\Controllers\KlasifikasiController;
use App\Http\Controllers\SuratMasukController;

// Public Routes
Route::get('/', [UserController::class, 'login'])->name('login');
Route::post('/login-proses', [UserController::class, 'login_proses'])->name('login-proses');
Route::get('/logout', [UserController::class, 'logout'])->name('logout');

Route::get('/register', [UserController::class, 'register'])->name('register');
Route::post('/register-proses', [UserController::class, 'register_proses'])->name('register-proses');

// Protected Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home.index');

    Route::get('/profile', [ProfilController::class, 'index'])->name('profile.index');
    Route::put('/profile/update', [ProfilController::class, 'update'])->name('profile.update');

    Route::get('/surat-masuk', [SuratMasukController::class, 'index'])->name('suratmasuk.index');
    Route::get('/surat-masuk/create', [SuratMasukController::class, 'create'])->name('suratmasuk.create');
    Route::post('/surat-masuk/store', [SuratMasukController::class, 'store'])->name('suratmasuk.store');
    Route::get('/surat-masuk/detail/{id}', [SuratMasukController::class, 'detail'])->name('suratmasuk.detail');

    Route::post('/surat-masuk/disposisi', [SuratMasukController::class, 'storeDisposisi'])->name('suratmasuk.storeDisposisi');

    Route::get('/divisi', [DivisiController::class, 'index'])->name('divisi.index');
    Route::post('/divisi/store', [DivisiController::class, 'store'])->name('divisi.store');
    Route::get('/divisi/{id}/edit', [DivisiController::class, 'edit'])->name('divisi.edit');
    Route::put('/divisi/{id}', [DivisiController::class, 'update'])->name('divisi.update');
    Route::get('/divisi/detail/{id}', [DivisiController::class, 'detail'])->name('divisi.detail');

    Route::get('/klasifikasi', [KlasifikasiController::class, 'index'])->name('klasifikasi.index');
    Route::post('/klasifikasi/store', [KlasifikasiController::class, 'store'])->name('klasifikasi.store');
    Route::get('/klasifikasi/create', [KlasifikasiController::class, 'create'])->name('klasifikasi.create');
    Route::get('/klasifikasi/{id}/edit', [KlasifikasiController::class, 'edit'])->name('klasifikasi.edit');
    Route::put('/klasifikasi/{id}', [KlasifikasiController::class, 'update'])->name('klasifikasi.update');
    Route::get('/klasifikasi/detail/{id}', [KlasifikasiController::class, 'detail'])->name('klasifikasi.detail');
});