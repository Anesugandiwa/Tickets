<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\EventController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

// Route::get('/events', function() {
//     return 'Api';
// });


Route::get('/events', [\App\Http\Controllers\Api\EventController::class,'apiIndex']);
// Route::get('/events/{id}/organiser', [\App\Http\Controllers\Api\EventController::class,'getOrganiser']);
Route::get('/events/{id}', [App\Http\Controllers\Api\EventController::class, 'show']);
