<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;

class TicketController extends Controller
{
    //
    public function index(){
        
    }

    public function store(Request $request){
        $request->validate([
            'event_id'         =>'required',
            'name'             =>'required',
            'image'            =>'required',
            'total_available'  =>'required',
            'price'            =>'required',

        ]);

        $ticket = Ticket::firstorNew(['id' =>$request->id]);
        
        $ticket->event_id           = $request->event_id;
        $ticket->name               = $request->name;
        

        if($request->hasFile('image')) {
            $filePath = $request->file('image')->store('images', 'public');
            $ticket->image = $filePath;


        } else {
            $ticket->image = $request->image;
        }
        $ticket->total_available        = $request->total_available;
        $ticket->price                  =$request->price;
        $ticket->save();

        return back()->with('message', [
            'type'        => 'success',
            'description' => '',
            'title'       => 'Ticket Details Saved',
        ]);

    }
}
