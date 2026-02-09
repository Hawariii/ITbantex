<?php

namespace App\Services;

use App\Models\PermintaanBarang;
use App\Models\PermintaanExport;
use App\Models\PermintaanExportItem;
use App\Models\StockTransaction;
use App\Models\ItemMaster;
use Illuminate\Support\Facades\DB;

class ExportService
{
    public function exportByDocNo(string $docNo, int $userId)
    {
        return DB::transaction(function () use ($docNo, $userId) {

            // ===============================
            // 1. Ambil semua permintaan barang
            // ===============================
            $items = PermintaanBarang::where('doc_no', $docNo)
                ->where('user_id', $userId)
                ->get();

            if ($items->isEmpty()) {
                throw new \Exception("Data permintaan dengan doc_no {$docNo} tidak ditemukan.");
            }

            // ===============================
            // 2. Buat header export
            // ===============================
            $export = PermintaanExport::create([
                'doc_no'      => $docNo,
                'user_id'     => $userId,
                'exported_at' => now(),
            ]);

            // ===============================
            // 3. Loop item → simpan export item
            // ===============================
            foreach ($items as $item) {

                // simpan snapshot item export
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

                // ===============================
                // 4. AUTO STOCK OUT TRANSACTION
                // ===============================

                // cari item master
                $master = ItemMaster::where('nama_barang', $item->nama_barang)->first();

                if (!$master) {
                    continue; // skip kalau tidak ada di master
                }

                // kurangi stock langsung
                $master->quantity -= $item->jumlah;
                $master->save();

                // buat transaksi pending admin
                StockTransaction::create([
                    'item_id'   => $master->id,
                    'quantity'  => $item->jumlah,
                    'type'      => 'OUT',
                    'status'    => 'pending',
                    'notes'     => "Permintaan export: {$docNo}",
                ]);
            }

            return $export;
        });
    }
}