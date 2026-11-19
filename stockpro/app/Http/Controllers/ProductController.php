<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Warehouse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $products = Product::with(['category', 'warehouse'])
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('code', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('products.index', compact('products', 'search'));
    }

    public function create()
    {
        $categories = Category::all();
        $warehouses = Warehouse::all();
        return view('products.create', compact('categories', 'warehouses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:255|unique:products,code',
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'warehouse_id' => 'required|exists:warehouses,id',
            'price' => 'nullable|numeric|min:0',
            'stock' => 'nullable|integer|min:0',
            'min_stock' => 'nullable|integer|min:0',
        ]);

        $validated['price'] = $validated['price'] ?? 0;
        $validated['stock'] = $validated['stock'] ?? 0;
        $validated['min_stock'] = $validated['min_stock'] ?? 0;

        Product::create($validated);

        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil ditambahkan.');
    }

    public function show(Product $product)
    {
        $product->load(['category', 'warehouse']);

        $stockIns = $product->stockIns()->latest()->take(5)->get();
        $stockOuts = $product->stockOuts()->latest()->take(5)->get();

        return view('products.show', compact('product', 'stockIns', 'stockOuts'));
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        $warehouses = Warehouse::all();
        return view('products.edit', compact('product', 'categories', 'warehouses'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:255|unique:products,code,' . $product->id,
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'warehouse_id' => 'required|exists:warehouses,id',
            'price' => 'nullable|numeric|min:0',
            'stock' => 'nullable|integer|min:0',
            'min_stock' => 'nullable|integer|min:0',
        ]);

        $validated['price'] = $validated['price'] ?? 0;
        $validated['stock'] = $validated['stock'] ?? 0;
        $validated['min_stock'] = $validated['min_stock'] ?? 0;

        $product->update($validated);

        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil dihapus.');
    }
}