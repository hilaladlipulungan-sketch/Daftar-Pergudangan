<?php

namespace App\Http\Controllers;

use App\Models\StockIn;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockInController extends Controller
{
    public function index()
    {
        $stockIns = StockIn::with(['product', 'supplier'])->latest()->get();
        return view('stock_ins.index', compact('stockIns'));
    }

    public function create()
    {
        $products = Product::all();
        $suppliers = Supplier::all();
        return view('stock_ins.create', compact('products', 'suppliers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string',
        ]);


        DB::transaction(function () use ($validated) {
            StockIn::create($validated);

            $product = Product::findOrFail($validated['product_id']);
            $product->increment('stock', $validated['quantity']);
        });

        return redirect()->route('stock-ins.index')
            ->with('success', 'Barang masuk berhasil dicatat.');
    }

    public function destroy(StockIn $stockIn)
    {
        DB::transaction(function () use ($stockIn) {
            $product = $stockIn->product;
            $product->decrement('stock', $stockIn->quantity);
            $stockIn->delete();
        });

        return redirect()->route('stock-ins.index')
            ->with('success', 'Data barang masuk berhasil dihapus.');
    }
}