<?php

namespace App\Http\Controllers;

use App\Models\StockTransaction;
use App\Models\ItemMaster;
use Illuminate\Http\Request;

class StockTransactionController extends Controller
{
    /**
     * ADMIN - List semua request stock
     */
    public function index()
    {
        $transactions = StockTransaction::latest()->get();

        return view('admin.stock.index', compact('transactions'));
    }

    /**
     * ADMIN - Show detail transaksi
     */
    public function show($id)
    {
        $transaction = StockTransaction::findOrFail($id);

        return view('admin.stock.show', compact('transaction'));
    }

    /**
     * ADMIN - Confirm barang datang
     */
    public function confirm($id)
    {
        $transaction = StockTransaction::findOrFail($id);

        // kalau sudah confirmed jangan dobel
        if ($transaction->status === 'confirmed') {
            return back()->with('error', 'Request ini sudah dikonfirmasi.');
        }

        // cari item di master
        $item = ItemMaster::where('nama_barang', $transaction->item_name)->first();

        if (!$item) {
            return back()->with('error', 'Item tidak ditemukan di Item Master.');
        }

        // tambah stock balik
        $item->stock += $transaction->quantity;
        $item->save();

        // update status
        $transaction->status = 'confirmed';
        $transaction->confirmed_at = now();
        $transaction->save();

        return redirect()
            ->route('admin.stock.index')
            ->with('success', 'Barang sudah dikonfirmasi datang. Stock bertambah kembali.');
    }
}