<?php

namespace App\Http\Controllers;

use App\Models\Path;
use App\Models\Event;
use App\Models\Office;
use App\Models\Building;
use App\Models\Procedure;
use Illuminate\Http\Request;
use App\Models\FeedbackReport;

class AdminController extends Controller
{
    public function index()
    {
        $building_count = Building::all()->count();
        $office_count = Office::all()->count();
        $path_count = Path::all()->count();
        $procedure_count = Procedure::all()->count();
        $onGoingEvents = Event::onGoingEvents(3);
        $endedEvents = Event::endedEvents(3);
        $upcomingEvents = Event::upcomingEvents(3);
        $fIP = FeedbackReport::inProgCount();
        $fp = FeedbackReport::pausedCount();
        $fr = FeedbackReport::resolvedCount();
        $fn = FeedbackReport::newCount();

        return view('admin.index', compact(
            'building_count',
            'office_count',
            'path_count',
            'procedure_count',
            'onGoingEvents',
            'upcomingEvents',
            'endedEvents',
            'fIP',
            'fp',
            'fr',
            'fn'
        ));
    }
}
