<?php

namespace App\Http\Controllers;

use App\Models\PermintaanExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PermintaanHistoryExcelExport;
use App\Services\ExportService;

class HistoryController extends Controller
{
    public function index()
    {
        $exports = PermintaanExport::where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('history.index', compact('exports'));
    }

    public function show($id)
    {
        $export = PermintaanExport::where('id', $id)
            ->where('user_id', auth()->id())
            ->with('items')
            ->firstOrFail();

        return view('history.show', compact('export'));
    }

    public function reprint($id)
    {
        $export = PermintaanExport::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        return Excel::download(
            new PermintaanHistoryExcelExport($export->id),
            $export->doc_no . '.xlsx'
        );
    }
    public function destroy($id)
    {
        $export = PermintaanExport::where('id', $id)
        ->where('user_id', auth()->id())
        ->firstOrFail();

        $export->delete();
        return redirect()
        ->route('history.index')
        ->with('success', 'History berhasil dihapus');
    } 
} 