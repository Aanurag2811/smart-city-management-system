<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-green-400">🔔 Notifications & Alerts</h2>
            <div class="flex gap-2">
                @if($unreadCount > 0)
                <form method="POST" action="{{ route('notifications.readAll') }}">
                    @csrf
                    <button type="submit" class="px-4 py-2 border border-gray-600 hover:border-green-500 text-gray-400 hover:text-green-400 text-sm font-semibold rounded-lg transition">
                        ✓ Mark All Read
                    </button>
                </form>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-4">

            @if(session('success'))
                <div class="bg-green-50 border border-green-300 text-green-800 px-4 py-3 rounded-lg">{{ session('success') }}</div>
            @endif

            {{-- Summary Bar --}}
            <div class="flex gap-4 text-sm">
                <span class="px-3 py-1 bg-gray-100 rounded-full text-gray-700 font-medium">Total: {{ $notifications->count() }}</span>
                <span class="px-3 py-1 bg-red-100 rounded-full text-red-700 font-medium">Unread: {{ $unreadCount }}</span>
                <span class="px-3 py-1 bg-orange-100 rounded-full text-orange-700 font-medium">Critical: {{ $criticalCount }}</span>
            </div>

            {{-- Notification Cards --}}
            @forelse($notifications as $notification)
            <div class="bg-white rounded-xl shadow-sm overflow-hidden border-l-4
                {{ $notification->severity === 'critical' ? 'border-red-500' : ($notification->severity === 'warning' ? 'border-yellow-500' : 'border-blue-400') }}
                {{ !$notification->is_read ? 'ring-1 ring-offset-1 ring-gray-200' : 'opacity-75' }}">
                <div class="p-5 flex items-start justify-between gap-4">
                    <div class="flex items-start gap-3 flex-1">
                        <span class="text-xl mt-0.5">{{ $notification->severity_icon }}</span>
                        <div class="flex-1">
                            <div class="flex items-center gap-2 flex-wrap">
                                <h4 class="font-bold text-gray-900">{{ $notification->title }}</h4>
                                @if(!$notification->is_read)
                                <span class="px-1.5 py-0.5 text-xs bg-blue-100 text-blue-700 rounded font-semibold">NEW</span>
                                @endif
                                <span class="px-2 py-0.5 text-xs rounded-full font-semibold
                                    {{ $notification->severity === 'critical' ? 'bg-red-100 text-red-700' : ($notification->severity === 'warning' ? 'bg-yellow-100 text-yellow-700' : 'bg-blue-100 text-blue-700') }}">
                                    {{ ucfirst($notification->severity) }}
                                </span>
                                @if($notification->module)
                                <span class="px-2 py-0.5 text-xs rounded-full bg-gray-100 text-gray-600 font-semibold">{{ ucfirst($notification->module) }}</span>
                                @endif
                            </div>
                            <p class="text-sm text-gray-600 mt-1">{{ $notification->message }}</p>
                            <p class="text-xs text-gray-400 mt-2">{{ $notification->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 flex-shrink-0">
                        @if(!$notification->is_read)
                        <form method="POST" action="{{ route('notifications.read', $notification) }}">
                            @csrf @method('PATCH')
                            <button type="submit" class="text-xs px-3 py-1.5 bg-green-100 hover:bg-green-200 text-green-700 rounded-lg transition">Mark Read</button>
                        </form>
                        @endif
                        <form method="POST" action="{{ route('notifications.destroy', $notification) }}" onsubmit="return confirm('Delete notification?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-xs px-3 py-1.5 bg-red-100 hover:bg-red-200 text-red-700 rounded-lg transition">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
            @empty
            <div class="bg-white rounded-xl shadow-sm p-12 text-center">
                <div class="text-4xl mb-3">✅</div>
                <h3 class="text-lg font-semibold text-gray-700">No Notifications</h3>
                <p class="text-sm text-gray-400 mt-1">All systems are operating normally.</p>
            </div>
            @endforelse
        </div>
    </div>
</x-app-layout>
