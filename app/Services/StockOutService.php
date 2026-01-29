<?php

namespace App\Services;

use App\Models\ItemMaster;
use App\Models\StockTransaction;
use Illuminate\Support\Facades\DB;

class StockOutService
{
    public function handle(int $itemId, int $qty, ?string $note = null): void
    {
        DB::transaction(function () use ($itemId, $qty, $note) {

            $item = ItemMaster::lockForUpdate()->findOrFail($itemId);

            if ($item->stock < $qty) {
                throw new \Exception('Stock tidak mencukupi');
            }

            // kurangi stock
            $item->stock -= $qty;
            $item->save();

            // log transaksi
            StockTransaction::create([
                'item_master_id' => $item->id,
                'type' => 'OUT',
                'qty' => $qty,
                'note' => $note,
            ]);
        });
    }
}