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
        return view('products.form', compact('categories'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255|unique:products',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'category_id' => 'required|exists:categories,id',
            'is_active' => 'boolean',
            'variants' => 'nullable|array',
            'variants.*.size' => 'required|string',
            'variants.*.stock' => 'required|integer',
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
                    $productVariant->size = $variant['size'];
                    $productVariant->stock = $variant['stock'];
                    $productVariant->save();
                }
            }

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
            $product = Product::with('variants')->findOrFail($id);
            $categories = Category::all();
            return view('products.form', compact('product', 'categories'));
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
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'category_id' => 'required|exists:categories,id',
            'is_active' => 'boolean',
            'variants' => 'nullable|array',
            'variants.*.size' => 'required|string',
            'variants.*.stock' => 'required|integer',
        ]);

        try {
            // Temukan produk yang akan diupdate
            $product = Product::findOrFail($id);
            $product->name = $request->name;
            $product->description = $request->description;
            $product->price = $request->price;
            $product->category_id = $request->category_id;
            $product->is_active = $request->is_active ?? false;
            $product->save();

            // Update gambar produk
            if ($request->hasFile('images')) {
                // Hapus gambar lama jika ada
                if ($product->images) {
                    foreach ($product->images as $image) {
                        Storage::disk('public')->delete($image);
                    }
                }

                // Simpan gambar baru
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
                $product->variants()->delete(); // Hapus varian lama
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
        try {
            $product = Product::findOrFail($id);

            // Hapus gambar produk
            if ($product->images) {
                foreach ($product->images as $image) {
                    Storage::disk('public')->delete($image);
                }
            }

            // Hapus varian produk
            $product->variants()->delete();

            // Hapus produk
            $product->delete();

            return redirect()->route('products.index')->with('success', 'Product deleted successfully');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete product: ' . $e->getMessage());
        }
    }
    public function search(Request $request)
    {
        $request->validate([
            'q' => 'required|string|min:2|max:255',
        ]);
        
        $query = $request->input('q');

        $products = Product::query()
            ->where('name', 'LIKE', "%{$query}%")
            ->orWhere('description', 'LIKE', "%{$query}%")
            ->orWhereHas('category', function ($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%");
            })
            ->get();

        return response()->json($products);
    }
}