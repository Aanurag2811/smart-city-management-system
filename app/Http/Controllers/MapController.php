<?php

namespace App\Http\Controllers;

use App\Models\Transport;
use App\Models\Route;
use App\Models\Warehouse;
use App\Models\Delivery;
use Illuminate\Http\Request;

class MapController extends Controller
{
    public function index()
    {
        $routes    = Route::all();
        $transports = Transport::all();
        $warehouses = Warehouse::all();
        $deliveries = Delivery::where('status', 'in_transit')->with('warehouse')->get();

        return view('map.index', compact('routes', 'transports', 'warehouses', 'deliveries'));
    }
}
