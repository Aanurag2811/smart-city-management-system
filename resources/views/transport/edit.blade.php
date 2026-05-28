<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('transport.index') }}" class="text-gray-400 hover:text-green-400 transition">← Back</a>
            <h2 class="font-semibold text-xl text-green-400">Edit Transport Route</h2>
        </div>
    </x-slot>
    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 bg-green-50">
                    <h3 class="font-bold text-green-800">✏️ Edit: {{ $transport->route_name }}</h3>
                </div>
                <form method="POST" action="{{ route('transport.update', $transport) }}" class="p-6 space-y-5">
                    @csrf @method('PATCH')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <x-input-label for="route_name" value="Route Name" />
                            <x-text-input id="route_name" name="route_name" class="mt-1 block w-full" value="{{ old('route_name', $transport->route_name) }}" required />
                        </div>
                        <div>
                            <x-input-label for="transport_type" value="Transport Type" />
                            <select id="transport_type" name="transport_type" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500">
                                @foreach(['road', 'rail', 'bus'] as $type)
                                <option value="{{ $type }}" {{ old('transport_type', $transport->transport_type) === $type ? 'selected' : '' }}>{{ ucfirst($type) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <x-input-label for="from_location" value="From Location" />
                            <x-text-input id="from_location" name="from_location" class="mt-1 block w-full" value="{{ old('from_location', $transport->from_location) }}" required />
                        </div>
                        <div>
                            <x-input-label for="to_location" value="To Location" />
                            <x-text-input id="to_location" name="to_location" class="mt-1 block w-full" value="{{ old('to_location', $transport->to_location) }}" required />
                        </div>
                        <div>
                            <x-input-label for="traffic_level" value="Traffic Level" />
                            <select id="traffic_level" name="traffic_level" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500">
                                @foreach(['low', 'medium', 'high'] as $level)
                                <option value="{{ $level }}" {{ old('traffic_level', $transport->traffic_level) === $level ? 'selected' : '' }}>{{ ucfirst($level) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <x-input-label for="status" value="Status" />
                            <select id="status" name="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500">
                                @foreach(['active', 'congested', 'closed'] as $s)
                                <option value="{{ $s }}" {{ old('status', $transport->status) === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <x-input-label for="vehicle_count" value="Vehicle Count" />
                            <x-text-input type="number" id="vehicle_count" name="vehicle_count" class="mt-1 block w-full" value="{{ old('vehicle_count', $transport->vehicle_count) }}" min="0" />
                        </div>
                        <div>
                            <x-input-label value="Peak Hours" />
                            <div class="mt-1 flex gap-2">
                                <x-text-input type="time" name="peak_start" class="block w-full" value="{{ old('peak_start', \Str::substr($transport->peak_start, 0, 5)) }}" />
                                <span class="self-center text-gray-400">–</span>
                                <x-text-input type="time" name="peak_end" class="block w-full" value="{{ old('peak_end', \Str::substr($transport->peak_end, 0, 5)) }}" />
                            </div>
                        </div>
                    </div>
                    <div>
                        <x-input-label for="notes" value="Notes" />
                        <textarea id="notes" name="notes" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500">{{ old('notes', $transport->notes) }}</textarea>
                    </div>
                    <div class="flex justify-end gap-3">
                        <a href="{{ route('transport.index') }}" class="px-4 py-2 text-sm bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition">Cancel</a>
                        <x-primary-button>Update Route</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
