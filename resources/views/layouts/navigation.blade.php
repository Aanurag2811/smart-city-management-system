<nav x-data="{ open: false }" class="border-b border-gray-800" style="background:#0d1117">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5">
                        <div style="width:32px;height:32px;background:#16a34a;border-radius:7px;display:flex;align-items:center;justify-content:center;flex-shrink:0">
                            <svg width="18" height="18" fill="none" stroke="white" viewBox="0 0 24 24" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064"/>
                            </svg>
                        </div>
                        <span class="font-bold text-sm" style="color:#f9fafb;letter-spacing:-0.01em">Smart<span style="color:#4ade80">City</span></span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-1 sm:-my-px sm:ms-8 sm:flex items-center">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        Dashboard
                    </x-nav-link>

                    @if(in_array(Auth::user()->role, ['admin', 'transport_manager']))
                    <x-nav-link :href="route('transport.index')" :active="request()->routeIs('transport.*')">
                        🚦 Transport
                    </x-nav-link>
                    @endif

                    @if(in_array(Auth::user()->role, ['admin', 'logistics_manager']))
                    <x-nav-link :href="route('logistics.index')" :active="request()->routeIs('logistics.*')">
                        🚚 Logistics
                    </x-nav-link>
                    @endif

                    @if(in_array(Auth::user()->role, ['admin', 'citizen']))
                    <x-nav-link :href="route('resources.index')" :active="request()->routeIs('resources.*')">
                        ⚡ Resources
                    </x-nav-link>
                    @endif

                    <x-nav-link :href="route('map.index')" :active="request()->routeIs('map.*')">
                        🗺️ Map
                    </x-nav-link>

                    @if(Auth::user()->role === 'admin')
                    <x-nav-link :href="route('analytics.index')" :active="request()->routeIs('analytics.*')">
                        📊 Analytics
                    </x-nav-link>
                    @endif
                </div>
            </div>

            <!-- Right side: Notifications + User -->
            <div class="hidden sm:flex sm:items-center sm:ms-6 gap-3">
                <!-- Notification Bell -->
                <a href="{{ route('notifications.index') }}" id="notif-bell" class="relative p-2 rounded-lg transition" style="color:#9ca3af" onmouseover="this.style.color='#4ade80'" onmouseout="this.style.color='#9ca3af'">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    <span id="notif-badge" class="absolute top-1 right-1 w-4 h-4 bg-red-500 rounded-full text-white text-xs items-center justify-center {{ \App\Models\SmartNotification::where('is_read', false)->count() > 0 ? 'flex' : 'hidden' }}">
                        {{ \App\Models\SmartNotification::where('is_read', false)->count() > 9 ? '9+' : \App\Models\SmartNotification::where('is_read', false)->count() }}
                    </span>
                </a>

                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-1.5 border border-gray-700 text-sm leading-4 font-medium rounded-lg transition" style="color:#d1d5db;background:transparent" onmouseover="this.style.borderColor='#4ade80';this.style.color='#4ade80'" onmouseout="this.style.borderColor='#374151';this.style.color='#d1d5db'">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        <div class="px-4 py-2 text-xs text-gray-500 border-b border-gray-100">
                            {{ Auth::user()->email }}
                            <span class="block capitalize font-semibold text-green-600">{{ str_replace('_', ' ', Auth::user()->role) }}</span>
                        </div>
                        <x-dropdown-link :href="route('profile.edit')">Profile</x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                Log Out
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md transition" style="color:#9ca3af">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden" style="background:#0d1117;border-top:1px solid #1f2937">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">Dashboard</x-responsive-nav-link>
            @if(in_array(Auth::user()->role, ['admin', 'transport_manager']))
            <x-responsive-nav-link :href="route('transport.index')" :active="request()->routeIs('transport.*')">🚦 Transport</x-responsive-nav-link>
            @endif
            @if(in_array(Auth::user()->role, ['admin', 'logistics_manager']))
            <x-responsive-nav-link :href="route('logistics.index')" :active="request()->routeIs('logistics.*')">🚚 Logistics</x-responsive-nav-link>
            @endif
            @if(in_array(Auth::user()->role, ['admin', 'citizen']))
            <x-responsive-nav-link :href="route('resources.index')" :active="request()->routeIs('resources.*')">⚡ Resources</x-responsive-nav-link>
            @endif
            <x-responsive-nav-link :href="route('map.index')" :active="request()->routeIs('map.*')">🗺️ Map</x-responsive-nav-link>
            @if(Auth::user()->role === 'admin')
            <x-responsive-nav-link :href="route('analytics.index')" :active="request()->routeIs('analytics.*')">📊 Analytics</x-responsive-nav-link>
            @endif
        </div>
        <div class="pt-4 pb-1 border-t border-gray-800">
            <div class="px-4">
                <div class="font-medium text-base" style="color:#f9fafb">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm" style="color:#6b7280">{{ Auth::user()->email }}</div>
                <div class="text-xs mt-0.5 font-semibold capitalize" style="color:#4ade80">{{ str_replace('_', ' ', Auth::user()->role) }}</div>
            </div>
            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">Profile</x-responsive-nav-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">Log Out</x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
