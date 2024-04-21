<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Building;
use App\Models\BuildingType;
use App\Models\Procedure;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $procedures = Procedure::all();
        $events = Event::all();
        $building_types = BuildingType::all();
        return view('home.map', compact('procedures', 'events', 'building_types'));
    }
}
