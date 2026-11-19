<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\Warehouse;
use App\Models\StockIn;
use App\Models\StockOut;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts = Product::count();
        $totalCategories = Category::count();
        $totalSuppliers = Supplier::count();
        $totalWarehouses = Warehouse::count();

        $lowStockProducts = Product::whereColumn('stock', '<=', 'min_stock')->get();

        $warehouseCapacities = Warehouse::withSum('products as total_stock', 'stock')->get()->map(function ($warehouse) {
            $totalStock = $warehouse->total_stock ?? 0;
            $percentage = $warehouse->capacity > 0
                ? round(($totalStock / $warehouse->capacity) * 100)
                : 0;

            return [
                'name' => $warehouse->name,
                'total_stock' => $totalStock,
                'capacity' => $warehouse->capacity,
                'percentage' => min($percentage, 100),
            ];
        });

        $stockIns = StockIn::with(['product', 'user'])->latest()->take(10)->get()->map(function ($item) {
            return [
                'time' => $item->created_at,
                'product' => $item->product?->name ?? 'Produk Dihapus',
                'code' => $item->product?->code ?? '-',
                'type' => 'MASUK',
                'quantity' => $item->quantity,
                'user' => $item->user?->name ?? 'System',
            ];
        });

        $stockOuts = StockOut::with(['product', 'user'])->latest()->take(10)->get()->map(function ($item) {
            return [
                'time' => $item->created_at,
                'product' => $item->product?->name ?? 'Produk Dihapus',
                'code' => $item->product?->code ?? '-',
                'type' => 'KELUAR',
                'quantity' => $item->quantity,
                'user' => $item->user?->name ?? 'System',
            ];
        });

        $recentActivities = $stockIns->concat($stockOuts)->sortByDesc('time')->take(10)->values();

        // Data untuk grafik "Tren Keluar-Masuk Stok" 14 hari terakhir
        $last14Days = collect(range(13, 0))->map(function ($i) {
            return now()->subDays($i)->format('Y-m-d');
        });

        $stockInPerDay = StockIn::selectRaw('DATE(created_at) as date, SUM(quantity) as total')
            ->where('created_at', '>=', now()->subDays(13)->startOfDay())
            ->groupBy('date')
            ->pluck('total', 'date');

        $stockOutPerDay = StockOut::selectRaw('DATE(created_at) as date, SUM(quantity) as total')
            ->where('created_at', '>=', now()->subDays(13)->startOfDay())
            ->groupBy('date')
            ->pluck('total', 'date');

        $stockTrendLabels = $last14Days->map(fn ($date) => \Carbon\Carbon::parse($date)->translatedFormat('d M'))->values();
        $stockTrendMasuk  = $last14Days->map(fn ($date) => (int) ($stockInPerDay[$date] ?? 0))->values();
        $stockTrendKeluar = $last14Days->map(fn ($date) => (int) ($stockOutPerDay[$date] ?? 0))->values();

        // Data untuk donut chart "Distribusi Kategori"
        $categoryDistribution = Category::withCount('products')->get()->map(function ($category) use ($totalProducts) {
            return [
                'name' => $category->name,
                'count' => $category->products_count,
                'percentage' => $totalProducts > 0 ? round(($category->products_count / $totalProducts) * 100) : 0,
            ];
        });

        return view('dashboard_custom', compact(
            'totalProducts',
            'totalCategories',
            'totalSuppliers',
            'totalWarehouses',
            'lowStockProducts',
            'warehouseCapacities',
            'recentActivities',
            'stockTrendLabels',
            'stockTrendMasuk',
            'stockTrendKeluar',
            'categoryDistribution'
        ));
    }
}