<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('logistics.index') }}" class="text-gray-400 hover:text-green-400 transition">← Back</a>
            <h2 class="font-semibold text-xl text-green-400">Edit Delivery</h2>
        </div>
    </x-slot>
    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 bg-green-50">
                    <h3 class="font-bold text-green-700">✏️ Edit: #{{ $delivery->delivery_code }}</h3>
                </div>
                <form method="POST" action="{{ route('logistics.update', $delivery) }}" class="p-6 space-y-5">
                    @csrf @method('PATCH')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <x-input-label for="source" value="Source" />
                            <x-text-input id="source" name="source" class="mt-1 block w-full" value="{{ old('source', $delivery->source) }}" required />
                        </div>
                        <div>
                            <x-input-label for="destination" value="Destination" />
                            <x-text-input id="destination" name="destination" class="mt-1 block w-full" value="{{ old('destination', $delivery->destination) }}" required />
                        </div>
                        <div>
                            <x-input-label for="driver_name" value="Driver Name" />
                            <x-text-input id="driver_name" name="driver_name" class="mt-1 block w-full" value="{{ old('driver_name', $delivery->driver_name) }}" required />
                        </div>
                        <div>
                            <x-input-label for="vehicle_number" value="Vehicle Number" />
                            <x-text-input id="vehicle_number" name="vehicle_number" class="mt-1 block w-full" value="{{ old('vehicle_number', $delivery->vehicle_number) }}" />
                        </div>
                        <div>
                            <x-input-label for="warehouse_id" value="Assigned Warehouse" />
                            <select id="warehouse_id" name="warehouse_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500">
                                <option value="">— None —</option>
                                @foreach($warehouses as $wh)
                                <option value="{{ $wh->id }}" {{ old('warehouse_id', $delivery->warehouse_id) == $wh->id ? 'selected' : '' }}>{{ $wh->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <x-input-label for="status" value="Status" />
                            <select id="status" name="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500">
                                @foreach(['pending' => 'Pending', 'in_transit' => 'In Transit', 'delivered' => 'Delivered', 'failed' => 'Failed'] as $val => $label)
                                <option value="{{ $val }}" {{ old('status', $delivery->status) === $val ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <x-input-label for="weight_kg" value="Weight (kg)" />
                            <x-text-input type="number" step="0.01" id="weight_kg" name="weight_kg" class="mt-1 block w-full" value="{{ old('weight_kg', $delivery->weight_kg) }}" />
                        </div>
                        <div>
                            <x-input-label for="eta" value="ETA (Date & Time)" />
                            <x-text-input type="datetime-local" id="eta" name="eta" class="mt-1 block w-full" value="{{ old('eta', $delivery->eta ? $delivery->eta->format('Y-m-d\TH:i') : '') }}" />
                        </div>
                    </div>
                    <div>
                        <x-input-label for="notes" value="Notes" />
                        <textarea id="notes" name="notes" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500">{{ old('notes', $delivery->notes) }}</textarea>
                    </div>
                    <div class="flex justify-end gap-3">
                        <a href="{{ route('logistics.index') }}" class="px-4 py-2 text-sm bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition">Cancel</a>
                        <x-primary-button>Update Delivery</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
