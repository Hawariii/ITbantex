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

            // Total item master
            'totalItems' => ItemMaster::count(),

            // Karena tabel stock_transactions belum punya kolom status
            'pendingRequests' => StockTransaction::count(),

            // Dummy sementara
            'approvedToday' => 0,
            'stockOutTotal' => 0,

            // Recent transactions
            'recentTransactions' => StockTransaction::latest()
                ->take(5)
                ->get(),
        ]);
    }
}