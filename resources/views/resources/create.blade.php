<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('resources.index') }}" class="text-gray-400 hover:text-green-400 transition">← Back</a>
            <h2 class="font-semibold text-xl text-green-400">Add Resource</h2>
        </div>
    </x-slot>
    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 bg-yellow-50">
                    <h3 class="font-bold text-yellow-700">⚡ New Resource Monitor</h3>
                </div>
                <form method="POST" action="{{ route('resources.store') }}" class="p-6 space-y-5">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <x-input-label for="type" value="Resource Type" />
                            <select id="type" name="type" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500" required>
                                <option value="">— Select Type —</option>
                                <option value="water" {{ old('type') === 'water' ? 'selected' : '' }}>💧 Water</option>
                                <option value="electricity" {{ old('type') === 'electricity' ? 'selected' : '' }}>⚡ Electricity</option>
                                <option value="waste" {{ old('type') === 'waste' ? 'selected' : '' }}>🗑️ Waste</option>
                            </select>
                            <x-input-error :messages="$errors->get('type')" class="mt-1" />
                        </div>
                        <div>
                            <x-input-label for="sector" value="Sector" />
                            <x-text-input id="sector" name="sector" class="mt-1 block w-full" value="{{ old('sector') }}" required placeholder="e.g. Sector 1" />
                        </div>
                        <div class="md:col-span-2">
                            <x-input-label for="location" value="Location" />
                            <x-text-input id="location" name="location" class="mt-1 block w-full" value="{{ old('location') }}" required placeholder="e.g. North Residential Zone" />
                        </div>
                        <div>
                            <x-input-label for="current_usage" value="Current Usage" />
                            <x-text-input type="number" step="0.01" id="current_usage" name="current_usage" class="mt-1 block w-full" value="{{ old('current_usage', 0) }}" min="0" required />
                        </div>
                        <div>
                            <x-input-label for="unit" value="Unit (e.g. Litres, kWh, Tons)" />
                            <x-text-input id="unit" name="unit" class="mt-1 block w-full" value="{{ old('unit') }}" required placeholder="e.g. Litres" />
                        </div>
                        <div>
                            <x-input-label for="alert_threshold" value="Alert Threshold (optional)" />
                            <x-text-input type="number" step="0.01" id="alert_threshold" name="alert_threshold" class="mt-1 block w-full" value="{{ old('alert_threshold') }}" min="0" />
                        </div>
                        <div>
                            <x-input-label for="status" value="Status" />
                            <select id="status" name="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500">
                                <option value="normal" {{ old('status') === 'normal' ? 'selected' : '' }}>Normal</option>
                                <option value="warning" {{ old('status') === 'warning' ? 'selected' : '' }}>Warning</option>
                                <option value="critical" {{ old('status') === 'critical' ? 'selected' : '' }}>Critical</option>
                            </select>
                        </div>
                        <div class="md:col-span-2">
                            <x-input-label for="description" value="Description" />
                            <textarea id="description" name="description" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500">{{ old('description') }}</textarea>
                        </div>
                    </div>
                    <div class="flex justify-end gap-3">
                        <a href="{{ route('resources.index') }}" class="px-4 py-2 text-sm bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition">Cancel</a>
                        <x-primary-button>Add Resource</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
