<div x-data="{ open: @entangle('isOpen') }">
    <!-- Floating Cart Button -->
    <button @click="open = !open"
        class="fixed bottom-6 right-6 bg-gradient-to-r from-orange-500 to-red-600 text-white p-4 rounded-full shadow-2xl hover:shadow-orange-500/50 hover:scale-105 transition-all duration-300 z-50 flex items-center justify-center border-4 border-white/20 backdrop-blur-sm">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
        </svg>
        @if(count($cartItems) > 0)
            <span
                class="absolute -top-1 -right-1 bg-white text-orange-600 text-xs font-black px-2 py-0.5 rounded-full border-2 border-orange-500 shadow-sm">
                {{ collect($cartItems)->sum('quantity') }}
            </span>
        @endif
    </button>

    <!-- Cart Slide-over -->
    <div x-show="open" class="fixed inset-0 overflow-hidden z-50" style="display: none;">
        <div class="absolute inset-0 overflow-hidden">
            <!-- Backdrop -->
            <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" @click="open = false"
                x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>

            <div class="fixed inset-y-0 right-0 pl-10 max-w-full flex">
                <div class="w-screen max-w-md"
                    x-transition:enter="transform transition ease-in-out duration-500 sm:duration-700"
                    x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
                    x-transition:leave="transform transition ease-in-out duration-500 sm:duration-700"
                    x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full">
                    <div class="h-full flex flex-col bg-white shadow-2xl rounded-l-[2.5rem] overflow-hidden">
                        <!-- Cart Header -->
                        <div class="px-6 py-6 bg-gradient-to-br from-orange-50 to-white border-b border-orange-100">
                            <div class="flex items-center justify-between">
                                <h2 class="text-2xl font-black text-gray-900">Your Order</h2>
                                <button @click="open = false"
                                    class="bg-white rounded-full p-2 text-gray-400 hover:text-orange-500 hover:bg-orange-50 transition border border-gray-100 shadow-sm">
                                    <span class="sr-only">Close panel</span>
                                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Cart Items -->
                        <div class="flex-1 py-6 overflow-y-auto px-6 bg-white">
                            <div class="flow-root">
                                <ul role="list" class="-my-6 space-y-6">
                                    @forelse($cartItems as $items)
                                        <li
                                            class="py-4 flex bg-white border border-gray-100 rounded-2xl p-3 shadow-sm hover:shadow-md transition-shadow">
                                            <div
                                                class="flex-shrink-0 w-20 h-20 border border-gray-100 rounded-xl overflow-hidden relative">
                                                @if($items['image'])
                                                    <img src="{{ \Illuminate\Support\Facades\Storage::url($items['image']) }}"
                                                        alt="{{ $items['name'] }}" class="w-full h-full object-cover">
                                                @else
                                                    <div
                                                        class="w-full h-full bg-gray-50 flex items-center justify-center text-gray-300">
                                                        <svg class="w-6 h-6" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                            </path>
                                                        </svg>
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="ml-4 flex-1 flex flex-col justify-between">
                                                <div class="flex justify-between text-base font-bold text-gray-900">
                                                    <h3>{{ $items['name'] }}</h3>
                                                    <p class="ml-4 text-orange-600">
                                                        ₦{{ number_format($items['price'] * $items['quantity'], 2) }}</p>
                                                </div>
                                                <div class="flex items-center justify-between text-sm mt-2">
                                                    <div
                                                        class="flex items-center bg-gray-50 rounded-full px-2 py-1 border border-gray-200">
                                                        <button
                                                            wire:click="updateQuantity({{ $items['id'] }}, {{ $items['quantity'] - 1 }})"
                                                            class="w-6 h-6 flex items-center justify-center text-gray-500 hover:text-orange-600 font-bold transition">-</button>
                                                        <span
                                                            class="mx-2 text-gray-900 font-semibold">{{ $items['quantity'] }}</span>
                                                        <button
                                                            wire:click="updateQuantity({{ $items['id'] }}, {{ $items['quantity'] + 1 }})"
                                                            class="w-6 h-6 flex items-center justify-center text-gray-500 hover:text-orange-600 font-bold transition">+</button>
                                                    </div>

                                                    <button wire:click="remove({{ $items['id'] }})" type="button"
                                                        class="font-medium text-red-400 hover:text-red-600 text-xs uppercase tracking-wide">Remove</button>
                                                </div>
                                            </div>
                                        </li>
                                    @empty
                                        <div class="flex flex-col items-center justify-center h-64 text-center">
                                            <div
                                                class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                                </svg>
                                            </div>
                                            <p class="text-gray-500 font-medium">Your cart is empty.</p>
                                            <button @click="open = false"
                                                class="mt-4 text-orange-600 font-bold hover:underline">Browse Menu</button>
                                        </div>
                                    @endforelse
                                </ul>
                            </div>
                        </div>

                        <!-- Footer -->
                        @if(count($cartItems) > 0)
                            <div class="border-t border-gray-100 py-8 px-6 bg-gray-50">
                                <div class="flex justify-between text-lg font-black text-gray-900 mb-4">
                                    <p>Total</p>
                                    <p>₦{{ number_format($this->total, 2) }}</p>
                                </div>
                                <p class="mt-0.5 text-xs text-gray-500 mb-6">Taxes and shipping calculated at checkout.</p>
                                <a href="{{ route('checkout') }}"
                                    class="w-full flex justify-center items-center px-6 py-4 border border-transparent rounded-2xl shadow-lg text-lg font-bold text-white bg-gradient-to-r from-orange-500 to-red-600 hover:from-orange-600 hover:to-red-700 transform hover:scale-[1.02] transition-all duration-200">
                                    Checkout Now
                                </a>
                                <div class="mt-4 flex justify-center text-sm text-center text-gray-500">
                                    <p>
                                        or <button @click="open = false" type="button"
                                            class="text-orange-600 font-bold hover:text-orange-500">Continue
                                            Ordering</button>
                                    </p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>