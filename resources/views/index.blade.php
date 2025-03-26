@extends('layouts.app')

@section('content')
    <div class="grid grid-cols-12 gap-4 md:gap-6">
        <div class="col-span-12 space-y-6 xl:col-span-7">
            <!-- Metric Group One -->
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:gap-6">
                <!-- Metric Item Start -->
                <div
                    class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] md:p-6">
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-gray-100 dark:bg-gray-800">
                        <svg class="fill-gray-800 dark:fill-white/90" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M8.80443 5.60156C7.59109 5.60156 6.60749 6.58517 6.60749 7.79851C6.60749 9.01185 7.59109 9.99545 8.80443 9.99545C10.0178 9.99545 11.0014 9.01185 11.0014 7.79851C11.0014 6.58517 10.0178 5.60156 8.80443 5.60156ZM5.10749 7.79851C5.10749 5.75674 6.76267 4.10156 8.80443 4.10156C10.8462 4.10156 12.5014 5.75674 12.5014 7.79851C12.5014 9.84027 10.8462 11.4955 8.80443 11.4955C6.76267 11.4955 5.10749 9.84027 5.10749 7.79851ZM4.86252 15.3208C4.08769 16.0881 3.70377 17.0608 3.51705 17.8611C3.48384 18.0034 3.5211 18.1175 3.60712 18.2112C3.70161 18.3141 3.86659 18.3987 4.07591 18.3987H13.4249C13.6343 18.3987 13.7992 18.3141 13.8937 18.2112C13.9797 18.1175 14.017 18.0034 13.9838 17.8611C13.7971 17.0608 13.4132 16.0881 12.6383 15.3208C11.8821 14.572 10.6899 13.955 8.75042 13.955C6.81096 13.955 5.61877 14.572 4.86252 15.3208ZM3.8071 14.2549C4.87163 13.2009 6.45602 12.455 8.75042 12.455C11.0448 12.455 12.6292 13.2009 13.6937 14.2549C14.7397 15.2906 15.2207 16.5607 15.4446 17.5202C15.7658 18.8971 14.6071 19.8987 13.4249 19.8987H4.07591C2.89369 19.8987 1.73504 18.8971 2.05628 17.5202C2.28015 16.5607 2.76117 15.2906 3.8071 14.2549ZM15.3042 11.4955C14.4702 11.4955 13.7006 11.2193 13.0821 10.7533C13.3742 10.3314 13.6054 9.86419 13.7632 9.36432C14.1597 9.75463 14.7039 9.99545 15.3042 9.99545C16.5176 9.99545 17.5012 9.01185 17.5012 7.79851C17.5012 6.58517 16.5176 5.60156 15.3042 5.60156C14.7039 5.60156 14.1597 5.84239 13.7632 6.23271C13.6054 5.73284 13.3741 5.26561 13.082 4.84371C13.7006 4.37777 14.4702 4.10156 15.3042 4.10156C17.346 4.10156 19.0012 5.75674 19.0012 7.79851C19.0012 9.84027 17.346 11.4955 15.3042 11.4955ZM19.9248 19.8987H16.3901C16.7014 19.4736 16.9159 18.969 16.9827 18.3987H19.9248C20.1341 18.3987 20.2991 18.3141 20.3936 18.2112C20.4796 18.1175 20.5169 18.0034 20.4837 17.861C20.2969 17.0607 19.913 16.088 19.1382 15.3208C18.4047 14.5945 17.261 13.9921 15.4231 13.9566C15.2232 13.6945 14.9995 13.437 14.7491 13.1891C14.5144 12.9566 14.262 12.7384 13.9916 12.5362C14.3853 12.4831 14.8044 12.4549 15.2503 12.4549C17.5447 12.4549 19.1291 13.2008 20.1936 14.2549C21.2395 15.2906 21.7206 16.5607 21.9444 17.5202C22.2657 18.8971 21.107 19.8987 19.9248 19.8987Z"
                                fill="" />
                        </svg>
                    </div>

                    <div class="mt-5 flex items-end justify-between">
                        <div>
                            <span class="text-sm text-gray-500 dark:text-gray-400">Total Customers</span>
                            <h4 class="mt-2 text-title-sm font-bold text-gray-800 dark:text-white/90">
                                {{ number_format($total_users) }}
                            </h4>
                        </div>
                        <span
                            class="flex items-center gap-1 rounded-full 
                            {{ $percentage_change_users >= 0
                                ? 'bg-success-50 text-success-600 dark:bg-success-500/15 dark:text-success-500'
                                : 'bg-error-50 text-error-600 dark:bg-error-500/15 dark:text-error-500' }} 
                            py-0.5 pl-2 pr-2.5 text-sm font-medium">
                            <span>
                                {{ $percentage_change_users >= 0 ? '⬆' : '⬇' }}
                            </span>
                            {{ number_format(abs($percentage_change_users), 2) }}%
                        </span>
                    </div>
                </div>
                <!-- Metric Item End -->

                <!-- Metric Item Start -->
                <div
                    class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] md:p-6">
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-gray-100 dark:bg-gray-800">
                        <svg class="fill-gray-800 dark:fill-white/90" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M21.41 11.58L12.41 2.58C12.04 2.21 11.53 2 11 2H4C2.9 2 2 2.9 2 4V11C2 11.53 2.21 12.04 2.58 12.41L11.58 21.41C12.36 22.19 13.63 22.19 14.41 21.41L21.41 14.41C22.19 13.63 22.19 12.36 21.41 11.58ZM11 5C11.55 5 12 5.45 12 6C12 6.55 11.55 7 11 7C10.45 7 10 6.55 10 6C10 5.45 10.45 5 11 5ZM4 4H11V11H4V4ZM14.29 14.71L16.71 12.29C17.1 11.9 17.73 11.9 18.12 12.29C18.51 12.68 18.51 13.31 18.12 13.7L15.7 16.12C15.31 16.51 14.68 16.51 14.29 16.12C13.9 15.73 13.9 15.1 14.29 14.71Z"
                                fill="" />
                        </svg>
                    </div>

                    <div class="mt-5 flex items-end justify-between">
                        <div>
                            <span class="text-sm text-gray-500 dark:text-gray-400">Total Sold</span>
                            <h4 class="mt-2 text-title-sm font-bold text-gray-800 dark:text-white/90">
                                Rp{{ number_format($total_earning, 0, ',', '.') }}
                            </h4>
                        </div>
                        <span
                            class="flex items-center gap-1 rounded-full 
                        {{ $percentage_change_earning >= 0
                            ? 'bg-success-50 text-success-600 dark:bg-success-500/15 dark:text-success-500'
                            : 'bg-error-50 text-error-600 dark:bg-error-500/15 dark:text-error-500' }} 
                        py-0.5 pl-2 pr-2.5 text-sm font-medium">
                            <span>
                                {{ $percentage_change_earning >= 0 ? '⬆' : '⬇' }}
                            </span>
                            {{ number_format(abs($percentage_change_earning), 2) }}%
                        </span>
                    </div>
                </div>
                <div
                    class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] md:p-6">
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-gray-100 dark:bg-gray-800">
                        <svg class="fill-gray-800 dark:fill-white/90" xmlns="http://www.w3.org/2000/svg" width="24"
                            height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-box">
                            <path
                                d="M21 16V8a2 2 0 0 0-1-1.73L13 2.27a2 2 0 0 0-2 0L4 6.27A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4a2 2 0 0 0 1-1.73Z" />
                            <path d="m3.3 7 8.7 5 8.7-5" />
                            <path d="M12 22V12" />
                        </svg>
                    </div>

                    <div class="mt-5 flex items-end justify-between">
                        <div>
                            <span class="text-sm text-gray-500 dark:text-gray-400">Total Products</span>
                            <h4 class="mt-2 text-title-sm font-bold text-gray-800 dark:text-white/90">
                                {{ number_format($total_products) }} </h4>
                        </div>
                        <span
                            class="flex items-center gap-1 rounded-full 
                            {{ $percentage_change_products >= 0
                                ? 'bg-success-50 text-success-600 dark:bg-success-500/15 dark:text-success-500'
                                : 'bg-error-50 text-error-600 dark:bg-error-500/15 dark:text-error-500' }} 
                            py-0.5 pl-2 pr-2.5 text-sm font-medium">
                            <span>
                                {{ $percentage_change_products >= 0 ? '⬆' : '⬇' }}
                            </span>
                            {{ number_format(abs($percentage_change_products), 2) }}%
                        </span>
                    </div>
                </div>
                <div
                    class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] md:p-6">
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-gray-100 dark:bg-gray-800">
                        <svg class="fill-gray-800 dark:fill-white/90" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M6 2C5.44772 2 5 2.44772 5 3V4H3C2.44772 4 2 4.44772 2 5C2 5.55228 2.44772 6 3 6H4.54698L6.86467 17.1423C7.11042 18.3582 8.17267 19.25 9.40944 19.25H18C18.5523 19.25 19 18.8023 19 18.25C19 17.6977 18.5523 17.25 18 17.25H9.40944C9.13201 17.25 8.89242 17.0534 8.83999 16.7812L8.62866 15.75H17.1073C18.2751 15.75 19.3118 14.9599 19.6401 13.8275L21.5401 7.5775C21.8406 6.54151 21.0809 5.5 19.9996 5.5H6.4L6.19347 4.43569C6.10626 3.97892 5.66078 3.67184 5.19347 3.74587L6 2ZM8.5 21C9.05228 21 9.5 21.4477 9.5 22C9.5 22.5523 9.05228 23 8.5 23C7.94772 23 7.5 22.5523 7.5 22C7.5 21.4477 7.94772 21 8.5 21ZM17 22C17 21.4477 16.5523 21 16 21C15.4477 21 15 21.4477 15 22C15 22.5523 15.4477 23 16 23C16.5523 23 17 22.5523 17 22Z"
                                fill="" />
                        </svg>
                    </div>

                    <div class="mt-5 flex items-end justify-between">
                        <div>
                            <span class="text-sm text-gray-500 dark:text-gray-400">Total Orders</span>
                            <h4 class="mt-2 text-title-sm font-bold text-gray-800 dark:text-white/90">
                                {{ number_format($total_order) }}
                            </h4>
                        </div>
                        <span
                            class="flex items-center gap-1 rounded-full 
                        {{ $percentage_change_orders >= 0
                            ? 'bg-success-50 text-success-600 dark:bg-success-500/15 dark:text-success-500'
                            : 'bg-error-50 text-error-600 dark:bg-error-500/15 dark:text-error-500' }} 
                        py-0.5 pl-2 pr-2.5 text-sm font-medium">
                            <span>
                                {{ $percentage_change_orders >= 0 ? '⬆' : '⬇' }}
                            </span>
                            {{ number_format(abs($percentage_change_orders), 2) }}%
                        </span>
                    </div>
                </div>
            </div>
            <!-- Metric Group One -->

            <!-- ====== Chart One Start -->
            @include('partials.chart.chart-01')
            <!-- ====== Chart One End -->
        </div>

        <div class="col-span-12 xl:col-span-5">
            <!-- ====== Map One Start -->
            @include('partials.map-01')
            <!-- ====== Map One End -->
        </div>

        <div class="col-span-12 xl:col-span-7">
            <!-- ====== Table One Start -->
            <div
                class="overflow-hidden rounded-2xl border border-gray-200 bg-white px-4 pb-3 pt-4 dark:border-gray-800 dark:bg-white/[0.03] sm:px-6">
                <div class="flex flex-col gap-2 mb-4 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                            Best Sellers
                        </h3>
                    </div>
                </div>

                <div class="w-full overflow-x-auto">
                    <table class="min-w-full">
                        <thead>
                            <tr class="border-gray-100 border-y dark:border-gray-800">
                                <th class="py-3">
                                    <div class="flex items-center">
                                        <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                                            Products
                                        </p>
                                    </div>
                                </th>
                                <th class="py-3">
                                    <div class="flex items-center">
                                        <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                                            Category
                                        </p>
                                    </div>
                                </th>
                                <th class="py-3">
                                    <div class="flex items-center">
                                        <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                                            Price
                                        </p>
                                    </div>
                                </th>
                                <th class="py-3">
                                    <div class="flex items-center">
                                        <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                                            Status
                                        </p>
                                    </div>
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                            @foreach ($best_sellers as $best_seller)
                                @php
                                    $product = $best_seller->productVariant->product ?? null;
                                    $image = $product->images ?? 'default.jpg';
                                @endphp
                                <tr>
                                    <td class="py-3">
                                        <div class="flex items-center">
                                            <div class="flex items-center gap-3">
                                                <div class="h-[50px] w-[50px] overflow-hidden rounded-md">
                                                    @php
                                                        $product = $best_seller->productVariant?->product;
                                                        $imagePath = !empty($product?->images)
                                                            ? (is_array($product->images)
                                                                ? $product->images[0]
                                                                : $product->images)
                                                            : 'default.jpg';
                                                    @endphp
                                                    <img src="{{ asset('storage/' . $imagePath) }}"
                                                        alt="{{ $product?->name ?? 'No Name' }}" />
                                                </div>
                                                <div>
                                                    <p class="font-medium text-gray-800 text-theme-sm dark:text-white/90">
                                                        {{ $best_seller->productVariant->product->name }}
                                                    </p>
                                                    <span class="text-gray-500 text-theme-xs dark:text-gray-400">
                                                        {{ $best_seller->productVariant->name }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3">
                                        <div class="flex items-center">
                                            <p class="text-gray-500 text-theme-sm dark:text-gray-400">
                                                {{ $best_seller->productVariant->product->category->name }}
                                            </p>
                                        </div>
                                    </td>
                                    <td class="py-3">
                                        <div class="flex items-center">
                                            <p class="text-gray-500 text-theme-sm dark:text-gray-400">
                                                Rp{{ number_format($best_seller->productVariant->price, 2) }}
                                            </p>
                                        </div>
                                    </td>
                                    <td class="py-3">
                                        <div class="flex items-center">
                                            <p
                                                class="rounded-full bg-success-50 px-2 py-0.5 text-theme-xs font-medium text-success-600 dark:bg-success-500/15 dark:text-success-500">
                                                Best Seller
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- ====== Table One End -->
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        const best_sellers = @json($best_sellers);
        console.log(best_sellers);
    </script>
@endsection
