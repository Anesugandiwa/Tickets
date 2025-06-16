<?php

namespace App\Http\Controllers\Api;



use App\Http\Controllers\Controller;
use Codevirtus\Payments\Pesepay;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Ticket;
use App\Models\Payment;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;


class EventController extends Controller
{
    /**
     * Display a listing of events
     */
    public function apiIndex()
    {
        try {
            $events = Event::with(['organisers'])
                ->orderBy('start_date', 'asc')
                ->get();

            return response()->json([
                'status' => 'success',
                'events' => $events,
                'count' => $events->count()
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching events: ' . $e->getMessage());
            
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch events'
            ], 500);
        }
    }

    /**
     * Get tickets for a specific event
     */
    public function getEventTickets($eventId)
    {
        try {
            $event = Event::findOrFail($eventId);
            $tickets = $event->tickets()->where('is_active', true)->get();

            return response()->json([
                'status' => 'success',
                'event' => $event->title,
                'tickets' => $tickets
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching event tickets: ' . $e->getMessage());
            
            return response()->json([
                'status' => 'error',
                'message' => 'Event or tickets not found'
            ], 404);
        }
    }

    /**
     * Get single ticket details
     */
    public function getTicket($ticketId)
    {
        try {
            $ticket = Ticket::with('event')->findOrFail($ticketId);

            return response()->json([
                'status' => 'success',
                'ticket' => $ticket
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching ticket: ' . $e->getMessage());
            
            return response()->json([
                'status' => 'error',
                'message' => 'Ticket not found'
            ], 404);
        }
    }

    /**
     * Process payment using Pesepay
     */
    public function processPesepayPayment(Request $request)
{
    $validator = Validator::make($request->all(), [
        'phone' => 'required|string|regex:/^\+263\d{9}$/',
        'event_id' => 'required|exists:events,id',
        'ticket_id' => 'required|exists:tickets,id'
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => false,
            'message' => 'Invalid input data',
            'errors' => $validator->errors()
        ], 400);
    }

    try {
        $ticket = Ticket::with('event')->findOrFail($request->ticket_id);
        $event = Event::findOrFail($request->event_id);

        // Initialize Pesepay
        $pesepay = new Pesepay(
            "34bebfa7-ac62-4f7d-a4fc-5231b288d3a4", // integration key
            "69df0e53d55748a79bc5cc9ba9e614db"      // encryption key
        );

        // Configure return & result URLs (optional)
        $pesepay->returnUrl = route('pese-return');
        $pesepay->resultUrl = route('pese-result-api', now());

        // Generate unique reference
        $referenceNumber = 'TKT-' . strtoupper(Str::random(6)) . '-' . time();

        // Create a Pesepay payment object
        $paymentObj = $pesepay->createPayment(
            'USD',
            'PZW211',                          // account reference/email (optional but recommended)
            'whatsapp.purchase@musami.com',    // contact email
            $request->phone,                   // contact phone
            $request->phone                    // customer identity
        );

        // Prepare requiredFields and execute seamless payment
        $requiredFields = ['customerPhoneNumber' => $request->phone];

        $response = $pesepay->makeSeamlessPayment(
            $paymentObj,
            'Buy Ticket ' . $ticket->name,
            $ticket->price,
            $requiredFields,
            $referenceNumber
        );

        if ($response->success()) {
            $pollUrl = $response->pollUrl();

            // Save the payment record
            Payment::create([
                'referenceNumber' => $referenceNumber,
                'pollUrl' => $pollUrl,
                'user_id' => $request->phone,
                'amount' => $ticket->price,
                'phone' => $request->phone,
                'event_id' => $request->event_id,
                'ticket_id' => $request->ticket_id,
                'is_paid' => false,
                'created_at' => now(),
            ]);

            return response()->json([
                'ref_num' => $referenceNumber,
                'pollUrl' => $pollUrl,
                'status' => 'success',
                'message' => 'Please enter PIN on your phone'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Payment initiation failed: ' . $response->message()
            ], 400);
        }

    } catch (\Exception $e) {
        Log::error('Pesepay error: ' . $e->getMessage(), [
            'trace' => $e->getTraceAsString(),
        ]);

        return response()->json([
            'status' => false,
            'message' => 'Payment processing failed: ' . $e->getMessage()
        ], 500);
    }
}
 /**
     * Check payment status with Pesepay
     */
    public function peseApiReturn(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ref_num' => 'required|string',
            'phone' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Invalid reference number or phone'
            ], 400);
        }

        try {
            $pesepay = new \Pesepay(
                "34bebfa7-ac62-4f7d-a4fc-5231b288d3a4",
                "69df0e53d55748a79bc5cc9ba9e614db"
            );

            $response = $pesepay->checkPayment($request->ref_num);

            if ($response->success()) {
                if ($response->paid()) {
                    // Update payment status
                    $payment = Payment::where('referenceNumber', $request->ref_num)->first();
                    
                    if ($payment && !$payment->is_paid) {
                        $payment->is_paid = true;
                        $payment->paid_at = now();
                        $payment->save();

                        return response()->json([
                            'status' => 'success',
                            'message' => 'Payment successful! Your ticket will be sent shortly. Reference: ' . $request->ref_num
                        ]);
                    } else if ($payment && $payment->is_paid) {
                        return response()->json([
                            'status' => 'success',
                            'message' => 'Payment already confirmed. Reference: ' . $request->ref_num
                        ]);
                    } else {
                        return response()->json([
                            'status' => 'failed',
                            'message' => 'Payment record not found'
                        ]);
                    }
                } else {
                    return response()->json([
                        'status' => 'pending',
                        'message' => 'Payment is still pending. Please complete the payment on your phone.'
                    ]);
                }
            } else {
                return response()->json([
                    'status' => 'failed',
                    'message' => $response->message() ?: 'Payment verification failed'
                ]);
            }

        } catch (\Exception $e) {
            Log::error('Payment status check error: ' . $e->getMessage());
            
            return response()->json([
                'status' => 'failed',
                'message' => 'Failed to check payment status'
            ], 500);
        }
    }

