<?php

namespace App\Http\Controllers;

use App\Services\ItemMasterSyncService;

class ItemMasterController extends Controller
{
    public function sync(ItemMasterSyncService $service)
    {
        $excelPath = storage_path('app/item_master.xlsx');

        $service->sync($excelPath);

        return back()->with('success', 'Item master berhasil disinkronkan');
    }
}