<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();

        return view('products.index', ['products' => $products]);
    }
    public function create()
    {
        $categories = Category::all();
        $variants = ProductVariant::select('variant_name', 'size')->get()->pluck('size', 'variant_name');
        return view('products.form', compact('categories', 'variants'));
    }
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255|unique:products',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'category_id' => 'required|exists:categories,id',
            'variant_name' => 'required|string|max:50',
            'is_active' => 'boolean',
        ]);

        try {
            // Simpan data produk
            $product = new Product();
            $product->name = $request->name;
            $product->description = $request->description;
            $product->price = $request->price;
            $product->category_id = $request->category_id;
            $product->is_active = $request->is_active ?? false;
            $product->save();

            // Simpan gambar produk
            if ($request->hasFile('images')) {
                $imagePaths = [];
                foreach ($request->file('images') as $image) {
                    $path = $image->store('products', 'public'); 
                    $imagePaths[] = $path;
                }
                $product->images = $imagePaths;
                $product->save();
            }

            // Simpan varian produk 
            if ($request->has('variants')) {
                foreach ($request->variants as $variant) {
                    $productVariant = new ProductVariant();
                    $productVariant->product_id = $product->id;
                    $productVariant->variant_name = $variant['variant_name'];
                    $productVariant->size = $variant['size'];
                    $productVariant->stock = $variant['stock'];
                    $productVariant->save();
                }
            }

            Product::create([
                

            ]);

            return redirect()->route('products.index')->with('success', 'Product created successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to create product: ' . $e->getMessage());
        }
    }
    public function show(string $id)
    {
        try {
            $product = Product::with('category', 'variants')->findOrFail($id);
            return view('products.show', compact('product'));
        } catch (\Exception $e) {
            return back()->with('error', 'Product not found: ' . $e->getMessage());
        }
    }

    public function edit(string $id)
    {   
        try {
            $product = Product::find($id);
            
            $categories = Category::all();
            $variants = ProductVariant::select('variant_name', 'size')->get()->pluck('size', 'variant_name');
            return view('products.form', compact('product', 'categories', 'variants'));
        } catch (\Exception $e) {
            return back()->with('error', 'Product not found: ' . $e->getMessage());
        }
    }

    public function update(Request $request, string $id)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255|unique:products,name,' . $id,
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'category_id' => 'required|exists:categories,id',
            'variant' => 'required|string|max:50',
            'is_active' => 'boolean',
        ]);

        try {
            // Temukan produk yang akan diupdate
            $product = Product::findOrFail($id);
            $product->name = $request->name;
            $product->description = $request->description;
            $product->price = $request->price;
            $product->stock = $request->stock;
            $product->category_id = $request->category_id;
            $product->is_active = $request->is_active ?? false;
            $product->variant = $request->variant;
            $product->save();

            // Update gambar produk
            if ($request->hasFile('images')) {
                $imagePaths = [];
                foreach ($request->file('images') as $image) {
                    $path = $image->store('products', 'public');
                    $imagePaths[] = $path;
                }
                $product->images = $imagePaths;
                $product->save();
            }

            // Update varian produk
            if ($request->has('variants')) {
                $product->variants()->delete(); 
                foreach ($request->variants as $variant) {
                    $productVariant = new ProductVariant();
                    $productVariant->product_id = $product->id;
                    $productVariant->size = $variant['size'];
                    $productVariant->stock = $variant['stock'];
                    $productVariant->save();
                }
            }

            return redirect()->route('products.index')->with('success', 'Product updated successfully');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to update product: ' . $e->getMessage());
        }
    }

    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('products.index')->with(['success' => 'Product deleted success']);
    }
}