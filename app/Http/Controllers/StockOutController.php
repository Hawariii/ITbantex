<?php

namespace App\Http\Controllers;

use App\Services\StockOutService;
use Illuminate\Http\Request;

class StockOutController extends Controller
{
    public function store(Request $request, StockOutService $service)
    {
        $request->validate([
            'item_id' => 'required|exists:item_masters,id',
            'qty' => 'required|integer|min:1',
            'note' => 'nullable|string',
        ]);

        $service->handle(
            $request->item_id,
            $request->qty,
            $request->note
        );

        return back()->with('success', 'Stock berhasil dikurangi');
    }
}