<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Luxora | Luxury Beyond Expectations')</title>

    <meta name="description"
          content="@yield('description', 'Discover exceptional rooms, refined hospitality and unforgettable stays at Luxora.')">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --luxora-forest: #20382f;
            --luxora-forest-dark: #172a22;
            --luxora-ivory: #faf9f6;
            --luxora-gold: #c4a574;
            --luxora-gold-light: #e0c69a;
            --luxora-ink: #242725;
            --luxora-muted: #777a74;
            --luxora-border: #e8e2d7;
        }

        * {
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            margin: 0;
            background: var(--luxora-ivory);
            color: var(--luxora-forest);
            font-family: Arial, Helvetica, sans-serif;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        img {
            max-width: 100%;
        }

        .luxora-serif {
            font-family: Georgia, 'Times New Roman', serif;
            font-weight: 400;
        }

        .luxora-shell {
            width: min(100% - 40px, 1280px);
            margin-inline: auto;
        }

        .luxora-header {
            position: relative;
            z-index: 50;
            background: var(--luxora-ivory);
            border-bottom: 1px solid var(--luxora-border);
        }

        .luxora-header-inner {
            min-height: 88px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 28px;
        }

        .luxora-brand {
            color: var(--luxora-forest);
            line-height: 1;
            flex-shrink: 0;
        }

        .luxora-brand-name {
            display: block;
            font-family: Georgia, 'Times New Roman', serif;
            font-size: 29px;
            letter-spacing: .16em;
        }

        .luxora-brand-subtitle {
            display: block;
            margin-top: 9px;
            font-size: 9px;
            letter-spacing: .42em;
        }

        .luxora-nav {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 24px;
            font-size: 13px;
        }

        .luxora-nav a {
            transition: color .2s ease;
            white-space: nowrap;
        }

        .luxora-nav a:hover,
        .luxora-nav a:focus-visible {
            color: #a78a59;
        }

        .luxora-nav-cta {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 45px;
            padding: 0 19px;
            border: 1px solid var(--luxora-forest);
            color: var(--luxora-forest);
            font-size: 11px;
            letter-spacing: .12em;
            transition: background .2s ease, color .2s ease;
        }

        .luxora-nav-cta:hover {
            background: var(--luxora-forest);
            color: white !important;
        }

        .luxora-menu-toggle {
            display: none;
            border: 1px solid var(--luxora-border);
            background: transparent;
            color: var(--luxora-forest);
            padding: 10px 13px;
            font-size: 22px;
            cursor: pointer;
        }

        .luxora-mobile-nav {
            display: none;
            padding: 8px 0 22px;
        }

        .luxora-mobile-nav.is-open {
            display: block;
        }

        .luxora-mobile-nav a {
            display: block;
            padding: 12px 0;
            border-bottom: 1px solid var(--luxora-border);
            font-size: 14px;
        }

        .luxora-mobile-nav a:hover {
            color: #a78a59;
        }

        .luxora-eyebrow {
            color: #a78a59;
            font-size: 11px;
            letter-spacing: .3em;
            line-height: 1.8;
            text-transform: uppercase;
        }

        .luxora-button {
            display: inline-flex;
            min-height: 49px;
            align-items: center;
            justify-content: center;
            padding: 14px 23px;
            border: 1px solid var(--luxora-forest);
            background: var(--luxora-forest);
            color: white;
            font-size: 11px;
            letter-spacing: .12em;
            text-align: center;
            text-transform: uppercase;
            transition: background .2s ease, border-color .2s ease;
            cursor: pointer;
        }

        .luxora-button:hover {
            background: #304f42;
            border-color: #304f42;
        }

        .luxora-footer {
            background: var(--luxora-forest-dark);
            color: white;
            padding: 58px 0 25px;
        }

        .luxora-footer-grid {
            display: grid;
            grid-template-columns: 1.4fr 1fr 1fr 1.2fr;
            gap: 40px;
        }

        .luxora-footer-heading {
            font-size: 11px;
            font-weight: 600;
            letter-spacing: .15em;
        }

        .luxora-footer-links {
            display: grid;
            gap: 13px;
            margin-top: 21px;
            color: rgba(255, 255, 255, .72);
            font-size: 13px;
        }

        .luxora-footer-links a:hover {
            color: var(--luxora-gold-light);
        }

        .luxora-footer-copy {
            margin-top: 43px;
            padding-top: 22px;
            border-top: 1px solid rgba(255, 255, 255, .15);
            color: rgba(255, 255, 255, .5);
            font-size: 11px;
        }

        @media (max-width: 1100px) {
            .luxora-header-inner {
                gap: 18px;
            }

            .luxora-nav {
                gap: 15px;
                font-size: 12px;
            }

            .luxora-nav-cta {
                padding-inline: 12px;
                font-size: 10px;
            }

            .luxora-footer-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 700px) {
            .luxora-shell {
                width: min(100% - 32px, 1280px);
            }

            .luxora-header-inner {
                min-height: 76px;
            }

            .luxora-brand-name {
                font-size: 25px;
            }

            .luxora-nav {
                display: none;
            }

            .luxora-nav-cta {
                display: none;
            }

            .luxora-menu-toggle {
                display: inline-block;
            }

            .luxora-footer-grid {
                grid-template-columns: 1fr 1fr;
                gap: 32px 22px;
            }
        }

        @media (max-width: 430px) {
            .luxora-footer-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

    @stack('styles')
</head>

<body>
    <header class="luxora-header">
        <div class="luxora-shell luxora-header-inner">
            <a href="{{ route('home') }}"
               class="luxora-brand"
               aria-label="Luxora homepage">
                <span class="luxora-brand-name">LUXORA</span>
                <span class="luxora-brand-subtitle">LUXURY HOTEL</span>
            </a>

            <nav class="luxora-nav" aria-label="Main navigation">
                <a href="{{ route('home') }}">Home</a>
                <a href="{{ route('home') }}#rooms">Rooms &amp; Suites</a>
                <a href="{{ route('services.index') }}">Services</a>
                <a href="{{ route('home') }}#experiences">Experiences</a>
                <a href="{{ route('home') }}#about">About</a>
                <a href="{{ route('home') }}#contact">Contact</a>
            </nav>

            <a class="luxora-nav-cta"
               href="{{ route('home') }}#booking">
                BOOK YOUR STAY
            </a>

            <button
                class="luxora-menu-toggle"
                id="luxora-menu-toggle"
                type="button"
                aria-label="Toggle navigation"
                aria-expanded="false"
                aria-controls="luxora-mobile-nav">
                ☰
            </button>
        </div>

        <nav class="luxora-shell luxora-mobile-nav"
             id="luxora-mobile-nav"
             aria-label="Mobile navigation">
            <a href="{{ route('home') }}">Home</a>
            <a href="{{ route('home') }}#rooms">Rooms &amp; Suites</a>
            <a href="{{ route('services.index') }}">Services</a>
            <a href="{{ route('home') }}#experiences">Experiences</a>
            <a href="{{ route('home') }}#about">About</a>
            <a href="{{ route('home') }}#contact">Contact</a>
            <a href="{{ route('home') }}#booking">Book your stay</a>
        </nav>
    </header>

    <main>
        @yield('content')
    </main>

    <footer class="luxora-footer" id="contact">
        <div class="luxora-shell">
            <div class="luxora-footer-grid">
                <div>
                    <a href="{{ route('home') }}"
                       class="luxora-serif"
                       style="font-size:30px;letter-spacing:.16em">
                        LUXORA
                    </a>

                    <p style="max-width:290px;margin-top:20px;font-size:13px;line-height:1.9;color:rgba(255,255,255,.68)">
                        Refined comfort. Thoughtful hospitality.
                        A more exceptional stay.
                    </p>
                </div>

                <div>
                    <h2 class="luxora-footer-heading">EXPLORE</h2>

                    <div class="luxora-footer-links">
                        <a href="{{ route('home') }}#rooms">Rooms &amp; Suites</a>
                        <a href="{{ route('services.index') }}">Services</a>
                        <a href="{{ route('home') }}#experiences">Experiences</a>
                        <a href="{{ route('home') }}#about">About Luxora</a>
                    </div>
                </div>

                <div>
                    <h2 class="luxora-footer-heading">GUEST INFORMATION</h2>

                    <div class="luxora-footer-links">
                        <a href="{{ route('home') }}#booking">Reservations</a>
                        <a href="{{ route('home') }}#contact">Contact</a>
                        <a href="{{ route('rooms.index') }}">Explore all rooms</a>
                    </div>
                </div>

                <div>
                    <h2 class="luxora-footer-heading">THE LUXORA EXPERIENCE</h2>

                    <p style="margin-top:21px;font-size:13px;line-height:1.9;color:rgba(255,255,255,.68)">
                        Discover elegant spaces, considered details and
                        hospitality designed around your stay.
                    </p>
                </div>
            </div>

            <div class="luxora-footer-copy">
                © {{ date('Y') }} Luxora Hotel. All rights reserved.
            </div>
        </div>
    </footer>

    <script>
        (() => {
            const toggle = document.getElementById('luxora-menu-toggle');
            const menu = document.getElementById('luxora-mobile-nav');

            if (!toggle || !menu) return;

            toggle.addEventListener('click', () => {
                const isOpen = menu.classList.toggle('is-open');

                toggle.setAttribute('aria-expanded', String(isOpen));
                toggle.textContent = isOpen ? '×' : '☰';
            });

            menu.querySelectorAll('a').forEach(link => {
                link.addEventListener('click', () => {
                    menu.classList.remove('is-open');
                    toggle.setAttribute('aria-expanded', 'false');
                    toggle.textContent = '☰';
                });
            });
        })();
    </script>

    @stack('scripts')
</body>
</html>