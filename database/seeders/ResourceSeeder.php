<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Resource;
use App\Models\Consumption;
use Carbon\Carbon;

class ResourceSeeder extends Seeder
{
    public function run(): void
    {
        // Seed Resources
        $resources = [
            ['type' => 'water', 'sector' => 'Sector 1', 'location' => 'North Residential Zone', 'current_usage' => 45200, 'unit' => 'Litres', 'alert_threshold' => 50000, 'status' => 'normal', 'description' => 'Primary water supply for North residential area.'],
            ['type' => 'water', 'sector' => 'Sector 4', 'location' => 'South Industrial Zone', 'current_usage' => 78000, 'unit' => 'Litres', 'alert_threshold' => 60000, 'status' => 'critical', 'description' => 'High water consumption detected. Possible leak or unmetered usage.'],
            ['type' => 'electricity', 'sector' => 'Sector 2', 'location' => 'City Centre', 'current_usage' => 2400, 'unit' => 'kWh', 'alert_threshold' => 3000, 'status' => 'normal', 'description' => 'Commercial district power distribution.'],
            ['type' => 'electricity', 'sector' => 'Sector 3', 'location' => 'Tech Park', 'current_usage' => 2950, 'unit' => 'kWh', 'alert_threshold' => 3000, 'status' => 'warning', 'description' => 'Approaching peak consumption. Grid load balancing required.'],
            ['type' => 'waste', 'sector' => 'Sector 1', 'location' => 'North Residential Zone', 'current_usage' => 12.5, 'unit' => 'Tons', 'alert_threshold' => 20, 'status' => 'normal', 'description' => 'Daily waste collection on schedule.'],
            ['type' => 'waste', 'sector' => 'Sector 5', 'location' => 'Market District', 'current_usage' => 18.8, 'unit' => 'Tons', 'alert_threshold' => 15, 'status' => 'warning', 'description' => 'Waste exceeding collection capacity. Extra pickup needed.'],
        ];

        foreach ($resources as $resource) {
            $res = Resource::create($resource);

            // Create 7 days of consumption data
            for ($i = 6; $i >= 0; $i--) {
                $baseValue = $resource['current_usage'];
                $variation = $baseValue * (rand(-8, 8) / 100);

                Consumption::create([
                    'resource_id'   => $res->id,
                    'value'         => round($baseValue + $variation, 2),
                    'unit'          => $resource['unit'],
                    'recorded_date' => Carbon::now()->subDays($i)->toDateString(),
                    'period'        => 'daily',
                    'notes'         => null,
                ]);
            }
        }
    }
}
