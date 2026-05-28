<?php

namespace App\Http\Controllers;

use App\Models\Delivery;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;

class LogisticsController extends Controller
{
    public function index()
    {
        $deliveries         = Delivery::with('warehouse')->latest()->get();
        $warehouses         = Warehouse::all();
        $activeDeliveries   = Delivery::where('status', 'in_transit')->count();
        $pendingDeliveries  = Delivery::where('status', 'pending')->count();
        $deliveredToday     = Delivery::where('status', 'delivered')
                                ->whereDate('delivered_at', today())->count();
        $totalWarehouses    = $warehouses->count();

        // Chart data — warehouse usage
        $warehouseLabels    = $warehouses->pluck('name')->map(fn($n) => Str::limit($n, 20))->toArray();
        $warehouseUsage     = $warehouses->map(fn($w) => $w->usage_percentage)->toArray();
        $warehouseCapacity  = $warehouses->pluck('capacity')->toArray();
        $warehouseLoad      = $warehouses->pluck('current_load')->toArray();

        return view('logistics.index', compact(
            'deliveries', 'warehouses',
            'activeDeliveries', 'pendingDeliveries', 'deliveredToday', 'totalWarehouses',
            'warehouseLabels', 'warehouseUsage', 'warehouseCapacity', 'warehouseLoad'
        ));
    }

    public function create()
    {
        $warehouses = Warehouse::where('status', '!=', 'full')->get();
        return view('logistics.create', compact('warehouses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'source'         => 'required|string|max:255',
            'destination'    => 'required|string|max:255',
            'warehouse_id'   => 'nullable|exists:warehouses,id',
            'driver_name'    => 'required|string|max:255',
            'vehicle_number' => 'nullable|string|max:50',
            'status'         => 'required|in:pending,in_transit,delivered,failed',
            'weight_kg'      => 'nullable|numeric|min:0',
            'eta'            => 'nullable|date',
            'notes'          => 'nullable|string',
        ]);

        $data = $request->all();
        $data['delivery_code'] = 'DLV-' . rand(1000, 9999);

        Delivery::create($data);

        return redirect()->route('logistics.index')
            ->with('success', 'Delivery created successfully.');
    }

    public function edit(Delivery $delivery)
    {
        $warehouses = Warehouse::all();
        return view('logistics.edit', compact('delivery', 'warehouses'));
    }

    public function update(Request $request, Delivery $delivery)
    {
        $request->validate([
            'source'         => 'required|string|max:255',
            'destination'    => 'required|string|max:255',
            'warehouse_id'   => 'nullable|exists:warehouses,id',
            'driver_name'    => 'required|string|max:255',
            'vehicle_number' => 'nullable|string|max:50',
            'status'         => 'required|in:pending,in_transit,delivered,failed',
            'weight_kg'      => 'nullable|numeric|min:0',
            'eta'            => 'nullable|date',
            'notes'          => 'nullable|string',
        ]);

        $data = $request->all();
        if ($request->status === 'delivered' && !$delivery->delivered_at) {
            $data['delivered_at'] = Carbon::now();
        }

        $delivery->update($data);

        return redirect()->route('logistics.index')
            ->with('success', 'Delivery updated successfully.');
    }

    public function destroy(Delivery $delivery)
    {
        $delivery->delete();

        return redirect()->route('logistics.index')
            ->with('success', 'Delivery removed successfully.');
    }

    public function warehouses()
    {
        $warehouses = Warehouse::withCount('deliveries')->get();
        return view('logistics.warehouses', compact('warehouses'));
    }

    public function createWarehouse()
    {
        return view('logistics.create-warehouse');
    }

    public function storeWarehouse(Request $request)
    {
        $request->validate([
            'name'           => 'required|string|max:255',
            'location'       => 'required|string|max:255',
            'zone'           => 'nullable|string|max:50',
            'capacity'       => 'required|integer|min:1',
            'current_load'   => 'required|integer|min:0',
            'status'         => 'required|in:operational,full,maintenance',
            'manager_name'   => 'nullable|string|max:255',
            'contact_number' => 'nullable|string|max:20',
        ]);

        Warehouse::create($request->all());

        return redirect()->route('logistics.warehouses')
            ->with('success', 'Warehouse added successfully.');
    }
}
