<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PermintaanExport extends Model
{
    protected $fillable = [
        'user_id',
        'doc_no',
        'lokasi',
        'item_count',
        'grand_total',
        'exported_at',
    ];

    protected $casts = [
        'exported_at' => 'datetime',
    ];

    public function items()
    {
        return $this->hasMany(PermintaanExportItem::class, 'export_id');
    }
}
