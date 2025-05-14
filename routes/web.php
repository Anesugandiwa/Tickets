<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\EventController;
use App\Http\Controllers\OrganiserController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\CartController;


Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', [DashboardController::class, 'index']
    //  return Inertia::render('Dashboard');
)->middleware(['auth', 'verified'])->name('dashboard');

Route::group([
    'prefix' => 'admin',
    'as'  => 'admin.',
    'middleware' =>[App\Http\Middleware\isAdmin::class,]
], function(){
    
    Route::resource('/event',EventController::class);
    Route::resource('/organiser',OrganiserController::class);
    Route::resource('/tickets',TicketController::class);
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
   

});

Route::get('/event/{slug}', function ($slug){

    return Inertia::render('SingleEvent', [
        'event' => \App\Models\Event::where('slug', $slug)
            ->with(['tickets'])
            ->first()
    ]);

})->name('single.event');

Route::get('/cart-checkout', [PagesController::class, 'cart'])->name('cart');
Route::get('/cart-add-remove/{item}',[PagesController::class,'addCart'])->name('card.add.remove');
Route::get('/cart-remove/{item}',[PagesController::class,'cartRemove'])->name('cart.remove');
Route::get('/cart',[PagesController::class,'index'])->name('view_cart');

Route::post('/cart/add', [PagesController::class, 'add'])->name('cart.add');


// view each ticket from the event
Route::get('/events/{event}/tickets', [TicketController::class, 'forEvent'])
     ->name('tickets.for-event');

// Payments Routes

Route::post('/make-payment',[PagesController::class, 'initiatePayment'])->name('make-payment');
Route::post('/check-payment',[PagesController::class,'pesePayReturn'])->name('pese-return');



require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
require __DIR__.'/user.php';



