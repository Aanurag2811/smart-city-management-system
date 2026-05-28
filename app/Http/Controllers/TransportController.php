<?php

namespace App\Http\Controllers;

use App\Models\Transport;
use App\Models\Vehicle;
use App\Models\Route;
use Illuminate\Http\Request;

class TransportController extends Controller
{
    public function index()
    {
        $transports   = Transport::latest()->get();
        $vehicles     = Vehicle::all();
        $routes       = Route::all();
        $congested    = Transport::where('status', 'congested')->count();
        $totalRoutes  = $transports->count();
        $activeVehicles = Vehicle::where('status', 'in_use')->count();
        $totalVehicles  = $vehicles->count();

        // Chart data — vehicle count per transport route (latest 7)
        $chartLabels  = $transports->take(7)->pluck('route_name')->toArray();
        $chartData    = $transports->take(7)->pluck('vehicle_count')->toArray();

        return view('transport.index', compact(
            'transports', 'vehicles', 'routes',
            'congested', 'totalRoutes', 'activeVehicles', 'totalVehicles',
            'chartLabels', 'chartData'
        ));
    }

    public function create()
    {
        return view('transport.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'route_name'     => 'required|string|max:255',
            'from_location'  => 'required|string|max:255',
            'to_location'    => 'required|string|max:255',
            'traffic_level'  => 'required|in:low,medium,high',
            'status'         => 'required|in:active,congested,closed',
            'transport_type' => 'required|string',
            'vehicle_count'  => 'required|integer|min:0',
            'peak_start'     => 'nullable|date_format:H:i',
            'peak_end'       => 'nullable|date_format:H:i',
            'notes'          => 'nullable|string',
        ]);

        Transport::create($request->all());

        return redirect()->route('transport.index')
            ->with('success', 'Transport route added successfully.');
    }

    public function edit(Transport $transport)
    {
        return view('transport.edit', compact('transport'));
    }

    public function update(Request $request, Transport $transport)
    {
        $request->validate([
            'route_name'     => 'required|string|max:255',
            'from_location'  => 'required|string|max:255',
            'to_location'    => 'required|string|max:255',
            'traffic_level'  => 'required|in:low,medium,high',
            'status'         => 'required|in:active,congested,closed',
            'transport_type' => 'required|string',
            'vehicle_count'  => 'required|integer|min:0',
            'peak_start'     => 'nullable|date_format:H:i',
            'peak_end'       => 'nullable|date_format:H:i',
            'notes'          => 'nullable|string',
        ]);

        $transport->update($request->all());

        return redirect()->route('transport.index')
            ->with('success', 'Transport route updated successfully.');
    }

    public function destroy(Transport $transport)
    {
        $transport->delete();

        return redirect()->route('transport.index')
            ->with('success', 'Transport route deleted successfully.');
    }
}
