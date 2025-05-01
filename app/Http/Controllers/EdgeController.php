<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Edge;

class EdgeController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'from_node' => 'required|string',
            'to_node' => 'required|string',
        ]);

        return Edge::create($request->only(['from_node', 'to_node']));
    }

    public function destroy($edge_id)
    {
        Edge::findOrFail($edge_id)->delete();
        return response()->json(['status' => 'edge deleted']);
    }
}
