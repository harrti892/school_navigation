<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Node;
use App\Models\Edge;
use App\Models\Map;

class NavigationController extends Controller
{
    public function showMapEditor(Request $request)
    {
        // 取得所有 maps 並組成 floorKey => path，例如：T03 => /storage/maps/t03.svg
        $maps = Map::all();
        $floorList = $maps->mapWithKeys(function ($map) {
            return [$map->building . $map->floor => $map->svg_path];
        })->toArray();

        // 設定目前選擇的樓層
        $currentFloor = $request->input('floor', array_key_first($floorList));
        $building = substr($currentFloor, 0, 1);
        $floor = substr($currentFloor, 1);

        $nodes = Node::where('floor', $currentFloor)->get();
        $edges = Edge::all();

        return view('admin.map-editor', compact('nodes', 'edges', 'floorList', 'currentFloor'));
    }
}
