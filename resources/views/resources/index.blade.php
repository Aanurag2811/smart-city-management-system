<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-green-400">⚡ Resource Management</h2>
            @if(auth()->user()->role === 'admin')
            <a href="{{ route('resources.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white text-sm font-semibold rounded-lg transition">+ Add Resource</a>
            @endif
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="bg-green-50 border border-green-300 text-green-800 px-4 py-3 rounded-lg">{{ session('success') }}</div>
            @endif

            {{-- Summary Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                {{-- Water --}}
                <div class="bg-blue-50 rounded-xl shadow-sm p-6 border-t-4 border-blue-500">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="text-2xl">💧</span>
                        <div class="text-sm font-bold text-blue-600 uppercase">Water Usage</div>
                    </div>
                    <div class="text-3xl font-bold text-gray-900">{{ number_format($waterResources->sum('current_usage')) }}</div>
                    <div class="text-xs text-gray-500 mt-1">{{ $waterResources->first()?->unit ?? 'Litres' }}</div>
                    @if($waterResources->where('status', 'critical')->count() > 0)
                    <div class="mt-2 text-xs text-red-600 font-semibold">🚨 {{ $waterResources->where('status', 'critical')->count() }} critical sector(s)</div>
                    @endif
                </div>
                {{-- Electricity --}}
                <div class="bg-yellow-50 rounded-xl shadow-sm p-6 border-t-4 border-yellow-500">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="text-2xl">⚡</span>
                        <div class="text-sm font-bold text-yellow-600 uppercase">Electricity</div>
                    </div>
                    <div class="text-3xl font-bold text-gray-900">{{ number_format($electricityResources->sum('current_usage')) }}</div>
                    <div class="text-xs text-gray-500 mt-1">{{ $electricityResources->first()?->unit ?? 'kWh' }}</div>
                    @if($electricityResources->where('status', 'warning')->count() > 0)
                    <div class="mt-2 text-xs text-yellow-600 font-semibold">⚠️ {{ $electricityResources->where('status', 'warning')->count() }} warning(s)</div>
                    @endif
                </div>
                {{-- Waste --}}
                <div class="bg-green-50 rounded-xl shadow-sm p-6 border-t-4 border-green-500">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="text-2xl">🗑️</span>
                        <div class="text-sm font-bold text-green-600 uppercase">Waste Collection</div>
                    </div>
                    <div class="text-3xl font-bold text-gray-900">{{ number_format($wasteResources->sum('current_usage'), 1) }}</div>
                    <div class="text-xs text-gray-500 mt-1">{{ $wasteResources->first()?->unit ?? 'Tons' }}</div>
                    @if($wasteResources->where('status', 'warning')->count() > 0)
                    <div class="mt-2 text-xs text-yellow-600 font-semibold">⚠️ Overload in {{ $wasteResources->where('status', 'warning')->count() }} sector(s)</div>
                    @endif
                </div>
            </div>

            {{-- Consumption Trend Chart --}}
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h3 class="font-bold text-gray-900">7-Day Consumption Trends</h3>
                </div>
                <div class="p-6 h-72">
                    <canvas id="consumptionChart"></canvas>
                </div>
                
            </div>

            {{-- Resources Table --}}
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h3 class="font-bold text-gray-900">All Resources</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-100">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Type</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Sector</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Location</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Current Usage</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Alert Threshold</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Status</th>
                                @if(auth()->user()->role === 'admin')
                                <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase">Actions</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($resources as $res)
                            <tr class="hover:bg-green-50/40 transition">
                                <td class="px-6 py-4">
                                    <span class="text-lg">{{ $res->type_icon }}</span>
                                    <span class="ml-1 text-sm font-semibold text-gray-900 capitalize">{{ $res->type }}</span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $res->sector }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $res->location }}</td>
                                <td class="px-6 py-4 text-sm font-semibold text-gray-900">{{ number_format($res->current_usage, 1) }} {{ $res->unit }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $res->alert_threshold ? number_format($res->alert_threshold, 1) . ' ' . $res->unit : '—' }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 rounded-full text-xs font-semibold
                                        @if($res->status === 'normal') bg-green-100 text-green-800
                                        @elseif($res->status === 'warning') bg-yellow-100 text-yellow-800
                                        @else bg-red-100 text-red-800 @endif">
                                        {{ ucfirst($res->status) }}
                                    </span>
                                </td>
                                @if(auth()->user()->role === 'admin')
                                <td class="px-6 py-4 text-right flex items-center justify-end gap-2">
                                    <a href="{{ route('resources.edit', $res) }}" class="text-xs px-3 py-1.5 bg-green-100 hover:bg-green-200 text-green-800 rounded-lg transition">Edit</a>
                                    <form method="POST" action="{{ route('resources.destroy', $res) }}" onsubmit="return confirm('Delete this resource?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-xs px-3 py-1.5 bg-red-100 hover:bg-red-200 text-red-700 rounded-lg transition">Delete</button>
                                    </form>
                                </td>
                                @endif
                            </tr>
                            @empty
                            <tr><td colspan="7" class="px-6 py-8 text-center text-gray-400">No resources found.</td></tr>
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

            const chartLabels = {!! json_encode($chartLabels) !!};
            const waterDataSet = {!! json_encode($waterData) !!};
            const electricityDataSet = {!! json_encode($electricityData) !!};
            const wasteDataSet = {!! json_encode($wasteData) !!};

            new Chart(document.getElementById('consumptionChart'), {
                type: 'line',
                data: {
                    labels: chartLabels,
                    datasets: [
                        { label: 'Water (L)', data: waterDataSet, borderColor: '#3b82f6', backgroundColor: 'rgba(59,130,246,0.1)', fill: true, tension: 0.4, borderWidth: 2, yAxisID: 'y' },
                        { label: 'Electricity (kWh)', data: electricityDataSet, borderColor: '#eab308', backgroundColor: 'rgba(234,179,8,0.1)', fill: true, tension: 0.4, borderWidth: 2, yAxisID: 'y1' },
                        { label: 'Waste (Tons)', data: wasteDataSet, borderColor: '#22c55e', backgroundColor: 'rgba(34,197,94,0.1)', fill: true, tension: 0.4, borderWidth: 2, yAxisID: 'y2' }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: { mode: 'index', intersect: false },
                    plugins: {
                        legend: { labels: { color: textColor } },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let value = context.parsed.y;
                                    if (value === null) return '';
                                    return context.dataset.label + ': ' + value.toLocaleString();
                                }
                            }
                        }
                    },
                    scales: {
                        x: { grid: { color: gridColor }, ticks: { color: textColor } },
                        y: {
                            type: 'linear',
                            display: true,
                            position: 'left',
                            title: { display: true, text: 'Water (L)', color: '#3b82f6' },
                            grid: { color: gridColor },
                            beginAtZero: true,
                            ticks: {
                                color: '#3b82f6',
                                callback: function(value) { return Number(value).toLocaleString(); }
                            }
                        },
                        y1: {
                            type: 'linear',
                            display: true,
                            position: 'right',
                            title: { display: true, text: 'Electricity (kWh)', color: '#eab308' },
                            grid: { drawOnChartArea: false },
                            beginAtZero: true,
                            ticks: {
                                color: '#eab308',
                                callback: function(value) { return Number(value).toLocaleString(); }
                            }
                        },
                        y2: {
                            type: 'linear',
                            display: true,
                            position: 'right',
                            offset: true,
                            title: { display: true, text: 'Waste (Tons)', color: '#22c55e' },
                            grid: { drawOnChartArea: false },
                            beginAtZero: true,
                            ticks: {
                                color: '#22c55e',
                                callback: function(value) { return Number(value).toLocaleString(); }
                            }
                        }
                    }
                }
            });
        });
    </script>
</x-app-layout>
