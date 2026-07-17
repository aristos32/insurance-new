<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ClaimController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'show'])->name('login');
    Route::post('/login', [LoginController::class, 'store']);
});

Route::post('/logout', [LoginController::class, 'destroy'])->middleware('auth')->name('logout');

Route::middleware(['auth', 'office:3'])->group(function () {
    Route::get('/', DashboardController::class)->name('dashboard');

    Route::resource('owners', OwnerController::class);
    Route::resource('sales', SaleController::class);

    Route::get('transactions/contract/{sale}', [TransactionController::class, 'index'])->name('transactions.index');
    Route::get('transactions/contract/{sale}/create', [TransactionController::class, 'create'])->name('transactions.create');
    Route::post('transactions/contract/{sale}', [TransactionController::class, 'store'])->name('transactions.store');

    Route::get('claims', [ClaimController::class, 'index'])->name('claims.index');
    Route::get('claims/create', [ClaimController::class, 'create'])->name('claims.create');
    Route::post('claims', [ClaimController::class, 'store'])->name('claims.store');
    Route::delete('claims/{claim}', [ClaimController::class, 'destroy'])->name('claims.destroy');

    Route::get('notes', [NoteController::class, 'index'])->name('notes.index');
    Route::get('notes/create', [NoteController::class, 'create'])->name('notes.create');
    Route::post('notes', [NoteController::class, 'store'])->name('notes.store');
    Route::delete('notes/{note}', [NoteController::class, 'destroy'])->name('notes.destroy');

    Route::get('history', [HistoryController::class, 'index'])->name('history.index');

    Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('reports/expiring', [ReportController::class, 'expiring'])->name('reports.expiring');
    Route::get('reports/balances', [ReportController::class, 'balances'])->name('reports.balances');
    Route::get('reports/production', [ReportController::class, 'production'])->name('reports.production');
});

Route::middleware(['auth', 'office:5'])->group(function () {
    Route::resource('users', UserController::class)->except(['show']);
});
