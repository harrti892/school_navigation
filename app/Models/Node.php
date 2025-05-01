<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Node extends Model
{
    protected $fillable = ['node_id', 'svg_x', 'svg_y', 'floor'];

    // 若需查此節點的所有 edge，可加：
    public function outgoingEdges()
    {
        return $this->hasMany(Edge::class, 'from_node', 'node_id');
    }

    public function incomingEdges()
    {
        return $this->hasMany(Edge::class, 'to_node', 'node_id');
    }
}

