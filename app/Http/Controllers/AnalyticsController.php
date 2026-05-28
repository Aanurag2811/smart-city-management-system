<?php

namespace App\Http\Controllers;

use App\Models\Transport;
use App\Models\Delivery;
use App\Models\Warehouse;
use App\Models\Resource;
use App\Models\Vehicle;
use App\Models\Consumption;
use App\Models\SmartNotification;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Services\ConsumptionService;

class AnalyticsController extends Controller
{
    public function index()
    {
        // Transport analytics
        $transportByLevel = [
            'low'    => Transport::where('traffic_level', 'low')->count(),
            'medium' => Transport::where('traffic_level', 'medium')->count(),
            'high'   => Transport::where('traffic_level', 'high')->count(),
        ];

        // Delivery analytics
        $deliveryStats = [
            'pending'    => Delivery::where('status', 'pending')->count(),
            'in_transit' => Delivery::where('status', 'in_transit')->count(),
            'delivered'  => Delivery::where('status', 'delivered')->count(),
            'failed'     => Delivery::where('status', 'failed')->count(),
        ];

        // Resource analytics
        $resourceAlerts = Resource::where('status', '!=', 'normal')->get();
        $resourceStats  = [
            'normal'   => Resource::where('status', 'normal')->count(),
            'warning'  => Resource::where('status', 'warning')->count(),
            'critical' => Resource::where('status', 'critical')->count(),
        ];

        // Vehicle fleet analytics
        $vehicleStats = [
            'available'   => Vehicle::where('status', 'available')->count(),
            'in_use'      => Vehicle::where('status', 'in_use')->count(),
            'maintenance' => Vehicle::where('status', 'maintenance')->count(),
        ];

        // Notification trend
        $notificationsByType = [
            'traffic'  => SmartNotification::where('type', 'traffic')->count(),
            'resource' => SmartNotification::where('type', 'resource')->count(),
            'delivery' => SmartNotification::where('type', 'delivery')->count(),
            'system'   => SmartNotification::where('type', 'system')->count(),
        ];

        // Warehouse capacity overview
        $warehouses = Warehouse::all()->map(fn($w) => [
            'name'  => $w->name,
            'usage' => $w->usage_percentage,
        ]);

        $consumptionService = new ConsumptionService();
        $latest = Consumption::max('recorded_date');
        $endDate = $latest ? Carbon::parse($latest) : now();

        $sums = $consumptionService->getDailySumsByTypes(['water','electricity','waste'], $endDate, 7);
        $chartLabels = collect($sums['dates'])->map(fn($d) => date('D, d M', strtotime($d)))->toArray();

        $waterTrend = $sums['water'];
        $elecTrend = $sums['electricity'];
        $wasteTrend = $sums['waste'];

        return view('analytics.index', compact(
            'transportByLevel', 'deliveryStats', 'resourceStats', 'vehicleStats',
            'notificationsByType', 'warehouses', 'resourceAlerts',
            'chartLabels', 'waterTrend', 'elecTrend', 'wasteTrend'
        ));
    }
    public function exportCsv()
    {
        $filename = "smart_city_analytics_" . date('Ymd') . ".csv";

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['Metric Category', 'Metric Name', 'Value'];

        $callback = function() {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Smart City Analytics Report']);
            fputcsv($file, ['Generated at: ' . now()->toDateTimeString()]);
            fputcsv($file, []); // blank line
            fputcsv($file, ['Metric Category', 'Metric Name', 'Value']);

            // Transport analytics
            fputcsv($file, ['Transport', 'Low Traffic Routes', Transport::where('traffic_level', 'low')->count()]);
            fputcsv($file, ['Transport', 'Medium Traffic Routes', Transport::where('traffic_level', 'medium')->count()]);
            fputcsv($file, ['Transport', 'High Traffic Routes', Transport::where('traffic_level', 'high')->count()]);

            // Delivery analytics
            fputcsv($file, ['Delivery', 'Pending Deliveries', Delivery::where('status', 'pending')->count()]);
            fputcsv($file, ['Delivery', 'In Transit Deliveries', Delivery::where('status', 'in_transit')->count()]);
            fputcsv($file, ['Delivery', 'Delivered', Delivery::where('status', 'delivered')->count()]);
            fputcsv($file, ['Delivery', 'Failed Deliveries', Delivery::where('status', 'failed')->count()]);

            // Resource analytics
            fputcsv($file, ['Resource', 'Normal Resources', Resource::where('status', 'normal')->count()]);
            fputcsv($file, ['Resource', 'Warning Resources', Resource::where('status', 'warning')->count()]);
            fputcsv($file, ['Resource', 'Critical Resources', Resource::where('status', 'critical')->count()]);

            // Vehicle fleet
            fputcsv($file, ['Fleet', 'Available Vehicles', Vehicle::where('status', 'available')->count()]);
            fputcsv($file, ['Fleet', 'In Use Vehicles', Vehicle::where('status', 'in_use')->count()]);
            fputcsv($file, ['Fleet', 'Maintenance Vehicles', Vehicle::where('status', 'maintenance')->count()]);

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
