<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\ProductVariant;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Xendit\Configuration;
use Xendit\Invoice\CreateInvoiceRequest;
use Xendit\Invoice\InvoiceApi;

class OrderController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        $orders = Order::where('user_id', $user->id)->with('orderProducts.productVariant')->get();
        return view('orders.index', compact('orders'));
        // return response()->json(['orders' => $orders]);
    }

      public function getOrders(Request $request)
    {
        Log::info('Authorization Header:', [$request->header('Authorization')]);
        Log::info('User from request:', [$request->user()]);
        
        $user = $request->user();
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not authenticated'
            ], 401);
        }
        
        Log::info("Fetching orders for user: " . $user->id);
        
        $orders = Order::where('user_id', $user->id)->with('orderProducts.productVariant')->get();
        return response()->json([
            'success' => true,
            'data' => $orders
        ]);
    }


    public function show($id)
    {
        $user = Auth::user();
        $order = Order::where('user_id', $user->id)->with('orderProducts.productVariant')->findOrFail($id);
        return view('orders.show', compact('order'));
        // return response()->json(['order' => $order]);
    }

    public function createOrder(Request $request)
{
    $user = Auth::user();
    if (!$user) {
        return response()->json(['message' => 'Unauthenticated.'], 401);
    }

    $request->validate([
        'phone' => 'required|string',
        'first_name' => 'required|string',
        'last_name' => 'required|string',
        'email' => 'required|email',
        'address' => 'required|string',
        'city' => 'required|string',
        'postal_code' => 'required|string',
        'country' => 'required|string',
        'products' => 'required|array',
        'products.*.product_variant_id' => 'required|exists:product_variants,id',
        'products.*.quantity' => 'required|integer|min:1',
    ]);

    DB::beginTransaction();
    try {
        $order = Order::create([
            'user_id' => $user->id,
            'phone' => $request->phone,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'address' => $request->address,
            'city' => $request->city,
            'postal_code' => $request->postal_code,
            'country' => $request->country,
            'status' => 'PENDING',
            'price' => 0,
            'total' => 0,
            'address_description' => $request->address_description ?? null,
        ]);

        $totalPrice = 0;
        $productsName = [];
        $orderProducts = [];

        foreach ($request->products as $product) {
            $productVariant = ProductVariant::with('product')->find($product['product_variant_id']);
            if (!$productVariant || $productVariant->stock < $product['quantity']) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Stok tidak mencukupi untuk salah satu produk.'
                ], 400);
            }

            $productVariant->decrement('stock', $product['quantity']);
            $price = $productVariant->price;
            $subtotal = $price * $product['quantity']; 

            $totalPrice += $subtotal;
            $productsName[] = $productVariant->product->name;

            $orderProducts[] = [
                'order_id' => $order->id,
                'product_variant_id' => $product['product_variant_id'],
                'quantity' => $product['quantity'],
                'price' => $price,  
                'subtotal' => $subtotal, 
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        OrderProduct::insert($orderProducts);
        $order->update([
            'price' => $totalPrice,
            'total' => $totalPrice,
            'products_name' => implode(', ', $productsName),
        ]);

        DB::commit();
        return response()->json(['message' => 'Order successfully created!', 'success' => true, 'order' => $order], 201);
    } catch (Exception $e) {
        DB::rollBack();
        return response()->json(['success' => false, 'message' => 'Failed to create order: ' . $e->getMessage()], 500);
    }
}

    public function deleteOrder($id)
    {
        $user = Auth::user();
        $order = Order::where('user_id', $user->id)->findOrFail($id);
        $order->delete();

        return response()->json([
            'success' => true,
            'message' => 'Order deleted successfully'
        ], 200);
    }

    public function payOrder($id)
    {
        DB::beginTransaction();

        try {
            $user = Auth::user();
            $order = Order::where('user_id', $user->id)->findOrFail($id);

            if ($order->status === "PAID") {
                throw new Exception("Order already paid");
            }

            if ($order->url) {
                return response()->json([
                    'data' => $order->url,
                    'message' => 'Invoice already generated'
                ], 200);
            }

            $total = $order->orderProducts->sum(fn ($op) => $op->quantity * $op->productVariant->price);

        //    $total = 0;
            
            Configuration::setXenditKey(env('XENDIT_API_KEY'));
            $apiInstance = new InvoiceApi();
            $createInvoiceRequest = new CreateInvoiceRequest([
                'external_id' => (string) $order->id,
                'description' => 'Invoice for order ' . $order->id,
                'amount' => $total,
                'invoice_duration' => 172800,
                'currency' => 'IDR',
                'reminder_time' => 1
            ]);
            
            $result = $apiInstance->createInvoice($createInvoiceRequest);
            $order->url = $result['invoice_url'];
            $order->save();

            
            DB::commit();

            return response()->json([
                'data' => $result['invoice_url'],
                'message' => 'Invoice generated successfully'
            ], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Failed to generate invoice: ' . $e->getMessage()
            ], 500);
        }
    }

public function getOrderById($id)
{
    $order = Order::find($id);

    if (!$order) {
        return response()->json(['message' => 'Pesanan tidak ditemukan'], 404);
    }

    return response()->json(['order' => $order]);
}

    public function webhookPayment(Request $request)
    {
        try {
            $signatureHeader = $request->header('x-callback-token');
            $secret = env('XENDIT_WEBHOOK_TOKEN');

            if ($signatureHeader !== $secret) {
                return response()->json(['message' => 'Unauthorized'], 401);
            }

            $payload = $request->all();
            $order = Order::findOrFail($payload['external_id']);

            if (!$order) {
                return response()->json(['message' => 'Order not found'], 404);
            }

            Log::info("Webhook Data:", $payload);

            $order->status = strtoupper($payload['status']);
            $order->payment_channel = $payload['payment_channel'] ?? 'UNKNOWN';
            $order->payment_method = $payload['payment_method'] ?? 'UNKNOWN';
            $order->save();

            return response()->json(['message' => 'Order status updated'], 200);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}