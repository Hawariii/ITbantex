<?php

namespace App\Http\Controllers;

use App\Services\StockInService;
use Illuminate\Http\Request;

class StockInController extends Controller
{
    public function store(Request $request, StockInService $service)
    {
        $request->validate([
            'item_id' => 'required|exists:item_masters,id',
            'qty'     => 'required|integer|min:1',
            'ref_no'  => 'required|string|max:50',
        ]);

        $service->in(
            $request->item_id,
            $request->qty,
            $request->ref_no,
            auth()->id()
        );

        return back()->with('success', 'Stock berhasil ditambahkan');
    }
}