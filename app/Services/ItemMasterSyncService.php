<?php

namespace App\Services;

use App\Models\ItemMaster;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\DB;

class ItemMasterSyncService
{
    public function sync(string $excelPath): void
    {
        $spreadsheet = IOFactory::load($excelPath);
        $sheet = $spreadsheet->getActiveSheet();

        DB::transaction(function () use ($sheet) {

            for ($row = 5; $row <= 53; $row++) {

                $namaBarang = trim((string) $sheet->getCell("G{$row}")->getValue());

                if ($namaBarang === '') {
                    continue; // skip row kosong
                }

                ItemMaster::updateOrCreate(
                    [
                        'nama_barang' => $namaBarang,
                    ],
                    [
                        'asset_no'    => $sheet->getCell("C{$row}")->getValue(),
                        'stock'       => (int) $sheet->getCell("D{$row}")->getValue(),
                        'type'        => $sheet->getCell("H{$row}")->getValue(),
                        'merk'        => $sheet->getCell("I{$row}")->getValue(),
                        'spesifikasi' => $sheet->getCell("J{$row}")->getValue(),
                        'stock_max'   => (int) $sheet->getCell("K{$row}")->getValue(),
                        'stock_min'   => (int) $sheet->getCell("L{$row}")->getValue(),
                    ]
                );
            }
        });
    }
}