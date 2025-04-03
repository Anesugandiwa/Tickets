<?php
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\EventController;

Route::group([
    'prefix' => 'client-area',
    'as'  => 'client.'
], function(){

Route::get('/dash', [UserDashboardController::class, 'index'])->name('user_dasshboard');
Route::get('/event/{slug}', [UserDashboardController::class, 'show'])->name('allEvents');

});
