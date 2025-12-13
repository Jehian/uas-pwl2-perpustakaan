<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController; // Pastikan nama controller auth sesuai file kamu
use App\Http\Controllers\PublicController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\Admin\BookCopyController;
use App\Http\Controllers\Admin\LoanController;
use Illuminate\Support\Facades\Schedule;

/*
|--------------------------------------------------------------------------
| 1. PUBLIC ROUTES (Area Bebas - Tidak Perlu Login)
|--------------------------------------------------------------------------
*/

// Halaman Depan (Katalog Buku)
Route::get('/', [PublicController::class, 'index'])->name('public.catalog');

// Autentikasi (Login & Register)
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.process');


/*
|--------------------------------------------------------------------------
| 2. ADMIN ROUTES (Area Terproteksi - Wajib Login)
|--------------------------------------------------------------------------
| Semua route di sini otomatis memiliki:
| - Middleware: 'auth'
| - URL Prefix: '/admin/...' (contoh: /admin/books)
| - Name Prefix: 'admin.' (contoh: route('admin.books.index'))
*/

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    
    // --- DASHBOARD ---
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // --- MANAJEMEN MEMBER ---
    Route::resource('members', MemberController::class);
    // Custom: Update Status Member (Aktif/Non-Aktif)
    Route::patch('/members/{id}/update-status', [MemberController::class, 'updateStatus'])
        ->name('members.update_status');

    // --- MANAJEMEN BUKU & KATEGORI ---
    Route::resource('categories', CategoryController::class);
    Route::resource('books', BookController::class);

    // --- MANAJEMEN STOK BUKU (BOOK COPIES) ---
    Route::get('/books/{id}/copies', [BookCopyController::class, 'index'])->name('books.copies.index');
    Route::post('/books/{id}/copies', [BookCopyController::class, 'store'])->name('books.copies.store');
    Route::delete('/copies/{id}', [BookCopyController::class, 'destroy'])->name('books.copies.destroy');

    // --- MANAJEMEN PEMINJAMAN (LOANS) ---
    Route::resource('loans', LoanController::class);
    // Custom: Selesaikan Peminjaman (Kembalikan Buku)
    Route::put('/loans/{id}/complete', [LoanController::class, 'complete'])->name('loans.complete');
    // Custom: Perpanjang / Ubah Tanggal
    Route::put('/loans/{id}/update-date', [LoanController::class, 'updateDueDate'])->name('loans.update_date');

    // Daftarkan perintah pengingat agar jalan setiap hari jam 08:00 pagi
    Schedule::command('loans:send-reminders')->dailyAt('08:00');    
}); 