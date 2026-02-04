<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ItemMaster;
use App\Models\StockTransaction;

class AdminDashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'totalItems' => ItemMaster::count(),

            'pendingRequests' => StockTransaction::where('status', 'pending')->count(),

            'approvedToday' => StockTransaction::whereDate('updated_at', today())
                ->where('status', 'approved')
                ->count(),

            'stockOutTotal' => StockTransaction::where('type', 'stock_out')->sum('qty'),

            'recentTransactions' => StockTransaction::latest()
                ->with(['user', 'item'])
                ->take(5)
                ->get(),
        ]);
    }
}