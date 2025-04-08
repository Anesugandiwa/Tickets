<?php

use App\Http\Controllers\EventController;

Route::group([
    'prefix' => "api."
], function (){
    Route::get('/events', [EventController::class, 'apiIndex']);

});

