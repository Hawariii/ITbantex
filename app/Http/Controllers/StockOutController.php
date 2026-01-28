<?php

namespace App\Http\Controllers;

use App\Services\StockOutService;
use Illuminate\Http\Request;

class StockOutController extends Controller
{
    protected StockOutService $service;

    public function __construct(StockOutService $service)
    {
        $this->service = $service;
    }

    /**
     * Form permintaan barang
     */
    public function create()
    {
        return view('stock-out.create');
    }

    /**
     * Simpan permintaan barang
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'item_name' => 'required|string|max:255',
            'quantity'  => 'required|integer|min:1',
            'note'      => 'nullable|string',
        ]);

        $this->service->handle(
            $validated['item_name'],
            $validated['quantity'],
            $validated['note'] ?? null
        );

        return redirect()
            ->back()
            ->with('success', 'Permintaan barang berhasil dicatat');
    }
}