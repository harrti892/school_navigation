<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Edge extends Model
{
    protected $fillable = ['from_node', 'to_node', 'distance'];

    public function from()
    {
        return $this->belongsTo(Node::class, 'from_node', 'node_id');
    }

    public function to()
    {
        return $this->belongsTo(Node::class, 'to_node', 'node_id');
    }
}

