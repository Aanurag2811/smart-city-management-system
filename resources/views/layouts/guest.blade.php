<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'SmartCity') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen flex">
            {{-- Left panel — black branding --}}
            <div class="hidden lg:flex lg:w-5/12 xl:w-1/2 bg-gray-900 flex-col justify-between p-10" style="background:#0d1117">
                <div>
                    <a href="/" class="flex items-center gap-3 text-white mb-12">
                        <div style="width:40px;height:40px;background:#16a34a;border-radius:10px;display:flex;align-items:center;justify-content:center">
                            <svg width="22" height="22" fill="none" stroke="white" viewBox="0 0 24 24" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064"/>
                            </svg>
                        </div>
                        <span style="font-size:1.25rem;font-weight:800;letter-spacing:-0.02em">Smart<span style="color:#4ade80">City</span></span>
                    </a>

                    <h2 style="font-size:1.75rem;font-weight:800;color:#f9fafb;line-height:1.2;margin-bottom:1rem;letter-spacing:-0.02em">
                        Intelligent<br>Urban Management
                    </h2>
                    <p style="color:#9ca3af;font-size:0.95rem;line-height:1.7;max-width:340px">
                        Real-time transport monitoring, delivery logistics, resource consumption analytics, and smart city-wide alerts — all in one platform.
                    </p>

                    {{-- Feature list --}}
                    <div style="margin-top:2.5rem;display:flex;flex-direction:column;gap:1rem">
                        @foreach([['🚦','Transport routes & live traffic'],['🚚','Logistics & delivery tracking'],['⚡','Resource consumption analytics'],['🔔','Smart alerts & notifications']] as $feat)
                        <div style="display:flex;align-items:center;gap:12px">
                            <div style="width:36px;height:36px;background:rgba(22,163,74,0.15);border:1px solid rgba(74,222,128,0.2);border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:1rem;flex-shrink:0">{{ $feat[0] }}</div>
                            <span style="color:#d1d5db;font-size:0.9rem;font-weight:500">{{ $feat[1] }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Terminal snippet --}}
                <div style="background:#161b22;border:1px solid #30363d;border-radius:10px;overflow:hidden;margin-top:2rem">
                    <div style="background:#21262d;padding:0.5rem 0.85rem;display:flex;align-items:center;gap:0.4rem;border-bottom:1px solid #30363d">
                        <span style="width:10px;height:10px;border-radius:50%;background:#f97316"></span>
                        <span style="width:10px;height:10px;border-radius:50%;background:#eab308"></span>
                        <span style="width:10px;height:10px;border-radius:50%;background:#22c55e"></span>
                    </div>
                    <div style="padding:1rem 1.1rem;font-family:'Courier New',monospace;font-size:0.78rem;line-height:1.7;color:#8b949e">
                        <div><span style="color:#4ade80">$</span> <span style="color:#f9fafb">smartcity --status</span></div>
                        <div><span style="color:#4ade80">[OK]</span> All systems operational</div>
                        <div><span style="color:#60a5fa">→</span> Dashboard ready for access</div>
                    </div>
                </div>
            </div>

            {{-- Right panel — form --}}
            <div class="flex-1 flex flex-col justify-center items-center px-6 py-12 bg-gray-50">
                {{-- Mobile logo --}}
                <div class="lg:hidden mb-8">
                    <a href="/" class="flex items-center gap-3">
                        <div style="width:40px;height:40px;background:#16a34a;border-radius:10px;display:flex;align-items:center;justify-content:center">
                            <svg width="22" height="22" fill="none" stroke="white" viewBox="0 0 24 24" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064"/>
                            </svg>
                        </div>
                        <span style="font-size:1.2rem;font-weight:800;color:#111827">Smart<span style="color:#16a34a">City</span></span>
                    </a>
                </div>

                <div class="w-full max-w-md">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 px-8 py-8">
                        {{ $slot }}
                    </div>
                    <p class="text-center text-xs text-gray-400 mt-5">
                        <a href="/" class="hover:text-green-600 transition">← Back to Home</a>
                    </p>
                </div>
            </div>
        </div>
    </body>
</html>
