<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Transport;
use App\Models\Delivery;
use App\Models\Warehouse;
use App\Models\Resource;
use App\Models\Vehicle;
use App\Models\SmartNotification;

/*
|--------------------------------------------------------------------------
| Smart City API Routes
|--------------------------------------------------------------------------
| All routes require authentication. These are used by AJAX polling
| on the frontend for real-time UI updates.
|
*/

Route::middleware('auth')->group(function () {

    // Live dashboard KPIs
    Route::get('/stats', function () {
        return response()->json([
            'total_routes'       => Transport::count(),
            'congested_routes'   => Transport::where('status', 'congested')->count(),
            'active_deliveries'  => Delivery::where('status', 'in_transit')->count(),
            'pending_deliveries' => Delivery::where('status', 'pending')->count(),
            'vehicles_in_use'    => Vehicle::where('status', 'in_use')->count(),
            'total_vehicles'     => Vehicle::count(),
            'critical_resources' => Resource::where('status', 'critical')->count(),
            'warning_resources'  => Resource::where('status', 'warning')->count(),
            'unread_alerts'      => SmartNotification::where('is_read', false)->count(),
        ]);
    });

    // Live notification count + latest alerts
    Route::get('/notifications/live', function () {
        $unread = SmartNotification::where('is_read', false)->count();
        $latest = SmartNotification::where('is_read', false)
            ->where('severity', '!=', 'info')
            ->latest()
            ->take(3)
            ->get(['id', 'title', 'message', 'severity', 'type', 'created_at']);

        return response()->json([
            'unread_count' => $unread,
            'alerts'       => $latest,
        ]);
    });

    // Live transport traffic data
    Route::get('/transport/live', function () {
        $transports = Transport::select('route_name', 'vehicle_count', 'traffic_level', 'status')
            ->orderByDesc('vehicle_count')
            ->get();

        return response()->json([
            'transports'      => $transports,
            'congested_count' => $transports->where('status', 'congested')->count(),
        ]);
    });

    // Live warehouse capacity
    Route::get('/warehouses/capacity', function () {
        $warehouses = Warehouse::all()->map(fn($w) => [
            'id'             => $w->id,
            'name'           => $w->name,
            'usage_percent'  => $w->usage_percentage,
            'status'         => $w->status,
            'current_load'   => $w->current_load,
            'capacity'       => $w->capacity,
        ]);

        return response()->json(['warehouses' => $warehouses]);
    });

    // Live resource status
    Route::get('/resources/status', function () {
        $resources = Resource::select('id', 'type', 'sector', 'current_usage', 'unit', 'status')
            ->orderBy('status')
            ->get();

        return response()->json([
            'resources'       => $resources,
            'critical_count'  => $resources->where('status', 'critical')->count(),
            'warning_count'   => $resources->where('status', 'warning')->count(),
        ]);
    });

    // Live delivery feed
    Route::get('/deliveries/feed', function () {
        $deliveries = Delivery::with('warehouse')
            ->latest()
            ->take(10)
            ->get(['id', 'delivery_code', 'destination', 'status', 'driver_name', 'eta', 'warehouse_id']);

        return response()->json(['deliveries' => $deliveries]);
    });
});
