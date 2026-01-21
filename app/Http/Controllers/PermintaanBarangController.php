<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PermintaanBarang;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PermintaanExport;


class PermintaanBarangController extends Controller{

    public function create()
    {
        return view('permintaan.create');
    }

public function store(Request $request)
{
    foreach ($request->nama_barang as $index => $nama) {

        $harga = str_replace('.', '', $request->harga_satuan[$index]);

        PermintaanBarang::create([
            'user_id'      => auth()->id(),
            'nama_barang'  => $nama,
            'merk_type'    => $request->merk_type[$index],
            'jumlah'       => $request->jumlah[$index],
            'harga_satuan' => $harga,
            'total'        => $request->jumlah[$index] * $harga,
            'supplier'     => $request->supplier,
            'arrival_date' => $request->arrival_date,
            'keterangan'   => $request->keterangan,
        ]);
    }

    return redirect()->route('dashboard')->with('success', 'Permintaan berhasil disimpan');
}

public function edit($id)
{
    $item = PermintaanBarang::where('id', $id)
        ->where('user_id', auth()->id())
        ->firstOrFail();

    return view('permintaan.edit', compact('item'));
}

public function update(Request $request, $id)
{
    $request->validate([
        'nama_barang'  => 'required',
        'merk_type'    => 'required',
        'jumlah'       => 'required|integer',
        'harga_satuan' => 'required',
    ]);

    $item = PermintaanBarang::where('id', $id)
        ->where('user_id', auth()->id())
        ->firstOrFail();

    $harga = str_replace('.', '', $request->harga_satuan);

    $item->update([
        'nama_barang'  => $request->nama_barang,
        'merk_type'    => $request->merk_type,
        'jumlah'       => $request->jumlah,
        'harga_satuan' => $harga,
        'total'        => $request->jumlah * $harga,
        'supplier'     => $request->supplier,
        'arrival_date' => $request->arrival_date,
        'keterangan'   => $request->keterangan,
    ]);

    return redirect()->route('permintaan.manage')
        ->with('success', 'Item berhasil diupdate');
}

public function destroy($id)
{
    $item = PermintaanBarang::where('id', $id)
        ->where('user_id', auth()->id())
        ->firstOrFail();

    $item->delete();

    return redirect()->route('permintaan.manage')
        ->with('success', 'Item berhasil dihapus');
}

public function manage()
{
    $data = PermintaanBarang::latest()->get();
    return view('permintaan.manage', compact('data'));
}

public function exportExcel(Request $request)
{
    if (!$request->ids) {
        return back()->with('error', 'Pilih minimal 1 data');
    }

    return Excel::download(
        new PermintaanExport($request->ids),
        'permintaan_barang.xlsx'
    );
}

}