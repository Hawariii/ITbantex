<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockTransaction extends Model
{
    protected $fillable = [
        'item_master_id',
        'type',
        'quantity',
        'reference',
        'note',
    ];

    public function itemMaster()
    {
        return $this->belongsTo(ItemMaster::class);
    }
}