<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use Illuminate\Support\Facades\Session;

class Cart extends Component
{
    public $isOpen = false;
    public $cartItems = [];

    protected $listeners = ['addToCart' => 'add', 'cartUpdated' => '$refresh'];

    public function mount()
    {
        $this->cartItems = Session::get('cart', []);
    }

    public function add($productId)
    {
        $product = Product::find($productId);
        if (!$product)
            return;

        if (isset($this->cartItems[$productId])) {
            $this->cartItems[$productId]['quantity']++;
        } else {
            $this->cartItems[$productId] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 1,
                'image' => $product->image,
            ];
        }

        $this->updateCart();
        $this->isOpen = true; // Open cart when item added
    }

    public function remove($productId)
    {
        unset($this->cartItems[$productId]);
        $this->updateCart();
    }

    public function updateQuantity($productId, $quantity)
    {
        if ($quantity <= 0) {
            $this->remove($productId);
        } else {
            if (isset($this->cartItems[$productId])) {
                $this->cartItems[$productId]['quantity'] = $quantity;
                $this->updateCart();
            }
        }
    }

    public function updateCart()
    {
        Session::put('cart', $this->cartItems);
        $this->dispatch('cartUpdated');
    }

    public function getTotalProperty()
    {
        return collect($this->cartItems)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });
    }

    public function toggleCart()
    {
        $this->isOpen = !$this->isOpen;
    }

    public function render()
    {
        return view('livewire.cart');
    }
}
