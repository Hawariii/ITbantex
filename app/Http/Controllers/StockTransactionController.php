<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\StockTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockTransactionController extends Controller
{
    
    /**
     * CLIENT EXPORT / AMBIL BARANG
     */
    public function stockOut(Request $request)
    {
        $request->validate([
            'item_id' => 'required|exists:items,id',
            'qty' => 'required|integer|min:1',
        ]);

        DB::transaction(function () use ($request) {
            $item = Item::lockForUpdate()->findOrFail($request->item_id);

            if ($item->stock < $request->qty) {
                abort(400, 'Stock tidak mencukupi');
            }

            // KURANGI STOK LANGSUNG
            $item->decrement('stock', $request->qty);

            // CATAT TRANSAKSI
            StockTransaction::create([
                'item_id' => $item->id,
                'qty' => $request->qty,
                'type' => 'out',
                'status' => 'pending',
                'created_by' => auth()->id(),
            ]);
        });

        return back()->with('success', 'Barang berhasil dikeluarkan');
    }

    /**
     * LIST TRANSAKSI (ADMIN)
     */
    public function index()
    {
        $transactions = StockTransaction::with(['item', 'creator', 'confirmer'])
            ->latest()
            ->get();

        return view('admin.stock-transactions.index', compact('transactions'));
    }

    /**
     * ADMIN CONFIRM BARANG PENGGANTI
     */
    public function confirm($id)
    {
        DB::transaction(function () use ($id) {
            $trx = StockTransaction::lockForUpdate()->findOrFail($id);

            if ($trx->status === 'completed') {
                abort(400, 'Transaksi sudah dikonfirmasi');
            }

            $item = Item::lockForUpdate()->findOrFail($trx->item_id);

            // TAMBAH STOK
            $item->increment('stock', $trx->qty);

            $trx->update([
                'status' => 'completed',
                'confirmed_by' => auth()->id(),
                'confirmed_at' => now(),
            ]);
        });

        return back()->with('success', 'Stock berhasil ditambahkan');
    }
}