<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Models\PermintaanBarang;
use App\Http\Controllers\PermintaanBarangController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\StockOutController;
use App\Http\Controllers\ItemMasterController;

Route::get('/', function () {
    return view('auth.login');
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

Route::middleware(['auth'])->group(function () {

    Route::get('/permintaan/create', [PermintaanBarangController::class, 'create'])
        ->name('permintaan.create');

    Route::post('/permintaan', [PermintaanBarangController::class, 'store'])
        ->name('permintaan.store');

    Route::get('/permintaan/manage', [PermintaanBarangController::class, 'manage'])
        ->name('permintaan.manage');

    Route::post('/permintaan/export-excel', [PermintaanBarangController::class, 'exportExcel'])
        ->name('permintaan.exportExcel');

    Route::get('/permintaan/{id}/edit', [PermintaanBarangController::class, 'edit'])
        ->name('permintaan.edit');

    Route::put('/permintaan/{id}', [PermintaanBarangController::class, 'update'])
        ->name('permintaan.update');

    Route::delete('/permintaan/{id}', [PermintaanBarangController::class, 'destroy'])
        ->name('permintaan.destroy');
    Route::post('/permintaan/export', [PermintaanBarangController::class, 'exportExcel'])
    ->name('permintaan.exportExcel');
});
});


Route::middleware(['auth'])->group(function () {

    Route::get('/history', [HistoryController::class, 'index'])
        ->name('history.index');

    // HARUS DI ATAS
    Route::get('/history/{id}/reprint', [HistoryController::class, 'reprint'])
        ->name('history.reprint');

    Route::get('/history/{id}', [HistoryController::class, 'show'])
        ->name('history.show');

    Route::delete('/history/{id}', [HistoryController::class, 'destroy'])
        ->name('history.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/item-master', [ItemMasterController::class, 'index'])
        ->name('item-master.index');

    Route::post('/item-master/sync', [ItemMasterController::class, 'sync'])
        ->name('item-master.sync');

    Route::post('/stock-out', [StockOutController::class, 'store'])
    ->name('stock.out');
});

