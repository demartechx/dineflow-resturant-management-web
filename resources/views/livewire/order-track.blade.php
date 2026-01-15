<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12" wire:poll.5s>
    <div class="mb-8 text-center">
        <h1 class="text-3xl font-extrabold text-gray-900">Order #{{ $order->id }}</h1>
        <p class="mt-2 text-sm text-gray-500">Track your order status below.</p>
    </div>

    <!-- Status Steps -->
    <div class="mb-12">
        <div class="overflow-hidden bg-gray-200 rounded-full h-4 flex">
            @php
                $statuses = ['pending', 'preparing', 'ready', 'completed'];
                $currentIndex = array_search($order->status, $statuses);
                if ($currentIndex === false && $order->status !== 'cancelled')
                    $currentIndex = -1;

                $width = 0;
                if ($order->status === 'cancelled') {
                    $width = 100;
                    $color = 'bg-red-500';
                } else {
                    $width = ($currentIndex + 1) / count($statuses) * 100;
                    $color = 'bg-green-500';
                }
            @endphp
            <div style="width: {{ $width }}%"
                class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center {{ $color }} transition-all duration-500">
            </div>
        </div>
        <div class="flex justify-between mt-2 text-xs sm:text-sm text-gray-600 font-medium">
            <span>Pending</span>
            <span>Preparing</span>
            <span>Ready</span>
            <span>Completed</span>
        </div>
        <div class="mt-4 text-center">
            <span
                class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium {{ $order->status === 'cancelled' ? 'bg-red-100 text-red-800' : 'bg-orange-100 text-orange-800' }}">
                Status: {{ ucfirst($order->status) }}
            </span>
            <span
                class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium {{ $order->payment_status === 'paid' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                Payment: {{ ucfirst($order->payment_status) }}
            </span>
        </div>
    </div>

    @if($order->status === 'cancelled')
        <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-8">
            <div class="flex">
                <div class="flex-shrink-0">
                    <!-- Heroicon name: solid/exclamation -->
                    <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                        fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd"
                            d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-red-700">
                        This order has been cancelled. Please contact staff.
                    </p>
                </div>
            </div>
        </div>
    @endif

    <!-- Payment Instructions if pending -->
    @if($order->payment_status === 'pending' && $order->status !== 'cancelled')
        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-8">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-yellow-700">
                        Payment is pending. Please transfer <strong>₦{{ number_format($order->total_amount, 2) }}</strong>
                        to Mock Bank Acc: 1234567890. Use Order #{{ $order->id }} as reference.
                    </p>
                </div>
            </div>
        </div>
    @endif

    <!-- Order Items -->
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Items Ordered</h3>
        </div>
        <ul role="list" class="divide-y divide-gray-200">
            @foreach($order->items as $item)
                <li class="px-4 py-4 sm:px-6 flex justify-between items-center">
                    <div class="flex items-center">
                        <span class="font-medium text-gray-900">{{ $item->product->name }}</span>
                        <span class="ml-2 text-sm text-gray-500">x {{ $item->quantity }}</span>
                    </div>
                    <span class="font-medium text-gray-900">₦{{ number_format($item->total_price, 2) }}</span>
                </li>
            @endforeach
            <li class="px-4 py-4 sm:px-6 flex justify-between items-center bg-gray-50">
                <span class="font-bold text-gray-900">Total</span>
                <span class="font-bold text-gray-900 text-lg">₦{{ number_format($order->total_amount, 2) }}</span>
            </li>
        </ul>
    </div>

    <div class="mt-8 text-center">
        <a href="{{ route('menu') }}" class="text-orange-600 hover:text-orange-900 font-medium">Place another order</a>
    </div>
</div>