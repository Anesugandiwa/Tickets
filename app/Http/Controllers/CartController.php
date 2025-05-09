<?php

namespace App\Http\Controllers;
use App\Models\Event;
use Illuminate\Http\Request;
use Binafy\LaravelCart\Facades\Cart;


class CartController extends Controller
{
    public function add(Request $request)
{
    $event = Event::findOrFail($request->input('event_id'));

    Cart::add([
        'id' => $event->id,
        'name' => $event->title,
        'price' => $event->price,
        'quantity' => 1,
    ]);

    return back()->with('success', 'Added to cart');
}

}
