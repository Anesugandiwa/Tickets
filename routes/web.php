<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\EventController;
use App\Http\Controllers\OrganiserController;
use App\Http\Controllers\TicketController;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::group([
    'prefix' => 'admin',
], function(){
    Route::resource('/event',EventController::class);
    Route::resource('/organiser',OrganiserController::class);
    Route::resource('/tickets',TicketController::class);

});



require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
