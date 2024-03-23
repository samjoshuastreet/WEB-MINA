<?php

namespace App\Http\Controllers;

use App\Models\Path;
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
        return response()->json(['success' => true, 'route' => $route]);
    }
}
