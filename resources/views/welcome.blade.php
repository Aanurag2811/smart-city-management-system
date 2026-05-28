<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SmartCity — Intelligent Urban Management</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    <style>
        *{box-sizing:border-box;margin:0;padding:0}
        body{font-family:'Figtree',sans-serif;background:#f9fafb;color:#111827}

        /* Nav */
        .home-nav{background:#0d1117;border-bottom:1px solid #1f2937}
        .home-nav-inner{max-width:1200px;margin:0 auto;padding:0 1.5rem;display:flex;justify-content:space-between;align-items:center;height:64px}
        .home-logo{display:flex;align-items:center;gap:10px;text-decoration:none}
        .home-logo-icon{width:36px;height:36px;background:#16a34a;border-radius:8px;display:flex;align-items:center;justify-content:center}
        .home-logo-text{font-size:1.1rem;font-weight:800;color:#f9fafb;letter-spacing:-0.02em}
        .home-logo-text span{color:#4ade80}
        .home-nav-links{display:flex;align-items:center;gap:0.75rem}
        .btn-outline{padding:0.45rem 1.1rem;border:1px solid #374151;color:#d1d5db;border-radius:8px;text-decoration:none;font-size:0.875rem;font-weight:500;transition:all 0.15s}
        .btn-outline:hover{border-color:#4ade80;color:#4ade80}
        .btn-green-sm{padding:0.45rem 1.25rem;background:#16a34a;color:#fff;border-radius:8px;text-decoration:none;font-size:0.875rem;font-weight:600;transition:background 0.15s}
        .btn-green-sm:hover{background:#15803d}

        /* Hero */
        .hero{background:#0d1117;padding:6rem 1.5rem 5rem;text-align:center;position:relative;overflow:hidden}
        .hero::before{content:'';position:absolute;inset:0;background:radial-gradient(ellipse at 50% 0%,rgba(22,163,74,0.18) 0%,transparent 60%);pointer-events:none}
        .hero-badge{display:inline-flex;align-items:center;gap:6px;background:rgba(22,163,74,0.12);border:1px solid rgba(74,222,128,0.3);color:#4ade80;font-size:0.78rem;font-weight:700;padding:0.3rem 0.9rem;border-radius:999px;margin-bottom:1.75rem;letter-spacing:0.05em;text-transform:uppercase}
        .hero-badge .dot{width:6px;height:6px;background:#4ade80;border-radius:50%;animation:blink 1.5s ease-in-out infinite}
        @keyframes blink{0%,100%{opacity:1}50%{opacity:0.3}}
        .hero h1{font-size:clamp(2.2rem,5vw,3.75rem);font-weight:800;color:#f9fafb;line-height:1.1;letter-spacing:-0.03em;margin-bottom:1.25rem}
        .hero h1 .hl{color:#4ade80}
        .hero p{font-size:1.05rem;color:#9ca3af;max-width:600px;margin:0 auto 2.5rem;line-height:1.7}
        .hero-cta{display:flex;gap:1rem;justify-content:center;flex-wrap:wrap}
        .btn-hero-primary{padding:0.85rem 2rem;background:#16a34a;color:#fff;border-radius:10px;text-decoration:none;font-size:1rem;font-weight:700;transition:all 0.15s;display:inline-flex;align-items:center;gap:8px}
        .btn-hero-primary:hover{background:#15803d;transform:translateY(-1px)}
        .btn-hero-secondary{padding:0.85rem 2rem;background:transparent;color:#d1d5db;border:1px solid #374151;border-radius:10px;text-decoration:none;font-size:1rem;font-weight:600;transition:all 0.15s}
        .btn-hero-secondary:hover{border-color:#4ade80;color:#4ade80}

        /* Terminal */
        .terminal-wrap{max-width:680px;margin:3.5rem auto 0}
        .terminal{background:#161b22;border:1px solid #30363d;border-radius:12px;overflow:hidden;text-align:left;box-shadow:0 20px 60px rgba(0,0,0,0.5)}
        .terminal-bar{background:#21262d;padding:0.65rem 1rem;display:flex;align-items:center;gap:0.5rem;border-bottom:1px solid #30363d}
        .dot{width:12px;height:12px;border-radius:50%}
        .dot-r{background:#f97316}.dot-y{background:#eab308}.dot-g{background:#22c55e}
        .t-title{font-size:0.8rem;color:#8b949e;margin:0 auto}
        .terminal-body{padding:1.25rem 1.5rem;font-family:'Courier New',monospace;font-size:0.85rem;line-height:1.8}
        .t-p{color:#4ade80}.t-c{color:#f9fafb}.t-o{color:#8b949e}.t-v{color:#60a5fa}.t-ok{color:#4ade80}.t-w{color:#fbbf24}
        .t-cursor{display:inline-block;width:9px;height:16px;background:#4ade80;vertical-align:middle;animation:cur 1s step-end infinite}
        @keyframes cur{0%,100%{opacity:1}50%{opacity:0}}

        /* Stats */
        .stats-bar{background:#fff;border-top:1px solid #e5e7eb;border-bottom:1px solid #e5e7eb;padding:2.5rem 1.5rem}
        .stats-inner{max-width:1200px;margin:0 auto;display:grid;grid-template-columns:repeat(auto-fit,minmax(150px,1fr));gap:2rem;text-align:center}
        .stat-num{font-size:2.25rem;font-weight:800;color:#111827;line-height:1}
        .stat-num span{color:#16a34a}
        .stat-lbl{font-size:0.875rem;color:#6b7280;margin-top:0.35rem}

        /* Features */
        .features-section{padding:5rem 1.5rem;max-width:1200px;margin:0 auto}
        .sec-label{font-size:0.78rem;font-weight:700;color:#16a34a;text-transform:uppercase;letter-spacing:0.1em;margin-bottom:0.75rem}
        .sec-title{font-size:clamp(1.6rem,3vw,2.4rem);font-weight:800;color:#111827;line-height:1.2;letter-spacing:-0.02em;margin-bottom:1rem}
        .sec-sub{font-size:1rem;color:#6b7280;max-width:560px;line-height:1.65}
        .features-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(280px,1fr));gap:1.5rem;margin-top:3rem}
        .feature-card{background:#fff;border:1px solid #e5e7eb;border-radius:14px;padding:1.75rem;transition:box-shadow 0.2s,border-color 0.2s;position:relative;overflow:hidden}
        .feature-card::before{content:'';position:absolute;top:0;left:0;right:0;height:3px;background:#16a34a;border-radius:14px 14px 0 0}
        .feature-card:hover{box-shadow:0 8px 30px rgba(0,0,0,0.08);border-color:#bbf7d0}
        .feat-icon{width:44px;height:44px;background:#f0fdf4;border:1px solid #bbf7d0;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:1.3rem;margin-bottom:1rem}
        .feat-title{font-size:1rem;font-weight:700;color:#111827;margin-bottom:0.5rem}
        .feat-desc{font-size:0.875rem;color:#6b7280;line-height:1.6}
        .feat-tags{display:flex;flex-wrap:wrap;gap:0.4rem;margin-top:1rem}
        .tag{font-size:0.72rem;font-weight:600;padding:0.2rem 0.6rem;border-radius:999px;background:#f0fdf4;color:#16a34a;border:1px solid #bbf7d0}

        /* CTA */
        .cta-section{background:#0d1117;padding:5rem 1.5rem;text-align:center;position:relative;overflow:hidden}
        .cta-section::before{content:'';position:absolute;inset:0;background:radial-gradient(ellipse at 50% 100%,rgba(22,163,74,0.15) 0%,transparent 60%);pointer-events:none}
        .cta-section h2{font-size:clamp(1.8rem,3.5vw,2.75rem);font-weight:800;color:#f9fafb;letter-spacing:-0.02em;margin-bottom:1rem;position:relative}
        .cta-section p{color:#9ca3af;font-size:1rem;margin-bottom:2rem;max-width:500px;margin-left:auto;margin-right:auto;position:relative}
        .cta-btns{display:flex;gap:1rem;justify-content:center;flex-wrap:wrap;position:relative}

        /* Footer */
        .home-footer{background:#0d1117;border-top:1px solid #1f2937;padding:1.5rem;text-align:center}
        .home-footer p{font-size:0.8rem;color:#6b7280}
        .home-footer span{color:#4ade80}

        @media(max-width:640px){.home-nav-links .btn-outline{display:none}.terminal-wrap{margin-top:2.5rem}}
    </style>
</head>
<body>

    {{-- Navigation --}}
    <nav class="home-nav">
        <div class="home-nav-inner">
            <a href="/" class="home-logo">
                <div class="home-logo-icon">
                    <svg width="20" height="20" fill="none" stroke="white" viewBox="0 0 24 24" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064"/>
                    </svg>
                </div>
                <span class="home-logo-text">Smart<span>City</span></span>
            </a>
            <div class="home-nav-links">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn-green-sm">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="btn-outline">Log in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn-green-sm">Get Started</a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>
    </nav>

    {{-- Hero --}}
    <section class="hero">
        <div class="hero-badge"><span class="dot"></span> Live System Active</div>
        <h1>Manage Your City<br>with <span class="hl">Smart Intelligence</span></h1>
        <p>A unified platform for real-time transport monitoring, logistics delivery tracking, resource consumption analytics, and intelligent city-wide alerts.</p>
        <div class="hero-cta">
            @auth
                <a href="{{ url('/dashboard') }}" class="btn-hero-primary">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                    Go to Dashboard
                </a>
            @else
                <a href="{{ route('login') }}" class="btn-hero-primary">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                    Login to Platform
                </a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="btn-hero-secondary">Create Account</a>
                @endif
            @endauth
        </div>

        {{-- Terminal mockup --}}
        <div class="terminal-wrap">
            <div class="terminal">
                <div class="terminal-bar">
                    <span class="dot dot-r"></span>
                    <span class="dot dot-y"></span>
                    <span class="dot dot-g"></span>
                    <span class="t-title">smartcity — live-monitor</span>
                </div>
                <div class="terminal-body">
                    <div><span class="t-p">smartcity</span><span class="t-o">:</span><span class="t-v">~</span><span class="t-o">$ </span><span class="t-c">./monitor --live --all-modules</span></div>
                    <div class="t-o">[<span class="t-ok">OK</span>]  Connected to SmartCity core v2.1.0</div>
                    <div class="t-o">[<span class="t-ok">OK</span>]  Loading city metrics...</div>
                    <div style="margin-top:0.4rem;border-top:1px solid #30363d;padding-top:0.5rem">
                        <div class="t-o">  Routes active   <span class="t-v">24</span>   &nbsp;Congested   <span class="t-w">3</span></div>
                        <div class="t-o">  Deliveries      <span class="t-v">18</span>   &nbsp;Pending     <span class="t-v">5</span></div>
                        <div class="t-o">  Fleet on road   <span class="t-v">12/20</span>  vehicles</div>
                        <div class="t-o">  Alerts          <span class="t-w">2</span>  critical, <span class="t-v">4</span> warnings</div>
                        <div class="t-o">  Resources       <span class="t-ok">Normal</span> — all systems green</div>
                    </div>
                    <div style="margin-top:0.5rem"><span class="t-p">smartcity</span><span class="t-o">:</span><span class="t-v">~</span><span class="t-o">$ </span><span class="t-cursor"></span></div>
                </div>
            </div>
        </div>
    </section>

    {{-- Stats --}}
    <div class="stats-bar">
        <div class="stats-inner">
            <div>
                <div class="stat-num">24<span>/7</span></div>
                <div class="stat-lbl">Real-Time Monitoring</div>
            </div>
            <div>
                <div class="stat-num"><span>6</span></div>
                <div class="stat-lbl">Platform Modules</div>
            </div>
            <div>
                <div class="stat-num"><span>5</span></div>
                <div class="stat-lbl">Role-Based Access Levels</div>
            </div>
            <div>
                <div class="stat-num"><span>∞</span></div>
                <div class="stat-lbl">Live Data Streams</div>
            </div>
        </div>
    </div>

    {{-- Features --}}
    <section class="features-section">
        <div class="sec-label">Platform Modules</div>
        <div class="sec-title">Everything your city needs,<br>in one place.</div>
        <div class="sec-sub">From live traffic signals to warehouse capacity — SmartCity gives every operator, manager and analyst the tools they need.</div>
        <div class="features-grid">
            <div class="feature-card">
                <div class="feat-icon">🚦</div>
                <div class="feat-title">Transport Management</div>
                <div class="feat-desc">Monitor live traffic levels across all city routes, manage fleet vehicles, and track congestion in real time with visual charts.</div>
                <div class="feat-tags">
                    <span class="tag">Live Traffic</span><span class="tag">Fleet Status</span><span class="tag">Route Planning</span>
                </div>
            </div>
            <div class="feature-card">
                <div class="feat-icon">🚚</div>
                <div class="feat-title">Logistics & Deliveries</div>
                <div class="feat-desc">Track every delivery from dispatch to destination, manage warehouse capacity, and monitor driver activity across the city.</div>
                <div class="feat-tags">
                    <span class="tag">Delivery Tracking</span><span class="tag">Warehouses</span><span class="tag">ETA</span>
                </div>
            </div>
            <div class="feature-card">
                <div class="feat-icon">⚡</div>
                <div class="feat-title">Resource Management</div>
                <div class="feat-desc">Analyze water, electricity and waste consumption trends. Get instant alerts when resources reach critical thresholds.</div>
                <div class="feat-tags">
                    <span class="tag">Water</span><span class="tag">Electricity</span><span class="tag">Waste</span>
                </div>
            </div>
            <div class="feature-card">
                <div class="feat-icon">🗺️</div>
                <div class="feat-title">Live City Map</div>
                <div class="feat-desc">Interactive map showing vehicle positions, delivery routes, resource zones and traffic hotspots across the entire city.</div>
                <div class="feat-tags">
                    <span class="tag">Interactive</span><span class="tag">GPS Tracking</span><span class="tag">Zone View</span>
                </div>
            </div>
            <div class="feature-card">
                <div class="feat-icon">📊</div>
                <div class="feat-title">Analytics Dashboard</div>
                <div class="feat-desc">City-wide analytics with trend charts, consumption graphs, fleet utilization breakdowns and export-ready CSV reports.</div>
                <div class="feat-tags">
                    <span class="tag">Charts</span><span class="tag">Trends</span><span class="tag">CSV Export</span>
                </div>
            </div>
            <div class="feature-card">
                <div class="feat-icon">🔔</div>
                <div class="feat-title">Smart Notifications</div>
                <div class="feat-desc">Intelligent alert system with severity levels. Live toast notifications keep operators informed without refreshing the page.</div>
                <div class="feat-tags">
                    <span class="tag">Critical Alerts</span><span class="tag">Live Toasts</span><span class="tag">Auto-Poll</span>
                </div>
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="cta-section">
        <h2>Ready to manage your city smarter?</h2>
        <p>Login to your SmartCity account or create a new one to get started with real-time urban management.</p>
        <div class="cta-btns">
            @auth
                <a href="{{ url('/dashboard') }}" class="btn-hero-primary">Go to Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="btn-hero-primary">Login Now</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="btn-hero-secondary">Create Account</a>
                @endif
            @endauth
        </div>
    </section>

    {{-- Footer --}}
    <footer class="home-footer">
        <p>&copy; {{ date('Y') }} <span>SmartCity</span> — Intelligent Urban Management Platform</p>
    </footer>

</body>
</html>
