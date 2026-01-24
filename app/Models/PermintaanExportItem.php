<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PermintaanExportItem extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'export_id',
        'nama_barang',
        'merk_type',
        'jumlah',
        'harga_satuan',
        'total',
        'supplier',
        'arrival_date',
        'keterangan',
    ];

    public function export()
    {
        return $this->belongsTo(
            PermintaanExport::class,
            'export_id',
            'id'
        );
    }
}
