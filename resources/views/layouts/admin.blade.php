<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('page-title', 'Administration') | Luxora Hotels</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --forest: #20382f;
            --forest-dark: #172a23;
            --gold: #c4a574;
            --ivory: #faf9f6;
            --cream: #f3f0e9;
            --ink: #282c29;
            --muted: #858980;
            --line: #e9e7e0;
            --white: #ffffff;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            background: var(--ivory);
            color: var(--ink);
            font-family: 'DM Sans', sans-serif;
        }

        a { text-decoration: none; }

        button, input, select, textarea {
            font: inherit;
        }

        .admin-sidebar {
            position: fixed;
            inset: 0 auto 0 0;
            z-index: 50;
            display: flex;
            flex-direction: column;
            width: 258px;
            padding: 28px 18px 20px;
            overflow-y: auto;
            background: var(--forest);
            color: var(--white);
            transition: transform .25s ease;
        }

        .admin-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0 12px 30px;
            border-bottom: 1px solid rgba(255,255,255,.12);
        }

        .brand-mark {
            display: grid;
            width: 43px;
            height: 43px;
            place-items: center;
            border: 1px solid var(--gold);
            color: var(--gold);
            font-family: 'Playfair Display', serif;
            font-size: 25px;
        }

        .brand-name {
            font-family: 'Playfair Display', serif;
            font-size: 23px;
            letter-spacing: 3px;
        }

        .brand-subtitle {
            margin-top: 3px;
            color: #c8cfc9;
            font-size: 9px;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        .nav-label {
            margin: 28px 12px 12px;
            color: #aab6ad;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 1.8px;
            text-transform: uppercase;
        }

        .admin-nav {
            display: grid;
            gap: 5px;
        }

        .admin-nav a {
            display: flex;
            align-items: center;
            gap: 12px;
            min-height: 45px;
            padding: 11px 13px;
            border-radius: 5px;
            color: #d8dfd9;
            font-size: 13px;
            transition: background .2s ease, color .2s ease;
        }

        .admin-nav a:hover {
            background: rgba(255,255,255,.08);
            color: var(--white);
        }

        .admin-nav a.active {
            background: rgba(196,165,116,.16);
            color: #ead4ad;
            box-shadow: inset 3px 0 var(--gold);
        }

        .nav-icon {
            display: inline-grid;
            width: 22px;
            place-items: center;
            color: var(--gold);
            font-size: 16px;
        }

        .sidebar-bottom {
            margin-top: auto;
            padding-top: 25px;
        }

        .sidebar-user {
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 17px 10px;
            border-top: 1px solid rgba(255,255,255,.13);
        }

        .user-avatar {
            display: grid;
            flex-shrink: 0;
            width: 38px;
            height: 38px;
            place-items: center;
            border-radius: 50%;
            background: var(--gold);
            color: var(--forest-dark);
            font-weight: 700;
        }

        .user-name {
            overflow: hidden;
            color: var(--white);
            font-size: 12px;
            font-weight: 600;
            text-overflow: ellipsis;
        }

        .user-role {
            margin-top: 4px;
            color: #b8c2ba;
            font-size: 10px;
        }

        .sidebar-logout {
            width: 100%;
            padding: 10px;
            border: 1px solid rgba(255,255,255,.2);
            border-radius: 4px;
            background: transparent;
            color: #e3e7e3;
            cursor: pointer;
            font-size: 12px;
            text-align: left;
        }

        .sidebar-logout:hover {
            border-color: var(--gold);
            color: var(--gold);
        }

        .admin-main {
            min-height: 100vh;
            margin-left: 258px;
        }

        .admin-topbar {
            position: sticky;
            top: 0;
            z-index: 30;
            display: flex;
            align-items: center;
            justify-content: space-between;
            min-height: 83px;
            padding: 17px 34px;
            border-bottom: 1px solid var(--line);
            background: rgba(250,249,246,.96);
            backdrop-filter: blur(12px);
        }

        .page-heading {
            margin: 0;
            font-family: 'Playfair Display', serif;
            font-size: 25px;
            font-weight: 600;
        }

        .page-date {
            margin-top: 5px;
            color: var(--muted);
            font-size: 11px;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .topbar-label {
            color: var(--muted);
            font-size: 12px;
        }

        .topbar-logout {
            padding: 10px 15px;
            border: 1px solid #dcd9d0;
            border-radius: 4px;
            background: transparent;
            color: var(--forest);
            cursor: pointer;
            font-size: 12px;
        }

        .topbar-logout:hover {
            border-color: var(--forest);
        }

        .admin-content {
            padding: 32px 34px 45px;
        }

        .alert {
            margin-bottom: 22px;
            padding: 14px 17px;
            border: 1px solid;
            border-radius: 5px;
            font-size: 13px;
        }

        .alert-success {
            border-color: #c8dfce;
            background: #eef7f0;
            color: #245d36;
        }

        .alert-error {
            border-color: #edcccc;
            background: #fff0f0;
            color: #923d3d;
        }

        .mobile-menu-button,
        .sidebar-overlay {
            display: none;
        }

        @media (max-width: 900px) {
            .admin-sidebar {
                transform: translateX(-100%);
            }

            .admin-sidebar.open {
                transform: translateX(0);
            }

            .admin-main {
                margin-left: 0;
            }

            .sidebar-overlay.open {
                position: fixed;
                inset: 0;
                z-index: 40;
                display: block;
                background: rgba(0,0,0,.4);
            }

            .mobile-menu-button {
                display: inline-grid;
                width: 39px;
                height: 39px;
                margin-right: 12px;
                place-items: center;
                border: 1px solid var(--line);
                border-radius: 4px;
                background: white;
                color: var(--forest);
                cursor: pointer;
            }

            .topbar-left {
                display: flex;
                align-items: center;
            }

            .admin-topbar {
                padding: 16px 20px;
            }

            .admin-content {
                padding: 25px 20px 35px;
            }
        }

        @media (max-width: 560px) {
            .page-heading { font-size: 21px; }
            .topbar-label { display: none; }
            .admin-content { padding: 20px 14px 30px; }
            .admin-topbar { padding: 14px; }
        }
    </style>

    @stack('styles')
</head>
<body>
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <aside class="admin-sidebar" id="adminSidebar">
        <a href="{{ route('admin.dashboard') }}" class="admin-brand">
            <div class="brand-mark">L</div>
            <div>
                <div class="brand-name">LUXORA</div>
                <div class="brand-subtitle">Hotel Administration</div>
            </div>
        </a>

        <div class="nav-label">Overview</div>

        <nav class="admin-nav">
            <a href="{{ route('admin.dashboard') }}"
               class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <span class="nav-icon">⌂</span>
                Dashboard
            </a>
        </nav>

        <div class="nav-label">Hotel Management</div>

        <nav class="admin-nav">
            <a href="{{ route('admin.bookings.index') }}"
               class="{{ request()->routeIs('admin.bookings.*') ? 'active' : '' }}">
                <span class="nav-icon">▤</span>
                Bookings
            </a>

            <a href="{{ route('admin.rooms.index') }}"
               class="{{ request()->routeIs('admin.rooms.*') ? 'active' : '' }}">
                <span class="nav-icon">▦</span>
                Rooms
            </a>

            <a href="{{ route('admin.guests.index') }}"
               class="{{ request()->routeIs('admin.guests.*') ? 'active' : '' }}">
                <span class="nav-icon">♙</span>
                Guests
            </a>

            <a href="{{ route('admin.staff.index') }}"
               class="{{ request()->routeIs('admin.staff.*') ? 'active' : '' }}">
                <span class="nav-icon">♧</span>
                Staff
            </a>

            <a href="{{ route('admin.services.index') }}"
               class="{{ request()->routeIs('admin.services.*') ? 'active' : '' }}">
                <span class="nav-icon">✧</span>
                Services
            </a>

            <a href="{{ route('admin.payments.index') }}"
               class="{{ request()->routeIs('admin.payments.*') ? 'active' : '' }}">
                <span class="nav-icon">₦</span>
                Payments
            </a>

            
            <a href="{{ route('admin.reports.index') }}"
                class="{{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
                <span class="nav-icon">▥</span>
                Reports &amp; Analytics
            </a>

        </nav>

        <div class="sidebar-bottom">
            <div class="sidebar-user">
                <div class="user-avatar">
                    {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                </div>
                <div style="min-width:0;">
                    <div class="user-name">{{ auth()->user()->name ?? 'Administrator' }}</div>
                    <div class="user-role">Hotel Administrator</div>
                </div>
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="sidebar-logout">
                    ↗ &nbsp; Sign out
                </button>
            </form>
        </div>
    </aside>

    <main class="admin-main">
        <header class="admin-topbar">
            <div class="topbar-left">
                <button type="button" class="mobile-menu-button" id="mobileMenuButton"
                        aria-label="Open navigation">
                    ☰
                </button>

                <div>
                    <h1 class="page-heading">@yield('page-title', 'Administration')</h1>
                    <div class="page-date">{{ now()->format('l, d F Y') }}</div>
                </div>
            </div>

            <div class="topbar-right">
                <span class="topbar-label">Luxora Management Portal</span>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="topbar-logout">Sign out</button>
                </form>
            </div>
        </header>

        <section class="admin-content">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-error">
                    {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-error">
                    <strong>Please correct the following:</strong>
                    <ul style="margin:8px 0 0;padding-left:20px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </section>
    </main>

    <script>
        const sidebar = document.getElementById('adminSidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const menuButton = document.getElementById('mobileMenuButton');

        function toggleAdminSidebar() {
            sidebar.classList.toggle('open');
            overlay.classList.toggle('open');
        }

        menuButton?.addEventListener('click', toggleAdminSidebar);

        overlay?.addEventListener('click', () => {
            sidebar.classList.remove('open');
            overlay.classList.remove('open');
        });
    </script>

    @stack('scripts')
</body>
</html>
