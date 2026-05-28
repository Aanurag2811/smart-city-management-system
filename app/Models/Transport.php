<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transport extends Model
{
    protected $fillable = [
        'route_name',
        'from_location',
        'to_location',
        'traffic_level',
        'status',
        'transport_type',
        'vehicle_count',
        'peak_start',
        'peak_end',
        'notes',
    ];

    protected $casts = [
        'vehicle_count' => 'integer',
    ];

    public function getTrafficBadgeColorAttribute(): string
    {
        return match ($this->traffic_level) {
            'low'    => 'green',
            'medium' => 'yellow',
            'high'   => 'red',
            default  => 'gray',
        };
    }

    public function getStatusBadgeColorAttribute(): string
    {
        return match ($this->status) {
            'active'    => 'green',
            'congested' => 'yellow',
            'closed'    => 'red',
            default     => 'gray',
        };
    }
}
