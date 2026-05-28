<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Consumption extends Model
{
    protected $fillable = [
        'resource_id',
        'value',
        'unit',
        'recorded_date',
        'period',
        'notes',
    ];

    protected $casts = [
        'value'         => 'decimal:2',
        'recorded_date' => 'date',
    ];

    public function resource()
    {
        return $this->belongsTo(Resource::class);
    }
}
