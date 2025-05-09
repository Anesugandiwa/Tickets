<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\Event;


class TicketController extends Controller
{
    //
    // public function index(){

        public function forEvent(Event $event)
        {
            $tickets = $event->tickets()
            ->where('total_available', '>', 0)
            ->get(['id', 'name', 'price', 'total_available', 'image']);
            
            return inertia('User/viewTickets', [
                'tickets' => $tickets,
                'event_id' => $event->id
            ]);

        
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
        

        if ($request->hasFile('image')) {

            $ticket->image   = $this->uploadFile($request->image,'/storage/tickets/');

        }else{

            $ticket->image             = $request->image;
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

    public function destroy(Ticket $ticket){
        $ticket ->delete();

        return redirect()->back()->with('message', [
            'type'        => 'success',
            'description' => '',
            'title'       => 'Ticket Deleted',
        ]);
    }
}
