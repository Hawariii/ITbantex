<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\PermintaanExport;

class DocNoGeneratorService
{
    public function generate(): string
    {
        $now = Carbon::now();

        $bulan = $now->format('m');
        $tahun = $now->format('y');

        // ambil doc terakhir di bulan & tahun yg sama
        $lastDoc = PermintaanExport::whereMonth('created_at', $now->month)
            ->whereYear('created_at', $now->year)
            ->orderBy('doc_no', 'desc')
            ->first();

        if ($lastDoc) {
            $lastNumber = (int) substr($lastDoc->doc_no, 0, 2);
            $nextNumber = str_pad($lastNumber + 1, 2, '0', STR_PAD_LEFT);
        } else {
            $nextNumber = '01';
        }

        return $nextNumber . $bulan . $tahun;
    }
}
