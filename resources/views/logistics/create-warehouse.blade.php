<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('logistics.warehouses') }}" class="text-gray-400 hover:text-green-400 transition">← Back</a>
            <h2 class="font-semibold text-xl text-green-400">Add Warehouse</h2>
        </div>
    </x-slot>
    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 bg-purple-50">
                    <h3 class="font-bold text-purple-700">🏬 New Warehouse</h3>
                </div>
                <form method="POST" action="{{ route('logistics.warehouses.store') }}" class="p-6 space-y-5">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="md:col-span-2">
                            <x-input-label for="name" value="Warehouse Name" />
                            <x-text-input id="name" name="name" class="mt-1 block w-full" value="{{ old('name') }}" required />
                        </div>
                        <div>
                            <x-input-label for="location" value="Location / Address" />
                            <x-text-input id="location" name="location" class="mt-1 block w-full" value="{{ old('location') }}" required />
                        </div>
                        <div>
                            <x-input-label for="zone" value="Zone" />
                            <select id="zone" name="zone" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500">
                                <option value="">— Select Zone —</option>
                                @foreach(['North', 'South', 'East', 'West', 'Central'] as $z)
                                <option value="{{ $z }}" {{ old('zone') === $z ? 'selected' : '' }}>{{ $z }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <x-input-label for="capacity" value="Max Capacity (units)" />
                            <x-text-input type="number" id="capacity" name="capacity" class="mt-1 block w-full" value="{{ old('capacity', 1000) }}" min="1" required />
                        </div>
                        <div>
                            <x-input-label for="current_load" value="Current Load (units)" />
                            <x-text-input type="number" id="current_load" name="current_load" class="mt-1 block w-full" value="{{ old('current_load', 0) }}" min="0" required />
                        </div>
                        <div>
                            <x-input-label for="status" value="Status" />
                            <select id="status" name="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500">
                                @foreach(['operational' => 'Operational', 'full' => 'Full', 'maintenance' => 'Under Maintenance'] as $val => $label)
                                <option value="{{ $val }}" {{ old('status') === $val ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <x-input-label for="manager_name" value="Manager Name" />
                            <x-text-input id="manager_name" name="manager_name" class="mt-1 block w-full" value="{{ old('manager_name') }}" />
                        </div>
                        <div>
                            <x-input-label for="contact_number" value="Contact Number" />
                            <x-text-input id="contact_number" name="contact_number" class="mt-1 block w-full" value="{{ old('contact_number') }}" />
                        </div>
                    </div>
                    <div class="flex justify-end gap-3">
                        <a href="{{ route('logistics.warehouses') }}" class="px-4 py-2 text-sm bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition">Cancel</a>
                        <x-primary-button>Add Warehouse</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
