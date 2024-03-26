<?php

namespace App\Http\Controllers;

use App\Models\Path;
use App\Models\Building;
use Taniko\Dijkstra\Graph;
use Illuminate\Http\Request;

class DirectionsController extends Controller
{
    public function get(Request $request)
    {
        $origin = $request->input('origin');
        $destination = $request->input('destination');
        $graph = Graph::create();
        $paths = Path::all();
        foreach ($paths as $path) {
            $graph->add($path->wp_a_code, $path->wp_b_code, $path->weight);
        }
        $route = $graph->search($origin, $destination);
        $weight = $graph->cost($route);
        if ($request->input('weight')) {
            return response()->json(['success' => true, 'route' => $route, 'weight' => $weight]);
        }
        return response()->json(['success' => true, 'route' => $route]);
    }
    public function polarpoints(Request $request)
    {
        $origin = $request->input('origin');
        $target_origin = Building::where('building_name', $origin)->first();
        $origin_entrypoints = json_decode($target_origin->buildingEntrypoint);
        $destination = $request->input('destination');
        $target_destination = Building::where('building_name', $destination)->first();
        $destination_entrypoints = json_decode($target_destination->buildingEntrypoint);
        return response()->json(['success' => true, 'target_origin' => $origin_entrypoints, 'target_destination' => $destination_entrypoints]);
    }
}
