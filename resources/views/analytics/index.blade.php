<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-green-400">📊 Smart City Analytics</h2>
            <div class="flex gap-3">
                <button onclick="window.print()" class="bg-gray-700 hover:bg-gray-800 text-white px-4 py-2 rounded-lg shadow-sm text-sm font-medium transition flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                    Print
                </button>
                <a href="{{ route('analytics.export') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg shadow-sm text-sm font-medium transition flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    Export CSV
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Row 1: Transport + Delivery + Resource Doughnut Charts --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                    <div class="px-5 py-4 border-b border-gray-100">
                        <h3 class="font-bold text-gray-900 text-sm">🚦 Traffic Levels</h3>
                    </div>
                    <div class="p-5 h-52"><canvas id="trafficDonut"></canvas></div>
                </div>
                <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                    <div class="px-5 py-4 border-b border-gray-100">
                        <h3 class="font-bold text-gray-900 text-sm">🚚 Delivery Status</h3>
                    </div>
                    <div class="p-5 h-52"><canvas id="deliveryDonut"></canvas></div>
                </div>
                <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                    <div class="px-5 py-4 border-b border-gray-100">
                        <h3 class="font-bold text-gray-900 text-sm">⚡ Resource Health</h3>
                    </div>
                    <div class="p-5 h-52"><canvas id="resourceDonut"></canvas></div>
                </div>
            </div>

            {{-- Row 2: Resource consumption trend --}}
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h3 class="font-bold text-gray-900">📈 7-Day Resource Consumption Trend</h3>
                </div>
                <div class="p-6 h-72"><canvas id="trendLine"></canvas></div>
            </div>

            {{-- Row 3: Warehouse usage bar + Vehicle fleet + Notification types --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100">
                        <h3 class="font-bold text-gray-900 text-sm">🏬 Warehouse Capacity</h3>
                    </div>
                    <div class="p-6 h-64"><canvas id="warehouseBar"></canvas></div>
                </div>
                <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100">
                        <h3 class="font-bold text-gray-900 text-sm">🚘 Vehicle Fleet Status</h3>
                    </div>
                    <div class="p-6 h-64"><canvas id="vehicleBar"></canvas></div>
                </div>
            </div>

            {{-- Notification breakdown --}}
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h3 class="font-bold text-gray-900">🔔 Alerts by Module</h3>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-0 divide-x divide-gray-100">
                    @foreach(['traffic' => ['🚦','blue'], 'resource' => ['⚡','yellow'], 'delivery' => ['🚚','green'], 'system' => ['⚙️','gray']] as $key => $meta)
                    <div class="p-6 text-center">
                        <div class="text-2xl mb-1">{{ $meta[0] }}</div>
                        <div class="text-3xl font-bold text-gray-900">{{ $notificationsByType[$key] }}</div>
                        <div class="text-xs text-gray-400 mt-1 capitalize">{{ $key }}</div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Critical Resources Table --}}
            @if($resourceAlerts->count() > 0)
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h3 class="font-bold text-red-500">⚠️ Resources Requiring Attention</h3>
                </div>
                <div class="divide-y divide-gray-100">
                    @foreach($resourceAlerts as $res)
                    <div class="px-6 py-4 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <span class="text-xl">{{ $res->type_icon }}</span>
                            <div>
                                <p class="font-semibold text-sm text-gray-900">{{ $res->sector }} — {{ $res->location }}</p>
                                <p class="text-xs text-gray-500">{{ number_format($res->current_usage, 1) }} {{ $res->unit }} (threshold: {{ $res->alert_threshold ? number_format($res->alert_threshold, 1) : 'N/A' }})</p>
                            </div>
                        </div>
                        <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $res->status === 'critical' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800' }}">
                            {{ ucfirst($res->status) }}
                        </span>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const txt = '#4b5563';
            const grid = '#e5e7eb';
            const dOpts = { responsive: true, maintainAspectRatio: false, plugins: { legend: { position: 'bottom', labels: { color: txt, boxWidth: 12 } } } };

            new Chart(document.getElementById('trafficDonut'), { type: 'doughnut', data: { labels: ['Low', 'Medium', 'High'], datasets: [{ data: [{{ $transportByLevel['low'] }}, {{ $transportByLevel['medium'] }}, {{ $transportByLevel['high'] }}], backgroundColor: ['#22c55e','#eab308','#ef4444'], borderWidth: 0 }] }, options: dOpts });
            new Chart(document.getElementById('deliveryDonut'), { type: 'doughnut', data: { labels: ['Pending','In Transit','Delivered','Failed'], datasets: [{ data: [{{ $deliveryStats['pending'] }},{{ $deliveryStats['in_transit'] }},{{ $deliveryStats['delivered'] }},{{ $deliveryStats['failed'] }}], backgroundColor: ['#eab308','#3b82f6','#22c55e','#ef4444'], borderWidth: 0 }] }, options: dOpts });
            new Chart(document.getElementById('resourceDonut'), { type: 'doughnut', data: { labels: ['Normal','Warning','Critical'], datasets: [{ data: [{{ $resourceStats['normal'] }},{{ $resourceStats['warning'] }},{{ $resourceStats['critical'] }}], backgroundColor: ['#22c55e','#eab308','#ef4444'], borderWidth: 0 }] }, options: dOpts });

            const lineOpts = { responsive: true, maintainAspectRatio: false, interaction: { mode: 'index', intersect: false }, plugins: { legend: { labels: { color: txt } } }, scales: { x: { grid: { color: grid }, ticks: { color: txt } }, y: { type: 'linear', display: true, position: 'left', title: { display: true, text: 'Water (L)', color: '#3b82f6' }, grid: { color: grid }, beginAtZero: true, ticks: { color: '#3b82f6', callback: v => Number(v).toLocaleString() } }, y1: { type: 'linear', display: true, position: 'right', title: { display: true, text: 'Electricity (kWh)', color: '#eab308' }, grid: { drawOnChartArea: false }, beginAtZero: true, ticks: { color: '#eab308', callback: v => Number(v).toLocaleString() } }, y2: { type: 'linear', display: true, position: 'right', offset: true, title: { display: true, text: 'Waste (Tons)', color: '#22c55e' }, grid: { drawOnChartArea: false }, beginAtZero: true, ticks: { color: '#22c55e', callback: v => Number(v).toLocaleString() } } } };
            new Chart(document.getElementById('trendLine'), { type: 'line', data: { labels: {!! json_encode($chartLabels) !!}, datasets: [
                { label: 'Water (L)', data: {!! json_encode($waterTrend) !!}, borderColor: '#3b82f6', backgroundColor: 'rgba(59,130,246,0.1)', fill: true, tension: 0.4, yAxisID: 'y' },
                { label: 'Electricity (kWh)', data: {!! json_encode($elecTrend) !!}, borderColor: '#eab308', backgroundColor: 'rgba(234,179,8,0.1)', fill: true, tension: 0.4, yAxisID: 'y1' },
                { label: 'Waste (Tons)', data: {!! json_encode($wasteTrend) !!}, borderColor: '#22c55e', backgroundColor: 'rgba(34,197,94,0.1)', fill: true, tension: 0.4, yAxisID: 'y2' }
            ] }, options: lineOpts });

            const barOpts = { responsive: true, maintainAspectRatio: false, plugins: { legend: { labels: { color: txt } } }, scales: { x: { grid: { color: grid }, ticks: { color: txt } }, y: { grid: { color: grid }, ticks: { color: txt } } } };
            const wUsage = {!! json_encode($warehouses->pluck('usage')) !!};
            new Chart(document.getElementById('warehouseBar'), { type: 'bar', data: { labels: {!! json_encode($warehouses->pluck('name')->map(fn($n) => strlen($n) > 18 ? substr($n, 0, 18).'...' : $n)->toArray()) !!}, datasets: [{ label: 'Usage %', data: wUsage, backgroundColor: wUsage.map(v => v >= 100 ? 'rgba(239,68,68,0.75)' : v >= 70 ? 'rgba(234,179,8,0.75)' : 'rgba(34,197,94,0.75)'), borderRadius: 6 }] }, options: { ...barOpts, scales: { ...barOpts.scales, y: { ...barOpts.scales.y, max: 110, ticks: { color: txt, callback: v => v + '%' } } } } });
            new Chart(document.getElementById('vehicleBar'), { type: 'bar', data: { labels: ['Available','In Use','Maintenance'], datasets: [{ label: 'Vehicles', data: [{{ $vehicleStats['available'] }},{{ $vehicleStats['in_use'] }},{{ $vehicleStats['maintenance'] }}], backgroundColor: ['rgba(34,197,94,0.75)','rgba(59,130,246,0.75)','rgba(234,179,8,0.75)'], borderRadius: 6 }] }, options: barOpts });
        });
    </script>
</x-app-layout>
