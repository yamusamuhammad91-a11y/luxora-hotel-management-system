<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">

    <title>Administrator Login | Luxora</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --forest: #20382f;
            --forest-light: #304b40;
            --ivory: #faf9f6;
            --gold: #c4a574;
            --muted: #77766f;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: 'DM Sans', sans-serif;
            background: var(--ivory);
            color: var(--forest);
        }

        .login-layout {
            min-height: 100vh;
            display: grid;
            grid-template-columns: 1fr 1fr;
        }

        .visual-panel {
            position: relative;
            min-height: 100vh;
            overflow: hidden;
            background:
                linear-gradient(180deg, rgba(15, 30, 24, .12), rgba(15, 30, 24, .85)),
                url('https://images.unsplash.com/photo-1611892440504-42a792e24d32?auto=format&fit=crop&w=1800&q=90')
                center / cover no-repeat;
            display: flex;
            align-items: flex-end;
            padding: 70px;
            color: white;
        }

        .visual-content {
            position: relative;
            z-index: 1;
            max-width: 520px;
        }

        .eyebrow {
            color: var(--gold);
            text-transform: uppercase;
            letter-spacing: .3em;
            font-size: 11px;
            font-weight: 700;
        }

        .visual-content h1 {
            margin: 22px 0;
            font-family: 'Playfair Display', serif;
            font-size: clamp(42px, 5vw, 68px);
            font-weight: 400;
            line-height: 1.1;
        }

        .visual-content p {
            max-width: 420px;
            color: rgba(255,255,255,.78);
            font-size: 14px;
            line-height: 1.9;
        }

        .form-panel {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 48px 28px;
        }

        .login-card {
            width: 100%;
            max-width: 430px;
        }

        .brand {
            display: inline-block;
            margin-bottom: 54px;
            color: var(--forest);
            font-family: 'Playfair Display', serif;
            font-size: 37px;
            letter-spacing: .06em;
            text-decoration: none;
        }

        .brand span {
            color: var(--gold);
        }

        .login-heading {
            margin: 0;
            font-family: 'Playfair Display', serif;
            font-size: 37px;
            font-weight: 500;
        }

        .login-description {
            margin: 12px 0 32px;
            color: var(--muted);
            font-size: 14px;
            line-height: 1.8;
        }

        .field {
            margin-bottom: 22px;
        }

        .field label {
            display: block;
            margin-bottom: 9px;
            font-size: 13px;
            font-weight: 600;
        }

        .field input {
            width: 100%;
            min-height: 52px;
            padding: 0 15px;
            border: 1px solid #dedbd2;
            border-radius: 8px;
            background: white;
            color: var(--forest);
            font: inherit;
            font-size: 14px;
            outline: none;
            transition: border-color .2s, box-shadow .2s;
        }

        .field input:focus {
            border-color: var(--gold);
            box-shadow: 0 0 0 3px rgba(196, 165, 116, .15);
        }

        .form-options {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin: 3px 0 27px;
            gap: 12px;
        }

        .remember-option {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            color: var(--muted);
            font-size: 12px;
        }

        .remember-option input {
            accent-color: var(--forest);
        }

        .submit-button {
            width: 100%;
            min-height: 54px;
            border: 0;
            border-radius: 8px;
            background: var(--forest);
            color: white;
            font: inherit;
            font-size: 13px;
            font-weight: 700;
            letter-spacing: .04em;
            cursor: pointer;
            transition: background .2s, transform .2s;
        }

        .submit-button:hover {
            background: var(--forest-light);
        }

        .submit-button:active {
            transform: scale(.99);
        }

        .error-message {
            margin-bottom: 22px;
            padding: 13px 15px;
            border: 1px solid #f1caca;
            border-radius: 8px;
            background: #fff2f2;
            color: #9b2929;
            font-size: 13px;
            line-height: 1.7;
        }

        .security-note {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            margin-top: 28px;
            color: var(--muted);
            font-size: 11px;
            line-height: 1.8;
        }

        .security-note span {
            color: var(--gold);
        }

        .footer-note {
            margin-top: 48px;
            color: #96938a;
            font-size: 11px;
            text-align: center;
        }

        @media (max-width: 850px) {
            .login-layout {
                grid-template-columns: 1fr;
            }

            .visual-panel {
                display: none;
            }

            .form-panel {
                min-height: 100vh;
                padding: 42px 24px;
            }

            .brand {
                margin-bottom: 44px;
            }
        }

        @media (max-width: 480px) {
            .login-heading {
                font-size: 32px;
            }

            .form-options {
                align-items: flex-start;
            }
        }
    </style>
</head>

<body>
    <main class="login-layout">
        <section class="visual-panel" aria-label="Luxora hotel">
            <div class="visual-content">
                <span class="eyebrow">The Luxora Experience</span>

                <h1>Hospitality, managed with distinction.</h1>

                <p>
                    A dedicated space for managing the details behind an
                    exceptional guest experience, from room availability
                    to the services that make every stay memorable.
                </p>
            </div>
        </section>

        <section class="form-panel">
            <div class="login-card">
                <a href="{{ route('home') }}" class="brand">
                    LUXORA<span>.</span>
                </a>

                <p class="eyebrow">Administration Portal</p>

                <h2 class="login-heading">Welcome back.</h2>

                <p class="login-description">
                    Sign in with your authorized administrator account
                    to access hotel management.
                </p>

                @if ($errors->any())
                    <div class="error-message" role="alert">
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                @if (session('status'))
                    <div class="error-message" role="status">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login.store') }}">
                    @csrf

                    <div class="field">
                        <label for="email">Email address</label>

                        <input
                            id="email"
                            name="email"
                            type="email"
                            value="{{ old('email') }}"
                            placeholder="admin@example.com"
                            autocomplete="username"
                            required
                            autofocus
                        >
                    </div>

                    <div class="field">
                        <label for="password">Password</label>

                        <input
                            id="password"
                            name="password"
                            type="password"
                            placeholder="Enter your password"
                            autocomplete="current-password"
                            required
                        >
                    </div>

                    <div class="form-options">
                        <label class="remember-option">
                            <input
                                type="checkbox"
                                name="remember"
                                value="1"
                            >
                            Remember me
                        </label>
                    </div>

                    <button type="submit" class="submit-button">
                        SIGN IN TO LUXORA
                    </button>
                </form>

                <div class="security-note">
                    <span aria-hidden="true">◆</span>
                    <p>
                        Restricted access. Only authorized hotel administrators
                        may enter this management portal.
                    </p>
                </div>

                <p class="footer-note">
                    &copy; {{ date('Y') }} Luxora Hotel. All rights reserved.
                </p>
            </div>
        </section>
    </main>
</body>
</html>
