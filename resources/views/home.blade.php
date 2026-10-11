{{-- resources/views/home.blade.php --}}

@extends('layouts.public')

@section('content')

{{-- HERO SECTION --}}
<section class="luxora-hero">
    <div class="luxora-hero-overlay"></div>

    <div class="luxora-hero-content">
        <span class="luxora-eyebrow">WELCOME TO LUXORA</span>

        <h1>Where Luxury<br>Feels Like Home.</h1>

        <p>
            Discover exceptional comfort, thoughtful hospitality,
            and unforgettable experiences in every stay.
        </p>

        <div class="luxora-hero-actions">
            <a href="#booking" class="luxora-btn luxora-btn-gold">
                Reserve Your Stay
            </a>

            <a href="#rooms" class="luxora-btn luxora-btn-outline">
                Explore Our Rooms
            </a>
        </div>
    </div>

    <div class="luxora-hero-caption">
        <span>EXCEPTIONAL HOSPITALITY</span>
        <span>COMFORT WITHOUT COMPROMISE</span>
    </div>
</section>


{{-- BOOKING SEARCH --}}
<section class="luxora-booking-wrap" id="booking">
    <div class="luxora-booking-panel">
        <div class="luxora-booking-heading">
            <span class="luxora-eyebrow">PLAN YOUR VISIT</span>
            <h2>Find Your Perfect Stay</h2>
            <p>Choose your dates and let us take care of the rest.</p>
        </div>

        <form action="{{ route('availability') }}"
              method="GET"
              class="luxora-booking-form"
              id="luxoraBookingForm">

            <div class="luxora-form-field">
                <label for="check_in">Check-in</label>
                <input
                    type="date"
                    id="check_in"
                    name="check_in"
                    value="{{ request('check_in') }}"
                    required
                >
            </div>

            <div class="luxora-form-field">
                <label for="check_out">Check-out</label>
                <input
                    type="date"
                    id="check_out"
                    name="check_out"
                    value="{{ request('check_out') }}"
                    required
                >
            </div>

            <div class="luxora-form-field">
                <label for="adults">Guests</label>
                <select id="adults" name="adults" required>
                    @for ($guestCount = 1; $guestCount <= 6; $guestCount++)
                        <option
                            value="{{ $guestCount }}"
                            {{ (int) request('adults', 2) === $guestCount ? 'selected' : '' }}
                        >
                            {{ $guestCount }}
                            {{ $guestCount === 1 ? 'Adult' : 'Adults' }}
                        </option>
                    @endfor
                </select>
            </div>

            <div class="luxora-form-field">
                <label for="rooms">Rooms</label>
                <select id="rooms" name="rooms" required>
                    @for ($roomCount = 1; $roomCount <= 4; $roomCount++)
                        <option
                            value="{{ $roomCount }}"
                            {{ (int) request('rooms', 1) === $roomCount ? 'selected' : '' }}
                        >
                            {{ $roomCount }}
                            {{ $roomCount === 1 ? 'Room' : 'Rooms' }}
                        </option>
                    @endfor
                </select>
            </div>

            <button type="submit" class="luxora-btn luxora-btn-forest luxora-search-btn">
                Search Availability
                <span aria-hidden="true">→</span>
            </button>
        </form>
    </div>
</section>


