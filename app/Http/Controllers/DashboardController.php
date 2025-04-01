<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Organiser;
use Inertia\Inertia;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class DashboardController extends Controller
{
    //
    public function index()
    {
        $trend = Trend::model(Event::class)
        ->between(
            start: now()->startOfYear(),
            end: now()->endOfYear(),
        )
        ->perMonth()
        ->count();

        return inertia('Dashboard', [
            'organisers' => Organiser::count(), 
            'events' => Event::count(),
            'labels' => $trend->map(fn ($item) => date('M', strtotime($item->date))),
            'dataset' => $trend->map(fn (TrendValue $item) => $item->aggregate),       
        ]);
    }
}
