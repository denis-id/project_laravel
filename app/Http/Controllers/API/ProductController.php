<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::with('variants')
            ->select(
                'products.id', 
                'products.name', 
                'products.is_active', 
                'products.description', 
                'products.category_id', 
                'products.images', 
                'categories.name as category_name'
            )
            ->join('categories', 'categories.id', '=', 'products.category_id')
            ->get()
            ->map(function ($product) {
                $product->images = collect($product->images)->map(fn($img) => asset('storage/' . $img));
                return $product;
            });

        return response()->json($products);
    }

    public function show(string $id)
    {
        $product = Product::with('variants')->select(
            'products.id', 'products.name', 'products.is_active', 'products.description', 
            'products.category_id', 'products.images', 'categories.name as category_name'
        )
        ->join('categories', 'categories.id', '=', 'products.category_id')
        ->findOrFail($id);

        $product->images = collect($product->images)->map(fn($img) => asset('storage/' . $img));

        return response()->json($product);
    }

    public function getVariantsByProduct($productId)
    {
        $variants = ProductVariant::where('product_id', $productId)->get();
        return response()->json($variants);
    }
}