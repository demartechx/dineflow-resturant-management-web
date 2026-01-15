<div class="min-h-screen bg-gray-50 pb-12">
    <!-- Header with Gradient -->
    <div class="relative bg-gray-900 pb-20 rounded-b-[3rem] shadow-2xl overflow-hidden">
        <div class="absolute inset-0 opacity-20">
            <svg class="h-full w-full text-gray-700" fill="currentColor" viewBox="0 0 100 100">
                <path d="M0 0h100v100H0z" fill="none" />
                <circle cx="50" cy="50" r="40" stroke="currentColor" stroke-width="2" fill="none" opacity="0.3" />
            </svg>
        </div>
        <div class="absolute inset-x-0 top-0 h-full bg-gradient-to-br from-orange-600/90 to-red-600/90"></div>

        <div class="relative pt-8 px-6">
            <a href="{{ route('menu') }}"
                class="inline-flex items-center text-white/80 hover:text-white mb-6 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Menu
            </a>
            <h1 class="text-3xl font-black text-white tracking-tight drop-shadow-md mb-2">Checkout</h1>
            <p class="text-orange-100 font-medium ml-1">Table: {{ $tableNumber ?? 'Unknown' }}</p>
        </div>
    </div>

    <div class="px-4 -mt-10 relative z-10 space-y-6 max-w-3xl mx-auto">
        <!-- Order Summary Card -->
        <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">
            <div class="px-6 py-5 bg-gray-50 border-b border-gray-100 flex justify-between items-center">
                <h2 class="text-lg font-bold text-gray-900 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    Order Summary
                </h2>
                <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">{{ count($cartItems) }}
                    items</span>
            </div>

            <ul role="list" class="divide-y divide-gray-100">
                @foreach($cartItems as $item)
                    <li class="px-6 py-4 flex items-center">
                        <div
                            class="flex-shrink-0 w-16 h-16 border border-gray-100 rounded-2xl overflow-hidden bg-gray-50 relative">
                            @if($item['image'])
                                <img src="{{ \Illuminate\Support\Facades\Storage::url($item['image']) }}"
                                    alt="{{ $item['name'] }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-300">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <div class="ml-4 flex-1">
                            <h3 class="font-bold text-gray-900">{{ $item['name'] }}</h3>
                            <div class="flex justify-between items-center mt-1">
                                <span class="text-sm text-gray-500">Qty: {{ $item['quantity'] }}</span>
                                <span
                                    class="font-bold text-orange-600">₦{{ number_format($item['price'] * $item['quantity'], 2) }}</span>
                            </div>
                        </div>
                    </li>
                @endforeach
                <li class="px-6 py-5 bg-gray-50 flex justify-between items-center border-t border-gray-100">
                    <span class="font-bold text-gray-900">Total Amount</span>
                    <span class="font-black text-2xl text-gray-900">₦{{ number_format($this->total, 2) }}</span>
                </li>
            </ul>
        </div>

        <!-- Checkout Form -->
        <form wire:submit.prevent="placeOrder"
            class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100 p-6 space-y-6">
            <div>
                <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    Your Details
                </h2>
                <div class="grid grid-cols-1 gap-5">
                    <div>
                        <label for="name" class="block text-sm font-semibold text-gray-700 mb-1">Name</label>
                        <input wire:model="customer_name" type="text" id="name"
                            class="block w-full px-4 py-3 rounded-xl border-gray-300 shadow-sm focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors bg-gray-50 focus:bg-white"
                            placeholder="John Doe" required>
                        @error('customer_name') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label for="phone" class="block text-sm font-semibold text-gray-700 mb-1">Phone</label>
                        <input wire:model="customer_phone" type="tel" id="phone"
                            class="block w-full px-4 py-3 rounded-xl border-gray-300 shadow-sm focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors bg-gray-50 focus:bg-white"
                            placeholder="+123456789" required>
                        @error('customer_phone') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-100 pt-6">
                <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z">
                        </path>
                    </svg>
                    Payment Method
                </h2>

                <div class="space-y-3">
                    <label
                        class="relative flex items-center p-4 rounded-xl border cursor-pointer hover:bg-orange-50 transition-colors {{ $payment_method === 'bank_transfer' ? 'border-orange-500 bg-orange-50 ring-1 ring-orange-500' : 'border-gray-200' }}">
                        <input wire:model.live="payment_method" name="payment_method" type="radio" value="bank_transfer"
                            class="h-4 w-4 text-orange-600 focus:ring-orange-500 border-gray-300">
                        <span class="ml-3 flex flex-col">
                            <span class="block text-sm font-bold text-gray-900">Bank Transfer</span>
                            <span class="block text-xs text-gray-500">Transfer to provided account</span>
                        </span>
                    </label>
                    <!-- Future Payment Methods can go here -->
                </div>

                @if($payment_method === 'bank_transfer')
                    <div class="mt-4 p-4 bg-orange-50 rounded-xl border border-orange-100">
                        <h3 class="text-sm font-bold text-orange-800 mb-2">Transfer Details</h3>
                        <p class="text-sm text-orange-700 space-y-1">
                            <span class="block"><strong>Bank:</strong> Mock Bank</span>
                            <span class="block"><strong>Acc No:</strong> 1234567890</span>
                            <span class="block text-xs mt-2 opacity-75">Reference will be Order ID.</span>
                        </p>
                    </div>
                @endif
            </div>

            <button type="submit"
                class="w-full flex justify-center py-4 px-6 border border-transparent rounded-2xl shadow-lg text-lg font-bold text-white bg-gradient-to-r from-orange-500 to-red-600 hover:from-orange-600 hover:to-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transform hover:scale-[1.01] transition-all">
                Confirm Order & Pay ₦{{ number_format($this->total, 2) }}
            </button>
        </form>
    </div>
</div>