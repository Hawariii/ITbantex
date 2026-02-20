<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StockTransaction;
use App\Models\ItemMaster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockTransactionController extends Controller
{
    /**
     * ADMIN - List pending transactions
     */
    public function index()
    {
        $transactions = StockTransaction::with('item')
            ->where('status', 'pending')
            ->latest()
            ->get();

        return view('admin.stock.index', compact('transactions'));
    }

    /**
     * ADMIN - Confirm transaction
     */
        public function confirm($id)
        {
            DB::transaction(function () use ($id) {

                $transaction = StockTransaction::lockForUpdate()->findOrFail($id);

                if ($transaction->status === 'completed') {
                    throw new \Exception('Transaksi sudah dikonfirmasi.');
                }

                $item = ItemMaster::lockForUpdate()->findOrFail($transaction->item_id);

                // Tambah stock kembali (barang pengganti datang)
                $item->stock += $transaction->quantity;
                $item->save();

                $transaction->status = 'completed';
                $transaction->save();
            });

            return back()->with('success', 'Transaksi berhasil dikonfirmasi.');
        }
    /**
     * ADMIN - Show detail transaction
     */
    public function show($id)
    {
        $transaction = StockTransaction::with('item')->findOrFail($id);

        return view('admin.stock.show', compact('transaction'));
    }
}