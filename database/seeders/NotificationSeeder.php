<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SmartNotification;

class NotificationSeeder extends Seeder
{
    public function run(): void
    {
        $notifications = [
            ['title' => 'High Traffic Alert', 'message' => 'Severe congestion on Downtown Corridor. Estimated delay: 45 minutes. Consider alternate routes via Ring Road East.', 'type' => 'traffic', 'severity' => 'critical', 'module' => 'transport', 'is_read' => false],
            ['title' => 'Harbour Link Road — Accident', 'message' => 'An accident has been reported on Harbour Link Road near Commerce Hub. Diversion in effect. Avoid the area during peak hours.', 'type' => 'traffic', 'severity' => 'critical', 'module' => 'transport', 'is_read' => false],
            ['title' => 'Water Overuse — Sector 4', 'message' => 'Water consumption in Sector 4 (South Industrial Zone) has exceeded the alert threshold of 60,000 L. Possible leak detected. Investigation initiated.', 'type' => 'resource', 'severity' => 'critical', 'module' => 'resources', 'is_read' => false],
            ['title' => 'Electricity Warning — Tech Park', 'message' => 'Electricity usage at Tech Park (Sector 3) is approaching 98% of alert threshold. Grid load balancing recommended.', 'type' => 'resource', 'severity' => 'warning', 'module' => 'resources', 'is_read' => false],
            ['title' => 'Delivery Failed — DLV-1028', 'message' => 'Delivery DLV-1028 from Central Logistics Centre to Tech Park has failed due to vehicle breakdown. Rescheduling required.', 'type' => 'delivery', 'severity' => 'warning', 'module' => 'logistics', 'is_read' => true],
            ['title' => 'South Port Warehouse Full', 'message' => 'South Port Warehouse has reached 100% capacity. No further deliveries can be accepted until unloading is complete.', 'type' => 'resource', 'severity' => 'critical', 'module' => 'logistics', 'is_read' => false],
            ['title' => 'Metro Line A — On Schedule', 'message' => 'Metro Line A is running on schedule. All 12 trains are operational. Average delay: 0 minutes.', 'type' => 'traffic', 'severity' => 'info', 'module' => 'transport', 'is_read' => true],
            ['title' => 'Waste Collection Overload — Sector 5', 'message' => 'Waste in Market District (Sector 5) has exceeded collection capacity. An extra pickup has been scheduled for tomorrow morning.', 'type' => 'resource', 'severity' => 'warning', 'module' => 'resources', 'is_read' => false],
            ['title' => 'System Maintenance Scheduled', 'message' => 'Scheduled system maintenance will occur tonight from 02:00–04:00 AM. Some features may be temporarily unavailable.', 'type' => 'system', 'severity' => 'info', 'module' => null, 'is_read' => true],
            ['title' => 'DLV-1024 Dispatched', 'message' => 'Delivery DLV-1024 from Central Logistics Centre to North Sector Warehouse has been dispatched. ETA: 2 hours.', 'type' => 'delivery', 'severity' => 'info', 'module' => 'logistics', 'is_read' => true],
        ];

        foreach ($notifications as $notification) {
            SmartNotification::create($notification);
        }
    }
}
