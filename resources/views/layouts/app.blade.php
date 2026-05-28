<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'SmartCity') }} — @yield('title', 'Dashboard')</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts & Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            /* Toast notifications */
            #toast-container{position:fixed;top:1rem;right:1rem;z-index:9999;display:flex;flex-direction:column;gap:0.5rem}
            .toast{display:flex;align-items:center;gap:0.75rem;padding:0.75rem 1.25rem;border-radius:0.75rem;box-shadow:0 4px 16px rgba(0,0,0,0.15);font-size:0.875rem;font-weight:500;min-width:260px;max-width:380px;animation:slideIn 0.3s ease}
            .toast-critical{background:#fef2f2;border-left:4px solid #ef4444;color:#991b1b}
            .toast-warning{background:#fffbeb;border-left:4px solid #f59e0b;color:#92400e}
            .toast-info{background:#f0fdf4;border-left:4px solid #22c55e;color:#15803d}
            @keyframes slideIn{from{opacity:0;transform:translateX(100%)}to{opacity:1;transform:translateX(0)}}
            @keyframes livePulse{0%,100%{transform:scale(1);opacity:1}50%{transform:scale(1.5);opacity:0.6}}
        </style>
    </head>
    <body class="font-sans antialiased bg-gray-50">
        <div class="min-h-screen">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-gray-900 shadow-sm border-b border-gray-800">
                    <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                        <div class="text-white">{{ $header }}</div>
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        <!-- Toast container for live alerts -->
        <div id="toast-container"></div>

        <!-- Global AJAX polling: notification badge + critical alert toasts -->
        <script>
        (function () {
            const badge  = document.getElementById('notif-badge');
            let lastCount = badge ? parseInt(badge.textContent) || 0 : 0;
            let shownIds  = new Set();

            function showToast(alert) {
                if (shownIds.has(alert.id)) return;
                shownIds.add(alert.id);
                const cls = alert.severity === 'critical' ? 'toast-critical' : alert.severity === 'warning' ? 'toast-warning' : 'toast-info';
                const icon = alert.severity === 'critical' ? '🚨' : alert.severity === 'warning' ? '⚠️' : 'ℹ️';
                const el = document.createElement('div');
                el.className = 'toast ' + cls;
                el.innerHTML = `<span>${icon}</span><div><strong>${alert.title}</strong><p style="font-weight:400;margin:0;font-size:0.8rem">${alert.message.slice(0,80)}${alert.message.length>80?'…':''}</p></div>`;
                const container = document.getElementById('toast-container');
                container.appendChild(el);
                setTimeout(() => el.remove(), 6000);
            }

            function pollNotifications() {
                fetch('/api/notifications/live', {
                    headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
                })
                .then(r => r.ok ? r.json() : null)
                .then(data => {
                    if (!data) return;
                    const count = data.unread_count;
                    if (badge) {
                        badge.textContent = count > 9 ? '9+' : count;
                        badge.className = badge.className.replace('hidden','').replace('flex','').trim();
                        badge.classList.add(count > 0 ? 'flex' : 'hidden');
                    }
                    if (data.alerts && count > lastCount) {
                        data.alerts.forEach(a => showToast(a));
                    }
                    lastCount = count;
                })
                .catch(() => {});
            }

            setTimeout(pollNotifications, 5000);
            setInterval(pollNotifications, 30000);
        })();
        </script>

        @stack('scripts')
    </body>
</html>
