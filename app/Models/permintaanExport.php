<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PermintaanExport extends Model
{
    protected $fillable = [
        'user_id',
        'doc_no',
        'exported_at',
    ];

    protected $casts = [
        'exported_at' => 'datetime',
    ];

    public function items()
    {
        return $this->hasMany(
            PermintaanExportItem::class,
            'export_id', // foreign key di permintaan_export_items
            'id'         // primary key di permintaan_exports
        );
    }
}
