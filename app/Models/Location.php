<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = ['name', 'type', 'lat', 'lng', 'floor'];

    public function wifiSignals()
    {
        return $this->hasMany(WifiSignal::class);
    }
}

