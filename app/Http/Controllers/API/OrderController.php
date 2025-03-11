<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\ProductVariant;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Xendit\Configuration;
use Xendit\Invoice\CreateInvoiceRequest;
use Xendit\Invoice\InvoiceApi;

class OrderController extends Controller
{
    public function getOrders(Request $request)
    {
        $user = $request->user();
        $orders = Order::where('user_id', $user->id)->with('orderProducts.productVariant')->get();
        return response()->json([
            'success' => true,
            'data' => $orders
        ]);
    }
    public function createOrder(Request $request)
    {
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
        $user = $request->user();


        try {
            // Buat order baru
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
                'address_description' => $request->address_description
            ]);

            $totalPrice = 0;
            $orderProducts = [];

            // Proses setiap produk yang dibeli
            foreach ($request->products as $product) {
                $productVariant = ProductVariant::find($product['product_variant_id']);

                // Cek stok cukup atau tidak
                if ($productVariant->stock < $product['quantity']) {
                    DB::rollBack();
                    return response()->json([
                        'success' => false,
                        'message' => "Stok untuk varian {$productVariant->variant_name} tidak mencukupi. Stok tersedia: {$productVariant->stock}"
                    ], 400);
                }

                // Kurangi stok produk
                $productVariant->decrement('stock', $product['quantity']);

                // Hitung harga total untuk produk ini
                $productPrice = $productVariant->product->price * $product['quantity'];
                $totalPrice += $productPrice;

                // Simpan ke order_products
                $orderProducts[] = [
                    'order_id' => $order->id,
                    'product_variant_id' => $product['product_variant_id'],
                    'quantity' => $product['quantity'],
                    'price' => $productPrice,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            // Simpan data ke order_products
            OrderProduct::insert($orderProducts);

            // Update harga total order
            $order->update(['price' => $totalPrice]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Order berhasil dibuat!',
                // 'order_id' => $order->id
            ], 201);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
    public function deleteOrder(Request $request, string $id)
    {
        $user = $request->user();
        $order = Order::where('user_id', $user->id)->findOrFail($id);
        $order->delete();
        return response()->json([
            'success' => true,
            'message' => 'Delete order success'
        ], 200);
    }

    public function payOrder(Request $request, string $id)
    {
        DB::beginTransaction();
        try {
            $user = $request->user();
            $order = Order::findOrFail($id);

            if ($order->user_id !== $user->id) {
                return response()->json([
                    'message' => "You are not allowed to access this data"
                ], 401);
            }

            if ($order->status === "PAID") {
                throw new Exception("Order already paid");
            }

            if ($order->url) { {
                    return response()->json([
                        'data' => $order->url,
                        'message' => 'Generated invoice successfully',
                    ], 200);
                }
            }

            $total = $order->orderProducts->sum(function ($orderProduct) {
                return $orderProduct->quantity * $orderProduct->productVariant->product->price;
            });

            Configuration::setXenditKey(env("XENDIT_API_KEY"));

            $apiInstance = new InvoiceApi();
            $create_invoice_request = new CreateInvoiceRequest([
                'external_id' => (string)$order->id,
                'description' => 'Invoice for order ' . $order->id,
                'amount' => $total,
                'invoice_duration' => 172800,
                'currency' => 'IDR',
                'reminder_time' => 1
            ]);

            $result = $apiInstance->createInvoice($create_invoice_request);
            $order->url = $result['invoice_url'];
            $order->save();

            DB::commit();

            return response()->json([
                'data' => $result['invoice_url'],
                'message' => "Generated invoice successfully",
            ], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'data' => null,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
    public function webhookPayment(Request $request)
    {
        try {
            $signatureHeader = $request->header('x-callback-token');
            $secret = env('XENDIT_WEBHOOK_TOKEN');
            
            if ($signatureHeader !== $secret) {
                return response()->json([
                    'message' => 'Unauthorized'
                ], 401);
            }

            $payload = $request->all();
            $order = Order::findOrFail($payload['external_id']);

            if (!$order) {
                return response()->json([
                    'message' => 'Order not found'
                ], 404);
            }

            $order->status = strtoupper($payload['status']);
            $order->payment_channel = $payload['payment_channel'];
            $order->payment_method = $payload['payment_method'];
            $order->save();

            return response()->json([
                'message' => 'Order status updated',
                'status' => 200
            ]);
        } catch (Exception $e) {
            Log::error($e->getMessage());

            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }
}