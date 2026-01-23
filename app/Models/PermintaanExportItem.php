<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PermintaanExportItem extends Model
{
    protected $fillable = [
        'export_id',
        'permintaan_barang_id',
        'nama_barang',
        'merk_type',
        'jumlah',
        'harga_satuan',
        'total',
        'supplier',
        'arrival_date',
        'keterangan',
    ];

    protected $casts = [
        'arrival_date' => 'date',
    ];

    public function export()
    {
        return $this->belongsTo(PermintaanExport::class, 'export_id');
    }
}
