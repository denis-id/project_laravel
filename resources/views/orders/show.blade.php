@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6">
        <div class="flex flex-col sm:flex-row items-center justify-between mb-6">
            <a href="{{ route('orders.index') }}"
                class="inline-flex items-center px-6 py-3 bg-blue-500 text-white font-bold rounded-2xl shadow-lg transform transition duration-500 hover:scale-110 mb-4 sm:mb-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Back to Orders
            </a>
            <h1
                class="text-2xl sm:text-3xl font-extrabold text-center bg-gradient-to-r from-blue-500 to-purple-600 text-transparent bg-clip-text animate-pulse">
                Detail Order #{{ $order->id }}</h1>
        </div>

        <div
            class="bg-gradient-to-br from-white to-blue-100 shadow-2xl rounded-2xl p-6 sm:p-8 transition-transform duration-500 hover:scale-105 dark:from-gray-800 dark:to-gray-900 dark:text-white">
            <div class="space-y-4">
                <p><strong>Name:</strong> {{ $order->first_name }} {{ $order->last_name }}</p>
                <p><strong>Email:</strong> {{ $order->email }}</p>
                <p><strong>Address:</strong> {{ $order->address }}, {{ $order->city }}, {{ $order->country }}</p>
                <p><strong>Postal Code:</strong> {{ $order->postal_code }}</p>
                <p><strong>Payment Channel:</strong> {{ $order->payment_channel }}</p>
                <p><strong>Payment Method:</strong> {{ $order->payment_method }}</p>
                <p><strong>Total Price:</strong> Rp{{ number_format($order->price, 0, ',', '.') }}</p>
                <p><strong>Status:</strong> {{ $order->status }}</p>
                <p><strong>Created At:</strong> {{ $order->created_at }}</p>
            </div>

            <div class="mt-8">
                <h2 class="text-xl font-bold text-blue-700 dark:text-blue-300">Products in this Order:</h2>
                <ul class="space-y-4 mt-4">
                    @if ($order->orderProducts->isNotEmpty())
                        @foreach ($order->orderProducts as $orderProduct)
                            <li
                                class="bg-gradient-to-r from-blue-100 to-blue-200 p-4 rounded-lg dark:from-blue-800 dark:to-blue-900">
                                <p><strong>Product:</strong>
                                    {{ $orderProduct->productVariant->product->name ?? 'Unknown Product' }}</p>
                                <p><strong>Size:</strong> {{ $orderProduct->productVariant->size ?? '-' }}</p>
                                <p><strong>Quantity:</strong> {{ $orderProduct->quantity }}</p>
                                <p><strong>Price:</strong> Rp{{ number_format($orderProduct->price, 0, ',', '.') }}</p>
                            </li>
                        @endforeach
                    @else
                        <li class="bg-yellow-100 text-yellow-800 p-4 rounded-lg dark:bg-yellow-900 dark:text-yellow-200">
                            {{ $order->products_name ?? 'No product details available' }}
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
@endsection
