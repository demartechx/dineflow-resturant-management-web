<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Order;

class OrderTrack extends Component
{
    public Order $order;

    public function mount(Order $order)
    {
        $this->order = $order;
    }

    #[Layout('layouts.guest')]
    public function render()
    {
        return view('livewire.order-track');
    }
}
