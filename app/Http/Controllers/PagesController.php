<?php

namespace App\Http\Controllers;
use Binafy\LaravelCart\Facades\Cart;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Ticket;

use Illuminate\Support\Facades\Session;
class PagesController extends Controller
{
    public function index(){
        $cartItems = Session::get('cart_items', []);
        $total = 0;
        
        foreach ($cartItems as $item) {
        $total += $item['price'] * $item['quantity'];
    }

    return Inertia::render('User/cart', [
        'cartItems' => $cartItems,
        'total' => $total,
        'cartCount' => count($cartItems),
    ]);


    }
    


 
    public function add(Request $request)
    {
     
            
            $ticketId = $request->input('ticket_id');
            $ticket = Ticket::findOrFail($ticketId);

            
            $cartItems = Session::get('cart_items', []);


            if (isset($cartItems[$ticketId])) {
               
                $cartItems[$ticketId]['quantity'] += 1;
                flash()->info('Ticket quantity updated in cart');
            } else {
                
                $cartItems[$ticketId] = [
                    'id' => $ticket->id,
                    'name' => $ticket->name,
                    'price' => $ticket->price,
                    'quantity' => 1,
                    'attributes' => [
                        'image' => $ticket->image,
                        
                    ]
                ];
                flash()->success('ticket added to cart successfully');
            }

           


            // Save cart back to session
            Session::put('cart_items', $cartItems);

            return back();

      
    }




    public function cartRemove($id){
        \Cart::session(auth()->user()->id)->remove($id);
        return back()->with('message', [
            'title' =>'item removed from cart successfully',
            'type'  =>'success',
        ]);

    }

}
