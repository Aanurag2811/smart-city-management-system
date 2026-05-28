<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Warehouse;
use App\Models\Delivery;
use Carbon\Carbon;

class LogisticsSeeder extends Seeder
{
    public function run(): void
    {
        // Seed Warehouses
        $warehouses = [
            ['name' => 'North Sector Warehouse', 'location' => 'North Industrial Area, Block 4', 'zone' => 'North', 'capacity' => 2000, 'current_load' => 1560, 'status' => 'operational', 'manager_name' => 'Deepak Joshi', 'contact_number' => '9811234567'],
            ['name' => 'South Port Warehouse', 'location' => 'South Docks, Pier 7', 'zone' => 'South', 'capacity' => 1500, 'current_load' => 1500, 'status' => 'full', 'manager_name' => 'Priya Nair', 'contact_number' => '9822345678'],
            ['name' => 'East Distribution Hub', 'location' => 'East Tech Park, Gate 2', 'zone' => 'East', 'capacity' => 3000, 'current_load' => 900, 'status' => 'operational', 'manager_name' => 'Arjun Reddy', 'contact_number' => '9833456789'],
            ['name' => 'Central Logistics Centre', 'location' => 'City Centre, Commerce Hub', 'zone' => 'Central', 'capacity' => 5000, 'current_load' => 2100, 'status' => 'operational', 'manager_name' => 'Sunita Mehta', 'contact_number' => '9844567890'],
            ['name' => 'West Storage Facility', 'location' => 'West Colony, Warehouse Road', 'zone' => 'West', 'capacity' => 1200, 'current_load' => 300, 'status' => 'maintenance', 'manager_name' => 'Kiran Bose', 'contact_number' => '9855678901'],
        ];

        foreach ($warehouses as $warehouse) {
            Warehouse::create($warehouse);
        }

        // Seed Deliveries
        $deliveries = [
            ['delivery_code' => 'DLV-1024', 'source' => 'Central Logistics Centre', 'destination' => 'North Sector Warehouse', 'warehouse_id' => 1, 'driver_name' => 'Ramesh Kumar', 'vehicle_number' => 'SC-TRK-001', 'status' => 'in_transit', 'weight_kg' => 450.0, 'eta' => Carbon::now()->addHours(2), 'notes' => 'Priority shipment'],
            ['delivery_code' => 'DLV-1025', 'source' => 'East Distribution Hub', 'destination' => 'City Centre Branch', 'warehouse_id' => 4, 'driver_name' => 'Anil Sharma', 'vehicle_number' => 'SC-VAN-001', 'status' => 'delivered', 'weight_kg' => 120.0, 'eta' => Carbon::now()->subHours(3), 'delivered_at' => Carbon::now()->subHours(2), 'notes' => null],
            ['delivery_code' => 'DLV-1026', 'source' => 'South Port Warehouse', 'destination' => 'West Colony Depot', 'warehouse_id' => 2, 'driver_name' => 'Suresh Patel', 'vehicle_number' => 'SC-TRK-002', 'status' => 'pending', 'weight_kg' => 800.0, 'eta' => Carbon::now()->addHours(5), 'notes' => 'Awaiting customs clearance'],
            ['delivery_code' => 'DLV-1027', 'source' => 'North Sector Warehouse', 'destination' => 'Airport Cargo Zone', 'warehouse_id' => 1, 'driver_name' => 'Vijay Rao', 'vehicle_number' => 'SC-MTR-001', 'status' => 'in_transit', 'weight_kg' => 30.0, 'eta' => Carbon::now()->addHours(1), 'notes' => 'Express documents delivery'],
            ['delivery_code' => 'DLV-1028', 'source' => 'Central Logistics Centre', 'destination' => 'Tech Park Office', 'warehouse_id' => 4, 'driver_name' => 'Ravi Verma', 'vehicle_number' => 'SC-VAN-002', 'status' => 'failed', 'weight_kg' => 200.0, 'eta' => Carbon::now()->subHours(1), 'notes' => 'Vehicle breakdown. Rescheduled.'],
            ['delivery_code' => 'DLV-1029', 'source' => 'East Distribution Hub', 'destination' => 'South Market Street', 'warehouse_id' => 3, 'driver_name' => 'Mahesh Singh', 'vehicle_number' => 'SC-BUS-001', 'status' => 'pending', 'weight_kg' => 1200.0, 'eta' => Carbon::now()->addHours(8), 'notes' => 'Bulk grocery supply'],
            ['delivery_code' => 'DLV-1030', 'source' => 'North Sector Warehouse', 'destination' => 'University District', 'warehouse_id' => 1, 'driver_name' => 'Ramesh Kumar', 'vehicle_number' => 'SC-TRK-001', 'status' => 'delivered', 'weight_kg' => 350.0, 'eta' => Carbon::now()->subDays(1), 'delivered_at' => Carbon::now()->subDays(1)->addHours(1), 'notes' => 'Lab equipment delivery'],
        ];

        foreach ($deliveries as $delivery) {
            Delivery::create($delivery);
        }
    }
}
