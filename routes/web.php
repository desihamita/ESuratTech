<?php

use App\Http\Controllers\DisposisiController;

use Faker\Guesser\Name;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\DivisiController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\SuratMasukController;
use App\Http\Controllers\KlasifikasiController;
use App\Http\Controllers\SuratKeluarController;
use App\Http\Controllers\StatusSuratController;
use App\Http\Controllers\LaporanSuratMasukController;
use App\Http\Controllers\LaporanSuratKeluarController;
use App\Http\Controllers\FilterData\FilterDataMasukController;
use App\Http\Controllers\FilterData\FilterDataKeluarkController;
use App\Http\Controllers\LembagaController;

// Public Routes
Route::get('/', [UserController::class, 'login'])->name('login');
Route::post('/login-proses', [UserController::class, 'login_proses'])->name('login-proses');
Route::get('/logout', [UserController::class, 'logout'])->name('logout');

Route::get('/register', [UserController::class, 'register'])->name('register');
Route::post('/register-proses', [UserController::class, 'register_proses'])->name('register-proses');

// Protected Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home.index');

    // profile
    Route::get('/profile', [ProfilController::class, 'index'])->name('profile.index');
    Route::put('/profile/update', [ProfilController::class, 'update'])->name('profile.update');
    Route::delete('/profile/delete', [ProfilController::class, 'deletePhoto'])->name('photo.delete');

    // kelola pengguna 
    Route::get('/user', [ProfilController::class, 'indexDatatable'])->name('user.index');
    Route::post('/user/create', [ProfilController::class, 'store'])->name('user.store');
    Route::post('/user/update/{id}', [ProfilController::class, 'update'])->name('user.update');
    Route::put('/user/delete/{id}', [ProfilController::class, 'destroy'])->name('user.delete');

    // surat masuk
    Route::get('/surat-masuk', [SuratMasukController::class, 'index'])->name('suratmasuk.index');
    Route::get('/surat-masuk/create', [SuratMasukController::class, 'create'])->name('suratmasuk.create');
    Route::post('/surat-masuk/store', [SuratMasukController::class, 'store'])->name('suratmasuk.store');
    Route::post('/surat-masuk/update/{id}', [SuratMasukController::class, 'update'])->name('suratmasuk.update');
    Route::post('/surat-masuk/delete/{id}', [SuratMasukController::class, 'destroy'])->name('suratmasuk.delete');
    Route::get('/surat-masuk/detail/{id}', [SuratMasukController::class, 'detail'])->name('suratmasuk.detail');
    
    Route::post('/surat-masuk/disposisi', [SuratMasukController::class, 'storeDisposisi'])->name('suratmasuk.storeDisposisi');

    // surat keluar controller
    Route::get('/surat-keluar', [SuratKeluarController::class, 'index'])->name('suratkeluar.index');
    Route::post('/surat-keluar/store', [SuratKeluarController::class, 'store'])->name('suratkeluar.store');
    Route::post('/surat-keluar/update/{id}', [SuratKeluarController::class, 'update'])->name('suratkeluar.update');
    Route::post('/surat-keluar/delete/{id}', [SuratKeluarController::class, 'destroy'])->name('suratkeluar.delete');
    Route::get('/surat-keluar/detail/{id}', [SuratKeluarController::class, 'detail'])->name('suratkeluar.detail');
    Route::post('/generate-nomor-surat', [SuratKeluarController::class, 'generateNomorSurat'])->name('generate.nomor_surat');
    Route::get('/surat-keluar/cetak/{id}', [SuratKeluarController::class, 'cetak'])->name('suratKeluar.cetak');

    Route::get('status-surat', [StatusSuratController::class,'index'])->name('status_surat.index');

    Route::get('/diposisi', [DisposisiController::class,'index'])->name('disposisi.index');
    Route::get('/diposisi/store', [DisposisiController::class,'store'])->name('disposisi.store');
    Route::put('/diposisi/{id}/update-status', [DisposisiController::class, 'updateStatus'])->name('disposisi.updateStatus');
    Route::get('/disposisi/{id}/pdf', [DisposisiController::class, 'generatePDF'])->name('disposisi.pdf');

    Route::get('/divisi', [DivisiController::class, 'index'])->name('divisi.index');
    Route::post('/divisi/store', [DivisiController::class, 'store'])->name('divisi.store');
    Route::get('/divisi/{id}/edit', [DivisiController::class, 'edit'])->name('divisi.edit');
    Route::put('/divisi/{id}', [DivisiController::class, 'update'])->name('divisi.update');
    Route::post('/divisi/delete/{id}', [DivisiController::class, 'destroy'])->name('divisi.delete');
    Route::get('/divisi/detail/{id}', [DivisiController::class, 'detail'])->name('divisi.detail');

    // klasifikasi
    Route::get('/klasifikasi', [KlasifikasiController::class, 'index'])->name('klasifikasi.index');
    Route::post('/klasifikasi/store', [KlasifikasiController::class, 'store'])->name('klasifikasi.store');
    Route::get('/klasifikasi/create', [KlasifikasiController::class, 'create'])->name('klasifikasi.create');
    Route::get('/klasifikasi/{id}/edit', [KlasifikasiController::class, 'edit'])->name('klasifikasi.edit');
    Route::put('/klasifikasi/{id}', [KlasifikasiController::class, 'update'])->name('klasifikasi.update');
    Route::post('/klasifikasi/delete/{id}', [KlasifikasiController::class, 'destroy'])->name('klasifikasi.delete');
    Route::get('/klasifikasi/detail/{id}', [KlasifikasiController::class, 'detail'])->name('klasifikasi.detail');

    //laporan surat masuk 
    Route::get('/laporan/surat-masuk', [LaporanSuratMasukController::class, 'index'])->name('laporanSuratMasuk.indes');
    Route::get('/laporan/filter-surat-masuk', [LaporanSuratMasukController::class, 'filter']);
    Route::get('/laporan/export-pdf-surat-masuk', [LaporanSuratMasukController::class, 'exportPdf'])->name('laporanSuratMasuk.export-pdf');
    Route::get('/laporan/export-excel-surat-masuk', [LaporanSuratMasukController::class, 'exportExcel'])->name('laporanSuratMasuk.export-excel');

    // filter form surat
    Route::post('filter/suratmasuk',[FilterDataMasukController::class, 'filterSuratMasuk'])->name('filter.Suratmasuk');
    Route::post('filter/suratkeluar', [FilterDataKeluarkController::class, 'filterSuratKeluar'])->name('filter.Suratkeluar');

    //laporan surat keluar 
    Route::get('/laporan/surat-keluar', [LaporanSuratKeluarController::class, 'index'])->name('laporanSuratKeluar.indes');
    Route::get('/laporan/filter-surat-keluar', [LaporanSuratKeluarController::class, 'filter']);
    Route::get('/laporan/export-pdf-surat-keluar', [LaporanSuratKeluarController::class, 'exportPdf'])->name('laporanSuratKeluar.export-pdf');
    Route::get('/laporan/export-excel-surat-keluar', [LaporanSuratKeluarController::class, 'exportExcel'])->name('laporanSuratKeluar.export-excel');

    Route::get('/klasifikasi/{id}/edit', [KlasifikasiController::class, 'edit'])->name('klasifikasi.edit');
    Route::put('/klasifikasi/{id}', [KlasifikasiController::class, 'update'])->name('klasifikasi.update');
    
    Route::get('/lembaga', [LembagaController::class, 'edit'])->name('lembaga.edit');
    Route::put('/lembaga/update/', [LembagaController::class, 'update'])->name('lembaga.update');
    Route::put('/lembaga/update/logo/', [LembagaController::class, 'updateLogo'])->name('lembaga.updateLogo');
});