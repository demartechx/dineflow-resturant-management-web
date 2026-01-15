<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Session;
use App\Models\Order;
use App\Models\RestaurantTable;
use App\Models\Product;

class Checkout extends Component
{
    public $cartItems = [];
    public $customer_name;
    public $customer_phone;
    public $payment_method = 'bank_transfer';
    public $tableNumber;

    public function mount()
    {
        $this->cartItems = Session::get('cart', []);
        $this->tableNumber = session('restaurant_table_number');

        if (empty($this->cartItems)) {
            return redirect()->route('menu');
        }
    }

    public function getTotalProperty()
    {
        return collect($this->cartItems)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });
    }

    public function placeOrder()
    {
        $this->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'nullable|string|max:20',
            'payment_method' => 'required|in:bank_transfer,cash',
        ]);

        $tableId = session('restaurant_table_id');

        // Create Order
        $order = Order::create([
            'restaurant_table_id' => $tableId,
            'customer_name' => $this->customer_name,
            'customer_phone' => $this->customer_phone,
            'total_amount' => $this->total,
            'status' => 'pending',
            'payment_status' => 'pending',
            'payment_method' => $this->payment_method,
        ]);

        // Create Order Items
        foreach ($this->cartItems as $item) {
            $order->items()->create([
                'product_id' => $item['id'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['price'],
                'total_price' => $item['price'] * $item['quantity'],
            ]);
        }

        // Create Payment (Mock)
        if ($this->payment_method === 'bank_transfer') {
            $order->payment()->create([
                'amount' => $this->total,
                'status' => 'pending', // Pending provider confirmation
                'provider' => 'bank_transfer',
                'transaction_id' => \Illuminate\Support\Str::uuid(),
            ]);
        }

        // Clear Cart
        Session::forget('cart');
        $this->dispatch('cartUpdated'); // To clear UI cart if visible

        return redirect()->route('order.track', $order);
    }

    #[Layout('layouts.guest')]
    public function render()
    {
        return view('livewire.checkout');
    }
}
