<?php

namespace App\Http\Controllers;

use App\Models\StockOut;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class StockOutController extends Controller
{
    public function index()
    {
        $stockOuts = StockOut::with('product')->latest()->get();
        return view('stock_outs.index', compact('stockOuts'));
    }

    public function create()
    {
        $products = Product::all();
        return view('stock_outs.create', compact('products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'destination' => 'nullable|string|max:255',
            'quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string',
        ]);

        $product = Product::findOrFail($validated['product_id']);

        if ($validated['quantity'] > $product->stock) {
            throw ValidationException::withMessages([
                'quantity' => 'Jumlah keluar melebihi stok yang tersedia (stok saat ini: ' . $product->stock . ').',
            ]);
        }

        DB::transaction(function () use ($validated, $product) {
            StockOut::create($validated);
            $product->decrement('stock', $validated['quantity']);
        });

        return redirect()->route('stock-outs.index')
            ->with('success', 'Barang keluar berhasil dicatat.');
    }

    public function destroy(StockOut $stockOut)
    {
        DB::transaction(function () use ($stockOut) {
            $product = $stockOut->product;
            $product->increment('stock', $stockOut->quantity);
            $stockOut->delete();
        });

        return redirect()->route('stock-outs.index')
            ->with('success', 'Data barang keluar berhasil dihapus.');
    }
}