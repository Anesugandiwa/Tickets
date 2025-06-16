<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\TicketController;
use Codevirtus\Payments\Pesepay;


// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

// Route::get('/events', function() {
//     return 'Api';
// });


Route::get('/events', [\App\Http\Controllers\Api\EventController::class,'apiIndex']);
// Route::get('/events/{id}/organiser', [\App\Http\Controllers\Api\EventController::class,'getOrganiser']);
Route::get('/event/{id}', [App\Http\Controllers\Api\EventController::class, 'getOrganiser']);
Route::post('/pese-return-api',[App\Http\Controllers\Api\EventController::class,'peseApiReturn'])->name('pese-return');
Route::get('/events/{event}/tickets',[TicketController::class, 'getTicketsForEvent']);

Route::get('/ticket/{ticketId}', [EventController::class, 'getTicket']);
Route::post('/payment', [EventController::class, 'processPesepayPayment']);
Route::post('/pese-result-api', function () {})->name('pese-result-api');

// Route::post('/payment', function(Request $request){
//     $pesepay = new \EmmanuelSiziba\Pesepay\Pesepay(
//         "34bebfa7-ac62-4f7d-a4fc-5231b288d3a4",
//         "69df0e53d55748a79bc5cc9ba9e614db"
//     );
//     $ticket = \App\Models\Ticket::find($request->ticket_id);
//     $pesepay->returnUrl = route('pese-return-api');
//     $pesepay->resultUrl = route('pese-result-api', now());

//     $requiredFileds = ['customerPhoneNumber'=>$request->phone];
        
//     $payment = $pesepay->createPayment(
//         'USD',
//         'PZW211',
//         'whatsapp.purchase@musami.com',
//         $request->phone,
//         $request->phone
//     );

//     $response = $pesepay->makeSeamlessPayment(
//         $payment,
//         'Buy Ticket'.$ticket->name,
//         $ticket->price,
//         $requiredFileds,
//         $request->phone.'_'.now()
//     );
//     if ($response->succes()){
//         $referenceNumber = $response->referenceNumber();
//         $pollUrl = $response->pollUrl();

//         session(['referenceNumber' => $referenceNumber]);

//         $paymentSaved = new Payment();

//         $paymentSaved->referenceNumber  = $referenceNumber;
//         $paymentSaved->pollUrl          = $pollUrl;
//         $paymentSaved->user_id          = $request->phone;
//         $paymentSaved->save();

//         return response()->json([
//             'ref_num' => $referenceNumber,
//             'pollUrl' => $pollUrl,
//             'status' => 'success',
//             'message' => 'please enter pin on your Phone'
//         ]);
//     }else {
//         $errorMessage = $response->message();

//         return response()->json([
//             'status' => false,
//             'message' => $errorMessage,
//         ]);
//     }


// });

