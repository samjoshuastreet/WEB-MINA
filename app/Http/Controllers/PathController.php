<?php

namespace App\Http\Controllers;

use App\Models\Path;
use App\Models\Building;
use App\Models\BuildingEntrypoint;
use Taniko\Dijkstra\Graph;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PathController extends Controller
{
    public function index()
    {
        $paths = Path::all();
        return view('admin.paths.index', compact('paths'));
    }
    public function add()
    {
        return view('admin.paths.add');
    }
    public function add_submit(Request $request)
    {
        $path = new Path();
        $path->wp_a_lng = $request->input('wp_a_lng');
        $path->wp_a_lat = $request->input('wp_a_lat');
        $path->wp_a_code = $request->input('wp_a_code');
        $path->wp_b_lng = $request->input('wp_b_lng');
        $path->wp_b_lat = $request->input('wp_b_lat');
        $path->wp_b_code = $request->input('wp_b_code');
        $path->weight = $request->input('weight');
        if ($request->input('building_connection') == 'true') {
            if ($request->input('buildingConnectionA')) {
                $target = $request->input('buildingConnectionA');
                $entrypoint = BuildingEntrypoint::find($target);
                $building = $entrypoint->building;
                $building->connection_count += 1;
                if ($building->status == 'inactive') {
                    $building->status = 'active';
                }
                $path->entrance = 'true';
                $path->connected_building = $building->id;
                $building->save();
            }
        } else {
            $path->entrance = 'false';
        }
        $path->save();
        return response()->json(['success' => true]);
    }
    public function get()
    {
        $paths = Path::all();
        return response()->json(['paths' => $paths]);
    }
    public function find(Request $request)
    {
        $target = $request->input('target');
        if ($request->input('editor')) {
            $path = Path::find($target);
            $codes = $path->wp_a_code . $path->wp_b_code;
            return response()->json(['codes' => $codes]);
        }
        $pathA = Path::where('wp_a_code', $target)->first();
        $pathB = Path::where('wp_b_code', $target)->first();

        if ($pathA) {
            $waypoint = true;
        } elseif ($pathB) {
            $waypoint = false;
        }

        $path = $pathA ?? $pathB;
        return response()->json(['path' => $path, 'waypoint' => $waypoint]);
    }
    public function validator(Request $request)
    {
        if ($request->input('redMarkers') == "true") {
            return response()->json(['success' => true]);
        } else if ($request->input('buildingConnection') == "true") {
            return response()->json(['success' => true]);
        } else {
            $code = $request->input('code');
            $existing = Path::where('wp_a_code', $code)
                ->orWhere('wp_b_code', $code)
                ->exists();


            if ($existing) {
                return response()->json(['success' => false, 'code' => $code]);
            } else {
                return response()->json(['success' => true]);
            }
        }
    }
    public function edit()
    {
        return view('admin.paths.edit');
    }
    public function delete(Request $request)
    {
        $target = $request->input('target');
        $path = Path::find($target);
        $codes = $path->wp_a_code . $path->wp_b_code;
        if ($path->entrance == 'true') {
            $building_id = $path->connected_building;
            $building = Building::find($building_id);
            if ($building->connection_count <= 1) {
                $building->status = 'inactive';
            }
            $building->connection_count -= 1;
            $building->save();
        }
        $path->delete();
        return response()->json(['codes' => $codes]);
    }
}
