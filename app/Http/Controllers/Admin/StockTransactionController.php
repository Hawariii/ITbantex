<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StockTransaction;
use Illuminate\Http\Request;

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
        $trx = StockTransaction::with('item')->findOrFail($id);

        // kalau sudah completed, stop
        if ($trx->status === 'completed') {
            return back()->with('error', 'Transaction already confirmed.');
        }

        $item = $trx->item;

        // ==========================
        // APPLY STOCK CHANGE
        // ==========================

        if ($trx->type === 'out') {
            // kurangi stock
            $item->quantity -= $trx->quantity;
        }

        if ($trx->type === 'in') {
            // tambah stock
            $item->quantity += $trx->quantity;
        }

        $item->save();

        // ==========================
        // UPDATE TRANSACTION STATUS
        // ==========================
        $trx->update([
            'status'       => 'completed',
            'confirmed_by' => auth()->id(),
            'confirmed_at' => now(),
        ]);

        return back()->with('success', 'Stock transaction confirmed successfully!');
    }
    
public function show($id)
{
    $transaction = StockTransaction::with('item')->findOrFail($id);

    return view('admin.stock.show', compact('transaction'));
}
}