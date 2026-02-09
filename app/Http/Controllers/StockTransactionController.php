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
     * ADMIN - Show detail request stock
     */
    public function show($id)
    {
        $transaction = StockTransaction::findOrFail($id);

        return view('admin.stock.show', compact('transaction'));
    }

    /**
     * ✅ ADMIN - Approve Transaction (Confirm barang datang)
     */
    public function confirm($id)
    {
        $transaction = StockTransaction::findOrFail($id);

        // Kalau sudah diproses, stop
        if ($transaction->status !== 'pending') {
            return redirect()->back()->with('error', 'Transaction sudah diproses.');
        }

        // Cari item di master stock
        $item = ItemMaster::where('item_code', $transaction->item_code)->first();

        if (!$item) {
            return redirect()->back()->with('error', 'Item tidak ditemukan di master.');
        }

        // ✅ Tambah stock
        $item->stock += $transaction->quantity;
        $item->save();

        // Update status transaction
        $transaction->status = 'approved';
        $transaction->save();

        return redirect()
            ->route('admin.stock.index')
            ->with('success', 'Transaction berhasil di-APPROVE & stock bertambah.');
    }

    /**
     * ❌ ADMIN - Reject Transaction
     */
    public function reject($id)
    {
        $transaction = StockTransaction::findOrFail($id);

        // Kalau sudah diproses, stop
        if ($transaction->status !== 'pending') {
            return redirect()->back()->with('error', 'Transaction sudah diproses.');
        }

        // Update status reject
        $transaction->status = 'rejected';
        $transaction->save();

        return redirect()
            ->route('admin.stock.index')
            ->with('success', 'Transaction berhasil di-REJECT.');
    }
}