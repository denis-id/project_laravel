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
            <div class="max-w-full overflow-x-auto">
                <div class="min-w-[800px]">
                    @if (session('success'))
                        <div class="text-green-500">{{ session('success') }}</div>
                    @endif
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead>
                            <tr>
                                <th class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Image</th>
                                <th class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Name</th>
                                <th class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Price</th>
                                <th class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Size</th>
                                <th class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Stock</th>
                                <th class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Active</th>
                                <th class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Category</th>
                                <th class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Actions</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($products as $product)
                                <tr class="border-b border-gray-200 dark:border-gray-700">
                                    <td class="px-4 py-2 text-sm text-gray-800 dark:text-white/90">
                                        <img src="{{ $product->images }}" alt="{{ $product->name }}"
                                            class="h-12 w-12 object-cover rounded-lg">
                                    </td>
                                    <td class="px-4 py-2 text-sm text-gray-800 font-medium dark:text-white/90">
                                        {{ $product->name }}
                                    </td>
                                    <td class="px-4 py-2 text-sm font-medium text-red-700 dark:text-white/90">
                                        Rp {{ number_format($product->price, 2, ',', '.') }}
                                    </td>
                                    <td class="px-4 py-2 text-sm text-gray-800 dark:text-white/90">
                                        @if ($product->variants && $product->variants->count())
                                            @foreach ($product->variants as $variant)
                                                <span>{{ $variant->size ?? 'No Size' }} </span>
                                            @endforeach
                                        @else
                                            <span>No Size Available</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-2 text-sm font-medium text-gray-500 font-medium dark:text-white/90">
                                        @if ($product->variants && $product->variants->count())
                                            @foreach ($product->variants as $variant)
                                                <span>{{ $variant->stock ?? 'Out of stock' }} </span>
                                            @endforeach
                                        @else
                                            <span>Out of stock</span>
                                        @endif
                                    </td>
                                    <td
                                        class="px-4 py-2 text-sm text-gray-800 dark:text-white/90 {{ $product->is_active ? 'text-green-500 font-bold' : 'text-orange-700 font-bold' }}">
                                        {{ $product->is_active ? 'Yes' : 'No' }}
                                    </td>
                                    <td class="px-4 py-2 text-sm font-medium text-gray-800 dark:text-white/90">
                                        {{ $product->category->name ?? 'No Category' }}
                                        <span class="text-gray-500"> (ID: {{ $product->category->id ?? 'N/A' }})</span>
                                    </td>
                                    <td class="px-4 py-2 text-sm">
                                        <a href="{{ route('products.edit', $product->id) }}"
                                            class="text-blue-500 hover:underline">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        •
                                        <form action="{{ route('products.destroy', $product->id) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:underline"
                                                onclick="return confirm('Are you sure?')">
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
