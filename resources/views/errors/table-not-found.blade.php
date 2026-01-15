<?php
/**
 * @var string $number
 */
?>
@component('layouts.guest')
    <div class="flex flex-col items-center justify-center min-h-[60vh] px-6 text-center">
        <div class="bg-orange-100 p-6 rounded-full mb-6 animate-pulse">
            <svg class="w-16 h-16 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
        </div>
        
        <h1 class="text-3xl font-black text-gray-900 mb-2">Table Not Found</h1>
        
        <p class="text-gray-600 text-lg mb-8 leading-relaxed">
            We couldn't seem to find the table you scanned. <br>
            <span class="font-medium text-orange-600">Kindly rescan</span> or talk to a waiter for assistance.
        </p>

        <div class="space-y-4 w-full">
            <a href="/" class="block w-full py-4 bg-gray-900 text-white rounded-2xl font-bold shadow-lg hover:bg-gray-800 transition-transform active:scale-95">
                Go to Home
            </a>
            
            <p class="text-xs text-gray-400 mt-8">
                Error Code: TABLE_NOT_FOUND
            </p>
        </div>
    </div>
@endcomponent