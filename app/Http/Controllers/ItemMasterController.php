<?php

namespace App\Http\Controllers;

use App\Models\ItemMaster;
use App\Services\ItemMasterSyncService;

class ItemMasterController extends Controller
{
    public function index()
    {
<<<<<<< HEAD
        $items = ItemMaster::orderBy('nama_barang')->get();
        compact('items');

        return view('admin.item-master.index');
=======
        $items = ItemMaster::orderBy('asset_no')->get();

        return view('item-master.index', compact('items'));
>>>>>>> 7d6e02b ( update item master index view and sync success message)
    }

    public function sync(ItemMasterSyncService $service)
    {
        $excelPath = storage_path('app/item-master/item_master.xlsx');

        $service->sync($excelPath);

        return redirect()
            ->route('item-master.index')
            ->with('success', 'Item master berhasil disinkronkan dari Excel');
<<<<<<< HEAD
    }

    public function stockTransactions()
    {
    return $this->hasMany(StockTransaction::class);
=======
>>>>>>> 7d6e02b ( update item master index view and sync success message)
    }
}