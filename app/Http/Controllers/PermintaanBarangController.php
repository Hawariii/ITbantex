<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PermintaanBarang;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PermintaanExcelExport;
use App\Models\PermintaanExportItem;
use App\Models\PermintaanExport;
use Illuminate\Support\Facades\DB;



class PermintaanBarangController extends Controller{

    public function create()
    {
        return view('permintaan.create');
    }

public function store(Request $request)
{
    $request->validate([
        'doc_no' => 'required|string|max:100',

        'nama_barang'    => 'required|array',
        'nama_barang.*'  => 'required|string|max:255',

        'merk_type'      => 'required|array',
        'merk_type.*'    => 'required|string|max:255',

        'jumlah'         => 'required|array',
        'jumlah.*'       => 'required|integer|min:1',

        'harga_satuan'   => 'required|array',
        'harga_satuan.*' => 'required',

        'supplier'       => 'required|string|max:255',
        'arrival_date'   => 'required|date',
        'keterangan'     => 'nullable|string',
    ]);

    foreach ($request->nama_barang as $index => $nama) {
        $harga = str_replace('.', '', $request->harga_satuan[$index]);

        PermintaanBarang::create([
            'user_id'      => auth()->id(),
            'doc_no'       => $request->doc_no,

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

    return redirect()->route('permintaan.manage')
        ->with('success', 'Permintaan berhasil disimpan');
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
        'doc_no'       => 'required|string|max:100',
        'nama_barang'  => 'required|string|max:255',
        'merk_type'    => 'required|string|max:255',
        'jumlah'       => 'required|integer|min:1',
        'harga_satuan' => 'required',
        'supplier'     => 'required|string|max:255',
        'arrival_date' => 'required|date',
        'keterangan'   => 'nullable|string',
    ]);

    $item = PermintaanBarang::where('id', $id)
        ->where('user_id', auth()->id())
        ->firstOrFail();

    $harga = str_replace('.', '', $request->harga_satuan);

    $item->update([
        'doc_no'       => $request->doc_no,
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
    $data = PermintaanBarang::where('user_id', auth()->id())
        ->orderBy('doc_no')
        ->orderByDesc('created_at')
        ->get()
        ->groupBy('doc_no');

    return view('permintaan.manage', compact('data'));
}

public function exportExcel(Request $request)
{
    $request->validate([
        'doc_no' => 'required|string|max:100',
    ]);

    $docNo = $request->doc_no;

    $items = PermintaanBarang::where('user_id', auth()->id())
        ->where('doc_no', $docNo)
        ->get();

    if ($items->isEmpty()) {
        return back()->with('error', 'Data tidak ditemukan');
    }

    DB::transaction(function () use ($items, $docNo) {

        $export = PermintaanExport::create([
            'user_id' => auth()->id(),
            'doc_no'  => $docNo,
        ]);

        foreach ($items as $item) {
            PermintaanExportItem::create([
                'export_id'            => $export->id,
                'nama_barang'          => $item->nama_barang,
                'merk_type'            => $item->merk_type,
                'jumlah'               => $item->jumlah,
                'harga_satuan'         => $item->harga_satuan,
                'total'                => $item->total,
                'supplier'             => $item->supplier,
                'arrival_date'         => $item->arrival_date,
                'keterangan'           => $item->keterangan,
            ]);
        }
    });

    return Excel::download(
        new PermintaanExcelExport($items->pluck('id')->toArray(), $docNo),
        $docNo . '.xlsx'
    );
}


}