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
     * ADMIN - Show detail transaksi stock
     */
    public function show($id)
    {
        $transaction = StockTransaction::findOrFail($id);

        return view('admin.stock.show', compact('transaction'));
    }

    /**
     * ADMIN - Approve stock transaction
     */
    public function confirm($id)
    {
        $transaction = StockTransaction::findOrFail($id);

        // update status jadi approved
        $transaction->status = 'approved';
        $transaction->save();

        // update stock item master
        $item = ItemMaster::where('item_code', $transaction->item_code)->first();

        if ($item) {
            $item->stock += $transaction->quantity;
            $item->save();
        }

        return redirect()
            ->route('admin.stock-transactions.index')
            ->with('success', 'Stock transaction approved!');
    }

    /**
     * ADMIN - Reject stock transaction
     */
    public function reject($id)
    {
        $transaction = StockTransaction::findOrFail($id);

        $transaction->status = 'rejected';
        $transaction->save();

        return redirect()
            ->route('admin.stock-transactions.index')
            ->with('error', 'Stock transaction rejected!');
    }
}