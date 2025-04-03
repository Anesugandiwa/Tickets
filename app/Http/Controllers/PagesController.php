<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class PagesController extends Controller
{
    //
    public function cart(){
        if(Auth::check()){
            $items = \Cart::session(auth()->user()->id)->getContent();
            $total=  \Cart::session(auth()->user()->id)->getTotal();

            return inertia('Checkout', [
                'items' => $items,
                "total" => $total
            ]);

        }else{
            return redirect('/');
        }
    }
    
    public function addCart($id){
        if (\Auth::check()){
            $user = auth()->user();
        } else{
            $exists = User::where('email', visitor()->ip().'@customer.com')->first();

            if($exists){
                Auth::login($exists);
            } else{
                $user = new User();

                $user->name = visitors()->browser().'_'.visitor()->platform();
                $user->role = 'user';
                $user->email = visitor()->ip().'@customer.com';
                $user->email_verified_at = now();
                $user->password           = Hash::make(now());
                $user->save();

                Auth::login($user);

            }
        }

        $eventTicket = \App\Models\Ticket::find($id);
        $userId      =auth()->user()->id;

        \Cart::session($userId)->add(array(
            'id'            =>$eventTicket->id,
            'name'          =>$eventTicket->name,
            'price'         =>$eventTicket->price ?: 0,
            'quantity'      =>1,
            'attributes'      => [
                'event_title' => Event::find($eventTicket->event_id)['title']
            ],
            'associatedModel' => $eventTicket

        ));

        $optiontext = 'Do you want to checkout now?';
        $optionRoute = route('cart');

        return back()->with('messag', [
            'title' =>'Ticket Added to cart Successfully',
            'type'  =>'success',
            'optiontext' => $optiontext,
            'optionRoute' =>$optionRoute,
        ]);
    }

    public function cartRemove($id){
        \Cart::session(auth()->user()->id)->remove($id);
        return back()->with('message', [
            'title' =>'item removed from cart successfully',
            'type'  =>'success',
        ]);

    }

}
