<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemMaster extends Model
{
    protected $fillable = [

        'asset_no',
        'nama_barang',
        'type',
        'merk',
        'spesifikasi',
        'stock',
        'stock_max',
        'stock_min',
    ];
}