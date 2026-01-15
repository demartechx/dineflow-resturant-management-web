<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Livewire\Menu;
use App\Livewire\Cart; // Optional if cart is a full page
use App\Livewire\Checkout;
use App\Livewire\OrderTrack;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/table/{number}', function ($number) {
    // Store table number in session
    $table = \App\Models\RestaurantTable::where('number', $number)->first();

    if (!$table) {
        return view('errors.table-not-found', ['number' => $number]);
    }

    session(['restaurant_table_id' => $table->id, 'restaurant_table_number' => $table->number]);
    return redirect()->route('menu');
})->name('table.scan');

Route::get('/menu', Menu::class)->name('menu');
Route::get('/checkout', Checkout::class)->name('checkout');
Route::get('/track/{order}', OrderTrack::class)->name('order.track');
