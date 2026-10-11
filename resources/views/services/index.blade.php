@extends('layouts.public')

@section('title', 'Our Services | Luxora Hotel')

@section('content')

<style>
    .lux-services {
        background: #faf9f6;
        color: #242725;
    }

    .lux-services-hero {
        position: relative;
        overflow: hidden;
        padding: 100px 24px 95px;
        background: #20382f;
        color: #fff;
        text-align: center;
    }

    .lux-services-hero::before,
    .lux-services-hero::after {
        position: absolute;
        width: 260px;
        height: 260px;
        border: 1px solid rgba(196, 165, 116, .2);
        border-radius: 50%;
        content: "";
        pointer-events: none;
    }

    .lux-services-hero::before {
        top: -145px;
        left: -70px;
    }

    .lux-services-hero::after {
        right: -80px;
        bottom: -170px;
        width: 340px;
        height: 340px;
    }

    .lux-services-hero-inner {
        position: relative;
        z-index: 1;
        max-width: 780px;
        margin: auto;
    }

    .lux-services-eyebrow {
        color: #e0c69a;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 3px;
        text-transform: uppercase;
    }

    .lux-services-hero h1 {
        margin: 22px 0;
        font-family: Georgia, "Times New Roman", serif;
        font-size: clamp(42px, 6vw, 72px);
        font-weight: 400;
        line-height: 1.1;
    }

    .lux-services-hero p {
        max-width: 620px;
        margin: 0 auto;
        color: rgba(255, 255, 255, .78);
        font-size: 15px;
        line-height: 2;
    }

    .lux-services-container {
        max-width: 1240px;
        margin: auto;
        padding: 75px 26px 95px;
    }

    .lux-services-intro {
        max-width: 680px;
        margin: 0 auto 48px;
        text-align: center;
    }

    .lux-services-intro h2 {
        margin: 15px 0;
        font-family: Georgia, "Times New Roman", serif;
        font-size: clamp(30px, 4vw, 44px);
        font-weight: 400;
    }

    .lux-services-intro p {
        color: #777a74;
        font-size: 14px;
        line-height: 1.9;
    }

    .lux-services-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 27px;
    }

    .lux-service-card {
        display: flex;
        min-width: 0;
        flex-direction: column;
        overflow: hidden;
        border: 1px solid #e8e2d7;
        background: #fff;
        transition: box-shadow .25s, transform .25s;
    }

    .lux-service-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 18px 45px rgba(32, 56, 47, .08);
    }

    .lux-service-image {
        position: relative;
        height: 225px;
        overflow: hidden;
        background: #e8e2d7;
    }

    .lux-service-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform .5s;
    }

    .lux-service-card:hover .lux-service-image img {
        transform: scale(1.04);
    }

    .lux-service-category {
        position: absolute;
        bottom: 15px;
        left: 16px;
        padding: 8px 12px;
        background: #20382f;
        color: #e0c69a;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 1.2px;
        text-transform: uppercase;
    }

    .lux-service-body {
        display: flex;
        flex: 1;
        flex-direction: column;
        padding: 25px;
    }

    .lux-service-body h3 {
        margin: 0 0 12px;
        font-family: Georgia, "Times New Roman", serif;
        font-size: 25px;
        font-weight: 400;
    }

    .lux-service-description {
        flex: 1;
        margin: 0;
        color: #777a74;
        font-size: 13px;
        line-height: 1.9;
        overflow-wrap: anywhere;
    }

    .lux-service-footer {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        margin-top: 24px;
        padding-top: 18px;
        border-top: 1px solid #e8e2d7;
    }

    .lux-service-price {
        color: #20382f;
        font-family: Georgia, "Times New Roman", serif;
        font-size: 23px;
    }

    .lux-service-price small {
        color: #777a74;
        font-family: Arial, sans-serif;
        font-size: 11px;
    }

    .lux-service-contact {
        color: #20382f;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 1px;
        text-decoration: none;
        text-transform: uppercase;
    }

    .lux-service-contact:hover {
        color: #9a7c4e;
    }

    .lux-services-empty {
        grid-column: 1 / -1;
        padding: 65px 25px;
        border: 1px solid #e8e2d7;
        background: #fff;
        text-align: center;
    }

    .lux-services-empty h3 {
        margin: 0 0 12px;
        font-family: Georgia, "Times New Roman", serif;
        font-size: 28px;
        font-weight: 400;
    }

    .lux-services-empty p {
        color: #777a74;
        font-size: 14px;
        line-height: 1.8;
    }

    .lux-services-cta {
        padding: 65px 24px;
        background: #f0ece3;
        text-align: center;
    }

    .lux-services-cta h2 {
        margin: 0 0 15px;
        font-family: Georgia, "Times New Roman", serif;
        font-size: clamp(30px, 4vw, 43px);
        font-weight: 400;
    }

    .lux-services-cta p {
        max-width: 550px;
        margin: 0 auto 25px;
        color: #777a74;
        font-size: 14px;
        line-height: 1.9;
    }

    .lux-services-cta a {
        display: inline-block;
        padding: 16px 25px;
        background: #20382f;
        color: #fff;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 1.5px;
        text-decoration: none;
        text-transform: uppercase;
    }

    .lux-services-cta a:hover {
        background: #c4a574;
        color: #172a22;
    }

    @media (max-width: 950px) {
        .lux-services-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 600px) {
        .lux-services-hero {
            padding: 75px 20px;
        }

        .lux-services-container {
            padding: 55px 20px 65px;
        }

        .lux-services-grid {
            grid-template-columns: 1fr;
        }

        .lux-service-image {
            height: 235px;
        }
    }
