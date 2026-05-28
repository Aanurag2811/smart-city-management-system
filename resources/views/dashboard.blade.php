<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-xl text-green-400 leading-tight">Smart City Dashboard</h2>
            <div class="text-right text-gray-400 text-sm">
                <p class="font-medium text-gray-400">{{ now()->format('l, d M Y') }}</p>
                <p class="text-xs">{{ now()->format('H:i') }}</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Welcome Banner --}}
            <div class="rounded-xl p-6 text-white shadow-sm border border-green-800" style="background:linear-gradient(135deg,#0d1117 0%,#111827 60%,#14532d 100%)">
                <div class="flex justify-between items-center flex-wrap gap-3">
                    <div>
                        <h3 class="text-xl font-bold text-white">Welcome back, <span class="text-green-400">{{ auth()->user()->name }}</span></h3>
                        <p class="text-gray-400 mt-1 text-sm">Role: <span class="capitalize font-semibold text-green-400 bg-green-900/40 px-2 py-0.5 rounded-full border border-green-800">{{ str_replace('_', ' ', auth()->user()->role) }}</span></p>
                    </div>
                    <div class="flex items-center gap-2 bg-green-900/20 border border-green-800 rounded-full px-3 py-1.5">
                        <span style="width:8px;height:8px;border-radius:50%;background:#4ade80;animation:livePulse 1.5s ease-in-out infinite;display:inline-block"></span>
                        <span class="text-green-400 text-xs font-semibold">Live</span>
                    </div>
                </div>
            </div>

            {{-- Success / Error Messages --}}
            @if(session('success'))
                <div class="bg-green-50 border border-green-300 text-green-800 px-4 py-3 rounded-lg text-sm">
                    {{ session('success') }}
                </div>
            @endif

            {{-- KPI Cards --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-green-500 relative">
                    <div class="text-xs font-bold text-green-600 uppercase tracking-wider">Total Routes</div>
                    <div id="kpi-routes" class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['total_routes'] }}</div>
                    <div class="text-xs text-red-500 mt-1"><span id="kpi-congested">{{ $stats['congested_routes'] }}</span> congested</div>
                    <div id="kpi-pulse-1" class="absolute top-3 right-3 w-2 h-2 rounded-full bg-green-400 opacity-0"></div>
                </div>
                <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-green-600 relative">
                    <div class="text-xs font-bold text-green-700 uppercase tracking-wider">Active Deliveries</div>
                    <div id="kpi-deliveries" class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['active_deliveries'] }}</div>
                    <div class="text-xs text-amber-600 mt-1"><span id="kpi-pending">{{ $stats['pending_deliveries'] }}</span> pending</div>
                    <div id="kpi-pulse-2" class="absolute top-3 right-3 w-2 h-2 rounded-full bg-green-400 opacity-0"></div>
                </div>
                <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-gray-700 relative">
                    <div class="text-xs font-bold text-gray-600 uppercase tracking-wider">Fleet Active</div>
                    <div id="kpi-fleet" class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['vehicles_in_use'] }}/{{ $stats['total_vehicles'] }}</div>
                    <div class="text-xs text-gray-400 mt-1">Vehicles on road</div>
                    <div id="kpi-pulse-3" class="absolute top-3 right-3 w-2 h-2 rounded-full bg-green-400 opacity-0"></div>
                </div>
                <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-red-500 relative">
                    <div class="text-xs font-bold text-red-500 uppercase tracking-wider">Alerts</div>
                    <div id="kpi-alerts" class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['unread_alerts'] }}</div>
                    <div class="text-xs text-red-500 mt-1"><span id="kpi-critical">{{ $stats['critical_resources'] }}</span> critical resources</div>
                    <div id="kpi-pulse-4" class="absolute top-3 right-3 w-2 h-2 rounded-full bg-red-400 opacity-0"></div>
                </div>
            </div>

            {{-- Module Quick Access --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @if(in_array(auth()->user()->role, ['admin', 'transport_manager']))
                <a href="{{ route('transport.index') }}" class="group block bg-white rounded-xl shadow-sm hover:shadow-md transition-all duration-200 overflow-hidden border border-gray-100 hover:border-green-200">
                    <div class="h-1.5" style="background:linear-gradient(90deg,#16a34a,#4ade80)"></div>
                    <div class="p-6">
                        <div class="flex items-center gap-3 mb-3">
                            <span class="text-2xl">🚦</span>
                            <h4 class="text-lg font-bold text-gray-900 group-hover:text-green-700">Transport Management</h4>
                        </div>
                        <p class="text-sm text-gray-500">Monitor live traffic, manage routes and public transport schedules.</p>
                        <div class="mt-4 flex gap-2 text-xs flex-wrap">
                            <span class="bg-green-50 text-green-700 border border-green-200 px-2 py-1 rounded-full">{{ $stats['total_routes'] }} Routes</span>
                            <span class="bg-red-50 text-red-700 border border-red-200 px-2 py-1 rounded-full">{{ $stats['congested_routes'] }} Congested</span>
                        </div>
                    </div>
                </a>
                @endif

                @if(in_array(auth()->user()->role, ['admin', 'logistics_manager']))
                <a href="{{ route('logistics.index') }}" class="group block bg-white rounded-xl shadow-sm hover:shadow-md transition-all duration-200 overflow-hidden border border-gray-100 hover:border-green-200">
                    <div class="h-1.5" style="background:linear-gradient(90deg,#15803d,#22c55e)"></div>
                    <div class="p-6">
                        <div class="flex items-center gap-3 mb-3">
                            <span class="text-2xl">🚚</span>
                            <h4 class="text-lg font-bold text-gray-900 group-hover:text-green-700">Logistics Management</h4>
                        </div>
                        <p class="text-sm text-gray-500">Track deliveries, manage fleet, and monitor warehouse capacity.</p>
                        <div class="mt-4 flex gap-2 text-xs flex-wrap">
                            <span class="bg-green-50 text-green-700 border border-green-200 px-2 py-1 rounded-full">{{ $stats['active_deliveries'] }} In Transit</span>
                            <span class="bg-amber-50 text-amber-700 border border-amber-200 px-2 py-1 rounded-full">{{ $stats['pending_deliveries'] }} Pending</span>
                        </div>
                    </div>
                </a>
                @endif

                @if(in_array(auth()->user()->role, ['admin', 'citizen']))
                <a href="{{ route('resources.index') }}" class="group block bg-white rounded-xl shadow-sm hover:shadow-md transition-all duration-200 overflow-hidden border border-gray-100 hover:border-green-200">
                    <div class="h-1.5" style="background:linear-gradient(90deg,#111827,#374151)"></div>
                    <div class="p-6">
                        <div class="flex items-center gap-3 mb-3">
                            <span class="text-2xl">⚡</span>
                            <h4 class="text-lg font-bold text-gray-900 group-hover:text-green-700">Resource Management</h4>
                        </div>
                        <p class="text-sm text-gray-500">Analyze water, electricity, and waste consumption trends.</p>
                        <div class="mt-4 flex gap-2 text-xs flex-wrap">
                            <span class="bg-red-50 text-red-700 border border-red-200 px-2 py-1 rounded-full">{{ $stats['critical_resources'] }} Critical</span>
                            <span class="bg-amber-50 text-amber-700 border border-amber-200 px-2 py-1 rounded-full">{{ $stats['warning_resources'] }} Warnings</span>
                        </div>
                    </div>
                </a>
                @endif
            </div>

            {{-- Bottom Row: Alerts + Recent Deliveries --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Recent Alerts --}}
                <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100">
                    <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100" style="background:#0d1117">
                        <h3 class="font-bold text-green-400 text-sm">🔔 Recent Alerts</h3>
                        <a href="{{ route('notifications.index') }}" class="text-xs text-green-500 hover:text-green-400 transition">View all →</a>
                    </div>
                    <div class="divide-y divide-gray-50">
                        @forelse($recentAlerts as $alert)
                        <div class="px-6 py-3 flex items-start gap-3">
                            <span class="mt-0.5 text-sm">
                                @if($alert->severity === 'critical') 🚨
                                @elseif($alert->severity === 'warning') ⚠️
                                @else ℹ️ @endif
                            </span>
                            <div>
                                <p class="text-sm font-semibold text-gray-900">{{ $alert->title }}</p>
                                <p class="text-xs text-gray-500 mt-0.5 line-clamp-1">{{ $alert->message }}</p>
                            </div>
                        </div>
                        @empty
                        <div class="px-6 py-6 text-center text-sm text-gray-400">No active alerts. All systems normal ✅</div>
                        @endforelse
                    </div>
                </div>

                {{-- Recent Deliveries --}}
                <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100">
                    <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100" style="background:#0d1117">
                        <h3 class="font-bold text-green-400 text-sm">📦 Recent Deliveries</h3>
                        @if(in_array(auth()->user()->role, ['admin', 'logistics_manager']))
                        <a href="{{ route('logistics.index') }}" class="text-xs text-green-500 hover:text-green-400 transition">View all →</a>
                        @endif
                    </div>
                    <div class="divide-y divide-gray-50">
                        @forelse($recentDeliveries as $delivery)
                        <div class="px-6 py-3 flex items-center justify-between">
                            <div>
                                <p class="text-sm font-semibold text-gray-900">{{ $delivery->delivery_code }}</p>
                                <p class="text-xs text-gray-500">→ {{ $delivery->destination }}</p>
                            </div>
                            <span class="px-2 py-0.5 rounded-full text-xs font-semibold
                                @if($delivery->status === 'delivered') bg-green-100 text-green-800
                                @elseif($delivery->status === 'in_transit') bg-blue-100 text-blue-800
                                @elseif($delivery->status === 'pending') bg-amber-100 text-amber-800
                                @else bg-red-100 text-red-800 @endif">
                                {{ $delivery->status_label }}
                            </span>
                        </div>
                        @empty
                        <div class="px-6 py-6 text-center text-sm text-gray-400">No deliveries found.</div>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- Quick Links (Admin) --}}
            @if(auth()->user()->role === 'admin')
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <a href="{{ route('analytics.index') }}" class="flex items-center gap-3 bg-white hover:bg-green-50 border border-gray-200 hover:border-green-300 rounded-xl p-4 transition shadow-sm">
                    <span class="text-2xl">📊</span><span class="font-semibold text-sm text-gray-700">Analytics</span>
                </a>
                <a href="{{ route('map.index') }}" class="flex items-center gap-3 bg-white hover:bg-green-50 border border-gray-200 hover:border-green-300 rounded-xl p-4 transition shadow-sm">
                    <span class="text-2xl">🗺️</span><span class="font-semibold text-sm text-gray-700">Live Map</span>
                </a>
                <a href="{{ route('notifications.index') }}" class="flex items-center gap-3 bg-white hover:bg-green-50 border border-gray-200 hover:border-green-300 rounded-xl p-4 transition shadow-sm">
                    <span class="text-2xl">🔔</span><span class="font-semibold text-sm text-gray-700">Notifications</span>
                </a>
                <a href="{{ route('logistics.warehouses') }}" class="flex items-center gap-3 bg-white hover:bg-green-50 border border-gray-200 hover:border-green-300 rounded-xl p-4 transition shadow-sm">
                    <span class="text-2xl">🏬</span><span class="font-semibold text-sm text-gray-700">Warehouses</span>
                </a>
            </div>
            @endif

        </div>
    </div>
