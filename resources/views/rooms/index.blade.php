@extends('layouts.public')

@section('title', 'Rooms & Suites | Luxora')
@section('description', 'Explore Luxora rooms and suites, with refined interiors, thoughtful amenities and elegant comfort.')

@push('styles')
<style>
    .rooms-hero {
        position: relative;
        min-height: 390px;
        display: flex;
        align-items: end;
        overflow: hidden;
        background: #20382f;
        color: white;
    }

    .rooms-hero-image {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .rooms-hero-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(90deg, rgba(16,31,25,.82), rgba(16,31,25,.2));
    }

    .rooms-hero-content {
        position: relative;
        z-index: 1;
        width: min(100% - 40px, 1280px);
        margin: 0 auto;
        padding: 75px 0;
    }

    .rooms-hero h1 {
        max-width: 750px;
        margin: 15px 0;
        font-family: Georgia, 'Times New Roman', serif;
        font-size: clamp(42px, 6vw, 76px);
        font-weight: 400;
        line-height: 1.08;
    }

    .rooms-hero p {
        max-width: 570px;
        color: rgba(255,255,255,.85);
        font-size: 14px;
        line-height: 1.9;
    }

    .rooms-main { padding: 80px 0 95px; }

    .rooms-heading {
        display: flex;
        justify-content: space-between;
        align-items: end;
        gap: 25px;
        margin-bottom: 35px;
    }

    .rooms-heading h2 {
        margin: 12px 0 0;
        font-family: Georgia, 'Times New Roman', serif;
        font-size: clamp(32px, 4vw, 48px);
        font-weight: 400;
    }

    .rooms-count {
        color: var(--luxora-muted);
        font-size: 13px;
    }

    .rooms-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 27px;
    }

    .room-card {
        overflow: hidden;
        background: white;
        border: 1px solid rgba(32,56,47,.07);
    }

    .room-card-image-wrap { overflow: hidden; }

    .room-card-image {
        display: block;
        width: 100%;
        height: 285px;
        object-fit: cover;
        transition: transform .6s ease;
    }

    .room-card:hover .room-card-image { transform: scale(1.045); }

    .room-card-body { padding: 25px; }

    .room-card-meta {
        color: #a78a59;
        font-size: 10px;
        letter-spacing: .16em;
        text-transform: uppercase;
    }

    .room-card h3 {
        margin: 13px 0;
        font-family: Georgia, 'Times New Roman', serif;
        font-size: 27px;
        font-weight: 400;
    }

    .room-card-description {
        min-height: 52px;
        color: #686c65;
        font-size: 13px;
        line-height: 1.9;
    }

    .room-feature-list {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin: 20px 0;
    }

    .room-feature {
        padding: 8px 10px;
        background: #f3f0e9;
        color: #4f574f;
        font-size: 10px;
    }

    .room-card-bottom {
        display: flex;
        align-items: end;
        justify-content: space-between;
        gap: 12px;
        margin-top: 23px;
        padding-top: 20px;
        border-top: 1px solid var(--luxora-border);
    }

    .room-price-label {
        color: var(--luxora-muted);
        font-size: 10px;
    }

    .room-price {
        margin-top: 7px;
        color: var(--luxora-forest);
        font-family: Georgia, 'Times New Roman', serif;
        font-size: 23px;
    }

    .room-price-period {
        margin-top: 5px;
        color: var(--luxora-muted);
        font-size: 10px;
    }

    .room-details-link {
        display: inline-block;
        padding-bottom: 5px;
        border-bottom: 1px solid var(--luxora-gold);
        color: var(--luxora-forest);
        font-size: 11px;
        white-space: nowrap;
    }

    .rooms-cta {
        margin-top: 65px;
        padding: 55px 25px;
        background: #f0eee7;
        text-align: center;
    }

    .rooms-cta h2 {
        margin: 14px 0;
        font-family: Georgia, 'Times New Roman', serif;
        font-size: clamp(30px, 4vw, 43px);
        font-weight: 400;
    }

    .rooms-cta p {
        max-width: 550px;
        margin: 0 auto 25px;
        color: #686c65;
        font-size: 13px;
        line-height: 1.9;
    }

    @media (max-width: 950px) {
        .rooms-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
    }

    @media (max-width: 620px) {
        .rooms-hero { min-height: 340px; }
        .rooms-hero-content { width: calc(100% - 32px); padding: 55px 0; }
        .rooms-main { padding: 52px 0 65px; }
        .rooms-heading { display: block; }
        .rooms-count { margin-top: 15px; }
        .rooms-grid { grid-template-columns: 1fr; gap: 22px; }
        .room-card-image { height: 250px; }
        .room-card-body { padding: 22px; }
        .rooms-cta { margin-top: 45px; padding: 42px 20px; }
    }
