<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Order;
use App\Models\Product;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'restaurant_table_id' => 'required|exists:restaurant_tables,id',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'customer_name' => 'nullable|string',
            'customer_phone' => 'nullable|string',
        ]);

        $totalAmount = 0;
        foreach ($validated['items'] as $itemData) {
            $product = Product::find($itemData['product_id']);
            $totalAmount += $product->price * $itemData['quantity'];
        }

        $order = Order::create([
            'restaurant_table_id' => $validated['restaurant_table_id'],
            'customer_name' => $validated['customer_name'] ?? null,
            'customer_phone' => $validated['customer_phone'] ?? null,
            'total_amount' => $totalAmount,
            'status' => 'pending',
            'payment_status' => 'pending',
        ]);

        foreach ($validated['items'] as $itemData) {
            $product = Product::find($itemData['product_id']);
            $order->items()->create([
                'product_id' => $product->id,
                'quantity' => $itemData['quantity'],
                'unit_price' => $product->price,
                'total_price' => $product->price * $itemData['quantity'],
            ]);
        }

        return response()->json([
            'message' => 'Order placed successfully',
            'order_id' => $order->id,
        ], 201);
    }

    public function show(Order $order)
    {
        return response()->json([
            'data' => $order->load('items.product', 'payment')
        ]);
    }
}
