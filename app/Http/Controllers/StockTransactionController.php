<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StockTransaction;
use App\Models\ItemMaster;

class StockTransactionController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | CLIENT REQUEST STOCK OUT
    |--------------------------------------------------------------------------
    */
    public function stockOut(Request $request)
    {
        $request->validate([
            'item_id' => 'required',
            'qty'     => 'required|integer|min:1'
        ]);

        $item = ItemMaster::findOrFail($request->item_id);

        StockTransaction::create([
            'doc_no'    => 'ST-' . now()->format('YmdHis'),
            'item_id'   => $item->id,
            'item_name' => $item->nama_barang,
            'qty'       => $request->qty,
            'status'    => 'pending',
        ]);

        return back()->with('success', 'Request stock-out berhasil dikirim!');
    }

    /*
    |--------------------------------------------------------------------------
    | ADMIN VIEW ALL TRANSACTIONS
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        $transactions = StockTransaction::latest()->get();

        return view('admin.stock-transactions.index', compact('transactions'));
    }

    /*
    |--------------------------------------------------------------------------
    | ADMIN CONFIRM STOCK OUT (REAL STOCK UPDATE)
    |--------------------------------------------------------------------------
    */
    public function confirm($id)
    {
        $trx = StockTransaction::findOrFail($id);

        if ($trx->status === 'confirmed') {
            return back()->with('error', 'Sudah dikonfirmasi!');
        }

        $item = ItemMaster::findOrFail($trx->item_id);

        // ❌ kalau stock kurang
        if ($item->stock < $trx->qty) {
            return back()->with('error', 'Stock tidak cukup!');
        }

        // ✅ kurangi stock
        $item->stock -= $trx->qty;
        $item->save();

        // ✅ update transaksi
        $trx->update([
            'status' => 'confirmed'
        ]);

        return back()->with('success', 'Stock berhasil dikurangi & transaksi confirmed!');
    }
}