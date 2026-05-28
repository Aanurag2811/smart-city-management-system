<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('resources.index') }}" class="text-gray-400 hover:text-green-400 transition">← Back</a>
            <h2 class="font-semibold text-xl text-green-400">Edit Resource</h2>
        </div>
    </x-slot>
    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 bg-green-50">
                    <h3 class="font-bold text-green-800">✏️ Edit: {{ ucfirst($resource->type) }} — {{ $resource->sector }}</h3>
                </div>
                <form method="POST" action="{{ route('resources.update', $resource) }}" class="p-6 space-y-5">
                    @csrf @method('PATCH')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <x-input-label for="type" value="Resource Type" />
                            <select id="type" name="type" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500" required>
                                @foreach(['water' => '💧 Water', 'electricity' => '⚡ Electricity', 'waste' => '🗑️ Waste'] as $val => $label)
                                <option value="{{ $val }}" {{ old('type', $resource->type) === $val ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <x-input-label for="sector" value="Sector" />
                            <x-text-input id="sector" name="sector" class="mt-1 block w-full" value="{{ old('sector', $resource->sector) }}" required />
                        </div>
                        <div class="md:col-span-2">
                            <x-input-label for="location" value="Location" />
                            <x-text-input id="location" name="location" class="mt-1 block w-full" value="{{ old('location', $resource->location) }}" required />
                        </div>
                        <div>
                            <x-input-label for="current_usage" value="Current Usage" />
                            <x-text-input type="number" step="0.01" id="current_usage" name="current_usage" class="mt-1 block w-full" value="{{ old('current_usage', $resource->current_usage) }}" required />
                        </div>
                        <div>
                            <x-input-label for="unit" value="Unit" />
                            <x-text-input id="unit" name="unit" class="mt-1 block w-full" value="{{ old('unit', $resource->unit) }}" required />
                        </div>
                        <div>
                            <x-input-label for="alert_threshold" value="Alert Threshold" />
                            <x-text-input type="number" step="0.01" id="alert_threshold" name="alert_threshold" class="mt-1 block w-full" value="{{ old('alert_threshold', $resource->alert_threshold) }}" />
                        </div>
                        <div>
                            <x-input-label for="status" value="Status" />
                            <select id="status" name="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500">
                                @foreach(['normal', 'warning', 'critical'] as $s)
                                <option value="{{ $s }}" {{ old('status', $resource->status) === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="md:col-span-2">
                            <x-input-label for="description" value="Description" />
                            <textarea id="description" name="description" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500">{{ old('description', $resource->description) }}</textarea>
                        </div>
                    </div>
                    <div class="flex justify-end gap-3">
                        <a href="{{ route('resources.index') }}" class="px-4 py-2 text-sm bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition">Cancel</a>
                        <x-primary-button>Update Resource</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
