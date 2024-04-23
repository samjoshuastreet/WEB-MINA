<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::all();
        return view('admin.events.index', compact('events'));
    }

    public function add()
    {
        return view('admin.events.add');
    }

    public function add_validate(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'event_name' => 'required|unique:events',
            'event_description' => 'required',
            'instructions' => 'required',
            'access_level' => 'required|numeric|min:1|max:4',
            'start_date' => 'required',
            'end_date' => 'required',
            'building_id' => 'required'
        ]);
        if ($validate->fails()) {
            return response()->json(['success' => false, 'msg' => $validate->errors()->toArray()]);
        } else {
            $event = Event::create([
                'event_name' => $request->input('event_name'),
                'event_description' => $request->input('event_description'),
                'event_instructions' => $request->input('instructions'),
                'access_level' => $request->input('access_level'),
                'start_date' => $request->input('start_date'),
                'end_date' => $request->input('end_date'),
                'building_id' => intval($request->input('bldg_id'))
            ]);
            return response()->json(['success' => true, 'event' => $event->event_name]);
        }
    }

    public function get(Request $request)
    {
        $target = Event::find($request->input('id'));
        $today = Carbon::today();
        $start = Carbon::parse($target->start_date)->format('F d (h:i A)');
        $end = Carbon::parse($target->end_date)->format('F d (h:i A)');
        if ($today >= $target->end_date) {
            $status = 'Ended';
        } elseif ($today < $target->end_date && $today >= $target->start_date) {
            $status = 'On Going';
        } else {
            $status = 'Upcoming';
        }
        $building = $target->building->buildingMarker;
        return response()->json(['target_event' => $target, 'status' => $status, 'end' => $end, 'start' => $start]);
    }
    public function delete(Request $request)
    {
        $target = Event::find($request->input('id'));
        $target->delete();
        return response()->json(['name' => $target->event_name]);
    }
    public function all()
    {
        $events = Event::all();
        return view('admin.events.ajax.list', compact('events'))->render();
    }
}
