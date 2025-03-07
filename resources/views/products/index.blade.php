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
            <div class="flex flex-col sm:flex-row sm:items-center gap-4 dark:text-white">
                <div class="flex flex-col">
                    <label for="sort" class="text-gray-800 dark:text-white font-semibold mb-1">Sort By:</label>
                    <form method="GET" action="{{ route('products.index') }}" class="flex gap-4">
                        <select name="sort" id="sort" onchange="this.form.submit()"
                            class="appearance-none px-4 py-2 rounded-lg border bg-white dark:bg-gray-800 text-gray-800 dark:text-white transition-all duration-300 ease-in-out focus:ring-2 focus:ring-blue-500 focus:outline-none">
                            <option value="all" {{ request('sort') == 'all' ? 'selected' : '' }} class="font-semibold">
                                All
                            </option>
                            <hr>
                            <option value="active" {{ request('sort') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ request('sort') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            <hr>
                            <option value="lowest_price" {{ request('sort') == 'lowest_price' ? 'selected' : '' }}>Lowest
                                Price</option>
                            <option value="highest_price" {{ request('sort') == 'highest_price' ? 'selected' : '' }}>Highest
                                Price</option>
                            <hr>
                            <option value="smallest_size" {{ request('sort') == 'smallest_size' ? 'selected' : '' }}>
                                Smallest Size</option>
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


                        <select name="category" id="category" onchange="this.form.submit()"
                            class="appearance-none px-4 py-2 rounded-lg border bg-white dark:bg-gray-800 text-gray-800 dark:text-white transition-all duration-300 ease-in-out focus:ring-2 focus:ring-blue-500 focus:outline-none">
                            <option value="all-categories" {{ request('category') == 'all' ? 'selected' : '' }}
                                class="font-semibold" selected>All
                                Categories</option>
                            <hr>
                            <option value="house-blend" {{ request('category') == 'house-blend' ? 'selected' : '' }}>House
                                Blend Coffee</option>
                            <hr>
                            <option value="arabica" {{ request('category') == 'arabica' ? 'selected' : '' }}>Arabica Coffee
                            </option>
                            <hr>
                            <option value="traditional" {{ request('category') == 'traditional' ? 'selected' : '' }}>
                                Traditional Coffee</option>
                            <hr>
                            <option value="non-coffee" {{ request('category') == 'non-coffee' ? 'selected' : '' }}>Non
                                Coffee</option>
                            <hr>
                            <option value="dessert" {{ request('category') == 'dessert' ? 'selected' : '' }}>Dessert
                            </option>
                            <hr>
                            <option value="japan-appetizer"
                                {{ request('category') == 'japan-appetizer' ? 'selected' : '' }}>Japan Appetizer</option>
                        </select>
                    </form>
                </div>
            </div>
        </div>
        <div class="max-w-full overflow-x-auto">
            <div class="min-w-[800px]">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-theme-xs font-medium text-gray-500 dark:text-gray-400">No</th>
                            <th class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Image</th>
                            <th class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Name</th>
                            <th class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Price</th>
                            <th class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Size</th>
                            <th class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Stock</th>
                            <th class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Category</th>
                            <th class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Description</th>
                            <th class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $index => $product)
                            <tr class="border-b border-gray-200 dark:border-gray-700 text-center">
                                <td class="px-4 py-2 text-xs text-gray-800 dark:text-white/90">
                                    {{ $index + 1 }}
                                </td>
                                <td class="px-4 py-4 text-xs text-gray-800 dark:text-white/90">
                                    @if ($product->images)
                                        <div class="flex flex-wrap gap-2">
                                            @foreach ($product->images as $image)
                                                <img src="{{ asset('storage/' . $image) }}" alt="{{ $product->name }}"
                                                    class="h-20 w-20 object-cover rounded-lg">
                                            @endforeach
                                        </div>
                                    @else
                                        <p class="text-center text-gray-500">No Images</p>
                                    @endif
                                </td>
                                <td class="px-2 py-2 text-sm font-medium text-gray-800 dark:text-white/90">
                                    {{ $product->name }}
                                    <div
                                        class="rounded-full px-2 py-0.5 text-xs font-medium {{ $product->is_active ? ' text-success-700  dark:text-success-500' : 'text-warning-700  dark:text-warning-400' }}">
                                        <span
                                            class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Status:</span>
                                        {{ $product->is_active ? 'Active' : 'Inactive' }}
                                    </div>
                                </td>
                                <td class="px-4 py-2 text-xs font-medium text-red-700 dark:text-red/90 whitespace-nowrap">
                                    Rp {{ number_format($product->price, 2, ',', '.') }}
                                </td>
                                <td class="px-4 py-2 text-xs font-medium text-black dark:text-white/90">
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
                                    <div class="max-w-[200px] max-h-[50px] overflow-auto whitespace-nowrap">
                                        {{ $product->category->name ?? 'No Category' }}
                                        <span class="text-gray-500">(ID:
                                            {{ $product->category->id ?? 'No ID' }})</span>
                                    </div>
                                </td>
                                <td class="px-4 py-2 text-xs text-gray-800 dark:text-white/90"
                                    style="max-width: 200px; overflow-y: auto; max-height: 100px;">
                                    @if (str_word_count($product->description ?? '') > 10)
                                        <div style="max-height: 100px; overflow-y: auto;">
                                            {{ $product->description ?? 'No description available' }}
                                        </div>
                                    @else
                                        {{ $product->description ?? 'No description available' }}
                                    @endif
                                </td>
                                <td class="px-4 py-2 text-sm flex items-center space-x-4">
                                    <form action="{{ route('products.edit', $product->id) }}"
                                        class="bg-blue-100 text-blue-500 hover:bg-blue-200 hover:text-blue-700 transition duration-300 ease-in-out transform hover:scale-110 px-2 py-1 rounded-lg">
                                        <button>
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    </form>
                                    <form id="download-form" action="{{ route('products.downloadPdf', $product->id) }}"
                                        method="GET" class="">
                                        <button
                                            class="bg-black text-white hover:bg-red-600 transition duration-300 ease-in-out transform hover:scale-105 px-1 py-0.5 rounded-md text-xs flex items-center space-x-2">
                                            <i class="fas fa-file-pdf text-sm"></i>
                                        </button>
                                    </form>
                                    <form class="btn-product-delete" action="{{ route('products.destroy', $product->id) }}"
                                        method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="bg-red-100 text-red-600 hover:bg-red-200 hover:text-red-800 transition duration-300 ease-in-out transform hover:scale-110 px-2 py-1 rounded-lg">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </td>

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
