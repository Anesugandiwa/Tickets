<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function apiIndex()
    {
        $events =Event::with(['organisers'])->orderBy('start_date', 'asc')->get();
        return response()->json([
            'status' => 'success',
            'events' => $events
        ]);

       
        
    }
    public function getOrganiser($eventId)
    {
        $event = Event::with('organiser')->findOrFail($eventId);
        
        if (!$event->organiser) {
            return response()->json([
                'message' => 'No organiser found for this event.'
            ], 404);
        }
        
        return response()->json([
            'organiser' => [
            'name' => $event->organiser->name,
            'email' => $event->organiser->email,
            'phone' => $event->organiser->phone_number,
            'organization' => $event->organiser->organization_name,
            'profile_image' => $event->organiser->profile_image,
        ],
    ]);
}

public function peseApiReturn(Request $request){
    $pesepay = new Pesepay(
        "34bebfa7-ac62-4f7d-a4fc-5231b288d3a4",
        "69df0e53d55748a79bc5cc9ba9e614db"
    );

    $response =  $pesepay->checkPayment($request->ref_num);

    if ($response->success()){
        if ($response->paid()){
            $paymen = Payment::where('referenceNumber', $request->ref_num)->first();
            $paymen->is_paid = 1;
            $paymen->save();

            return response()->json([
                    'status'      => 'success',
                    'message'     =>  'Payment Successfully. Please wait for your Ticket. Your reference no is: '.$request->ref_num
                ]);
        } else {
            return response()->json([
                'status' => 'pending',
                'message' => 'pending please wait',
            ]);
        } 
    } else{
        return response()->json([
            'status' => 'failed',
            'message' => $response->message(),
        ]);
    }

}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show( $id)
    {
        $event = Event::with('organiser')->findOrFail($id);
        return response()->json($event);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
