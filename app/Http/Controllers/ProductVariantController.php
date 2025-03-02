<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductVariant;

class ProductVariantController extends Controller
{
    public function index()
    {
        try {
            $variants = ProductVariant::all();
            return response()->json($variants, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch product variants', 'message' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'product_id' => 'required|integer|exists:products,id',
                'variant_name' => 'required|string|max:255',
                'stock' => 'required|integer|min:0',
                'size' => 'required|string|max:50',
            ]);

            $variant = ProductVariant::create($validatedData);
            return response()->json(['message' => 'Product variant created successfully', 'data' => $variant], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create product variant', 'message' => $e->getMessage()], 500);
        }
    }

    public function show(ProductVariant $productVariant)
    {
        return response()->json($productVariant, 200);
    }

    public function update(Request $request, ProductVariant $productVariant)
    {
        try {
            $validatedData = $request->validate([
                'product_id' => 'sometimes|integer|exists:products,id',
                'variant_name' => 'required|string|max:255',
                'stock' => 'required|integer|min:0',
                'size' => 'required|string|max:50',
            ]);

            $productVariant->update($validatedData);
            return response()->json(['message' => 'Product variant updated successfully', 'data' => $productVariant], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update product variant', 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy(ProductVariant $productVariant)
    {
        try {
            $productVariant->delete();
            return response()->json(['message' => 'Product variant deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete product variant', 'message' => $e->getMessage()], 500);
        }
    }
}