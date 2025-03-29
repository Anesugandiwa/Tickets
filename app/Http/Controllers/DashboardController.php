<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Organiser;
use Inertia\Inertia;

class DashboardController extends Controller
{
    //
    public function index()
    {
        return inertia('Dashboard', [
            'organisers' => Organiser::count(), 
            'events' => Event::count()         
        ]);
    }
}
