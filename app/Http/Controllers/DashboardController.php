<?php

namespace App\Http\Controllers;

use App\Models\Transport;
use App\Models\Delivery;
use App\Models\Warehouse;
use App\Models\Resource;
use App\Models\Vehicle;
use App\Models\SmartNotification;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // KPI stats for dashboard
        $stats = [
            'total_routes'       => Transport::count(),
            'congested_routes'   => Transport::where('status', 'congested')->count(),
            'active_deliveries'  => Delivery::where('status', 'in_transit')->count(),
            'pending_deliveries' => Delivery::where('status', 'pending')->count(),
            'total_warehouses'   => Warehouse::count(),
            'full_warehouses'    => Warehouse::where('status', 'full')->count(),
            'critical_resources' => Resource::where('status', 'critical')->count(),
            'warning_resources'  => Resource::where('status', 'warning')->count(),
            'total_vehicles'     => Vehicle::count(),
            'vehicles_in_use'    => Vehicle::where('status', 'in_use')->count(),
            'unread_alerts'      => SmartNotification::where('is_read', false)->count(),
        ];

        $recentAlerts   = SmartNotification::where('is_read', false)
                            ->where('severity', '!=', 'info')
                            ->latest()
                            ->take(5)
                            ->get();

        $recentDeliveries = Delivery::with('warehouse')
                            ->latest()
                            ->take(5)
                            ->get();

        return view('dashboard', compact('stats', 'recentAlerts', 'recentDeliveries'));
    }
}