{{-- ABOUT SECTION --}}
<section class="luxora-about luxora-section" id="about">
    <div class="luxora-about-image">
        <img
            src="https://images.unsplash.com/photo-1611892440504-42a792e24d32?auto=format&fit=crop&w=1200&q=85"
            alt="Elegant hotel bedroom with premium furnishings"
            loading="lazy"
        >

        <div class="luxora-image-note">
            <span class="luxora-note-number">01</span>
            <span>Thoughtfully designed.<br>Beautifully experienced.</span>
        </div>
    </div>

    <div class="luxora-about-content">
        <span class="luxora-eyebrow">THE LUXORA EXPERIENCE</span>

        <h2>A Different Kind<br>of Hospitality.</h2>

        <p>
            At Luxora, we believe a remarkable stay is about more than
            a beautiful room. It is about feeling welcomed, enjoying
            thoughtful details, and having the space to relax.
        </p>

        <p>
            From the moment you arrive to the moment you depart,
            our experience is designed around comfort, elegance,
            and attentive service.
        </p>

        <div class="luxora-about-points">
            <div>
                <span class="luxora-point-icon">✦</span>
                <div>
                    <h3>Considered Comfort</h3>
                    <p>Spaces designed for rest and relaxation.</p>
                </div>
            </div>

            <div>
                <span class="luxora-point-icon">✦</span>
                <div>
                    <h3>Personal Attention</h3>
                    <p>Hospitality that makes every guest feel welcome.</p>
                </div>
            </div>

            <div>
                <span class="luxora-point-icon">✦</span>
                <div>
                    <h3>Memorable Moments</h3>
                    <p>Little details that make a stay feel special.</p>
                </div>
            </div>
        </div>

        <a href="#experiences" class="luxora-text-link">
            Discover the Luxora experience <span aria-hidden="true">→</span>
        </a>
    </div>
</section>


{{-- ROOMS SECTION --}}
<section class="luxora-rooms luxora-section" id="rooms">
    <div class="luxora-section-heading">
        <div>
            <span class="luxora-eyebrow">YOUR PRIVATE RETREAT</span>
            <h2>Rooms &amp; Suites</h2>
            <p>
                Beautifully appointed spaces where every detail
                is designed to make you feel at ease.
            </p>
        </div>

        <a href="{{ route('rooms.index') }}" class="luxora-text-link">
            View All Rooms <span aria-hidden="true">→</span>
        </a>
    </div>

    <div class="luxora-room-grid">
        @forelse ($rooms as $room)
            <article class="luxora-room-card">
                <a
                    href="{{ route('rooms.show', $room['slug']) }}"
                    class="luxora-room-image"
                    aria-label="View {{ $room['name'] }}"
                >
                    <img
                        src="{{ $room['image'] }}"
                        alt="{{ $room['name'] }}"
                        loading="lazy"
                    >

                    <span class="luxora-room-image-label">
                        EXPLORE ROOM
                    </span>
                </a>

                <div class="luxora-room-body">
                    <div class="luxora-room-title-row">
                        <h3>{{ $room['name'] }}</h3>
                        <span class="luxora-room-capacity">
                            Up to {{ $room['capacity'] }} guests
                        </span>
                    </div>

                    <p class="luxora-room-description">
                        {{ $room['description'] }}
                    </p>

                    @if (!empty($room['features']))
                        <div class="luxora-room-features">
                            @foreach ($room['features'] as $feature)
                                <span>{{ $feature }}</span>
                            @endforeach
                        </div>
                    @endif

                    <div class="luxora-room-footer">
                        <div class="luxora-room-price">
                            <span>Starting from</span>
                            <strong>
                                ₦{{ number_format($room['price']) }}
                            </strong>
                            <small>/ night</small>
                        </div>

                        <a
                            href="{{ route('rooms.show', $room['slug']) }}"
                            class="luxora-room-link"
                        >
                            View Details <span aria-hidden="true">→</span>
                        </a>
                    </div>
                </div>
            </article>
        @empty
            <div class="luxora-empty-rooms">
                <h3>Our rooms are being prepared.</h3>
                <p>Please check back soon to explore our accommodation.</p>
            </div>
        @endforelse
    </div>
</section>