</style>

<div class="lux-services">

    <section class="lux-services-hero">
        <div class="lux-services-hero-inner">
            <span class="lux-services-eyebrow">The Luxora Experience</span>

            <h1>Thoughtful service.<br>Exceptional stays.</h1>

            <p>
                Discover the details that make your stay special.
                Explore Luxora's services, designed to bring comfort,
                convenience and a little extra luxury to every visit.
            </p>
        </div>
    </section>

    <section class="lux-services-container">
        <div class="lux-services-intro">
            <span class="lux-services-eyebrow">Made For You</span>

            <h2>More than a place to stay</h2>

            <p>
                From moments of relaxation to the little conveniences
                that make travel easier, discover the services available
                to enhance your Luxora experience.
            </p>
        </div>

        <div class="lux-services-grid">
            @forelse ($services as $service)
                <article class="lux-service-card">

                    <div class="lux-service-image">
                        <img
                            src="{{ $service->image ?: 'https://images.unsplash.com/photo-1414235077428-338989a2e8c0?auto=format&fit=crop&w=1000&q=85' }}"
                            alt="{{ $service->name }}"
                            loading="lazy"
                        >

                        <span class="lux-service-category">
                            {{ str_replace('_', ' ', $service->category) }}
                        </span>
                    </div>

                    <div class="lux-service-body">
                        <h3>{{ $service->name }}</h3>

                        <p class="lux-service-description">
                            {{ $service->description }}
                        </p>

                        <div class="lux-service-footer">
                            <div class="lux-service-price">
                                @if ((float) $service->price > 0)
                                    ₦{{ number_format((float) $service->price) }}
                                    <small>
                                        / {{ str_replace('_', ' ', $service->price_type) }}
                                    </small>
                                @else
                                    <small>Contact us for pricing</small>
                                @endif
                            </div>

                            <a
                                class="lux-service-contact"
                                href="{{ route('home') }}#contact"
                            >
                                Make an enquiry →
                            </a>
                        </div>
                    </div>

                </article>
            @empty
                <div class="lux-services-empty">
                    <h3>Something special is coming</h3>

                    <p>
                        Our service collection is being prepared.
                        Please check back soon or contact our team
                        for assistance with your stay.
                    </p>
                </div>
            @endforelse
        </div>
    </section>

    <section class="lux-services-cta">
        <h2>Let us make your stay memorable</h2>

        <p>
            Have a question about a service or need help planning
            your visit? Our team would be delighted to assist.
        </p>

        <a href="{{ route('home') }}#contact">
            Contact Luxora
        </a>
    </section>

</div>

@endsection
