<?php

namespace App\Services;

use App\Models\ItemMaster;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ItemMasterSyncService
{
    public function sync(string $excelPath): void
    {
        if (!file_exists($excelPath)) {
            throw new \Exception("File Excel tidak ditemukan");
        }

        $spreadsheet = IOFactory::load($excelPath);
        $sheet = $spreadsheet->getActiveSheet();

        /**:
         * C = asset_no
         * G = nama_barang
         * H = type
         * I = merk
         * J = spesifikasi
         * D = stock
         * K = stock_max
         * L = stock_min
         */

        for ($row = 5; $row <= 54; $row++) {
            $assetNo = trim((string) $sheet->getCell("C{$row}")->getValue());
            $nama    = trim((string) $sheet->getCell("H{$row}")->getValue());
            $id      = trim((string) $sheet->getCell("B{$row}")->getValue());

            if (!$assetNo || !$nama) {
                continue;
            }

            ItemMaster::updateOrCreate(
                ['asset_no' => $assetNo],
                [
                    'nama_barang' => $nama,
                    'type'        => $sheet->getCell("J{$row}")->getValue(),
                    'merk'        => $sheet->getCell("I{$row}")->getValue(),
                    'spesifikasi' => $sheet->getCell("J{$row}")->getValue(),
                    'stock'       => (int) $sheet->getCell("D{$row}")->getValue(),
                    'stock_max'   => (int) $sheet->getCell("K{$row}")->getValue(),
                    'stock_min'   => (int) $sheet->getCell("L{$row}")->getValue(),
                ]
            );
        }
    }
}