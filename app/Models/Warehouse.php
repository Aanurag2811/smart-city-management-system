<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    protected $fillable = [
        'name',
        'location',
        'zone',
        'capacity',
        'current_load',
        'status',
        'manager_name',
        'contact_number',
    ];

    protected $casts = [
        'capacity'     => 'integer',
        'current_load' => 'integer',
    ];

    public function deliveries()
    {
        return $this->hasMany(Delivery::class);
    }

    public function getUsagePercentageAttribute(): float
    {
        if ($this->capacity == 0) return 0;
        return round(($this->current_load / $this->capacity) * 100, 1);
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'operational' => 'green',
            'full'        => 'red',
            'maintenance' => 'yellow',
            default       => 'gray',
        };
    }
}
