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

    return redirect()->route('permintaan.manage')->with('success', 'Permintaan berhasil disimpan');
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
    $data = PermintaanBarang::where('user_id', auth()->id())->get();
    return view('permintaan.manage', compact('data'));
}

public function exportExcel(Request $request)
{
    $request->validate([
        'doc_no' => 'required|string|max:100',
        'ids'    => 'required|array',
    ]);

    $docNo = $request->doc_no;
    $ids   = $request->ids;

    $items = PermintaanBarang::whereIn('id', $ids)
        ->where('user_id', auth()->id())
        ->get();

    if ($items->isEmpty()) {
        return back()->with('error', 'Data tidak valid / bukan milik kamu');
    }

    DB::transaction(function () use ($items, $docNo) {

        $export = PermintaanExport::create([
            'user_id'     => auth()->id(),
            'doc_no'      => $docNo,
            'lokasi'      => 'Sentul',
            'item_count'  => $items->count(),
            'grand_total' => $items->sum('total'),
            'exported_at' => now(),
        ]);

        foreach ($items as $item) {
            PermintaanExportItem::create([
                'export_id'            => $export->id,
                'permintaan_barang_id' => $item->id,

                'nama_barang'  => $item->nama_barang,
                'merk_type'    => $item->merk_type,
                'jumlah'       => $item->jumlah,
                'harga_satuan' => $item->harga_satuan,
                'total'        => $item->total,
                'supplier'     => $item->supplier,
                'arrival_date' => $item->arrival_date,
                'keterangan'   => $item->keterangan,
            ]);
        }
    });

    return Excel::download(
        new PermintaanExcelExport($ids, $docNo),
        $docNo . '.xlsx'
    );
}

}