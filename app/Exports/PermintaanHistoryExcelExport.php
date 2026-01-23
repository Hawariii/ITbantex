<?php

namespace App\Exports;

use App\Models\PermintaanExport;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeWriting;
use Maatwebsite\Excel\Excel;
use Maatwebsite\Excel\Files\LocalTemporaryFile;

class PermintaanHistoryExcelExport implements WithEvents
{
    protected $exportId;

    public function __construct($exportId)
    {
        $this->exportId = $exportId;
    }

    public function registerEvents(): array
    {
        return [
            BeforeWriting::class => function (BeforeWriting $event) {

                $export = PermintaanExport::with('items')->findOrFail($this->exportId);

                $template = storage_path('app/templates/form_permintaan.xlsx');

                $event->writer->reopen(
                    new LocalTemporaryFile($template),
                    Excel::XLSX
                );

                $sheet = $event->writer->getSheetByIndex(0)->getDelegate();

                $row = 11;
                $grandTotal = 0;

                foreach ($export->items as $item) {
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
                $sheet->setCellValue("K4", $export->doc_no);
                $sheet->setCellValue("K2",  now()->format('d/m/Y'));
                $sheet->setCellValue("J35", 'Sentul, ' . optional($export->exported_at)->format('d/m/Y'));
            }
        ];
    }
}