{{-- EXPERIENCES SECTION --}}
<section class="luxora-experiences luxora-section" id="experiences">
    <div class="luxora-section-heading luxora-experiences-heading">
        <div>
            <span class="luxora-eyebrow">MORE THAN A STAY</span>
            <h2>Make Every Moment Count</h2>
            <p>
                Discover the little luxuries that turn an ordinary visit
                into an exceptional experience.
            </p>
        </div>
    </div>

    <div class="luxora-experience-grid">
        <article class="luxora-experience-card">
            <img
                src="https://images.unsplash.com/photo-1414235077428-338989a2e8c0?auto=format&fit=crop&w=1000&q=85"
                alt="Fine dining table prepared for an elegant meal"
                loading="lazy"
            >

            <div class="luxora-experience-overlay">
                <span>01 / DINING</span>
                <h3>Flavours to Remember</h3>
                <p>
                    Make room for memorable meals and thoughtful dining
                    experiences during your stay.
                </p>
            </div>
        </article>

        <article class="luxora-experience-card">
            <img
                src="https://images.unsplash.com/photo-1540555700478-4be289fbecef?auto=format&fit=crop&w=1000&q=85"
                alt="Peaceful spa environment"
                loading="lazy"
            >

            <div class="luxora-experience-overlay">
                <span>02 / WELLNESS</span>
                <h3>Time to Unwind</h3>
                <p>
                    Slow down, recharge, and make space for a more
                    relaxing escape.
                </p>
            </div>
        </article>

        <article class="luxora-experience-card">
            <img
                src="https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?auto=format&fit=crop&w=1000&q=85"
                alt="Warm and elegant hospitality interior"
                loading="lazy"
            >

            <div class="luxora-experience-overlay">
                <span>03 / HOSPITALITY</span>
                <h3>Every Detail Matters</h3>
                <p>
                    Enjoy welcoming spaces and attentive service
                    throughout your visit.
                </p>
            </div>
        </article>
    </div>

    <p class="luxora-experience-disclaimer">
        Experience and service availability may vary by property.
    </p>
</section>


{{-- FINAL BOOKING CALL TO ACTION --}}
<section class="luxora-final-cta" id="contact">
    <div class="luxora-final-cta-content">
        <span class="luxora-eyebrow">YOUR NEXT CHAPTER STARTS HERE</span>

        <h2>Make Yourself<br>At Home at Luxora.</h2>

        <p>
            Your next memorable stay is only a few steps away.
            Explore our rooms and plan your visit.
        </p>

        <a href="#booking" class="luxora-btn luxora-btn-gold">
            Plan Your Stay <span aria-hidden="true">→</span>
        </a>
    </div>
</section>

@endsection


