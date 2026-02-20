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

            // 1. Ambil semua item berdasarkan doc_no & user
            $items = PermintaanBarang::where('doc_no', $docNo)
                ->where('user_id', $userId)
                ->get();

            if ($items->isEmpty()) {
                throw new \Exception("Doc {$docNo} tidak ditemukan.");
            }

            // 2. Cek apakah export sudah pernah dibuat
            $export = PermintaanExport::where('doc_no', $docNo)
                ->where('user_id', $userId)
                ->first();

            // 3. Jika belum ada export → buat baru
            if (!$export) {

                $export = PermintaanExport::create([
                    'doc_no'      => $docNo,
                    'user_id'     => $userId,
                    'exported_at' => now(),
                ]);

                foreach ($items as $item) {

                    // Snapshot item ke export_items
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

                    // Cari item di master
                    $master = ItemMaster::where('nama_barang', $item->nama_barang)->first();

                    // Kalau tidak ada di master, skip
                    if (!$master) {
                        continue;
                    }
                    if ($master->stock < $item->jumlah) {
                        throw new \Exception("Stock untuk {$master->nama_barang} tidak mencukupi.");
                    }
                    $master->stock -= $item->jumlah;
                    $master->save();

                    // Buat stock transaction (pending)
                    StockTransaction::create([
                        'item_id'    => $master->id,
                        'quantity'   => $item->jumlah,
                        'type'       => 'out',
                        'status'     => 'pending',
                        'created_by' => $userId,
                    ]);
                }
            }

            return $export;
        });
    }
}