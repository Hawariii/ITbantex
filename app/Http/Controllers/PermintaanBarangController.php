<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PermintaanBarang;

class PermintaanBarangController extends Controller
{
    public function create()
    {
        return view('permintaan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_barang'   => 'required',
            'merk_type'     => 'required',
            'jumlah'        => 'required|integer',
            'harga_satuan'  => 'required',
            'supplier'      => 'required',
            'arrival_date'  => 'required|date',
        ]);

        $harga = str_replace('.', '', $request->harga_satuan);

        PermintaanBarang::create([
            'user_id'       => auth()->id(),
            'nama_barang'   => $request->nama_barang,
            'merk_type'     => $request->merk_type,
            'jumlah'        => $request->jumlah,
            'harga_satuan'  => $harga,
            'total'         => $request->jumlah * $harga,
            'supplier'      => $request->supplier,
            'arrival_date'  => $request->arrival_date,
            'keterangan'    => $request->keterangan,
        ]);

        return redirect()->route('dashboard')
            ->with('success', 'Permintaan barang berhasil dibuat');
    }
}
