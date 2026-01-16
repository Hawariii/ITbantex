<?php
namespace App\Exports;

use App\Models\PermintaanBarang;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PermintaanExport implements FromCollection, WithMapping, WithHeadings
{
    protected $ids;

    public function __construct(array $ids)
    {
        $this->ids = $ids;
    }

    public function collection()
    {
        return PermintaanBarang::whereIn('id', $this->ids)->get();
    }

    public function map($row): array
    {
        return [
            $row->nama_barang,    // B
            $row->merk_type,      // D
            $row->jumlah,         // E
            $row->harga_satuan,   // G
            $row->total,          // H
            $row->supplier,       // I
            $row->arrival_date,   // J
            $row->keterangan,     // K
            $row->created_at->format('d-m-Y'), // J35/K2 nanti bisa adjust
        ];
    }

    public function headings(): array
    {
        return [
            'Nama Barang', 'Merk/Type', 'Jumlah', 'Harga Satuan', 'Subtotal', 'Supplier', 'Arrival Date', 'Keterangan', 'Created At'
        ];
    }
}
