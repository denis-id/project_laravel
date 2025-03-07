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
        return view('products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('products.form', compact('categories'));
    }

    public function store(Request $request)
    {
        $this->validateProduct($request);

        try {
            $product = Product::create($this->getProductData($request));
            $this->handleImages($request, $product);
            $this->handleVariants($request, $product);

            return redirect()->route('products.index')->with('success', 'Product created successfully');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to create product: ' . $e->getMessage());
        }
    }

    public function show(string $id)
    {
        $product = Product::with('category', 'variants')->findOrFail($id);
        return view('products.show', compact('product'));
    }

    public function edit(string $id)
    {
        $product = Product::with('variants')->findOrFail($id);
        $categories = Category::all();
        return view('products.form', compact('product', 'categories'));
    }

    public function update(Request $request, string $id)
    {
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
            $product = Product::findOrFail($id);
            $product->name = $request->name;
            $product->description = $request->description;
            $product->price = $request->price;
            $product->category_id = $request->category_id;
            $product->is_active = $request->is_active ?? false;
            $product->save();

            if ($request->hasFile('images')) {
                if ($product->images) {
                    foreach ($product->images as $image) {
                        Storage::disk('public')->delete($image);
                    }
                }

                $imagePaths = [];
                foreach ($request->file('images') as $image) {
                    $path = $image->store('products', 'public');
                    $imagePaths[] = $path;
                }
                $product->images = $imagePaths;
                $product->save();
            }

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
        try {
            $product = Product::findOrFail($id);
            $this->deleteImages($product);
            $product->variants()->delete();
            $product->delete();

            return redirect()->route('products.index')->with('success', 'Product deleted successfully');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete product: ' . $e->getMessage());
        }
    }

    public function validateProduct(Request $request, $id = null)
    {
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
    }

    public function getProductData(Request $request)
    {
        return $request->only([
            'name', 
            'description', 
            'price', 
            'category_id']) + ['is_active' => $request->is_active ?? false
        ];
    }

    public function handleImages(Request $request, Product $product, $isUpdate = false)
    {
        if ($request->hasFile('images')) {
            if ($isUpdate && $product->images) {
                $this->deleteImages($product);
            }

            $imagePaths = [];
            foreach ($request->file('images') as $image) {
                $imagePaths[] = $image->store('products', 'public');
            }

            $product->images = $imagePaths;
            $product->save();
        }
    }

    public function handleVariants(Request $request, Product $product, $isUpdate = false)
    {
        if ($isUpdate) {
            $product->variants()->delete();
        }

        if ($request->has('variants')) {
            foreach ($request->variants as $variant) {
                $product->variants()->create($variant);
            }
        }
    }

    public function deleteImages(Product $product)
    {
        if ($product->images) {
            foreach ($product->images as $image) {
                Storage::disk('public')->delete($image);
            }
        }
    }
}    