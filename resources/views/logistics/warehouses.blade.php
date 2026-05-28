<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ route('logistics.index') }}" class="text-gray-400 hover:text-green-400 transition">← Back</a>
                <h2 class="font-semibold text-xl text-green-400">🏬 Warehouse Management</h2>
            </div>
            <a href="{{ route('logistics.warehouses.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-semibold rounded-lg transition">+ Add Warehouse</a>
        </div>
    </x-slot>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="bg-green-50 border border-green-300 text-green-800 px-4 py-3 rounded-lg">{{ session('success') }}</div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($warehouses as $wh)
                <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                    <div class="h-2 {{ $wh->status === 'operational' ? 'bg-green-500' : ($wh->status === 'full' ? 'bg-red-500' : 'bg-yellow-500') }}"></div>
                    <div class="p-5">
                        <div class="flex items-start justify-between mb-3">
                            <div>
                                <h4 class="font-bold text-gray-900">{{ $wh->name }}</h4>
                                <p class="text-xs text-gray-500 mt-0.5">📍 {{ $wh->location }}</p>
                            </div>
                            <span class="px-2 py-1 rounded-full text-xs font-semibold
                                {{ $wh->status === 'operational' ? 'bg-green-100 text-green-800' : ($wh->status === 'full' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                {{ ucfirst($wh->status) }}
                            </span>
                        </div>
                        {{-- Capacity Bar --}}
                        <div class="mb-4">
                            <div class="flex justify-between text-xs text-gray-500 mb-1">
                                <span>Capacity</span>
                                <span>{{ $wh->usage_percentage }}% ({{ number_format($wh->current_load) }}/{{ number_format($wh->capacity) }})</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div class="h-2.5 rounded-full {{ $wh->usage_percentage >= 100 ? 'bg-red-500' : ($wh->usage_percentage >= 70 ? 'bg-yellow-500' : 'bg-green-500') }}"
                                    style="width: {{ min($wh->usage_percentage, 100) }}%"></div>
                            </div>
                        </div>
                        <div class="text-xs text-gray-500 space-y-1">
                            <p>🏷️ Zone: <span class="font-semibold text-gray-700">{{ $wh->zone ?? '—' }}</span></p>
                            <p>👤 Manager: <span class="font-semibold text-gray-700">{{ $wh->manager_name ?? '—' }}</span></p>
                            <p>📦 Deliveries: <span class="font-semibold text-gray-700">{{ $wh->deliveries_count }}</span></p>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-3 text-center py-12 text-gray-400">No warehouses found. <a href="{{ route('logistics.warehouses.create') }}" class="text-green-600 underline">Add one</a></div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
