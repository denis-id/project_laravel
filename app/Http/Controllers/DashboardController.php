<?php

namespace App\Http\Controllers;

use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
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

        $previousTotalUsers = User::whereBetween('created_at', [
            now()->subWeek()->startOfWeek(), now()->subWeek()->endOfWeek()
        ])->count();

        $previousTotalOrder = OrderProduct::whereBetween('created_at', [
            now()->subWeek()->startOfWeek(), now()->subWeek()->endOfWeek()
        ])->sum('quantity');

        $previousTotalProducts = Product::whereBetween('created_at', [
            now()->subWeek()->startOfWeek(), now()->subWeek()->endOfWeek()
        ])->count();

        $previousTotalEarning = OrderProduct::whereBetween('created_at', [
            now()->subWeek()->startOfWeek(), now()->subWeek()->endOfWeek()
        ])->get()->sum(fn(OrderProduct $orderProduct) => $orderProduct->quantity * $orderProduct->productVariant->price);

        $best_sellers = OrderProduct::select('product_variant_id')
        ->selectRaw('SUM(quantity) as total_sold')
        ->groupBy('product_variant_id')
        ->orderByDesc('total_sold')
        ->with('productVariant.product.category')
        ->limit(5)
        ->get();

        foreach ($best_sellers as $best_seller) {
            $best_seller->percentage = $total_order > 0 ? ($best_seller->total_sold / $total_order) * 100 : 0;
        }
        
        $percentageChangeEarning = $previousTotalEarning > 0
        ? (($totalOrder - $previousTotalEarning) / $previousTotalEarning) * 100
        : 0;

        $percentageChangeUsers = $previousTotalUsers > 0
        ? (($total_users - $previousTotalUsers) / $previousTotalUsers) * 100
        : 0;

        $percentageChangeOrders = $previousTotalOrder > 0
        ? (($total_order - $previousTotalOrder) / $previousTotalOrder) * 100
        : 0;
            
        $percentageChangeProducts = $previousTotalProducts > 0
        ? (($total_products - $previousTotalProducts) / $previousTotalProducts) * 100
        : 0;
        
        return view("index", [
            'total_earning' => $totalOrder,
            'total_products' => $total_products,
            'best_sellers' => $best_sellers,
            'total_users' => $total_users,
            'total_order' => $total_order,
            'percentage_change_earning' => $percentageChangeEarning,
            'percentage_change_users' => $percentageChangeUsers,
            'percentage_change_orders' => $percentageChangeOrders,
            'percentage_change_products' => $percentageChangeProducts,
        ]);
    }
}