@push('styles')
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

    .luxora-hero,
    .luxora-hero *,
    .luxora-booking-wrap,
    .luxora-booking-wrap *,
    .luxora-section,
    .luxora-section *,
    .luxora-final-cta,
    .luxora-final-cta * {
        box-sizing: border-box;
    }

    .luxora-hero {
        position: relative;
        display: flex;
        align-items: center;
        min-height: 690px;
        padding: 100px max(7%, calc((100% - 1240px) / 2));
        overflow: hidden;
        color: #fff;
        background:
            url('https://images.unsplash.com/photo-1611892440504-42a792e24d32?auto=format&fit=crop&w=2200&q=90')
            center 55% / cover no-repeat;
    }

    .luxora-hero-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(
            90deg,
            rgba(15, 29, 23, .88) 0%,
            rgba(15, 29, 23, .64) 48%,
            rgba(15, 29, 23, .12) 100%
        );
    }

    .luxora-hero-content {
        position: relative;
        z-index: 1;
        width: 100%;
        max-width: 760px;
    }

    .luxora-eyebrow {
        display: inline-block;
        color: var(--luxora-gold);
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 3px;
        line-height: 1.8;
    }

    .luxora-hero h1 {
        margin: 22px 0;
        color: #fff;
        font-family: Georgia, 'Times New Roman', serif;
        font-size: clamp(46px, 6.5vw, 82px);
        font-weight: 400;
        letter-spacing: -2px;
        line-height: 1.08;
    }

    .luxora-hero-content > p {
        max-width: 510px;
        margin: 0 0 30px;
        color: rgba(255, 255, 255, .82);
        font-size: 16px;
        line-height: 1.9;
    }

    .luxora-hero-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 13px;
    }

    .luxora-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
        min-height: 49px;
        padding: 14px 22px;
        border: 1px solid transparent;
        border-radius: 0;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 1px;
        text-align: center;
        text-decoration: none;
        transition: background .2s ease, color .2s ease, border-color .2s ease;
        cursor: pointer;
    }

    .luxora-btn-gold {
        color: var(--luxora-forest-dark);
        background: var(--luxora-gold);
    }

    .luxora-btn-gold:hover {
        color: var(--luxora-forest-dark);
        background: var(--luxora-gold-light);
    }

    .luxora-btn-outline {
        color: #fff;
        border-color: rgba(255, 255, 255, .55);
        background: transparent;
    }

    .luxora-btn-outline:hover {
        color: var(--luxora-forest-dark);
        border-color: #fff;
        background: #fff;
    }

    .luxora-hero-caption {
        position: absolute;
        right: 7%;
        bottom: 35px;
        left: 7%;
        display: flex;
        justify-content: space-between;
        gap: 15px;
        color: rgba(255, 255, 255, .7);
        font-size: 9px;
        letter-spacing: 2px;
    }

    .luxora-booking-wrap {
        position: relative;
        z-index: 3;
        padding: 0 6%;
        background: var(--luxora-ivory);
    }

    .luxora-booking-panel {
        position: relative;
        max-width: 1240px;
        margin: 0 auto;
        padding: 38px 40px;
        border-bottom: 1px solid var(--luxora-border);
        background: #fff;
        box-shadow: 0 15px 50px rgba(32, 56, 47, .07);
    }

    .luxora-booking-heading {
        margin-bottom: 23px;
    }

    .luxora-booking-heading h2,
    .luxora-section h2,
    .luxora-final-cta h2 {
        margin: 9px 0 12px;
        color: var(--luxora-forest);
        font-family: Georgia, 'Times New Roman', serif;
        font-size: clamp(30px, 3.5vw, 45px);
        font-weight: 400;
        line-height: 1.2;
    }

    .luxora-booking-heading p,
    .luxora-section-heading > div > p {
        margin: 0;
        color: var(--luxora-muted);
        font-size: 14px;
        line-height: 1.8;
    }

    .luxora-booking-form {
        display: grid;
        grid-template-columns: 1fr 1fr .8fr .7fr auto;
        align-items: end;
        gap: 14px;
    }

    .luxora-form-field {
        min-width: 0;
    }

    .luxora-form-field label {
        display: block;
        margin-bottom: 9px;
        color: var(--luxora-ink);
        font-size: 11px;
        font-weight: 700;
        letter-spacing: .5px;
    }

    .luxora-form-field input,
    .luxora-form-field select {
        width: 100%;
        min-height: 47px;
        padding: 11px 12px;
        border: 1px solid var(--luxora-border);
        border-radius: 0;
        color: var(--luxora-ink);
        background: #fff;
        font: inherit;
        font-size: 12px;
    }

    .luxora-form-field input:focus,
    .luxora-form-field select:focus {
        border-color: var(--luxora-gold);
        outline: 2px solid rgba(196, 165, 116, .18);
    }

    .luxora-search-btn {
        min-height: 47px;
        padding-right: 17px;
        padding-left: 17px;
        white-space: nowrap;
        color: #fff;
        background: var(--luxora-forest);
    }

    .luxora-search-btn:hover {
        background: var(--luxora-forest-dark);
    }

    .luxora-section {
        padding: 100px 7%;
    }

    .luxora-about {
        display: grid;
        grid-template-columns: 1fr 1fr;
        align-items: center;
        gap: clamp(40px, 7vw, 100px);
        max-width: 1600px;
        margin: 0 auto;
        background: var(--luxora-ivory);
    }

    .luxora-about-image {
        position: relative;
        min-width: 0;
    }

    .luxora-about-image > img {
        display: block;
        width: 100%;
        height: 570px;
        object-fit: cover;
    }

    .luxora-image-note {
        position: absolute;
        right: -22px;
        bottom: 30px;
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 22px 27px;
        color: #fff;
        background: var(--luxora-forest);
        font-family: Georgia, 'Times New Roman', serif;
        font-size: 15px;
        line-height: 1.6;
    }

    .luxora-note-number {
        color: var(--luxora-gold);
        font-size: 30px;
    }

    .luxora-about-content h2 {
        margin-top: 14px;
        font-size: clamp(36px, 4vw, 52px);
    }

    .luxora-about-content > p {
        margin: 17px 0;
        color: var(--luxora-muted);
        font-size: 14px;
        line-height: 1.95;
    }

    .luxora-about-points {
        display: grid;
        gap: 21px;
        margin: 30px 0;
    }

    .luxora-about-points > div {
        display: flex;
        align-items: flex-start;
        gap: 15px;
    }

    .luxora-point-icon {
        display: flex;
        flex: 0 0 34px;
        align-items: center;
        justify-content: center;
        width: 34px;
        height: 34px;
        color: var(--luxora-gold);
        border: 1px solid var(--luxora-border);
    }

    .luxora-about-points h3 {
        margin: 0 0 5px;
        color: var(--luxora-forest);
        font-family: Georgia, 'Times New Roman', serif;
        font-size: 18px;
        font-weight: 400;
    }

    .luxora-about-points p {
        margin: 0;
        color: var(--luxora-muted);
        font-size: 12px;
        line-height: 1.7;
    }

    .luxora-text-link {
        display: inline-flex;
        align-items: center;
        gap: 12px;
        color: var(--luxora-forest);
        font-size: 11px;
        font-weight: 700;
        letter-spacing: .5px;
        text-decoration: none;
    }

    .luxora-text-link span,
    .luxora-room-link span {
        transition: transform .2s ease;
    }

    .luxora-text-link:hover span,
    .luxora-room-link:hover span {
        transform: translateX(4px);
    }

    .luxora-rooms {
        background: #fff;
    }

    .luxora-section-heading {
        display: flex;
        align-items: end;
        justify-content: space-between;
        gap: 30px;
        max-width: 1240px;
        margin: 0 auto 38px;
    }

    .luxora-section-heading h2 {
        margin-top: 10px;
    }

    .luxora-section-heading > div > p {
        max-width: 560px;
    }

    .luxora-section-heading > .luxora-text-link {
        flex-shrink: 0;
        margin-bottom: 8px;
    }

    .luxora-room-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 25px;
        max-width: 1240px;
        margin: 0 auto;
    }

    .luxora-room-card {
        min-width: 0;
        overflow: hidden;
        border: 1px solid var(--luxora-border);
        background: #fff;
        transition: box-shadow .25s ease, transform .25s ease;
    }

    .luxora-room-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 15px 35px rgba(32, 56, 47, .08);
    }

    .luxora-room-image {
        position: relative;
        display: block;
        height: 260px;
        overflow: hidden;
        background: #e7e3da;
    }

    .luxora-room-image img {
        display: block;
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform .5s ease;
    }

    .luxora-room-card:hover .luxora-room-image img {
        transform: scale(1.045);
    }

    .luxora-room-image-label {
        position: absolute;
        right: 13px;
        bottom: 13px;
        padding: 9px 12px;
        color: var(--luxora-forest);
        background: var(--luxora-ivory);
        font-size: 9px;
        font-weight: 700;
        letter-spacing: 1px;
    }

    .luxora-room-body {
        padding: 24px 22px 20px;
    }

    .luxora-room-title-row {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 10px;
    }

    .luxora-room-title-row h3 {
        margin: 0;
        color: var(--luxora-forest);
        font-family: Georgia, 'Times New Roman', serif;
        font-size: 23px;
        font-weight: 400;
        line-height: 1.3;
    }

    .luxora-room-capacity {
        flex-shrink: 0;
        padding-top: 5px;
        color: var(--luxora-muted);
        font-size: 10px;
    }

    .luxora-room-description {
        min-height: 44px;
        margin: 12px 0 17px;
        color: var(--luxora-muted);
        font-size: 12px;
        line-height: 1.8;
    }

    .luxora-room-features {
        display: flex;
        flex-wrap: wrap;
        gap: 7px;
        min-height: 29px;
        margin-bottom: 22px;
    }

    .luxora-room-features span {
        padding: 6px 8px;
        color: #555a53;
        background: var(--luxora-ivory);
        font-size: 10px;
    }

    .luxora-room-footer {
        display: flex;
        align-items: end;
        justify-content: space-between;
        gap: 10px;
        padding-top: 17px;
        border-top: 1px solid var(--luxora-border);
    }

    .luxora-room-price > span {
        display: block;
        margin-bottom: 4px;
        color: var(--luxora-muted);
        font-size: 10px;
    }

    .luxora-room-price strong {
        color: var(--luxora-forest);
        font-family: Georgia, 'Times New Roman', serif;
        font-size: 23px;
        font-weight: 400;
    }

    .luxora-room-price small {
        color: var(--luxora-muted);
        font-size: 10px;
    }

    .luxora-room-link {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding-bottom: 5px;
        color: var(--luxora-forest);
        font-size: 10px;
        font-weight: 700;
        text-decoration: none;
        white-space: nowrap;
    }

    .luxora-empty-rooms {
        grid-column: 1 / -1;
        padding: 45px;
        text-align: center;
        background: var(--luxora-ivory);
    }

    .luxora-empty-rooms h3 {
        color: var(--luxora-forest);
        font-family: Georgia, 'Times New Roman', serif;
        font-weight: 400;
    }

    .luxora-empty-rooms p {
        color: var(--luxora-muted);
        font-size: 13px;
    }

    .luxora-experiences {
        background: #f3f0e9;
    }

    .luxora-experience-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 22px;
        max-width: 1240px;
        margin: 0 auto;
    }

    .luxora-experience-card {
        position: relative;
        min-height: 410px;
        overflow: hidden;
        background: var(--luxora-forest);
    }

    .luxora-experience-card::after {
        position: absolute;
        inset: 0;
        background: linear-gradient(
            180deg,
            rgba(17, 29, 23, .03) 15%,
            rgba(17, 29, 23, .88) 100%
        );
        content: "";
    }

    .luxora-experience-card > img {
        position: absolute;
        inset: 0;
        display: block;
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform .5s ease;
    }

    .luxora-experience-card:hover > img {
        transform: scale(1.05);
    }

    .luxora-experience-overlay {
        position: absolute;
        z-index: 1;
        right: 24px;
        bottom: 25px;
        left: 24px;
        color: #fff;
    }

    .luxora-experience-overlay > span {
        color: var(--luxora-gold-light);
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 2px;
    }

    .luxora-experience-overlay h3 {
        margin: 12px 0 9px;
        color: #fff;
        font-family: Georgia, 'Times New Roman', serif;
        font-size: 27px;
        font-weight: 400;
    }

    .luxora-experience-overlay p {
        margin: 0;
        color: rgba(255, 255, 255, .8);
        font-size: 12px;
        line-height: 1.8;
    }

    .luxora-experience-disclaimer {
        max-width: 1240px;
        margin: 18px auto 0;
        color: var(--luxora-muted);
        font-size: 10px;
    }

    .luxora-final-cta {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 430px;
        padding: 85px 7%;
        overflow: hidden;
        color: #fff;
        background:
            linear-gradient(rgba(23, 42, 34, .88), rgba(23, 42, 34, .88)),
            url('https://images.unsplash.com/photo-1511818966892-d7d671e672a2?auto=format&fit=crop&w=1800&q=85')
            center / cover no-repeat;
        text-align: center;
    }

    .luxora-final-cta-content {
        max-width: 680px;
    }

    .luxora-final-cta h2 {
        margin: 15px 0;
        color: #fff;
        font-size: clamp(38px, 5vw, 58px);
    }

    .luxora-final-cta p {
        max-width: 510px;
        margin: 0 auto 27px;
        color: rgba(255, 255, 255, .8);
        font-size: 14px;
        line-height: 1.9;
    }

    @media (max-width: 1100px) {
        .luxora-booking-form {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .luxora-search-btn {
            grid-column: 1 / -1;
        }

        .luxora-room-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .luxora-room-image {
            height: 280px;
        }

        .luxora-about {
            gap: 45px;
        }
    }

    @media (max-width: 760px) {
        .luxora-hero {
            min-height: 610px;
            padding: 85px 7% 105px;
            background-position: 60% center;
        }

        .luxora-hero-overlay {
            background: linear-gradient(
                90deg,
                rgba(15, 29, 23, .87),
                rgba(15, 29, 23, .45)
            );
        }

        .luxora-hero h1 {
            letter-spacing: -1px;
        }

        .luxora-hero-content > p {
            font-size: 14px;
        }

        .luxora-hero-caption {
            bottom: 23px;
            font-size: 8px;
            letter-spacing: 1px;
        }

        .luxora-booking-wrap {
            padding: 0 5%;
        }

        .luxora-booking-panel {
            padding: 30px 20px;
        }

        .luxora-booking-form {
            grid-template-columns: 1fr 1fr;
            gap: 15px 12px;
        }

        .luxora-search-btn {
            grid-column: 1 / -1;
            width: 100%;
        }

        .luxora-section {
            padding: 70px 6%;
        }

        .luxora-about {
            grid-template-columns: 1fr;
            gap: 38px;
        }

        .luxora-about-image > img {
            height: 400px;
        }

        .luxora-image-note {
            right: -7px;
            bottom: 18px;
            padding: 17px;
            font-size: 13px;
        }

        .luxora-section-heading {
            align-items: flex-start;
            flex-direction: column;
            gap: 18px;
        }

        .luxora-room-grid {
            grid-template-columns: 1fr;
            gap: 23px;
        }

        .luxora-room-image {
            height: 290px;
        }

        .luxora-experience-grid {
            grid-template-columns: 1fr;
        }

        .luxora-experience-card {
            min-height: 360px;
        }

        .luxora-final-cta {
            min-height: 390px;
            padding: 70px 6%;
        }
    }

    @media (max-width: 400px) {
        .luxora-hero-actions {
            align-items: stretch;
            flex-direction: column;
        }

        .luxora-hero-actions .luxora-btn {
            width: 100%;
        }

        .luxora-booking-form {
            grid-template-columns: 1fr;
        }

        .luxora-search-btn {
            grid-column: auto;
        }

        .luxora-room-title-row {
            flex-direction: column;
            gap: 5px;
        }

        .luxora-room-image {
            height: 240px;
        }

        .luxora-room-body {
            padding: 20px 16px;
        }

        .luxora-room-footer {
            align-items: flex-start;
            flex-direction: column;
        }
    }
</style>
@endpush


@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const checkIn = document.getElementById('check_in');
        const checkOut = document.getElementById('check_out');
        const bookingForm = document.getElementById('luxoraBookingForm');

        if (!checkIn || !checkOut || !bookingForm) {
            return;
        }

        // Use the browser's local calendar date, not a UTC date.
        function localDateString(date) {
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');

            return `${year}-${month}-${day}`;
        }

        const today = localDateString(new Date());
        checkIn.min = today;

        function updateCheckoutMinimum() {
            if (!checkIn.value || checkIn.value < today) {
                checkIn.setCustomValidity(
                    'Please choose today or a future date.'
                );
            } else {
                checkIn.setCustomValidity('');
            }

            const nextDay = new Date(`${checkIn.value}T12:00:00`);

            if (!Number.isNaN(nextDay.getTime())) {
                nextDay.setDate(nextDay.getDate() + 1);
                checkOut.min = localDateString(nextDay);

                if (checkOut.value && checkOut.value <= checkIn.value) {
                    checkOut.value = '';
                }
            } else {
                const tomorrow = new Date();
                tomorrow.setDate(tomorrow.getDate() + 1);
                checkOut.min = localDateString(tomorrow);
            }
        }

        checkIn.addEventListener('change', updateCheckoutMinimum);

        checkOut.addEventListener('change', function () {
            checkOut.setCustomValidity('');

            if (checkIn.value && checkOut.value <= checkIn.value) {
                checkOut.setCustomValidity(
                    'Check-out must be after check-in.'
                );
            }
        });

        bookingForm.addEventListener('submit', function (event) {
            updateCheckoutMinimum();

            if (
                !checkIn.value ||
                !checkOut.value ||
                checkIn.value < today ||
                checkOut.value <= checkIn.value
            ) {
                event.preventDefault();

                if (!checkIn.value || checkIn.value < today) {
                    checkIn.reportValidity();
                } else {
                    checkOut.setCustomValidity(
                        'Check-out must be after check-in.'
                    );
                    checkOut.reportValidity();
                }
            }
        });

        // Keep previously submitted dates when returning to the homepage.
        updateCheckoutMinimum();
    });
</script>
@endpush
