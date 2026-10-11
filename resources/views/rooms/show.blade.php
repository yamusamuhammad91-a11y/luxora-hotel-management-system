@extends('layouts.public')

@section('title', $room['name'] . ' | Luxora Hotel')

@section('content')

<style>
    .room-detail-page {
        background: var(--luxora-ivory, #faf9f6);
        color: var(--luxora-ink, #242725);
    }

    .room-detail-hero {
        position: relative;
        min-height: 460px;
        overflow: hidden;
        background: #20382f;
    }

    .room-detail-hero img {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .room-detail-hero::after {
        content: "";
        position: absolute;
        inset: 0;
        background: linear-gradient(
            90deg,
            rgba(15, 28, 22, .84),
            rgba(15, 28, 22, .44),
            rgba(15, 28, 22, .12)
        );
    }

    .room-detail-hero-content {
        position: relative;
        z-index: 1;
        max-width: 1240px;
        margin: auto;
        padding: 110px 28px 85px;
        color: #fff;
    }

    .room-detail-eyebrow {
        color: #e0c69a;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 3px;
        text-transform: uppercase;
    }

    .room-detail-hero h1 {
        max-width: 700px;
        margin: 18px 0;
        font-family: Georgia, "Times New Roman", serif;
        font-size: clamp(42px, 6vw, 76px);
        font-weight: 400;
        line-height: 1.08;
    }

    .room-detail-hero p {
        max-width: 600px;
        color: rgba(255,255,255,.83);
        font-size: 16px;
        line-height: 1.9;
    }

    .room-breadcrumbs {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 30px;
        color: rgba(255,255,255,.75);
        font-size: 12px;
    }

    .room-breadcrumbs a {
        color: #fff;
        text-decoration: none;
    }

    .room-breadcrumbs a:hover {
        color: #e0c69a;
    }

    .room-detail-container {
        max-width: 1240px;
        margin: auto;
        padding: 76px 28px;
    }

    .room-detail-grid {
        display: grid;
        grid-template-columns: minmax(0, 1.6fr) minmax(290px, .8fr);
        gap: 60px;
        align-items: start;
    }

    .room-detail-section-label {
        color: #9a7c4e;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 2.5px;
        text-transform: uppercase;
    }

    .room-detail-main h2,
    .related-rooms-heading h2 {
        margin: 15px 0 22px;
        font-family: Georgia, "Times New Roman", serif;
        font-size: clamp(30px, 4vw, 43px);
        font-weight: 400;
        line-height: 1.2;
    }

    .room-detail-description {
        color: #6d706a;
        font-size: 15px;
        line-height: 2;
    }

    .room-feature-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 0;
        margin-top: 35px;
        border-top: 1px solid #e8e2d7;
    }

    .room-feature {
        display: flex;
        align-items: center;
        gap: 13px;
        padding: 20px 12px 20px 0;
        border-bottom: 1px solid #e8e2d7;
        color: #444941;
        font-size: 13px;
    }

    .room-feature-icon {
        display: grid;
        width: 35px;
        height: 35px;
        flex-shrink: 0;
        place-items: center;
        border: 1px solid #e2d6c2;
        border-radius: 50%;
        color: #9a7c4e;
        font-size: 15px;
    }

    .room-booking-card {
        position: sticky;
        top: 25px;
        padding: 30px;
        border: 1px solid #e8e2d7;
        background: #fff;
        box-shadow: 0 18px 50px rgba(32, 56, 47, .07);
    }

    .room-booking-card h3 {
        margin: 0 0 9px;
        font-family: Georgia, "Times New Roman", serif;
        font-size: 27px;
        font-weight: 400;
    }

    .room-price {
        margin: 20px 0 7px;
        color: #20382f;
        font-family: Georgia, "Times New Roman", serif;
        font-size: 35px;
    }

    .room-price small {
        color: #777a74;
        font-family: Arial, sans-serif;
        font-size: 12px;
    }

    .room-booking-divider {
        height: 1px;
        margin: 24px 0;
        background: #e8e2d7;
    }

    .room-booking-info {
        display: flex;
        justify-content: space-between;
        gap: 12px;
        margin: 17px 0;
        color: #666b63;
        font-size: 13px;
    }

    .room-booking-info strong {
        color: #242725;
        font-weight: 600;
        text-align: right;
    }

    .room-reserve-button {
        display: block;
        width: 100%;
        margin-top: 25px;
        padding: 17px 20px;
        border: 1px solid #20382f;
        background: #20382f;
        color: #fff;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 1.8px;
        text-align: center;
        text-decoration: none;
        text-transform: uppercase;
        transition: background .2s, color .2s;
    }

    .room-reserve-button:hover {
        background: #c4a574;
        border-color: #c4a574;
        color: #172a22;
    }

    .room-booking-note {
        margin: 17px 0 0;
        color: #777a74;
        font-size: 11px;
        line-height: 1.8;
        text-align: center;
    }

    .related-rooms-section {
        background: #f1eee6;
    }

    .related-rooms-heading {
        margin-bottom: 35px;
    }

    .related-rooms-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 25px;
    }

    .related-room-card {
        overflow: hidden;
        background: #fff;
    }

    .related-room-image {
        display: block;
        height: 230px;
        overflow: hidden;
        background: #e8e2d7;
    }

    .related-room-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform .5s;
    }

    .related-room-card:hover .related-room-image img {
        transform: scale(1.04);
    }

    .related-room-content {
        padding: 23px;
    }

    .related-room-content h3 {
        margin: 0 0 10px;
        font-family: Georgia, "Times New Roman", serif;
        font-size: 24px;
        font-weight: 400;
    }

    .related-room-content p {
        min-height: 48px;
        color: #777a74;
        font-size: 13px;
        line-height: 1.8;
    }

    .related-room-bottom {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
        margin-top: 20px;
        padding-top: 18px;
        border-top: 1px solid #e8e2d7;
    }

    .related-room-price {
        color: #20382f;
        font-family: Georgia, "Times New Roman", serif;
        font-size: 22px;
    }

    .related-room-price small {
        color: #777a74;
        font-family: Arial, sans-serif;
        font-size: 11px;
    }

    .related-room-link {
        color: #20382f;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 1px;
        text-decoration: none;
        text-transform: uppercase;
    }

    @media (max-width: 850px) {
        .room-detail-grid {
            grid-template-columns: 1fr;
            gap: 40px;
        }

        .room-booking-card {
            position: static;
        }

        .related-rooms-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .room-detail-hero {
            min-height: 390px;
        }
    }

    @media (max-width: 560px) {
        .room-detail-hero-content {
            padding: 85px 20px 65px;
        }

        .room-detail-container {
            padding: 52px 20px;
        }

        .room-feature-grid,
        .related-rooms-grid {
            grid-template-columns: 1fr;
        }

        .room-booking-card {
            padding: 24px;
        }

        .related-room-image {
            height: 220px;
        }
    }
