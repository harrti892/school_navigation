<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Node;
use App\Models\Edge;

class NodeController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'node_id' => 'required|unique:nodes',
            'svg_x' => 'required|numeric',
            'svg_y' => 'required|numeric',
            'floor' => 'required|string',
        ]);

        return Node::create($request->only(['node_id', 'svg_x', 'svg_y', 'floor']));
    }

    public function destroy($node_id)
    {
        // 刪除與此節點有關的邊
        Edge::where('from_node', $node_id)->orWhere('to_node', $node_id)->delete();

        // 刪除節點
        Node::where('node_id', $node_id)->delete();

        return response()->json(['status' => 'deleted']);
    }
}
