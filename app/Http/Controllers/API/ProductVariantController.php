<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;

class ProductVariantController extends Controller
{
    // Menampilkan daftar varian
    public function index()
    {
        $variants = ProductVariant::with('product')->get();
        return response()->json($variants);
    }

    // Menyimpan varian baru
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'size' => 'required|string|max:50',
            'stock' => 'required|integer|min:0',
        ]);

        $variant = ProductVariant::create($request->all());
        return response()->json(['message' => 'Variant created successfully.', 'variant' => $variant], 201);
    }

    // Menampilkan varian berdasarkan ID
    public function show($id)
    {
        $variant = ProductVariant::with('product')->findOrFail($id);
        return response()->json($variant);
    }

    // Mengupdate varian
    public function update(Request $request, $id)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'size' => 'required|string|max:50',
            'stock' => 'required|integer|min:0',
        ]);

        $variant = ProductVariant::findOrFail($id);
        $variant->update($request->all());

        return response()->json(['message' => 'Variant updated successfully.', 'variant' => $variant]);
    }

    // Menghapus varian
    public function destroy($id)
    {
        $variant = ProductVariant::findOrFail($id);
        $variant->delete();

        return response()->json(['message' => 'Variant deleted successfully.']);
    }
}