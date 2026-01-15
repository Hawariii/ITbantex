<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Models\PermintaanBarang;
use App\Http\Controllers\PermintaanBarangController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', function () {
        $data = PermintaanBarang::where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('dashboard', compact('data'));
    })->name('dashboard');

    Route::get('/permintaan/create', function () {
        return view('permintaan.create');
    })->name('permintaan.create');

});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', function () {
        $data = PermintaanBarang::where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('dashboard', compact('data'));
    })->name('dashboard');

    Route::get('/permintaan/create', [PermintaanBarangController::class, 'create'])
        ->name('permintaan.create');

    Route::post('/permintaan', [PermintaanBarangController::class, 'store'])
        ->name('permintaan.store');
});
