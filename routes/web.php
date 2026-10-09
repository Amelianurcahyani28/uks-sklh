<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KunjunganController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/layanan', [HomeController::class, 'layanan'])->name('public.layanan');
Route::get('/ringkasan', [HomeController::class, 'summary'])->name('public.ringkasan');
Route::get('/kunjungan-publik', [HomeController::class, 'kunjunganPublic'])->name('public.kunjungan');
Route::get('/isi-kunjungan', [HomeController::class, 'createVisit'])->name('public.kunjungan.create');
Route::post('/isi-kunjungan', [KunjunganController::class, 'store'])->name('public.kunjungan.store');
Route::get('/hubungi', [HomeController::class, 'hubungi'])->name('public.hubungi');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'create'])->name('login');
    Route::post('/login', [AuthController::class, 'store'])->name('login.store');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'destroy'])->name('logout');
    Route::get('/dashboard', [KunjunganController::class, 'dashboard'])->name('dashboard');
    Route::get('/admin/ringkasan', [KunjunganController::class, 'ringkasanAdmin'])->name('admin.ringkasan');
    Route::get('/kunjungan', [KunjunganController::class, 'index'])->name('kunjungan.index');
    Route::get('/kunjungan/create', [KunjunganController::class, 'create'])->name('kunjungan.create');
    Route::post('/kunjungan', [KunjunganController::class, 'store'])->name('kunjungan.store');
    Route::get('/kunjungan/{visit}/edit', [KunjunganController::class, 'edit'])->name('kunjungan.edit');
    Route::put('/kunjungan/{visit}', [KunjunganController::class, 'update'])->name('kunjungan.update');
    Route::delete('/kunjungan/{visit}', [KunjunganController::class, 'destroy'])->name('kunjungan.destroy');
    Route::get('/siswa', [StudentController::class, 'index'])->name('students.index');
    Route::get('/siswa/create', [StudentController::class, 'create'])->name('students.create');
    Route::post('/siswa', [StudentController::class, 'store'])->name('students.store');
    Route::get('/siswa/{student}/edit', [StudentController::class, 'edit'])->name('students.edit');
    Route::put('/siswa/{student}', [StudentController::class, 'update'])->name('students.update');
    Route::delete('/siswa/{student}', [StudentController::class, 'destroy'])->name('students.destroy');
});
