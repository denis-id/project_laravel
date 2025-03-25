<?php

namespace App\Http\Controllers;

use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $totalOrder = OrderProduct::get()->sum(fn(OrderProduct $orderProduct) => $orderProduct->quantity * $orderProduct->productVariant->price
    );

        $total_users = User::count();

        $total_order = OrderProduct::sum('quantity');

        $total_products = Product::count();

        $best_sellers = OrderProduct::select('product_variant_id')
        ->selectRaw('SUM(quantity) as total_sold')
       
        ->groupBy('product_variant_id')
        ->orderByDesc('total_sold') 
        ->with('productVariant.product.category')
        ->limit(5)
        ->get();

        return view("index", [
            'total_earning' => $totalOrder,
            'total_products' => $total_products,
            'best_sellers' => $best_sellers,
            'total_users' => $total_users,
        ]);
    }
}