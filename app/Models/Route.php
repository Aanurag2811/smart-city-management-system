<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    protected $fillable = [
        'name',
        'from_location',
        'to_location',
        'distance_km',
        'estimated_minutes',
        'type',
        'status',
        'avg_speed_kmh',
        'waypoints',
    ];

    protected $casts = [
        'distance_km'       => 'decimal:2',
        'estimated_minutes' => 'integer',
        'avg_speed_kmh'     => 'integer',
    ];

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'open'                 => 'green',
            'congested'            => 'yellow',
            'closed'               => 'red',
            'under_construction'   => 'orange',
            default                => 'gray',
        };
    }
}
