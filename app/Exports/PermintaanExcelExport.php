<?php

namespace App\Exports;

use App\Models\PermintaanBarang;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeWriting;
use Maatwebsite\Excel\Excel;
use Maatwebsite\Excel\Files\LocalTemporaryFile;

class PermintaanExcelExport implements WithEvents
{
    protected $ids;
    protected $docNo;

    public function __construct($ids, $docNo)
    {
        $this->ids = $ids;
        $this->docNo = $docNo;
    }

    public function registerEvents(): array
    {
        return [
            BeforeWriting::class => function (BeforeWriting $event) {

                $template = storage_path('app/templates/form_permintaan.xlsx');

                $event->writer->reopen(
                    new LocalTemporaryFile($template),
                    Excel::XLSX
                );

                $sheet = $event->writer->getSheetByIndex(0)->getDelegate();

                $data = PermintaanBarang::whereIn('id', $this->ids)->get();

                $row = 11;
                $grandTotal = 0;

                foreach ($data as $item) {
                    $sheet->setCellValue("B{$row}", $item->nama_barang);
                    $sheet->setCellValue("D{$row}", $item->merk_type);
                    $sheet->setCellValue("E{$row}", $item->jumlah);
                    $sheet->setCellValue("G{$row}", $item->harga_satuan);
                    $sheet->setCellValue("H{$row}", $item->total);
                    $sheet->setCellValue("I{$row}", $item->supplier);
                    $sheet->setCellValue("J{$row}", $item->arrival_date);
                    $sheet->setCellValue("K{$row}", $item->keterangan);

                    $grandTotal += $item->total;
                    $row++;
                }

                $sheet->setCellValue("H33", $grandTotal);
                $sheet->setCellValue("K4", $this->docNo);
                $sheet->setCellValue("J35", 'Sentul, ' . now()->format('d/m/Y'));
                $sheet->setCellValue("K2",  now()->format('d/m/Y'));
            }
        ];
    }
}
