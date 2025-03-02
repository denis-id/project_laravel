@extends('layouts.app')
@section('content')
    <div
        class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] shadow-lg transition-transform duration-300 hover:scale-105 max-w-full overflow-x-auto">
        <div class="px-5 py-4 sm:px-6 sm:py-5 bg-gradient-to-r from-blue-500 to-purple-500 rounded-t-2xl">
            <h3 class="text-base font-medium text-white">Products</h3>
        </div>

        <div class="p-6.5">
            @if (session('success'))
                <div>{{ session('success') }}</div>
            @endif
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead>
                    <tr>
                        <th class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Image</th>
                        <th class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Name</th>
                        <th class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Price</th>
                        <th class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Size</th>
                        <th class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Active</th>
                        <th class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Category
                        </th>
                        <th class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Actions
                        </th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($products as $product)
                        <tr class="border-b border-gray-200 dark:border-gray-700">
                            <td class="px-4 py-2 text-sm text-gray-800 dark:text-white/90">
                                <img src="{{ asset('storage/' . $product->images) }}" alt="{{ $product->name }}">
                                class="h-12 w-12 object-cover rounded-lg">
                            </td>
                            <td class="px-4 py-2 text-sm text-gray-800 dark:text-white/90">
                                {{ $product->name }}</td>
                            <td class="px-4 py-2 text-sm text-gray-800 dark:text-white/90">
                                ${{ number_format($product->price, 2) }}</td>
                            <td class="px-4 py-2 text-sm text-gray-800 dark:text-white/90">
                                {{ $product->size }}</td>
                            <td class="px-4 py-2 text-sm text-gray-800 dark:text-white/90">
                                {{ $product->is_active ? 'Yes' : 'No' }}</td>
                            <td class="px-4 py-2 text-sm text-gray-800 dark:text-white/90">
                                {{ $product->category->name ?? 'No Category' }}</td>
                            <td class="px-4 py-2 text-sm">
                                <form method="POST" class="btn-product-delete"
                                    action="{{ route('products.destroy', ['product' => $product->id]) }}">
                                    <a href="{{ route('products.edit', $product->id) }}"
                                        class="text-blue-600 hover:text-blue-800">Edit</a>
                                    •
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
