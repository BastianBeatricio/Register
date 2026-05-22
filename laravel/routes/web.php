<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;

// Gerbang Pengunjung (Belum Login)
Route::middleware('guest')->group(function () {
    Route::get('/signup', [AuthController::class, 'showSignup'])->name('signup');
    Route::post('/signup', [AuthController::class, 'signup']);
    Route::get('/signin', [AuthController::class, 'showSignin'])->name('login');
    Route::post('/signin', [AuthController::class, 'signin']);
});

// Gerbang Mahasiswa (Wajib Login)
Route::middleware('auth')->group(function () {
    // Halaman Ringkasan Utama
    Route::get('/dashboard', [HomeController::class, 'index'])->name('home');
    Route::get('/', function () { return redirect()->route('home'); });
    
    // Fitur Keamanan Akun (Ubah Password)
    Route::get('/ubah-password', [HomeController::class, 'editPassword'])->name('password.edit');
    Route::post('/ubah-password', [HomeController::class, 'updatePassword'])->name('password.update');
    
    // Halaman Manajemen Tugas Akun (To-Do)
    Route::get('/tugas', [HomeController::class, 'halamanTugas'])->name('tugas.index');
    Route::post('/todo/store', [HomeController::class, 'storeTodo'])->name('todo.store');
    Route::post('/todo/done/{id}', [HomeController::class, 'updateTodo'])->name('todo.done');

    // Halaman Manajemen Jam Kerja Praktik (Plus-Minus)
    Route::get('/jam-kerja', [HomeController::class, 'halamanJam'])->name('jam.index');
    Route::post('/jam/store', [HomeController::class, 'storeJam'])->name('jam.store');

    // Proses Log Out
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});