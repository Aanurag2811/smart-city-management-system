<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-xl text-green-400 leading-tight">🚦 Transport Management</h2>
            <a href="{{ route('transport.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-semibold rounded-lg transition">
                + Add Route
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="bg-green-50 border border-green-300 text-green-800 px-4 py-3 rounded-lg">{{ session('success') }}</div>
            @endif

            {{-- KPI Cards --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-white bg-white rounded-xl shadow-sm p-5 border-l-4 border-green-500">
                    <div class="text-xs font-semibold text-green-600 uppercase">Total Routes</div>
                    <div class="text-3xl font-bold text-gray-900 text-gray-900 mt-2">{{ $totalRoutes }}</div>
                </div>
                <div class="bg-white bg-white rounded-xl shadow-sm p-5 border-l-4 border-red-500">
                    <div class="text-xs font-semibold text-red-500 uppercase">Congested</div>
                    <div class="text-3xl font-bold text-gray-900 text-gray-900 mt-2">{{ $congested }}</div>
                </div>
                <div class="bg-white bg-white rounded-xl shadow-sm p-5 border-l-4 border-green-500">
                    <div class="text-xs font-semibold text-green-500 uppercase">Vehicles Active</div>
                    <div class="text-3xl font-bold text-gray-900 text-gray-900 mt-2">{{ $activeVehicles }}/{{ $totalVehicles }}</div>
                </div>
                <div class="bg-white bg-white rounded-xl shadow-sm p-5 border-l-4 border-purple-500">
                    <div class="text-xs font-semibold text-gray-600 uppercase">City Routes</div>
                    <div class="text-3xl font-bold text-gray-900 text-gray-900 mt-2">{{ $routes->count() }}</div>
                </div>
            </div>

            {{-- Chart --}}
            <div class="bg-white bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 border-gray-100">
                    <h3 class="font-bold text-gray-900 text-gray-900">Live Traffic — Vehicles per Route</h3>
                </div>
                <div class="p-6 h-64">
                    <canvas id="trafficChart"></canvas>
                </div>
            </div>

            {{-- Routes Table --}}
            <div class="bg-white bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 border-gray-100">
                    <h3 class="font-bold text-gray-900 text-gray-900">All Transport Routes</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 divide-gray-100">
                        <thead class="bg-gray-50 bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Route</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">From → To</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Type</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Vehicles</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Traffic</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Peak Hours</th>
                                <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 divide-gray-100">
                            @forelse($transports as $transport)
                            <tr class="hover:bg-gray-50 hover:bg-green-50/50 transition">
                                <td class="px-6 py-4 text-sm font-semibold text-gray-900 text-gray-900">{{ $transport->route_name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500 text-gray-500">{{ $transport->from_location }} → {{ $transport->to_location }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500 text-gray-500 capitalize">{{ $transport->transport_type }}</td>
                                <td class="px-6 py-4 text-sm font-semibold text-gray-900 text-gray-900">{{ $transport->vehicle_count }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 rounded-full text-xs font-semibold
                                        @if($transport->traffic_level === 'low') bg-green-100 text-green-800
                                        @elseif($transport->traffic_level === 'medium') bg-yellow-100 text-yellow-800
                                        @else bg-red-100 text-red-800 @endif">
                                        {{ ucfirst($transport->traffic_level) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 rounded-full text-xs font-semibold
                                        @if($transport->status === 'active') bg-green-100 text-green-800
                                        @elseif($transport->status === 'congested') bg-yellow-100 text-yellow-800
                                        @else bg-red-100 text-red-800 @endif">
                                        {{ ucfirst($transport->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500 text-gray-500">
                                    @if($transport->peak_start) {{ \Str::substr($transport->peak_start, 0, 5) }} – {{ \Str::substr($transport->peak_end, 0, 5) }}
                                    @else — @endif
                                </td>
                                <td class="px-6 py-4 text-right flex items-center justify-end gap-2">
                                    <a href="{{ route('transport.edit', $transport) }}" class="text-xs px-3 py-1.5 bg-green-100 hover:bg-green-200 text-green-800 rounded-lg transition">Edit</a>
                                    <form method="POST" action="{{ route('transport.destroy', $transport) }}" onsubmit="return confirm('Delete this route?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-xs px-3 py-1.5 bg-red-100 hover:bg-red-200 text-red-700 rounded-lg transition">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="8" class="px-6 py-8 text-center text-gray-400">No transport routes found. <a href="{{ route('transport.create') }}" class="text-green-600 underline">Add one</a></td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Vehicles Table --}}
            <div class="bg-white bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 border-gray-100">
                    <h3 class="font-bold text-gray-900 text-gray-900">Fleet Status</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 divide-gray-100">
                        <thead class="bg-gray-50 bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Vehicle No.</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Type</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Driver</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Zone</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Fuel %</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 divide-gray-100">
                            @foreach($vehicles as $vehicle)
                            <tr class="hover:bg-gray-50 hover:bg-green-50/50 transition">
                                <td class="px-6 py-4 text-sm font-semibold text-gray-900 text-gray-900">{{ $vehicle->vehicle_number }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500 text-gray-500 capitalize">{{ $vehicle->type }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500 text-gray-500">{{ $vehicle->driver_name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500 text-gray-500">{{ $vehicle->assigned_zone ?? '—' }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <div class="flex-1 bg-gray-200 rounded-full h-2 w-20">
                                            <div class="h-2 rounded-full {{ $vehicle->fuel_level > 50 ? 'bg-green-500' : ($vehicle->fuel_level > 25 ? 'bg-yellow-500' : 'bg-red-500') }}" style="width: {{ $vehicle->fuel_level }}%"></div>
                                        </div>
                                        <span class="text-xs text-gray-500">{{ $vehicle->fuel_level }}%</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 rounded-full text-xs font-semibold
                                        @if($vehicle->status === 'available') bg-green-100 text-green-800
                                        @elseif($vehicle->status === 'in_use') bg-blue-100 text-blue-800
                                        @elseif($vehicle->status === 'maintenance') bg-yellow-100 text-yellow-800
                                        @else bg-red-100 text-red-800 @endif">
                                        {{ ucfirst(str_replace('_', ' ', $vehicle->status)) }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const isDark = document.documentElement.classList.contains('dark') || window.matchMedia('(prefers-color-scheme: dark)').matches;
            const textColor = isDark ? '#9ca3af' : '#4b5563';
            const gridColor = isDark ? '#374151' : '#e5e7eb';
            new Chart(document.getElementById('trafficChart'), {
                type: 'bar',
                data: {
                    labels: {!! json_encode($chartLabels) !!},
                    datasets: [{
                        label: 'Vehicles per Route',
                        data: {!! json_encode($chartData) !!},
                        backgroundColor: {!! json_encode($chartData) !!}.map(v => v > 300 ? 'rgba(239,68,68,0.75)' : v > 150 ? 'rgba(234,179,8,0.75)' : 'rgba(34,197,94,0.75)'),
                        borderRadius: 6
                    }]
                },
                options: {
                    responsive: true, maintainAspectRatio: false,
                    plugins: { legend: { labels: { color: textColor } } },
                    scales: {
                        x: { grid: { color: gridColor }, ticks: { color: textColor } },
                        y: { grid: { color: gridColor }, ticks: { color: textColor } }
                    }
                }
            });
        });
    </script>
</x-app-layout>
