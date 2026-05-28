<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Transport;
use App\Models\Vehicle;
use App\Models\Route;

class TransportSeeder extends Seeder
{
    public function run(): void
    {
        // Seed Transport Routes (traffic monitoring)
        $transports = [
            ['route_name' => 'Downtown Corridor', 'from_location' => 'Central Station', 'to_location' => 'City Hall', 'traffic_level' => 'high', 'status' => 'congested', 'transport_type' => 'road', 'vehicle_count' => 320, 'peak_start' => '08:00:00', 'peak_end' => '10:00:00', 'notes' => 'Heavy congestion during morning rush.'],
            ['route_name' => 'Highway 5 Express', 'from_location' => 'North Gate', 'to_location' => 'Industrial Zone', 'traffic_level' => 'medium', 'status' => 'active', 'transport_type' => 'road', 'vehicle_count' => 180, 'peak_start' => '17:00:00', 'peak_end' => '19:00:00', 'notes' => 'Expected congestion in evening.'],
            ['route_name' => 'Metro Line A', 'from_location' => 'Airport Terminal', 'to_location' => 'South Market', 'traffic_level' => 'low', 'status' => 'active', 'transport_type' => 'rail', 'vehicle_count' => 12, 'peak_start' => '07:00:00', 'peak_end' => '09:00:00', 'notes' => 'Running on schedule.'],
            ['route_name' => 'Ring Road East', 'from_location' => 'East Bridge', 'to_location' => 'Tech Park', 'traffic_level' => 'medium', 'status' => 'active', 'transport_type' => 'road', 'vehicle_count' => 220, 'peak_start' => '08:30:00', 'peak_end' => '10:30:00', 'notes' => 'Under minor maintenance near junction 4.'],
            ['route_name' => 'Bus Route 101', 'from_location' => 'West Colony', 'to_location' => 'University District', 'traffic_level' => 'low', 'status' => 'active', 'transport_type' => 'bus', 'vehicle_count' => 8, 'peak_start' => '06:30:00', 'peak_end' => '08:30:00', 'notes' => 'Regular schedule maintained.'],
            ['route_name' => 'Harbour Link Road', 'from_location' => 'Harbour Gate', 'to_location' => 'Commerce Hub', 'traffic_level' => 'high', 'status' => 'congested', 'transport_type' => 'road', 'vehicle_count' => 410, 'peak_start' => '09:00:00', 'peak_end' => '11:00:00', 'notes' => 'Accident reported. Diversion in effect.'],
        ];

        foreach ($transports as $transport) {
            Transport::create($transport);
        }

        // Seed Vehicles
        $vehicles = [
            ['vehicle_number' => 'SC-TRK-001', 'type' => 'truck', 'driver_name' => 'Ramesh Kumar', 'driver_contact' => '9876543210', 'status' => 'in_use', 'fuel_level' => 75.5, 'capacity_kg' => 5000, 'assigned_zone' => 'North'],
            ['vehicle_number' => 'SC-TRK-002', 'type' => 'truck', 'driver_name' => 'Suresh Patel', 'driver_contact' => '9876543211', 'status' => 'available', 'fuel_level' => 90.0, 'capacity_kg' => 5000, 'assigned_zone' => 'South'],
            ['vehicle_number' => 'SC-VAN-001', 'type' => 'van', 'driver_name' => 'Anil Sharma', 'driver_contact' => '9876543212', 'status' => 'in_use', 'fuel_level' => 60.0, 'capacity_kg' => 1000, 'assigned_zone' => 'East'],
            ['vehicle_number' => 'SC-VAN-002', 'type' => 'van', 'driver_name' => 'Ravi Verma', 'driver_contact' => '9876543213', 'status' => 'maintenance', 'fuel_level' => 45.0, 'capacity_kg' => 1000, 'assigned_zone' => 'West'],
            ['vehicle_number' => 'SC-BUS-001', 'type' => 'bus', 'driver_name' => 'Mahesh Singh', 'driver_contact' => '9876543214', 'status' => 'in_use', 'fuel_level' => 80.0, 'capacity_kg' => 8000, 'assigned_zone' => 'Central'],
            ['vehicle_number' => 'SC-MTR-001', 'type' => 'motorcycle', 'driver_name' => 'Vijay Rao', 'driver_contact' => '9876543215', 'status' => 'available', 'fuel_level' => 95.0, 'capacity_kg' => 50, 'assigned_zone' => 'North'],
        ];

        foreach ($vehicles as $vehicle) {
            Vehicle::create($vehicle);
        }

        // Seed Routes
        $routes = [
            ['name' => 'City Centre Loop', 'from_location' => 'Central Station', 'to_location' => 'City Hall', 'distance_km' => 8.5, 'estimated_minutes' => 20, 'type' => 'city', 'status' => 'congested', 'avg_speed_kmh' => 25, 'waypoints' => 'Market Square, Old Fort, Town Park'],
            ['name' => 'North-South Expressway', 'from_location' => 'North Gate', 'to_location' => 'South Docks', 'distance_km' => 24.3, 'estimated_minutes' => 30, 'type' => 'expressway', 'status' => 'open', 'avg_speed_kmh' => 80, 'waypoints' => 'Midway Junction, Toll Plaza 2'],
            ['name' => 'Industrial Ring Road', 'from_location' => 'West Colony', 'to_location' => 'Industrial Zone', 'distance_km' => 15.0, 'estimated_minutes' => 25, 'type' => 'ring_road', 'status' => 'open', 'avg_speed_kmh' => 60, 'waypoints' => 'Factory Gate A, Warehouse District'],
            ['name' => 'Airport Highway', 'from_location' => 'City Hub', 'to_location' => 'Airport Terminal', 'distance_km' => 35.0, 'estimated_minutes' => 40, 'type' => 'highway', 'status' => 'open', 'avg_speed_kmh' => 90, 'waypoints' => 'Flyover Bridge, Cargo Gate'],
        ];

        foreach ($routes as $route) {
            Route::create($route);
        }
    }
}
