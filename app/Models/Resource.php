<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    protected $fillable = [
        'type',
        'sector',
        'location',
        'current_usage',
        'unit',
        'alert_threshold',
        'status',
        'description',
    ];

    protected $casts = [
        'current_usage'   => 'decimal:2',
        'alert_threshold' => 'decimal:2',
    ];

    public function consumptions()
    {
        return $this->hasMany(Consumption::class);
    }

    public function getTypeColorAttribute(): string
    {
        return match ($this->type) {
            'water'       => 'blue',
            'electricity' => 'yellow',
            'waste'       => 'green',
            default       => 'gray',
        };
    }

    public function getTypeIconAttribute(): string
    {
        return match ($this->type) {
            'water'       => '💧',
            'electricity' => '⚡',
            'waste'       => '🗑️',
            default       => '📦',
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'normal'   => 'green',
            'warning'  => 'yellow',
            'critical' => 'red',
            default    => 'gray',
        };
    }
}
