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



    public function recover(){
        return inertia('recover');
    }

    public function recoverTicket($ref_no){
        $paymen = Payment::where('referenceNumber', $ref_no)->with(['ticket'])->get();
        if($paymen->is_paid ==1){
            return inertia('Recovered', [
                'tickets' => Purchase::where('referenceNumber',$ref_no)->with(['ticket'])->get(),
                'referenceNumber' => $ref_no,
            ]);


        } else {
            return inertia('Hanging', [
                'reference' => $ref_no,
            ]);
        }
    }

    public function initiatePayment(Request $request){
        if(env('App_DEBUG')){
            $referenceNumber = rand(1, 50);

            $paymentSaved = new Payment();

            $paymentSaved->referenceNumber  = $referenceNumber;
            $paymentSaved->pollUrl          = '/fake-urd';
            $paymentSaved->user_id          = auth()->user()->id;
            $paymentSaved->save();

            return response()->json([
                'ref_num' => $referenceNumber,
                'pollUrl' => '/fake-urd',
                'status'  => 'success',
                'message' => 'Please Enter pin on your phone',
            ]);



        }

        $pesepay = new Pesepay(
            "34bebfa7-ac62-4f7d-a4fc-5231b288d3a4",
            "69df0e53d55748a79bc5cc9ba9e614db"
        );

        $pesepay->returnUrl =  route('pese-return');
        $pesepay->resultUrl =  route('pese-result',now());

        $requiredFields = ['customerPhoneNumber'=>$request->customerPhoneNumber];

        $payment = $pesepay->createPayment(
            'USD',
            'PZW211',
            auth()->user()->email,
            $request->customerPhoneNumber,
            auth()->user()->name
        );

        $response = $pesepay->makeSeamlessPayment(
            $payment,
            $request->reason,
            \Cart::session(auth()->user()->id)->getTotal(),
            $requiredFields,
            auth()->user()->id.'-'.now()
        );

        
        if ($response->success()) {
            # Save the reference number and/or poll url (used to check the status of a transaction)
            $referenceNumber = $response->referenceNumber();
            $pollUrl = $response->pollUrl();

            $paymentSaved = new Payment();

            $paymentSaved->referenceNumber  = $referenceNumber;
            $paymentSaved->pollUrl          = $pollUrl;
            $paymentSaved->user_id          = auth()->user()->id;
            $paymentSaved->save();

            return response()->json([
                'ref_num'      => $referenceNumber,
                'pollUrl'      => $pollUrl,
                'status'       => 'success',
                'message'      => 'Please enter pin on your phone'
            ]);

        } else {
            #Get Error Message
            $errorMessage = $response->message();

           return response()->json([
                'status'       => 'failed',
                'message'      => $errorMessage
            ]);
        }

    }

    public function pesePayReturn(Request $request){
        
        if(env('APP_DEBUG')){
            
            $paymen = Payment::where('referenceNumber',$request->ref_num)->first();
            $paymen->is_paid = 1;
            $paymen->save();
            
            return response()->json([
                'status'       => 'paid',
                'ref_num'      => $request->ref_num,
                'message'      => 'Payment Complete'
             ]);
            }

            $pesepay = new Pespay(
                "34bebfa7-ac62-4f7d-a4fc-5231b288d3a4",
                "69df0e53d55748a79bc5cc9ba9e614db"
            );

            $response = $pesepay->checkPayment($request->ref_num);

            if ($response->success()){
                if($response->paid()){
                    $paymen = Payment::where('referenceNumber', $request->ref_num)->first();
                    $paymen->is_paid = 1;
                    $paymen->save();

                     return response()->json([
                         'status'       => 'paid',
                         'ref_num'      => $request->ref_num,
                         'message'      => 'Payment Complete'
                     ]);
                } else{
                    return response()->json([
                        'status' => 'pending',
                        'message' => 'pending please wait'
                    ]);
                }
            }  else {
                 # Get error message
                 return response()->json([
                     'status'      => 'failed',
                     'message'     =>  $response->message()
                 ]);
             }


    }
    public function pesePayResult($id){
        $paymen = Payment::where('referenceNumber',$id)->first();

        if($paymen->is_paid ==1){
            if(count(Purchase::where('referenceNumber', $id)->get())===0){
                $items = \Cart::session(auth()->user()->id)->getContent();
                $tickets = [];
                
                foreach($items as $item){
                    for($i =0; i< $item->quantity; $i++){
                        $objct = new \stdClass();

                        $objct->id          =$item->id.'_'.$i;
                        $objct->name        =$item->name;     
                        $objct->image        =$item->associatedModel->image;
                        $objct->event_id   =$item->associatedModel->event_id;
                        $objct->price     = $item->price;
                        $objct->event     = Event::find($item->associatedModel->event_id);

                        array_push( $tickets, $objct);

                        $name = rand(1001,20458).$objct->id;

                        QRCode::text($id)
                             ->setOutfile(Storage::disk("public")->path("tickets/purchases/".$name.".svg"))
                             ->svg();

                        $purchase = new Purchase();

                        $purchase->event_id  = $objct->event_id;
                        $purchase->ticket_id          = $item->id;
                        $purchase->user_id            = auth()->user()->id;
                        $purchase->quantity           = 1;
                        $purchase->referenceNumber    = $id;
                        $purchase->qr_path            = "/storage/tickets/purchases/".$name.".svg";
                        $purchase->status             = 0;
                        $purchase->save();
                        \Cart::session(auth()->user()->id)->remove($item->id);
                    }
                }
            }

            Auth::logout();
            return inertia(' PaymentSuccess',[
                'tickets' => Purchase::where('referenceNumber', $id)
                    ->with(['ticket'])
                    ->get(),
                'referenceNumber' => $id,
            ]);
 
        }else{
            return inertia('Hanging', [
                'rerference' =>$id,
            ]);
        }
    }
        public function verifyTicket($id)
    {
        return Purchase::where('referenceNumber',$id)->where('status',0)->first();
    }

    public function pesePayCheckout(){
        $pesepay = new Pesepay(
            "34bebfa7-ac62-4f7d-a4fc-5231b288d3a4",
            "69df0e53d55748a79bc5cc9ba9e614db"
        );

        $pesepay->returnUrl =  route('pesePayReturnExternal');
        $pesepay->resultUrl =  route('pese-result',now());

        $transaction = $pesepay->createTransaction(
            \Cart::session(auth()->user()->id)->getTotal(),
            'USD',
            'Purchase of a ticket',
            'MERCHANT_REFERENCE_'.now()
        );

        $response = $pesepay->initiateTransaction($transaction);

        if ($response->success()) {
            # Save the reference number and/or poll url (used to check the status of a transaction)
            $referenceNumber = $response->referenceNumber();
            $pollUrl = $response->pollUrl();


            $paymentSaved = new Payment();

            $paymentSaved->referenceNumber  = $referenceNumber;
            $paymentSaved->pollUrl          = $pollUrl;
            $paymentSaved->user_id          = auth()->user()->id;
            $paymentSaved->save();

            # Get the redirect url and redirect user to complete transaction
            $redirectUrl = $response->redirectUrl();

            //add reference to session
            session(['referenceNumber' => $referenceNumber]);
            return inertia_location($redirectUrl);

        } else {
            # Get error message
            $errorMessage = $response->message();

            return $errorMessage;
        }
    }
     public function  pesePayReturnExternal(){

        if(env('APP_DEBUG')){

            $paymen = Payment::where('referenceNumber',session('referenceNumber'))->first();
            $paymen->is_paid = 1;
            $paymen->save();
            return  redirect()->route('pese-result',session('referenceNumber'));
        }

        $pesepay = new Pesepay(
            "34bebfa7-ac62-4f7d-a4fc-5231b288d3a4",
            "69df0e53d55748a79bc5cc9ba9e614db"
        );

        $response = $pesepay->checkPayment(session('referenceNumber'));

        if ($response->success()) {

            if ($response->paid()) {

                $paymen = Payment::where('referenceNumber',session('referenceNumber'))->first();
                $paymen->is_paid = 1;
                $paymen->save();

                return  redirect()->route('pese-result',session('referenceNumber'));

            }else{

                return Inertia::render('PaymentFailed');
            }

        } else {
            # Get error message
            return response()->json([
                'status'      => 'failed',
                'message'     =>  $response->message()
            ]);
        }

    }


}
