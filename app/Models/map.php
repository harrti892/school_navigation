<?php

// app/Models/Map.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Map extends Model
{
    protected $fillable = ['building', 'floor', 'svg_path'];

    public function getFloorKeyAttribute()
    {
        return $this->building . $this->floor;
    }
}
