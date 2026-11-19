<?php

namespace App\Http\Controllers;

use App\Models\StockIn;
use App\Models\StockOut;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->input('type', 'all');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $stockIns = collect();
        $stockOuts = collect();

        if ($type === 'all' || $type === 'in') {
            $stockIns = StockIn::with(['product', 'supplier'])
                ->when($startDate, fn($query) => $query->whereDate('created_at', '>=', $startDate))
                ->when($endDate, fn($query) => $query->whereDate('created_at', '<=', $endDate))
                ->latest()
                ->get();
        }

        if ($type === 'all' || $type === 'out') {
            $stockOuts = StockOut::with('product')
                ->when($startDate, fn($query) => $query->whereDate('created_at', '>=', $startDate))
                ->when($endDate, fn($query) => $query->whereDate('created_at', '<=', $endDate))
                ->latest()
                ->get();
        }

        $totalIn = $stockIns->sum('quantity');
        $totalOut = $stockOuts->sum('quantity');

        return view('reports.index', compact(
            'stockIns',
            'stockOuts',
            'totalIn',
            'totalOut',
            'type',
            'startDate',
            'endDate'
        ));
    }

    public function printPdf(Request $request)
    {
        $type = $request->input('type', 'all');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $stockIns = collect();
        $stockOuts = collect();

        if ($type === 'all' || $type === 'in') {
            $stockIns = StockIn::with(['product', 'supplier'])
                ->when($startDate, fn($query) => $query->whereDate('created_at', '>=', $startDate))
                ->when($endDate, fn($query) => $query->whereDate('created_at', '<=', $endDate))
                ->latest()
                ->get();
        }

        if ($type === 'all' || $type === 'out') {
            $stockOuts = StockOut::with('product')
                ->when($startDate, fn($query) => $query->whereDate('created_at', '>=', $startDate))
                ->when($endDate, fn($query) => $query->whereDate('created_at', '<=', $endDate))
                ->latest()
                ->get();
        }

        $totalIn = $stockIns->sum('quantity');
        $totalOut = $stockOuts->sum('quantity');

        $pdf = Pdf::loadView('reports.pdf', compact(
            'stockIns',
            'stockOuts',
            'totalIn',
            'totalOut',
            'type',
            'startDate',
            'endDate'
        ))->setPaper('a4', 'portrait');

        $filename = 'laporan-stok-' . now()->format('Y-m-d_His') . '.pdf';

        return $pdf->download($filename);
    }
}