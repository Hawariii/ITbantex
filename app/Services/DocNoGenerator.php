<?php

namespace App\Services;

use App\Models\PermintaanBarang;
use Carbon\Carbon;

class DocNoGenerator
{
    public static function generate(): string
    {
        $now   = Carbon::now();
        $month = $now->format('m'); // 01–12
        $year  = $now->format('y'); // 26

        // cari doc terakhir di bulan & tahun yg sama
        $lastDoc = PermintaanBarang::where('doc_no', 'like', "__{$month}{$year}")
            ->orderBy('doc_no', 'desc')
            ->first();

        if ($lastDoc) {
            $lastNumber = (int) substr($lastDoc->doc_no, 0, 2);
            $nextNumber = str_pad($lastNumber + 1, 2, '0', STR_PAD_LEFT);
        } else {
            $nextNumber = '01';
        }

        return $nextNumber . $month . $year;
    }
}
