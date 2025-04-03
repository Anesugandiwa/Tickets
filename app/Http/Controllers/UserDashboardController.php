<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class UserDashboardController extends Controller
{
    //
    public function index(){
        $events = Event::all();
        return inertia('User/dash', [
            'events' =>$events
        ]);

    }
}
