<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $fillable = [
        'vehicle_number',
        'type',
        'driver_name',
        'driver_contact',
        'status',
        'fuel_level',
        'capacity_kg',
        'assigned_zone',
    ];

    protected $casts = [
        'fuel_level'   => 'decimal:2',
        'capacity_kg'  => 'integer',
    ];

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'available'   => 'green',
            'in_use'      => 'blue',
            'maintenance' => 'yellow',
            'retired'     => 'red',
            default       => 'gray',
        };
    }
}