</style>
@endpush

@section('content')
    <section class="rooms-hero">
        <img
            class="rooms-hero-image"
            src="https://images.unsplash.com/photo-1611892440504-42a792e24d32?auto=format&fit=crop&w=2000&q=90"
            alt="Elegant Luxora hotel accommodation"
            fetchpriority="high"
        >

        <div class="rooms-hero-overlay"></div>

        <div class="rooms-hero-content">
            <span class="luxora-eyebrow" style="color:#e0c69a">
                The Luxora collection
            </span>

            <h1>Spaces designed for exceptional stays.</h1>

            <p>
                Explore thoughtfully appointed rooms and suites where
                refined comfort meets considered hospitality.
            </p>

            <a href="{{ route('home') }}#booking"
               class="luxora-button"
               style="margin-top:18px;background:#c4a574;border-color:#c4a574;color:#20382f">
                Plan your stay
            </a>
        </div>
    </section>

    <section class="rooms-main">
        <div class="luxora-shell">
            <div class="rooms-heading">
                <div>
                    <span class="luxora-eyebrow">Stay beautifully</span>
                    <h2>Rooms &amp; Suites</h2>
                </div>

                <p class="rooms-count">
                    {{ count($rooms) }} room categories to explore
                </p>
            </div>

            <div class="rooms-grid">
                @forelse ($rooms as $room)
                    <article class="room-card">
                        <a href="{{ route('rooms.show', $room['slug']) }}"
                           class="room-card-image-wrap"
                           aria-label="View {{ $room['name'] }}">
                            <img
                                class="room-card-image"
                                src="{{ $room['image'] }}"
                                alt="{{ $room['name'] }}"
                                loading="lazy"
                            >
                        </a>

                        <div class="room-card-body">
                            <div class="room-card-meta">
                                Accommodates up to {{ $room['capacity'] }} guests
                            </div>

                            <h3>{{ $room['name'] }}</h3>

                            <p class="room-card-description">
                                {{ $room['description'] }}
                            </p>

                            <div class="room-feature-list">
                                @foreach (array_slice($room['features'], 0, 3) as $feature)
                                    <span class="room-feature">
                                        {{ $feature }}
                                    </span>
                                @endforeach
                            </div>

                            <div class="room-card-bottom">
                                <div>
                                    <div class="room-price-label">
                                        Starting from
                                    </div>

                                    <div class="room-price">
                                        ₦{{ number_format($room['price']) }}
                                    </div>

                                    <div class="room-price-period">
                                        Per night · Indicative rate
                                    </div>
                                </div>

                                <a class="room-details-link"
                                   href="{{ route('rooms.show', $room['slug']) }}">
                                    Explore room →
                                </a>
                            </div>
                        </div>
                    </article>
                @empty
                    <p>No room categories are available to display yet.</p>
                @endforelse
            </div>

            <section class="rooms-cta">
                <span class="luxora-eyebrow">Your next escape</span>

                <h2>Find your place at Luxora.</h2>

                <p>
                    Start planning your stay by choosing your dates and
                    preferences on our homepage.
                </p>

                <a href="{{ route('home') }}#booking" class="luxora-button">
                    Check your dates
                </a>
            </section>
        </div>
    </section>
@endsection
