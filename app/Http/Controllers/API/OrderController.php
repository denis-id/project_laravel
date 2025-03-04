<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function createOrder(Request $request)
    {
        $validate = $request->validate([
            "phone"=> ['required','string'],
            "first_name"=> ['required','string'],
            "last_name"=> ['required','string'],
            "email"=> ['required','string', 'email'],
            "address"=> ['required','string'],
            "city"=> ['required','string'],
            "postal_code"=> ['required','string'],
            "country"=> ['required','string'],
            "products"=> ['required','array'],
            "products.*.product_variant_id"=> ['required','exist:product_variants,id'],
            "products.*.quantity"=> ['required','integer', 'min:1']
        ]);

        DB::beginTransaction();
        $user = $request->user();

        try {
            // buat order baru
            $order = Order::create([
                'user_id' => $user->id,
                'phone'=> $request->phone,
                'first_name'=> $request->firstName,
                'last_name'=> $request->lastName,
                'email'=> $request->email,
                'address'=> $request->address,
                'city'=> $request->city,
                'postal_code' => $request->postal_code,
                'country' => $request->country,
                'status' => 'PENDING',
                'price' => 0
            ]);

            $totalPrice = 0;
            $orderProducts = [];

            // proses tiap produk yang dibeli
            foreach ($request->products as $product) {
                $productVariant = ProductVariant::find($product['product_variant_id']);

                // cek stok cukup atau tidak
                if ($productVariant->stock < $product['quantity']) {
                    DB::rollback();
                    return response()->json([
                        'data' => null,
                        'message' => "Stock for variant {$productVariant->variant_name} out of stock",
                        'success' => false
                        ], 400);
                }
                
                // kurangi stock produk            
                $productVariant->decrement('stock', $product['quantity']);

                $productPrice = $productVariant->product->price * $product['quantity'];
                $totalPrice += $productPrice;

                // simpan ke order products
                $orderProducts[] = [
                    'order_id' => $order->id,
                    'product_variant_id' => $product['product_variant_id'],
                    'quantity' => $product['quantity'],
                    'price' => $productPrice,
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }

            // simpan data ke order_products
            OrderProduct::insert($orderProducts);

            // update harga total order
            $order->update(['price' => $totalPrice ]);

            DB::commit();

            return response ()->json([
                'success' => true,
                'message' => 'Order successfully created!',
                'order_id' => $order->id
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'There is an error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function deleteOrder(Request $request, string $id)
    {
        $user = $request->user();
        $order = Order::where('user_id', $user->id)->findOrFail($id);
        $order->delete();
        return response() -> json([
            'success' => true,
            'message' => 'Delete Order Success'
        ], 200);
    }
}