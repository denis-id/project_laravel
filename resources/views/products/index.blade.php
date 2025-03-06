@extends('layouts.app')
@section('content')
    <div
        class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] shadow-lg transition-transform duration-300 hover:scale-105 max-w-full overflow-x-auto">
        <div
            class="px-5 py-4 sm:px-6 sm:py-5 bg-gradient-to-r from-blue-500 to-purple-500 rounded-t-2xl flex justify-between items-center">
            <h3 class="text-base font-medium text-white">Products</h3>
            <a href="{{ route('products.create') }}"
                class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition">
                + Add Product
            </a>
        </div>

        <div class="border-t border-gray-100 p-5 dark:border-gray-800 sm:p-6">
            <div class="mb-4 dark:text-white">Sort By
                <form method="GET" action="{{ route('products.index') }}">
                    <select name="sort" onchange="this.form.submit()"
                        class="appearance-none px-4 py-2 rounded-lg border bg-white dark:bg-gray-800 text-gray-800 dark:text-white transition-all duration-300 ease-in-out focus:ring-2 focus:ring-blue-500 focus:outline-none">
                        <option value="all" {{ request('sort') == 'all' ? 'selected' : '' }}>All</option>
                        <hr>
                        <option value="active" {{ request('sort') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('sort') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        <hr>
                        <option value="lowest_price" {{ request('sort') == 'lowest_price' ? 'selected' : '' }}>Lowest Price
                        </option>
                        <option value="highest_price" {{ request('sort') == 'highest_price' ? 'selected' : '' }}>Highest
                            Price</option>
                        <hr>
                        <option value="smallest_size" {{ request('sort') == 'smallest_size' ? 'selected' : '' }}>Smallest
                            Size</option>
                        <option value="medium_size" {{ request('sort') == 'medium_size' ? 'selected' : '' }}>Medium Size
                        </option>
                        <option value="biggest_size" {{ request('sort') == 'biggest_size' ? 'selected' : '' }}>Big Size
                        </option>
                        <hr>
                        <option value="lowest_stock" {{ request('sort') == 'lowest_stock' ? 'selected' : '' }}>Minimum
                            Stock</option>
                        <option value="highest_stock" {{ request('sort') == 'highest_stock' ? 'selected' : '' }}>High
                            Stock</option>
                    </select>
                </form>
            </div>

            <div class="max-w-full overflow-x-auto">
                <div class="min-w-[800px]">
                    @php
                        $products = match (request('sort')) {
                            'all' => $products,
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
                            default => $products->sortByDesc('created_at'),
                        };
                    @endphp

                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead>
                            <tr>
                                <th class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">No</th>
                                <th class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Image</th>
                                <th class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Name</th>
                                <th class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Price</th>
                                <th class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Size</th>
                                <th class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Stock</th>
                                <th class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Category</th>
                                <th class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Description</th>
                                <th class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Status</th>
                                <th class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $index => $product)
                                <tr class="border-b border-gray-200 dark:border-gray-700">
                                    <td class="px-4 py-2 text-sm text-gray-800 dark:text-white/90">
                                        {{ $index + 1 }}
                                    </td>
                                    <td class="px-4 py-2 text-xs text-gray-800 dark:text-white/90">
                                        @if ($product->images)
                                            @foreach ($product->images as $image)
                                                <img src="{{ asset('storage/' . $image) }}" alt="{{ $product->name }}"
                                                    class="h-12 w-12 object-cover rounded-lg">
                                            @endforeach
                                        @else
                                            <p>No Images</p>
                                        @endif
                                    </td>
                                    <td class="px-4 py-2 text-sm font-medium text-gray-800 dark:text-white/90">
                                        {{ $product->name }}
                                    </td>
                                    <td class="px-4 py-2 text-xs font-medium text-red-700 dark:text-red/90">
                                        Rp {{ number_format($product->price, 2, ',', '.') }}
                                    </td>
                                    <td class="px-4 py-2 text-xs font-bold text-black dark:text-white/90">
                                        @foreach ($product->variants as $variant)
                                            <span>{{ $variant->size ?? 'No Size' }}</span>
                                        @endforeach
                                    </td>
                                    <td class="px-4 py-2 text-xs font-bold">
                                        @foreach ($product->variants as $variant)
                                            <span
                                                class="{{ $variant->stock < 20 ? 'text-red-600 dark:text-orange/90' : 'text-blue-500 dark:text-blue/90' }}">
                                                {{ $variant->stock ?? 'Out of stock' }}
                                            </span>
                                        @endforeach
                                    </td>

                                    <td class="px-4 py-2 text-sm font-medium text-gray-800 dark:text-white/90">
                                        {{ $product->category->name ?? 'No Category' }}
                                    </td>
                                    <td class="px-4 py-2 text-xs text-gray-800 dark:text-white/90">
                                        {{ $product->description ?? 'No description available' }}
                                    </td>
                                    <td
                                        class="rounded-full px-2 py-0.5 text-xs font-medium {{ $product->is_active ? 'bg-success-50 text-success-700 dark:bg-success-500/15 dark:text-success-500' : 'bg-warning-50 text-warning-700 dark:bg-warning-500/15 dark:text-warning-400' }}">
                                        {{ $product->is_active ? 'Active' : 'Inactive' }}
                                    </td>
                                    <td class="px-4 py-2 text-sm">
                                        <a href="{{ route('products.edit', $product->id) }}"
                                            class="text-blue-500 hover:underline">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        •
                                        <form class="btn-product-delete"
                                            action="{{ route('products.destroy', $product->id) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('.btn-product-delete').on('submit', function(event) {
                event.preventDefault();
                Swal.fire({
                    title: 'Are you sure you want to delete this product?',
                    text: 'You will not be able to recover this product.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it',
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    cancelButtonText: 'No',
                }).then((result) => {
                    if (result.value) {
                        this.submit();
                    }
                })
            })
        })
    </script>
@endsection
