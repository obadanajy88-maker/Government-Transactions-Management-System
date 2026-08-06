<?php

use App\Http\Controllers\EmployeeTransactionController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
})->name('home');

Route::middleware(['auth'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');

    Route::middleware(['role:citizen'])->prefix('citizen')->name('citizen.')->group(function () {
        Route::get('transactions/create', [TransactionController::class, 'create'])->name('transactions.create');
        Route::post('transactions', [TransactionController::class, 'store'])->name('transactions.store');
    });

    Route::middleware(['role:employee,manager'])->prefix('employee')->name('employee.')->group(function () {
        Route::get('transactions', [EmployeeTransactionController::class, 'index'])->name('transactions.index');
        Route::post('transactions/{transaction}/process', [EmployeeTransactionController::class, 'process'])->name('transactions.process');
    });
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';        Route::post('transactions/{transaction}/process', [EmployeeTransactionController::class, 'process'])->name('transactions.process');
