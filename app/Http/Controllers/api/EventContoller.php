<?php

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Organiser;
use Illuminate\Support\Str;

class EventController extends Controller{

// Add this method to your EventController
public function apiIndex()
{
    $events = Event::with(['organisers', 'tickets'])->get()->map(function ($event) {
        return [
            'id' => $event->id,
            'title' => $event->title,
            'description' => $event->description,
            'start_date' => $event->start_date,
            'end_date' => $event->end_date,
            'location' => $event->location,
            'preview_image' => asset('storage/' . $event->preview_image),
            'organisers' => $event->organisers->pluck('name'),
            'tickets' => $event->tickets
        ];
    });

    return response()->json([
        'events' => $events
    ]);
}
}