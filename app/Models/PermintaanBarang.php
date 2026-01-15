<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PermintaanBarang extends Model
{
    protected $fillable = [
        'user_id',
        'nama_barang',
        'merk_type',
        'jumlah',
        'harga_satuan',
        'total',
        'supplier',
        'arrival_date',
        'keterangan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

