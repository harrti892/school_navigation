<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WifiSignal extends Model
{
    protected $fillable = ['location_id', 'ssid', 'bssid', 'rssi'];

    public function location()
    {
        return $this->belongsTo(Location::class);
    }
}
