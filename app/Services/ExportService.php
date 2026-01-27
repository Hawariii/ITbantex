<?php

namespace App\Services;

use DB;
use App\Models\PermintaanBarang;
use App\Models\PermintaanExport;
use App\Models\PermintaanExportItem;

class ExportService
{
    public function exportByDocNo(string $docNo, int $userId): PermintaanExport
    {
        // 🔒 CEGAH DUPLIKAT HISTORY
        $existingExport = PermintaanExport::where('doc_no', $docNo)->first();

        if ($existingExport) {
            return $existingExport; // ⬅️ REPRINT CASE
        }

        $items = PermintaanBarang::where('user_id', $userId)
            ->where('doc_no', $docNo)
            ->get();

        if ($items->isEmpty()) {
            throw new \Exception('Data tidak ditemukan');
        }

        return DB::transaction(function () use ($items, $docNo, $userId) {

            $export = PermintaanExport::create([
                'user_id'     => $userId,
                'doc_no'      => $docNo,
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
            }

            return $export;
        });
    }
}
