<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;

class ProductVariantController extends Controller
{
    // Menampilkan daftar varian
    public function index()
    {
        $variants = ProductVariant::with('product')->get();
        return view('variants.index', compact('variants'));
    }

    // Menampilkan form tambah varian
    public function create()
    {
        $products = Product::all();
        return view('variants.create', compact('products'));
    }

    // Menyimpan varian baru
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'size' => 'required|string|max:50',
            'stock' => 'required|integer|min:0',
        ]);

        ProductVariant::create($request->all());

        return redirect()->route('variants.index')->with('success', 'Variant created successfully.');
    }

    // Menampilkan form edit varian
    public function edit(ProductVariant $variant)
    {
        $products = Product::all();
        return view('variants.edit', compact('variant', 'products'));
    }

    // Mengupdate varian
    public function update(Request $request, ProductVariant $variant)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'size' => 'required|string|max:50',
            'stock' => 'required|integer|min:0',
        ]);

        $variant->update($request->all());

        return redirect()->route('variants.index')->with('success', 'Variant updated successfully.');
    }

    // Menghapus varian
    public function destroy(ProductVariant $variant)
    {
        $variant->delete();
        return redirect()->route('variants.index')->with('success', 'Variant deleted successfully.');
    }
}