<?php

namespace App\Services;

use App\Models\ItemMaster;
use App\Models\StockTransaction;
use Illuminate\Support\Facades\DB;
use Exception;

class StockInService
{
    /**
     * Barang pengganti datang (STOCK NAMB AH)
     */
    public function in(
        int $itemId,
        int $qty,
        string $refNo,
        ?int $adminId = null
    ): StockTransaction {
        return DB::transaction(function () use ($itemId, $qty, $refNo, $adminId) {

            $item = ItemMaster::lockForUpdate()->findOrFail($itemId);

            if ($qty <= 0) {
                throw new Exception('Qty tidak valid');
            }

            // TAMBAH STOCK
            $item->increment('stock', $qty);

            return StockTransaction::create([
                'item_master_id' => $item->id,
                'qty'            => $qty,
                'type'           => 'IN',
                'source'         => 'PURCHASE_REPLACEMENT',
                'status'         => 'CONFIRMED',
                'ref_no'         => $refNo,
                'confirmed_by'   => $adminId,
                'confirmed_at'   => now(),
            ]);
        });
    }
}