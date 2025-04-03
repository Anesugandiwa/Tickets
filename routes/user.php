<?php
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\UserDashboardController;

Route::group([
    'prefix' => 'client-area',
], function(){

Route::get('/dash', [UserDashboardController::class, 'index']);

});
