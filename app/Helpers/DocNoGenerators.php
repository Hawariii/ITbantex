<?php

namespace App\Helpers;

use App\Models\PermintaanBarang;
use Carbon\Carbon;

class DocNoGenerator
{
    public static function generate(): string
    {
        $now = Carbon::now();

        // MMYY
        $month = $now->format('m');
        $year  = $now->format('y');

        // Cari doc terakhir di bulan & tahun yang sama
        $lastDoc = PermintaanBarang::where('doc_no', 'like', '__' . $month . $year)
            ->orderBy('doc_no', 'desc')
            ->value('doc_no');

        if ($lastDoc) {
            // Ambil 2 digit urutan depan
            $lastNumber = intval(substr($lastDoc, 0, 2));
            $nextNumber = $lastNumber + 1;
        } else {
            // Jika belum ada di bulan tsb
            $nextNumber = 1;
        }

        // Format NN (2 digit)
        $number = str_pad($nextNumber, 2, '0', STR_PAD_LEFT);

        return $number . $month . $year;
    }
}
