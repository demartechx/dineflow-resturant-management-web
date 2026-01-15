<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Order;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    public function initiate(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
        ]);

        $order = Order::findOrFail($request->order_id);

        // Mock payment initiation
        $payment = $order->payment()->create([
            'amount' => $order->total_amount,
            'status' => 'pending',
            'provider' => 'manual', // or bank_transfer
            'transaction_id' => Str::uuid(),
        ]);

        return response()->json([
            'message' => 'Payment initiated',
            'payment_id' => $payment->id,
            'amount' => $payment->amount,
            'account_details' => [
                'bank' => 'Mock Bank',
                'account_number' => '1234567890',
                'account_name' => 'Restaurant QR',
            ]
        ]);
    }
}
