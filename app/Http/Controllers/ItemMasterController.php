<?php

namespace App\Http\Controllers;

use App\Models\ItemMaster;
use App\Services\ItemMasterSyncService;

class ItemMasterController extends Controller
{
    public function index()
    {
        $items = ItemMaster::orderBy('asset_no')->get();

        return view('admin.item-master.index', compact('items'));
    }

    public function stock()
    {
        $items = ItemMaster::orderBy('asset_no')->get();

        return view('permintaan.stock', compact('items'));
    }

    public function sync(ItemMasterSyncService $service)
    {
        $excelPath = storage_path('app/item-master/item_master.xlsx');

        $service->sync($excelPath);

        return redirect()
            ->route('admin.item-master.index')
            ->with('success', 'Item master berhasil disinkronkan dari Excel');
    }
}