@<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PermintaanBarangController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\ItemMasterController;
use App\Http\Controllers\StockTransactionController;
use App\Http\Middleware\AdminMiddleware;
use App\Models\PermintaanBarang;

/*
|--------------------------------------------------------------------------
| PUBLIC
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('auth.login');
});

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';

/*
|--------------------------------------------------------------------------
| CLIENT (AUTH)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    Route::get('/dashboard', function () {
        $data = PermintaanBarang::where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('dashboard', compact('data'));
    })->name('dashboard');

    // PROFILE
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // PERMINTAAN BARANG
    Route::get('/permintaan/create', [PermintaanBarangController::class, 'create'])
        ->name('permintaan.create');

    Route::post('/permintaan', [PermintaanBarangController::class, 'store'])
        ->name('permintaan.store');

    Route::get('/permintaan/manage', [PermintaanBarangController::class, 'manage'])
        ->name('permintaan.manage');

    Route::post('/permintaan/export', [PermintaanBarangController::class, 'exportExcel'])
        ->name('permintaan.export');

    Route::get('/permintaan/{id}/edit', [PermintaanBarangController::class, 'edit'])
        ->name('permintaan.edit');

    Route::put('/permintaan/{id}', [PermintaanBarangController::class, 'update'])
        ->name('permintaan.update');

    Route::delete('/permintaan/{id}', [PermintaanBarangController::class, 'destroy'])
        ->name('permintaan.destroy');

    // HISTORY
    Route::get('/history', [HistoryController::class, 'index'])
        ->name('history.index');

    Route::get('/history/{id}/reprint', [HistoryController::class, 'reprint'])
        ->name('history.reprint');

    Route::get('/history/{id}', [HistoryController::class, 'show'])
        ->name('history.show');

    Route::delete('/history/{id}', [HistoryController::class, 'destroy'])
        ->name('history.destroy');
});

/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', AdminMiddleware::class])
    ->prefix('admin')
    ->group(function () {

        // ITEM MASTER
        Route::get('/item-master', [ItemMasterController::class, 'index'])
            ->name('item-master.index');

        Route::post('/item-master/sync', [ItemMasterController::class, 'sync'])
            ->name('item-master.sync');

        // STOCK TRANSACTION
        Route::get('/stock-transactions', [StockTransactionController::class, 'index'])
            ->name('admin.stock.index');

        Route::post('/stock-transactions/{id}/confirm', [StockTransactionController::class, 'confirm'])
            ->name('admin.stock.confirm');
    });

/*
|--------------------------------------------------------------------------
| CLIENT STOCK REQUEST
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->post(
    '/stock-out',
    [StockTransactionController::class, 'stockOut']
)->name('stock.out');