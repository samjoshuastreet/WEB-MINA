<?php

namespace App\Http\Controllers;

use App\Models\Path;
use App\Models\Building;
use Taniko\Dijkstra\Graph;
use Illuminate\Http\Request;
use App\Models\BuildingEntrypoint;
use Illuminate\Support\Facades\DB;

use function Symfony\Component\String\b;
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
        if ($request->input('single_search')) {
            $code_a = $request->input('a');
            $code_b = $request->input('b');
            $paths = Path::all();
            foreach ($paths as $path) {
                if ($path->wp_a_code == $code_a || $path->wp_b_code == $code_a) {
                    if ($path->wp_a_code == $code_b || $path->wp_b_code == $code_b) {
                        $target = $path;
                    }
                }
            }
            return response()->json(['path' => $target]);
        }
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
            $entries = BuildingEntrypoint::all();
            $decodedEntries = [];

            foreach ($entries as $entry) {
                // Decode the JSON string from the entrypoints column
                $decodedEntry = json_decode($entry->entrypoints, true);

                // Check if decoding was successful
                if ($decodedEntry !== null) {
                    // Add decoded entrypoints to the array
                    $decodedEntries[] = $decodedEntry;
                } else {
                    // Handle the case where JSON decoding failed for a record
                    return response()->json(['error' => 'Failed to decode JSON for record with ID ' . $entry->id]);
                }
            }
            return response()->json(['success' => true, 'decodedEntries' => $decodedEntries]);
        } else if ($request->input('buildingConnection') == "true") {
            return response()->json(['success' => true, 'connection' => true]);
        } else if ($request->input('entrypoint_validation')) {
            if ($request->input('connection') !== "true") {
                $target = $request->input('code');
                $codes = $request->input('codes');
                foreach ($codes as $code) {
                    if ($code == $target) {
                        return response()->json(['success' => false, 'code' => $code]);
                    }
                }
            }
            return response()->json(['success' => true]);
        } else {
            $code = $request->input('code');
            $pathExists = Path::where('wp_a_code', $code)
                ->orWhere('wp_b_code', $code)
                ->exists();

            if ($pathExists) {
                return response()->json(['success' => false, 'code' => $code]);
            } else {
                $entries = BuildingEntrypoint::all();
                $decodedEntries = [];

                foreach ($entries as $entry) {
                    // Decode the JSON string from the entrypoints column
                    $decodedEntry = json_decode($entry->entrypoints, true);

                    // Check if decoding was successful
                    if ($decodedEntry !== null) {
                        // Add decoded entrypoints to the array
                        $decodedEntries[] = $decodedEntry;
                    } else {
                        // Handle the case where JSON decoding failed for a record
                        return response()->json(['error' => 'Failed to decode JSON for record with ID ' . $entry->id]);
                    }
                }
                return response()->json(['success' => true, 'decodedEntries' => $decodedEntries]);
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