    /**
     * Send ticket after successful payment
     */
    public function sendTicket(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ref' => 'required|string',
            'phoneNumber' => 'required|string',
            'event_id' => 'required|exists:events,id',
            'ticket_id' => 'required|exists:tickets,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid request data'
            ], 400);
        }

        try {
            // Verify payment was successful
            $payment = Payment::where('referenceNumber', $request->ref)
                ->where('is_paid', true)
                ->first();

            if (!$payment) {
                return response()->json([
                    'status' => false,
                    'message' => 'Payment not found or not completed'
                ], 404);
            }

            $ticket = Ticket::with('event')->findOrFail($request->ticket_id);
            $event = Event::findOrFail($request->event_id);

            // Here you would typically:
            // 1. Generate a unique ticket code/QR code
            // 2. Send email with ticket details
            // 3. Store ticket purchase record
            
            $ticketCode = 'TICKET-' . strtoupper(Str::random(8));
            
            // You can add your email sending logic here
            // Mail::to($userEmail)->send(new TicketEmail($ticket, $event, $ticketCode));

            // Update payment with ticket code
            $payment->ticket_code = $ticketCode;
            $payment->ticket_sent_at = now();
            $payment->save();

            return response()->json([
                'status' => true,
                'message' => 'Your ticket has been generated! Ticket Code: ' . $ticketCode . '. Check your email for full details.',
                'ticket_code' => $ticketCode,
                'event_name' => $event->title,
                'ticket_name' => $ticket->name
            ]);

        } catch (\Exception $e) {
            Log::error('Ticket sending error: ' . $e->getMessage());
            
            return response()->json([
                'status' => false,
                'message' => 'Failed to generate ticket'
            ], 500);
        }
    }

    /**
     * Get organiser details for an event
     */
    public function getOrganiser($eventId)
    {
        try {
            $event = Event::with('organiser')->findOrFail($eventId);

            if (!$event->organiser) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No organiser found for this event.'
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'organiser' => [
                    'name' => $event->organiser->name,
                    'email' => $event->organiser->email,
                    'phone' => $event->organiser->phone_number,
                    'organization' => $event->organiser->organization_name,
                    'profile_image' => $event->organiser->profile_image,
                ],
            ]);

        } catch (\Exception $e) {
            Log::error('Error fetching organiser: ' . $e->getMessage());
            
            return response()->json([
                'status' => 'error',
                'message' => 'Organiser not found'
            ], 404);
        }
    }

    /**
     * Display the specified event
     */
    public function show($id)
    {
        try {
            $event = Event::with('organiser')->findOrFail($id);
            
            return response()->json([
                'status' => 'success',
                'event' => $event
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Event not found'
            ], 404);
        }
    }

    /**
     * Store a newly created event
     */
    public function store(Request $request)
    {
        // Implementation for creating new events
        // Add your validation and creation logic here
    }

    /**
     * Update the specified event
     */
    public function update(Request $request, string $id)
    {
        // Implementation for updating events
        // Add your validation and update logic here
    }

    /**
     * Remove the specified event
     */
    public function destroy(string $id)
    {
        // Implementation for deleting events
        // Add your deletion logic here
    }
}