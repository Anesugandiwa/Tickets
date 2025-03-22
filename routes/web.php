<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\EventController;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/event',[EventController::class, 'index'])->name('admin.events.list');
Route::post('/event',[EventController::class, 'store'])->name('admin.events.store');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
