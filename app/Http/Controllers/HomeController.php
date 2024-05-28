<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Office;
use App\Models\Building;
use App\Models\Procedure;
use App\Models\BuildingType;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class HomeController extends Controller
{
    public function index()
    {
        $procedures = Procedure::all();
        $today = Carbon::today();
        $events = Event::where('end_date', '>=', $today->toDateString())
            ->get();
        $building_types = BuildingType::all();
        $offices = Office::all();
        return view('home.map', compact('procedures', 'events', 'building_types', 'events', 'offices'));
    }
}
