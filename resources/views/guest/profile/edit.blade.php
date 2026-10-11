@extends('layouts.public')

@section('content')
<style>
    .profile-page {
        min-height: 75vh;
        padding: 65px 0 90px;
        background: #faf9f6;
    }

    .profile-container {
        width: min(850px, calc(100% - 36px));
        margin: 0 auto;
    }

    .profile-heading {
        margin-bottom: 32px;
    }

    .profile-eyebrow {
        margin-bottom: 12px;
        color: #a48758;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 2.5px;
        text-transform: uppercase;
    }

    .profile-title {
        margin: 0;
        color: #20382f;
        font-family: 'Playfair Display', serif;
        font-size: clamp(32px, 5vw, 44px);
        font-weight: 500;
    }

    .profile-description {
        margin-top: 12px;
        color: #777c74;
        font-size: 14px;
        line-height: 1.8;
    }

    .profile-card {
        margin-bottom: 24px;
        padding: 30px;
        border: 1px solid #e9e5dc;
        background: #fff;
    }

    .profile-card h2 {
        margin: 0 0 8px;
        color: #20382f;
        font-family: 'Playfair Display', serif;
        font-size: 23px;
        font-weight: 500;
    }

    .profile-note {
        margin: 0 0 25px;
        color: #858980;
        font-size: 12px;
        line-height: 1.7;
    }

    .profile-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 20px;
    }

    .profile-field {
        margin-bottom: 20px;
    }

    .profile-field label {
        display: block;
        margin-bottom: 9px;
        color: #454b44;
        font-size: 12px;
        font-weight: 600;
    }

    .profile-field input {
        width: 100%;
        min-height: 47px;
        padding: 12px 14px;
        border: 1px solid #dedbd2;
        border-radius: 0;
        outline: none;
        background: #fff;
        color: #30372f;
        font: inherit;
        font-size: 13px;
        box-sizing: border-box;
    }

    .profile-field input:focus {
        border-color: #a48758;
    }

    .profile-error {
        margin-top: 7px;
        color: #a34e4e;
        font-size: 12px;
    }

    .profile-actions {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 20px;
        margin-top: 8px;
    }

    .profile-submit {
        min-height: 46px;
        padding: 13px 24px;
        border: 0;
        background: #20382f;
        color: #fff;
        cursor: pointer;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: .7px;
    }

    .profile-submit:hover {
        background: #172a23;
    }

    .profile-back {
        color: #8b7048;
        font-size: 12px;
        font-weight: 600;
        text-decoration: none;
    }

    @media (max-width: 600px) {
        .profile-page {
            padding: 42px 0 60px;
        }

        .profile-card {
            padding: 22px 18px;
        }

        .profile-grid {
            grid-template-columns: 1fr;
            gap: 0;
        }
    }
</style>

<section class="profile-page">
    <div class="profile-container">

        <header class="profile-heading">
            <div class="profile-eyebrow">Your Luxora Account</div>
            <h1 class="profile-title">Personal Details</h1>
            <p class="profile-description">
                Keep your contact information up to date and manage
                your account security.
            </p>
        </header>

        @if (session('success'))
            <div role="status"
                style="margin-bottom:20px;padding:15px;background:#edf4ee;color:#376548;font-size:13px;">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div role="alert"
                style="margin-bottom:20px;padding:15px;background:#f9eaea;color:#a34e4e;font-size:13px;">
                Please review the highlighted fields and try again.
            </div>
        @endif

        <form method="POST" action="{{ route('guest.profile.update') }}">
            @csrf
            @method('PATCH')

            <section class="profile-card">
                <h2>Personal Information</h2>
                <p class="profile-note">
                    These details help us identify and contact you about
                    your reservations.
                </p>

                <div class="profile-field">
                    <label for="name">Full Name</label>
                    <input
                        id="name"
                        name="name"
                        type="text"
                        value="{{ old('name', $user->name) }}"
                        autocomplete="name"
                        required
                    >
                    @error('name')
                        <div class="profile-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="profile-field">
                    <label for="email">Email Address</label>
                    <input
                        id="email"
                        name="email"
                        type="email"
                        value="{{ old('email', $user->email) }}"
                        autocomplete="email"
                        required
                    >
                    @error('email')
                        <div class="profile-error">{{ $message }}</div>
                    @enderror
                </div>
            </section>

            <section class="profile-card">
                <h2>Change Password</h2>
                <p class="profile-note">
                    Leave these fields empty if you do not want to change
                    your password. A password change requires your current
                    password.
                </p>

                <div class="profile-field">
                    <label for="current_password">Current Password</label>
                    <input
                        id="current_password"
                        name="current_password"
                        type="password"
                        autocomplete="current-password"
                    >
                    @error('current_password')
                        <div class="profile-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="profile-grid">
                    <div class="profile-field">
                        <label for="password">New Password</label>
                        <input
                            id="password"
                            name="password"
                            type="password"
                            autocomplete="new-password"
                        >
                        @error('password')
                            <div class="profile-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="profile-field">
                        <label for="password_confirmation">
                            Confirm New Password
                        </label>
                        <input
                            id="password_confirmation"
                            name="password_confirmation"
                            type="password"
                            autocomplete="new-password"
                        >
                    </div>
                </div>
            </section>

            <div class="profile-actions">
                <button class="profile-submit" type="submit">
                    SAVE CHANGES
                </button>

                <a class="profile-back" href="{{ route('guest.dashboard') }}">
                    ← BACK TO MY ACCOUNT
                </a>
            </div>
        </form>

    </div>
</section>
@endsection
