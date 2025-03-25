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
                    <tr>
                        <td class="py-3">
                            <div class="flex items-center">
                                <div class="flex items-center gap-3">
                                    <div class="h-[50px] w-[50px] overflow-hidden rounded-md">
                                        <img src="{{ asset($best_seller->productVariant->product->image ?? 'default.jpg') }}"
                                            alt="{{ $best_seller->productVariant->product->name }}" />
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
                                    ${{ number_format($best_seller->productVariant->price, 2) }}
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
