<?php

namespace App\Http\Controllers;

use App\Models\ItemMaster;
use App\Services\ItemMasterSyncService;
use Illuminate\Http\Request;

class ItemMasterController extends Controller
{
    public function index()
    {
        $items = ItemMaster::orderBy('nama_barang')->get();
        return view('item-master.index', compact('items'));
    }

    public function sync(ItemMasterSyncService $service)
    {
        $excelPath = storage_path('app/item-master/item_master.xlsx');

        $service->sync($excelPath);

        return redirect()
            ->route('item-master.index')
            ->with('success', 'Item master berhasil disinkronkan');
    }
}