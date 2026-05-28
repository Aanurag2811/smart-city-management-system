<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use App\Models\Consumption;
use Carbon\Carbon;
use App\Services\ConsumptionService;
use Illuminate\Http\Request;

class ResourceController extends Controller
{
    public function index()
    {
        $resources  = Resource::with('consumptions')->get();
        $critical   = Resource::where('status', 'critical')->count();
        $warnings   = Resource::where('status', 'warning')->count();
        $normal     = Resource::where('status', 'normal')->count();

        // Separate by type for summary cards
        $waterResources       = Resource::where('type', 'water')->get();
        $electricityResources = Resource::where('type', 'electricity')->get();
        $wasteResources       = Resource::where('type', 'waste')->get();

        // Chart data — last 7 days aggregated consumption.
        $consumptionService = new ConsumptionService();
        $latest = Consumption::max('recorded_date');
        $endDate = $latest ? Carbon::parse($latest) : now();

        $sums = $consumptionService->getDailySumsByTypes(['water','electricity','waste'], $endDate, 7);

        $chartLabels     = collect($sums['dates'])->map(fn($d) => date('D', strtotime($d)))->toArray();
        $waterData       = $sums['water'];
        $electricityData = $sums['electricity'];
        $wasteData       = $sums['waste'];

        return view('resources.index', compact(
            'resources', 'critical', 'warnings', 'normal',
            'waterResources', 'electricityResources', 'wasteResources',
            'chartLabels', 'waterData', 'electricityData', 'wasteData'
        ));
    }

    private function getChartData(string $type, $dates): array
    {
        // kept for backward compatibility but now delegates to service
        $service = new ConsumptionService();
        $end = Carbon::parse($dates->last());
        $res = $service->getDailySumsByTypes([$type], $end, count($dates));
        return $res[$type] ?? [];
    }

    public function create()
    {
        return view('resources.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'type'            => 'required|in:water,electricity,waste',
            'sector'          => 'required|string|max:100',
            'location'        => 'required|string|max:255',
            'current_usage'   => 'required|numeric|min:0',
            'unit'            => 'required|string|max:50',
            'alert_threshold' => 'nullable|numeric|min:0',
            'status'          => 'required|in:normal,warning,critical',
            'description'     => 'nullable|string',
        ]);

        $resource = Resource::create($request->all());

        // Log initial consumption
        Consumption::create([
            'resource_id'   => $resource->id,
            'value'         => $request->current_usage,
            'unit'          => $request->unit,
            'recorded_date' => today()->toDateString(),
            'period'        => 'daily',
        ]);

        return redirect()->route('resources.index')
            ->with('success', 'Resource added successfully.');
    }

    public function edit(Resource $resource)
    {
        return view('resources.edit', compact('resource'));
    }

    public function update(Request $request, Resource $resource)
    {
        $request->validate([
            'type'            => 'required|in:water,electricity,waste',
            'sector'          => 'required|string|max:100',
            'location'        => 'required|string|max:255',
            'current_usage'   => 'required|numeric|min:0',
            'unit'            => 'required|string|max:50',
            'alert_threshold' => 'nullable|numeric|min:0',
            'status'          => 'required|in:normal,warning,critical',
            'description'     => 'nullable|string',
        ]);

        $resource->update($request->all());

        return redirect()->route('resources.index')
            ->with('success', 'Resource updated successfully.');
    }

    public function destroy(Resource $resource)
    {
        $resource->delete();

        return redirect()->route('resources.index')
            ->with('success', 'Resource removed successfully.');
    }
}