</x-app-layout>

@push('scripts')
<script>
(function () {
    const els = {
        routes:    document.getElementById('kpi-routes'),
        congested: document.getElementById('kpi-congested'),
        deliveries:document.getElementById('kpi-deliveries'),
        pending:   document.getElementById('kpi-pending'),
        fleet:     document.getElementById('kpi-fleet'),
        alerts:    document.getElementById('kpi-alerts'),
        critical:  document.getElementById('kpi-critical'),
    };
    const pulses = [1,2,3,4].map(i => document.getElementById('kpi-pulse-' + i));

    function flashPulse() {
        pulses.forEach(p => {
            if (!p) return;
            p.style.opacity = '1';
            p.style.transition = 'opacity 0.5s';
            setTimeout(() => { p.style.opacity = '0'; }, 800);
        });
    }

    function updateEl(el, val) {
        if (el && el.textContent !== String(val)) {
            el.textContent = val;
            el.style.transition = 'color 0.4s';
            el.style.color = '#16a34a';
            setTimeout(() => el.style.color = '', 1000);
        }
    }

    function refreshStats() {
        fetch('/api/stats', {
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
        })
        .then(r => r.ok ? r.json() : null)
        .then(data => {
            if (!data) return;
            const changed =
                (els.routes    && els.routes.textContent    !== String(data.total_routes)) ||
                (els.deliveries&& els.deliveries.textContent!== String(data.active_deliveries)) ||
                (els.alerts    && els.alerts.textContent    !== String(data.unread_alerts));

            updateEl(els.routes,     data.total_routes);
            updateEl(els.congested,  data.congested_routes);
            updateEl(els.deliveries, data.active_deliveries);
            updateEl(els.pending,    data.pending_deliveries);
            updateEl(els.fleet,      data.vehicles_in_use + '/' + data.total_vehicles);
            updateEl(els.alerts,     data.unread_alerts);
            updateEl(els.critical,   data.critical_resources);

            if (changed) flashPulse();
        })
        .catch(() => {});
    }

    setInterval(refreshStats, 60000);
})();
</script>
@endpush
