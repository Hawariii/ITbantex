<?php

namespace App\Services;

use App\Models\ItemMaster;
use App\Models\StockTransaction;
use Illuminate\Support\Facades\DB;

class StockOutService
{
    /**
     * Stock keluar (permintaan barang)
     */
    public function handle(string $itemName, int $qty, ?string $note = null): StockTransaction
    {
        return DB::transaction(function () use ($itemName, $qty, $note) {

            // cari item master berdasarkan nama (partial match)
            $item = ItemMaster::where('name', 'like', "%{$itemName}%")->first();

            // default: item tidak terdaftar
            $itemId = null;

            if ($item) {
                // kurangi stock
                $item->reduceStock($qty);
                $itemId = $item->id;
            }

            // catat transaksi (baik master / non-master)
            return StockTransaction::create([
                'item_master_id' => $itemId,
                'type'           => 'OUT',
                'quantity'       => $qty,
                'reference'      => 'REQUEST',
                'note'           => $note ?? $itemName,
            ]);
        });
    }
}