</style>

<div class="room-detail-page">

    <section class="room-detail-hero">
        <img
            src="{{ $room['image'] ?: 'https://images.unsplash.com/photo-1611892440504-42a792e24d32?auto=format&fit=crop&w=1800&q=85' }}"
            alt="{{ $room['name'] }}"
        >

        <div class="room-detail-hero-content">
            <div class="room-breadcrumbs">
                <a href="{{ route('home') }}">Home</a>
                <span>/</span>
                <a href="{{ route('rooms.index') }}">Rooms & Suites</a>
                <span>/</span>
                <span>{{ $room['name'] }}</span>
            </div>

            <span class="room-detail-eyebrow">Your Private Sanctuary</span>

            <h1>{{ $room['name'] }}</h1>

            <p>{{ $room['description'] }}</p>
        </div>
    </section>

    <section class="room-detail-container">
        <div class="room-detail-grid">

            <div class="room-detail-main">
                <span class="room-detail-section-label">Thoughtfully Designed</span>

                <h2>Comfort, privacy and understated luxury.</h2>

                <div class="room-detail-description">
                    {{ $room['long_description'] ?: $room['description'] }}
                </div>

                <div class="room-feature-grid">
                    @forelse ($room['features'] as $feature)
                        <div class="room-feature">
                            <span class="room-feature-icon" aria-hidden="true">✦</span>
                            <span>{{ $feature }}</span>
                        </div>
                    @empty
                        <div class="room-feature">
                            <span class="room-feature-icon" aria-hidden="true">✦</span>
                            <span>Comfortable luxury accommodation</span>
                        </div>
                        <div class="room-feature">
                            <span class="room-feature-icon" aria-hidden="true">✦</span>
                            <span>Personalised guest service</span>
                        </div>
                    @endforelse
                </div>
            </div>

            <aside class="room-booking-card">
                <span class="room-detail-section-label">Make It Yours</span>

                <h3>Reserve your stay</h3>

                <p style="color:#777a74;font-size:13px;line-height:1.8;">
                    Begin your Luxora experience with a reservation in this room.
                </p>

                <div class="room-price">
                    ₦{{ number_format($room['price']) }}
                    <small>/ night</small>
                </div>

                <div class="room-booking-divider"></div>

                <div class="room-booking-info">
                    <span>Accommodation</span>
                    <strong>{{ $room['name'] }}</strong>
                </div>

                <div class="room-booking-info">
                    <span>Maximum capacity</span>
                    <strong>
                        {{ $room['capacity'] }}
                        {{ $room['capacity'] === 1 ? 'guest' : 'guests' }}
                        per room
                    </strong>
                </div>

                <div class="room-booking-info">
                    <span>Reservation</span>
                    <strong>Request to book</strong>
                </div>

                <a
                    class="room-reserve-button"
                    href="{{ route('booking.create', [
                        'slug' => $room['slug'],
                        'check_in' => request('check_in'),
                        'check_out' => request('check_out'),
                        'adults' => request('adults'),
                        'children' => request('children'),
                        'rooms_count' => request('rooms_count', request('rooms')),
                    ]) }}"
                >
                    Reserve This Room
                </a>

                <p class="room-booking-note">
                    Your reservation will be submitted for processing.
                    Online payment is not yet connected.
                </p>
            </aside>

        </div>
    </section>

    @if (count($otherRooms) > 0)
        <section class="related-rooms-section">
            <div class="room-detail-container">
                <div class="related-rooms-heading">
                    <span class="room-detail-section-label">Discover More</span>
                    <h2>Explore our other rooms</h2>
                </div>

                <div class="related-rooms-grid">
                    @foreach ($otherRooms as $otherRoom)
                        <article class="related-room-card">
                            <a
                                class="related-room-image"
                                href="{{ route('rooms.show', $otherRoom['slug']) }}"
                            >
                                <img
                                    src="{{ $otherRoom['image'] ?: 'https://images.unsplash.com/photo-1590490360182-c33d57733427?auto=format&fit=crop&w=1000&q=85' }}"
                                    alt="{{ $otherRoom['name'] }}"
                                    loading="lazy"
                                >
                            </a>

                            <div class="related-room-content">
                                <h3>{{ $otherRoom['name'] }}</h3>

                                <p>{{ $otherRoom['description'] }}</p>

                                <div class="related-room-bottom">
                                    <div class="related-room-price">
                                        ₦{{ number_format($otherRoom['price']) }}
                                        <small>/ night</small>
                                    </div>

                                    <a
                                        class="related-room-link"
                                        href="{{ route('booking.create', $otherRoom['slug']) }}"
                                    >
                                        Reserve →
                                    </a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

</div>

@endsection
