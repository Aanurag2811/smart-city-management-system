<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SmartNotification extends Model
{
    protected $table = 'smart_notifications';

    protected $fillable = [
        'title',
        'message',
        'type',
        'severity',
        'module',
        'user_id',
        'is_read',
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getSeverityColorAttribute(): string
    {
        return match ($this->severity) {
            'info'     => 'blue',
            'warning'  => 'yellow',
            'critical' => 'red',
            default    => 'gray',
        };
    }

    public function getSeverityIconAttribute(): string
    {
        return match ($this->severity) {
            'info'     => 'ℹ️',
            'warning'  => '⚠️',
            'critical' => '🚨',
            default    => '🔔',
        };
    }
}
