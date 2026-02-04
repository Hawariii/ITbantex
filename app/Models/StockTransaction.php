<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockTransaction extends Model
{
    protected $fillable = [
        'doc_no',
        'item_id',
        'item_name',
        'qty',
        'status',
    ];
}