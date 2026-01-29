<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockTransaction extends Model
{
    protected $fillable = [
        'item_master_id',
        'type',
        'qty',
        'note',
    ];

    public function item()
    {
        return $this->belongsTo(ItemMaster::class, 'item_master_id');
    }
}