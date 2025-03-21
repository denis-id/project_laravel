@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6">
        <h1
            class="text-2xl sm:text-3xl font-extrabold text-center bg-gradient-to-r from-blue-500 to-blue-600 text-transparent bg-clip-text animate-pulse mb-4">
            Order List
        </h1>

        @if (session('success'))
            <div
                class="bg-gradient-to-r from-green-100 to-green-300 text-green-800 p-2 rounded-lg mb-4 text-sm dark:from-green-900 dark:to-green-700 dark:text-green-200">
                {{ session('success') }}
            </div>
        @endif

        <form method="GET" action="{{ route('orders.index') }}"
            class="mb-6 flex items-center gap-2 bg-white dark:bg-gray-800 p-4 rounded-xl shadow-md">
            <input type="text" name="search" placeholder="🔍 Search Orders..." value="{{ request('search') }}"
                class="w-full p-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 ease-in-out" />
            <button type="submit"
                class="px-4 py-3 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition duration-200 ease-in-out">
                Search
            </button>
        </form>

        <div
            class="overflow-x-auto bg-gradient-to-r from-white to-gray-100 shadow-md rounded-xl dark:from-gray-800 dark:to-gray-900">
            <table class="min-w-full border-collapse">
                <thead>
                    <tr
                        class="bg-gradient-to-r from-blue-500 to-blue-700 text-white text-sm dark:from-blue-700 dark:to-blue-900">
                        <th class="py-2 px-4">ID</th>
                        <th class="py-2 px-4">Name</th>
                        <th class="py-2 px-4">Email</th>
                        <th class="py-2 px-4">Total Price</th>
                        <th class="py-2 px-4">Products</th> <!-- Tambahan kolom produk -->
                        <th class="py-2 px-4">Status</th>
                        <th class="py-2 px-4">Payment Info</th>
                        <th class="py-2 px-4">Detail</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                        <tr
                            class="border-b hover:bg-gradient-to-r from-blue-50 to-blue-100 transition duration-200 text-sm dark:hover:from-blue-900 dark:hover:to-blue-800">
                            <td class="py-2 px-4 dark:text-gray-200">{{ $order->id }}</td>
                            <td class="py-2 px-4 dark:text-gray-200">{{ $order->first_name }} {{ $order->last_name }}</td>
                            <td class="py-2 px-4 dark:text-gray-200">{{ $order->email }}</td>
                            <td class="py-2 px-4 dark:text-gray-200">Rp{{ number_format($order->price, 0, ',', '.') }}</td>
                            <td class="py-2 px-4 dark:text-gray-200">
                                {{ $order->products_name ?? '-' }} <!-- Menampilkan produk -->
                            </td>
                            <td class="py-2 px-4">
                                <span
                                    class="px-3 py-1 rounded-full text-white text-xs {{ $order->status === 'PAID' ? 'bg-gradient-to-r from-green-500 to-green-700' : 'bg-gradient-to-r from-yellow-500 to-yellow-700' }}">
                                    {{ $order->status }}
                                </span>
                            </td>
                            <td
                                class="py-2 px-4 bg-blue-50 hover:bg-blue-100 dark:bg-blue-800 dark:hover:bg-blue-700 text-gray-700 dark:text-gray-200">
                                <div class="text-sm">
                                    <p>
                                        <span class="text-blue-600 dark:text-blue-400 font-semibold">Method:</span>
                                        <span
                                            class="text-gray-800 dark:text-gray-300">{{ $order->payment_method ?? '-' }}</span>
                                    </p>
                                    <p>
                                        <span class="text-green-600 dark:text-green-500 font-semibold">Channel:</span>
                                        <span
                                            class="text-gray-800 dark:text-gray-300">{{ $order->payment_channel ?? '-' }}</span>
                                    </p>
                                </div>
                            </td>
                            <td class="py-2 px-4 text-center">
                                <a href="{{ route('orders.show', $order->id) }}"
                                    class="text-blue-500 hover:underline text-sm dark:text-blue-300">Order Details</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-6 text-gray-500 text-sm dark:text-gray-400">
                                No Orders Available...
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
