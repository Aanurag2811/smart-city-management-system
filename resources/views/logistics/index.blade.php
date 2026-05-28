<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-green-400">🚚 Logistics & Delivery Management</h2>
            <div class="flex gap-2">
                <a href="{{ route('logistics.warehouses') }}" class="inline-flex items-center gap-2 px-4 py-2 border border-gray-600 hover:border-green-500 text-gray-400 hover:text-green-400 text-sm font-semibold rounded-lg transition">🏬 Warehouses</a>
                <a href="{{ route('logistics.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-semibold rounded-lg transition">+ Add Delivery</a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="bg-green-50 border border-green-300 text-green-800 px-4 py-3 rounded-lg">{{ session('success') }}</div>
            @endif

            {{-- KPI Cards --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-blue-500">
                    <div class="text-xs font-semibold text-blue-500 uppercase">In Transit</div>
                    <div class="text-3xl font-bold text-gray-900 mt-2">{{ $activeDeliveries }}</div>
                </div>
                <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-yellow-500">
                    <div class="text-xs font-semibold text-yellow-500 uppercase">Pending</div>
                    <div class="text-3xl font-bold text-gray-900 mt-2">{{ $pendingDeliveries }}</div>
                </div>
                <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-green-500">
                    <div class="text-xs font-semibold text-green-500 uppercase">Delivered Today</div>
                    <div class="text-3xl font-bold text-gray-900 mt-2">{{ $deliveredToday }}</div>
                </div>
                <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-purple-500">
                    <div class="text-xs font-semibold text-purple-500 uppercase">Warehouses</div>
                    <div class="text-3xl font-bold text-gray-900 mt-2">{{ $totalWarehouses }}</div>
                </div>
            </div>

            {{-- Warehouse Capacity Chart --}}
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h3 class="font-bold text-gray-900">Warehouse Capacity Utilization</h3>
                </div>
                <div class="p-6 h-64">
                    <canvas id="warehouseChart"></canvas>
                </div>
            </div>

            {{-- Deliveries Table --}}
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h3 class="font-bold text-gray-900">All Deliveries</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-100">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Code</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Source → Destination</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Driver</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Vehicle</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Weight</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">ETA</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Status</th>
                                <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($deliveries as $delivery)
                            <tr class="hover:bg-green-50/40 transition">
                                <td class="px-6 py-4 text-sm font-semibold text-gray-900">#{{ $delivery->delivery_code }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $delivery->source }} → {{ $delivery->destination }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $delivery->driver_name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $delivery->vehicle_number ?? '—' }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $delivery->weight_kg ? $delivery->weight_kg . ' kg' : '—' }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $delivery->eta ? $delivery->eta->format('d M, H:i') : '—' }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 rounded-full text-xs font-semibold
                                        @if($delivery->status === 'delivered') bg-green-100 text-green-800
                                        @elseif($delivery->status === 'in_transit') bg-blue-100 text-blue-800
                                        @elseif($delivery->status === 'pending') bg-yellow-100 text-yellow-800
                                        @else bg-red-100 text-red-800 @endif">
                                        {{ $delivery->status_label }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right flex items-center justify-end gap-2">
                                    <a href="{{ route('logistics.edit', $delivery) }}" class="text-xs px-3 py-1.5 bg-green-100 hover:bg-green-200 text-green-800 rounded-lg transition">Edit</a>
                                    <form method="POST" action="{{ route('logistics.destroy', $delivery) }}" onsubmit="return confirm('Delete this delivery?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-xs px-3 py-1.5 bg-red-100 hover:bg-red-200 text-red-700 rounded-lg transition">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="8" class="px-6 py-8 text-center text-gray-400">No deliveries found. <a href="{{ route('logistics.create') }}" class="text-green-600 underline">Create one</a></td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const textColor = '#4b5563';
            const gridColor = '#e5e7eb';
            const usages = {!! json_encode($warehouseUsage) !!};
            new Chart(document.getElementById('warehouseChart'), {
                type: 'bar',
                data: {
                    labels: {!! json_encode($warehouseLabels) !!},
                    datasets: [{
                        label: 'Usage (%)',
                        data: usages,
                        backgroundColor: usages.map(v => v >= 100 ? 'rgba(239,68,68,0.75)' : v >= 70 ? 'rgba(234,179,8,0.75)' : 'rgba(34,197,94,0.75)'),
                        borderRadius: 6
                    }]
                },
                options: {
                    responsive: true, maintainAspectRatio: false,
                    plugins: { legend: { labels: { color: textColor } } },
                    scales: {
                        x: { grid: { color: gridColor }, ticks: { color: textColor } },
                        y: { max: 110, grid: { color: gridColor }, ticks: { color: textColor, callback: v => v + '%' } }
                    }
                }
            });
        });
    </script>
</x-app-layout>
