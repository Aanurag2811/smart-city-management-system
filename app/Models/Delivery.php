<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    protected $fillable = [
        'delivery_code',
        'source',
        'destination',
        'warehouse_id',
        'driver_name',
        'vehicle_number',
        'status',
        'weight_kg',
        'eta',
        'delivered_at',
        'notes',
    ];

    protected $casts = [
        'eta'          => 'datetime',
        'delivered_at' => 'datetime',
        'weight_kg'    => 'decimal:2',
    ];

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'pending'    => 'yellow',
            'in_transit' => 'blue',
            'delivered'  => 'green',
            'failed'     => 'red',
            default      => 'gray',
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending'    => 'Pending',
            'in_transit' => 'In Transit',
            'delivered'  => 'Delivered',
            'failed'     => 'Failed',
            default      => ucfirst($this->status),
        };
    }
}
