<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;


class EventController extends Controller
{
    public function index(){
        $events = Event::all();

        return inertia('Admin/Events/event',[
            'events' => $events
            
        ]);
    }

    public function create(){
        return inertia('Admin/Events');

    }

    public function store(Request $request){
        $request->validate([
            'title'                 =>'required|string|max:225|min:5',
            'description'           =>'required|max:225|min:5',
            'start_date'            =>'required|date|after_or_equal:today',
            'end_date'              =>'required|date|after:start_date',
            'preview_image'         => 'required|image|mimes:jpeg,png,jpg,gif',
            'location'              =>'required|string|max:255|min:3',
            'total_tickets'         =>'required|min:1',
            'is_priced'             =>'required'
        ]);

        $event = Event::firstOrNew(['id' =>$request->id]);

        if($request->hasFile('preview_image')) {
            $filePath = $request->file('preview_image')->store('images', 'public');
            $event->preview_image = $filePath;


        } else {
            $event->preview_image = $request->preview_image;
        }

        $event->title = $request->title;
        $event->description = $request->description;
        $event->slug =$request->slug;
        $event->start_date =$request->start_date;
        $event->end_date =$request->end_date;
        $event->location = $request->location;
        $event->total_tickets = $request->total_tickets;
        $event->is_priced = $request->is_priced;

        $event->save();

        return redirect(route('event.index'));




    }

    public function show(Event $event)
    {

    }
    public function update(Request $request, $id){

        $request-> validate([
            'title'                 =>'required|string|max:225|min:5',
            'description'           =>'required|max:225|min:5',
            'start_date'            =>'required|date|after_or_equal:today',
            'end_date'              =>'required|date|after:start_date',
            'preview_image'         => 'required|image|mimes:jpeg,png,jpg,gif',
            'location'              =>'required|string|max:255|min:3',
            'total_tickets'         =>'required|min:1',
            'is_priced'             =>'required'
            
        ]);

        $event =Event::findOrFail($id);

        $event->update([
            'title' => $request->title,
            'description' => $request->description,
            'slug' => $request->slug,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'location' => $request->location,
            'total_tickets' => $request->total_tickets,
            'is_priced' => $request->is_priced,
        ]);

        if ($request->hasFile('preview_image')) {
            $imagePath = $request->file('preview_image')->store('events', 'public');
            $event->preview_image = $imagePath;

            $event->save();
        }

        return redirect()->route('event.index')->with('success', 'Event Updated successfully!');


        
    }

    
    public function destroy(Event $event)
    {

        
        $event->delete();

        return redirect()->back()->with('message', [
            'type'        => 'success',
            'description' => '',
            'title'       => 'Event Deleted',
        ]);
    }
}
