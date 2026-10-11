<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Create Your Account | Luxora Hotels</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --forest: #20382f;
            --forest-dark: #172a23;
            --gold: #c4a574;
            --ivory: #faf9f6;
            --muted: #858980;
            --line: #e7e3da;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            min-height: 100vh;
            background: var(--ivory);
            color: #282c29;
            font-family: 'DM Sans', sans-serif;
        }

        a { text-decoration: none; }

        .register-layout {
            display: grid;
            grid-template-columns: minmax(0, 1fr) minmax(440px, .9fr);
            min-height: 100vh;
        }

        .register-visual {
            position: relative;
            display: flex;
            min-height: 650px;
            flex-direction: column;
            justify-content: space-between;
            padding: 42px;
            overflow: hidden;
            background:
                linear-gradient(180deg, rgba(18,36,28,.30), rgba(18,36,28,.87)),
                url('https://images.unsplash.com/photo-1611892440504-42a792e24d32?auto=format&fit=crop&w=1500&q=85')
                center / cover no-repeat;
            color: white;
        }

        .register-brand {
            display: inline-flex;
            align-items: center;
            gap: 13px;
            width: fit-content;
            color: white;
        }

        .register-brand-mark {
            display: grid;
            width: 45px;
            height: 45px;
            place-items: center;
            border: 1px solid var(--gold);
            color: var(--gold);
            font-family: 'Playfair Display', serif;
            font-size: 26px;
        }

        .register-brand-name {
            font-family: 'Playfair Display', serif;
            font-size: 25px;
            letter-spacing: 4px;
        }

        .register-brand-caption {
            margin-top: 4px;
            color: #e1e2db;
            font-size: 9px;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        .register-visual-copy {
            max-width: 510px;
            padding: 35px 0;
        }

        .register-eyebrow {
            margin-bottom: 18px;
            color: #e1c796;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 3px;
            text-transform: uppercase;
        }

        .register-visual h1 {
            margin: 0;
            font-family: 'Playfair Display', serif;
            font-size: clamp(39px, 5vw, 66px);
            font-weight: 400;
            line-height: 1.13;
        }

        .register-visual-copy p {
            max-width: 420px;
            margin-top: 22px;
            color: #e1e5df;
            font-size: 13px;
            line-height: 1.9;
        }

        .register-visual-footer {
            padding-top: 20px;
            border-top: 1px solid rgba(255,255,255,.25);
            color: #e1e5df;
            font-size: 10px;
            letter-spacing: 1.5px;
        }

        .register-form-side {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 45px 35px;
        }

        .register-form-wrap {
            width: 100%;
            max-width: 435px;
        }

        .register-back {
            display: inline-block;
            margin-bottom: 36px;
            color: #697068;
            font-size: 12px;
        }

        .register-back:hover { color: var(--forest); }

        .register-form-eyebrow {
            margin-bottom: 12px;
            color: #9c8053;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 2.3px;
            text-transform: uppercase;
        }

        .register-form-title {
            margin: 0;
            color: var(--forest);
            font-family: 'Playfair Display', serif;
            font-size: 38px;
            font-weight: 500;
        }

        .register-form-description {
            margin: 12px 0 28px;
            color: #858980;
            font-size: 12px;
            line-height: 1.8;
        }

        .register-alert {
            margin-bottom: 20px;
            padding: 13px 15px;
            border: 1px solid #e7caca;
            background: #fff0f0;
            color: #923d3d;
            font-size: 12px;
            line-height: 1.7;
        }

        .register-alert ul {
            margin: 7px 0 0;
            padding-left: 18px;
        }

        .register-field {
            margin-bottom: 19px;
        }

        .register-field label {
            display: block;
            margin-bottom: 9px;
            color: #424940;
            font-size: 11px;
            font-weight: 600;
        }

        .register-field input {
            display: block;
            width: 100%;
            min-height: 48px;
            padding: 12px 14px;
            border: 1px solid var(--line);
            border-radius: 3px;
            outline: none;
            background: #fff;
            color: #282c29;
            font-size: 12px;
            transition: border-color .2s, box-shadow .2s;
        }

        .register-field input:focus {
            border-color: var(--forest);
            box-shadow: 0 0 0 3px rgba(32,56,47,.07);
        }

        .register-field input::placeholder { color: #a5a79f; }

        .register-field-error {
            margin-top: 7px;
            color: #a33f3f;
            font-size: 11px;
        }

        .register-password-note {
            margin-top: 7px;
            color: #858980;
            font-size: 10px;
            line-height: 1.7;
        }

        .register-terms {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            margin: 23px 0;
            color: #737970;
            font-size: 11px;
            line-height: 1.8;
        }

        .register-terms input {
            width: 15px;
            height: 15px;
            flex-shrink: 0;
            margin-top: 3px;
            accent-color: var(--forest);
        }

        .register-terms a {
            color: var(--forest);
            font-weight: 600;
            text-decoration: underline;
        }

        .register-submit {
            display: block;
            width: 100%;
            min-height: 49px;
            padding: 14px;
            border: 0;
            border-radius: 3px;
            background: var(--forest);
            color: white;
            cursor: pointer;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 1.4px;
            transition: background .2s;
        }

        .register-submit:hover { background: var(--forest-dark); }

        .register-login {
            margin-top: 25px;
            color: #777c74;
            font-size: 12px;
            text-align: center;
        }

        .register-login a {
            color: var(--forest);
            font-weight: 700;
        }

        .register-login a:hover { text-decoration: underline; }

        @media (max-width: 900px) {
            .register-layout {
                grid-template-columns: 1fr;
            }

            .register-visual {
                min-height: 300px;
                padding: 27px;
            }

            .register-visual h1 { font-size: 39px; }

            .register-visual-copy { padding: 35px 0 20px; }

            .register-visual-footer { display: none; }

            .register-form-side { padding: 40px 24px 55px; }

            .register-back { margin-bottom: 25px; }
        }

        @media (max-width: 480px) {
            .register-visual { min-height: 270px; }
            .register-visual h1 { font-size: 34px; }
            .register-visual-copy p { font-size: 12px; }
            .register-form-title { font-size: 32px; }
            .register-form-side { padding-right: 20px; padding-left: 20px; }
        }
    </style>
</head>

<body>
    <main class="register-layout">
        <section class="register-visual">
            <a href="{{ route('home') }}" class="register-brand">
                <div class="register-brand-mark">L</div>

                <div>
                    <div class="register-brand-name">LUXORA</div>
                    <div class="register-brand-caption">Hotel &amp; Retreat</div>
                </div>
            </a>

            <div class="register-visual-copy">
                <div class="register-eyebrow">A More Personal Stay</div>

                <h1>Your next exceptional experience begins here.</h1>

                <p>
                    Create your guest account to access your reservations
                    and keep your upcoming stays organised in one place.
                </p>
            </div>

            <div class="register-visual-footer">
                THOUGHTFUL HOSPITALITY. TIMELESS COMFORT.
            </div>
        </section>

        <section class="register-form-side">
            <div class="register-form-wrap">
                <a href="{{ route('home') }}" class="register-back">
                    ← Back to Luxora
                </a>

                <div class="register-form-eyebrow">Guest Membership</div>

                <h2 class="register-form-title">Create your account</h2>

                <p class="register-form-description">
                    Enter your details below to get started with your
                    personal Luxora guest account.
                </p>

                @if ($errors->any())
                    <div class="register-alert" role="alert">
                        <strong>Please check the following:</strong>

                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('register.store') }}">
                    @csrf

                    <div class="register-field">
                        <label for="name">Full name</label>

                        <input
                            type="text"
                            id="name"
                            name="name"
                            value="{{ old('name') }}"
                            placeholder="Enter your full name"
                            autocomplete="name"
                            maxlength="255"
                            required
                            autofocus
                        >

                        @error('name')
                            <div class="register-field-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="register-field">
                        <label for="email">Email address</label>

                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="you@example.com"
                            autocomplete="email"
                            maxlength="255"
                            required
                        >

                        @error('email')
                            <div class="register-field-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="register-field">
                        <label for="password">Password</label>

                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="Create a strong password"
                            autocomplete="new-password"
                            required
                        >

                        <div class="register-password-note">
                            Use at least 8 characters, including uppercase
                            and lowercase letters, a number and a symbol.
                        </div>

                        @error('password')
                            <div class="register-field-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="register-field">
                        <label for="password_confirmation">Confirm password</label>

                        <input
                            type="password"
                            id="password_confirmation"
                            name="password_confirmation"
                            placeholder="Enter your password again"
                            autocomplete="new-password"
                            required
                        >
                    </div>

                    <label class="register-terms">
                        <input type="checkbox" name="terms" value="1"
                               required {{ old('terms') ? 'checked' : '' }}>

                        <span>
                            I agree to the
                            <a href="{{ url('/terms') }}">Terms of Service</a>
                            and
                            <a href="{{ url('/privacy') }}">Privacy Policy</a>.
                        </span>
                    </label>

                    @error('terms')
                        <div class="register-field-error" style="margin-top:-14px;margin-bottom:18px;">
                            {{ $message }}
                        </div>
                    @enderror

                    <button type="submit" class="register-submit">
                        CREATE MY ACCOUNT
                    </button>
                </form>

                <div class="register-login">
                    Already have an account?
                    <a href="{{ route('login') }}">Sign in</a>
                </div>
            </div>
        </section>
    </main>
</body>
</html>
