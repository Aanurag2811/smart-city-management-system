<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-green-400">🗺️ Smart City Live Map</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Map --}}
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                    <h3 class="font-bold text-gray-900">Live City Map</h3>
                    <div class="flex gap-3 text-xs">
                        <span class="flex items-center gap-1"><span class="w-3 h-3 rounded-full bg-green-500 inline-block"></span> Open Route</span>
                        <span class="flex items-center gap-1"><span class="w-3 h-3 rounded-full bg-yellow-500 inline-block"></span> Congested</span>
                        <span class="flex items-center gap-1"><span class="w-3 h-3 rounded-full bg-red-500 inline-block"></span> Closed</span>
                        <span class="flex items-center gap-1"><span class="w-3 h-3 rounded-full bg-purple-500 inline-block"></span> Warehouse</span>
                        <span class="flex items-center gap-1"><span class="w-3 h-3 rounded-full bg-blue-500 inline-block"></span> In-Transit</span>
                    </div>
                </div>
                <div id="map" style="height: 520px; width: 100%;"></div>
            </div>

            {{-- Data Panels --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                {{-- Routes --}}
                <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                    <div class="px-5 py-4 border-b border-gray-100">
                        <h4 class="font-bold text-gray-900 text-sm">🛣️ City Routes ({{ $routes->count() }})</h4>
                    </div>
                    <div class="divide-y divide-gray-50">
                        @foreach($routes as $route)
                        <div class="px-5 py-3 flex items-center justify-between">
                            <div>
                                <p class="text-sm font-semibold text-gray-900">{{ $route->name }}</p>
                                <p class="text-xs text-gray-400">{{ $route->distance_km }} km · ~{{ $route->estimated_minutes }} min</p>
                            </div>
                            <span class="px-2 py-0.5 rounded-full text-xs font-semibold
                                @if($route->status === 'open') bg-green-100 text-green-800
                                @elseif($route->status === 'congested') bg-yellow-100 text-yellow-800
                                @else bg-red-100 text-red-800 @endif">
                                {{ ucfirst($route->status) }}
                            </span>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Warehouses --}}
                <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                    <div class="px-5 py-4 border-b border-gray-100">
                        <h4 class="font-bold text-gray-900 text-sm">🏬 Warehouses ({{ $warehouses->count() }})</h4>
                    </div>
                    <div class="divide-y divide-gray-50">
                        @foreach($warehouses as $wh)
                        <div class="px-5 py-3 flex items-center justify-between">
                            <div>
                                <p class="text-sm font-semibold text-gray-900">{{ $wh->name }}</p>
                                <p class="text-xs text-gray-400">{{ $wh->zone }} · {{ $wh->usage_percentage }}% full</p>
                            </div>
                            <span class="px-2 py-0.5 rounded-full text-xs font-semibold
                                @if($wh->status === 'operational') bg-green-100 text-green-800
                                @elseif($wh->status === 'full') bg-red-100 text-red-800
                                @else bg-yellow-100 text-yellow-800 @endif">
                                {{ ucfirst($wh->status) }}
                            </span>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Active Deliveries --}}
                <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                    <div class="px-5 py-4 border-b border-gray-100">
                        <h4 class="font-bold text-gray-900 text-sm">📦 In Transit ({{ $deliveries->count() }})</h4>
                    </div>
                    <div class="divide-y divide-gray-50">
                        @forelse($deliveries as $delivery)
                        <div class="px-5 py-3">
                            <p class="text-sm font-semibold text-gray-900">#{{ $delivery->delivery_code }}</p>
                            <p class="text-xs text-gray-400">{{ $delivery->source }} → {{ $delivery->destination }}</p>
                            <p class="text-xs text-green-600">ETA: {{ $delivery->eta ? $delivery->eta->format('H:i, d M') : '—' }}</p>
                        </div>
                        @empty
                        <div class="px-5 py-6 text-center text-sm text-gray-400">No active deliveries</div>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- Leaflet.js Map --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Centre on a representative city (using mock coordinates)
            const map = L.map('map').setView([20.5937, 78.9629], 6); // India center

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);

            // Mock coordinates for routes (spread across a city grid)
            const routeData = [
                { name: 'City Centre Loop', from: [20.59, 78.96], to: [20.60, 78.97], status: 'congested' },
                { name: 'North-South Expressway', from: [20.65, 78.96], to: [20.52, 78.96], status: 'open' },
                { name: 'Industrial Ring Road', from: [20.58, 78.92], to: [20.58, 79.00], status: 'open' },
                { name: 'Airport Highway', from: [20.59, 78.96], to: [20.45, 78.85], status: 'open' },
            ];

            const colors = { open: '#22c55e', congested: '#eab308', closed: '#ef4444' };

            routeData.forEach(r => {
                L.polyline([r.from, r.to], { color: colors[r.status] || '#6b7280', weight: 5, opacity: 0.8 })
                    .addTo(map).bindPopup(`<b>${r.name}</b><br>Status: ${r.status}`);
                L.circleMarker(r.from, { radius: 6, fillColor: colors[r.status], color: '#fff', fillOpacity: 1 }).addTo(map);
                L.circleMarker(r.to, { radius: 6, fillColor: colors[r.status], color: '#fff', fillOpacity: 1 }).addTo(map);
            });

            // Warehouse markers
            const warehouses = [
                { name: 'North Sector Warehouse', coords: [20.65, 78.96], status: 'operational' },
                { name: 'South Port Warehouse', coords: [20.52, 78.96], status: 'full' },
                { name: 'East Distribution Hub', coords: [20.59, 79.02], status: 'operational' },
                { name: 'Central Logistics Centre', coords: [20.59, 78.96], status: 'operational' },
                { name: 'West Storage Facility', coords: [20.59, 78.90], status: 'maintenance' },
            ];
            const warehouseIcon = L.divIcon({ className: '', html: '<div style="font-size:20px;">🏬</div>' });
            warehouses.forEach(w => {
                L.marker(w.coords, { icon: warehouseIcon }).addTo(map).bindPopup(`<b>${w.name}</b><br>Status: ${w.status}`);
            });

            // In-transit deliveries
            const deliveries = [
                { code: 'DLV-1024', coords: [20.63, 78.96] },
                { code: 'DLV-1027', coords: [20.55, 78.92] },
            ];
            const truckIcon = L.divIcon({ className: '', html: '<div style="font-size:18px;">🚚</div>' });
            deliveries.forEach(d => {
                L.marker(d.coords, { icon: truckIcon }).addTo(map).bindPopup(`<b>${d.code}</b><br>In Transit`);
            });
        });
    </script>
</x-app-layout>
