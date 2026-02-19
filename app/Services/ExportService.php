<?php

namespace App\Services;

use App\Models\PermintaanBarang;
use App\Models\PermintaanExport;
use App\Models\PermintaanExportItem;
use Illuminate\Support\Facades\DB;
use App\Models\StockTransaction;
use App\Models\ItemMaster;

class ExportService
{
    public function exportByDocNo(string $docNo, int $userId)
    {
        return DB::transaction(function () use ($docNo, $userId) {

            // 1. Ambil semua item permintaan
            $items = PermintaanBarang::where('doc_no', $docNo)
                ->where('user_id', $userId)
                ->get();

            if ($items->isEmpty()) {
                throw new \Exception("Doc {$docNo} tidak ditemukan.");
            }

            // 2. Cari apakah export sudah pernah dibuat
            $export = PermintaanExport::where('doc_no', $docNo)
                ->where('user_id', $userId)
                ->first();

            // 3. Kalau belum → buat export + snapshot items
            if (!$export) {

                $export = PermintaanExport::create([
                    'doc_no'      => $docNo,
                    'user_id'     => $userId,
                    'exported_at' => now(),
                ]);

                foreach ($items as $item) {
                    PermintaanExportItem::create([
                        'export_id'    => $export->id,
                        'nama_barang'  => $item->nama_barang,
                        'merk_type'    => $item->merk_type,
                        'jumlah'       => $item->jumlah,
                        'harga_satuan' => $item->harga_satuan,
                        'total'        => $item->total,
                        'supplier'     => $item->supplier,
                        'arrival_date' => $item->arrival_date,
                        'keterangan'   => $item->keterangan,
                    ]);

                    // UPDATE STOCK TRANSACTION
                    $master = ItemMaster::where('nama_barang', 
                    $item->nama_barang) -> firstOrFail();

                    if (!$master) {
                        continue;
                    }
                    StockTransaction::create([
                        'item_id'     => $master->id,
                        'quantity'    => $item->jumlah,
                        'type'        => 'out',
                        'status'      => 'pending',
                        'created_by'  => $userId,
                    ]);
                }
            }

            // 4. Return export untuk dipakai download
            return $export;
        });
    }
}