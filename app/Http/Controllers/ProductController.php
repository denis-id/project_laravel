<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::all();

        // filter products
        $products = match ($request->sort) {
            'all', 'all-categories' => $products,
            'oldest' => $products->sortBy('created_at'),
            'active' => $products->where('is_active', true),
            'inactive' => $products->where('is_active', false),
            'lowest_price' => $products->sortBy('price'),
            'highest_price' => $products->sortByDesc('price'),
            'smallest_size' => $products->sortBy(fn($p) => $p->variants->min('size') ?? ''),
            'medium_size' => $products->filter(fn($p) => $p->variants->contains('size', 'M')),
            'biggest_size' => $products->sortByDesc(fn($p) => $p->variants->max('size') ?? ''),
            'lowest_stock' => $products->sortBy(fn($p) => $p->variants->min('stock') ?? 0),
            'highest_stock' => $products->sortByDesc(fn($p) => $p->variants->max('stock') ?? 0),
            'category' => $products->where('category_id', $request->category),
            default => $products->sortByDesc('created_at'),
        };
        
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
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'category_id' => 'required|exists:categories,id',
            'is_active' => 'boolean',
            'variants' => 'nullable|array',
            'variants.*.size' => 'required|string',
            'variants.*.stock' => 'required|integer',
            'variants.*price' => 'required|integer',
        ]);

        try {
            $product = Product::findOrFail($id);
            $product->name = $request->name;
            $product->description = $request->description;
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
                    $productVariant->price = $variant['price'];
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
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'category_id' => 'required|exists:categories,id',
            'is_active' => 'boolean',
            'variants' => 'nullable|array',
            'variants.*.size' => 'required|string',
            'variants.*.stock' => 'required|integer',
            'variants.*.price' => 'required|integer',
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
    
    public function downloadPdf($id)
    {
        $product = Product::find($id);

        // Render view jadi HTML
        $html = view('products.pdf', compact('product'))->render();

      // Konfigurasi Dompdf
      $options = new Options();
      $options->set('defaultFont', 'Helvetica');
      $options->set('isHtml5ParserEnabled', true);
      $options->set('isRemoteEnabled', true);

      // Buat Dompdf instance
      $dompdf = new Dompdf($options);
      $dompdf->loadHtml($html);
      $dompdf->setPaper('A4', 'portrait');
      $dompdf->render();

      // Download PDF
      return $dompdf->stream('product-' . $product->id . '.pdf');
        }
}    