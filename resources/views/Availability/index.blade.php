{{-- resources/views/availability/index.blade.php --}}

@extends('layouts.public')

@section('content')

<section class="luxora-availability-hero">
    <div class="luxora-availability-hero-inner">
        <span class="luxora-eyebrow">YOUR LUXORA STAY</span>
        <h1>Find Your Perfect Room</h1>
        <p>Explore our accommodation options for your selected dates.</p>
    </div>
</section>

<section class="luxora-availability-page">

    {{-- SEARCH SUMMARY --}}
    <div class="luxora-search-summary">
        <div>
            <span class="luxora-summary-label">CHECK-IN</span>
            <strong>{{ \Carbon\Carbon::parse($search['check_in'])->format('D, d M Y') }}</strong>
        </div>

        <div>
            <span class="luxora-summary-label">CHECK-OUT</span>
            <strong>{{ \Carbon\Carbon::parse($search['check_out'])->format('D, d M Y') }}</strong>
        </div>

        <div>
            <span class="luxora-summary-label">LENGTH OF STAY</span>
            <strong>{{ $nights }} {{ $nights === 1 ? 'night' : 'nights' }}</strong>
        </div>

        <div>
            <span class="luxora-summary-label">GUESTS / ROOMS</span>
            <strong>
                {{ $search['adults'] }} {{ (int) $search['adults'] === 1 ? 'adult' : 'adults' }},
                {{ $search['rooms'] }} {{ (int) $search['rooms'] === 1 ? 'room' : 'rooms' }}
            </strong>
        </div>
    </div>

    {{-- CHANGE SEARCH --}}
    <details class="luxora-change-search">
        <summary>Change your search</summary>

        <form action="{{ route('availability') }}"
              method="GET"
              class="luxora-change-search-form">

            <div>
                <label for="availability_check_in">Check-in</label>
                <input
                    id="availability_check_in"
                    type="date"
                    name="check_in"
                    value="{{ $search['check_in'] }}"
                    min="{{ now()->toDateString() }}"
                    required
                >
            </div>

            <div>
                <label for="availability_check_out">Check-out</label>
                <input
                    id="availability_check_out"
                    type="date"
                    name="check_out"
                    value="{{ $search['check_out'] }}"
                    min="{{ \Carbon\Carbon::parse($search['check_in'])->addDay()->toDateString() }}"
                    required
                >
            </div>

            <div>
                <label for="availability_adults">Adults</label>
                <select id="availability_adults" name="adults" required>
                    @for ($i = 1; $i <= 6; $i++)
                        <option value="{{ $i }}" @selected((int) $search['adults'] === $i)>
                            {{ $i }}
                        </option>
                    @endfor
                </select>
            </div>

            <div>
                <label for="availability_rooms">Rooms</label>
                <select id="availability_rooms" name="rooms" required>
                    @for ($i = 1; $i <= 4; $i++)
                        <option value="{{ $i }}" @selected((int) $search['rooms'] === $i)>
                            {{ $i }}
                        </option>
                    @endfor
                </select>
            </div>

            @if (!empty($search['room']))
                <input type="hidden" name="room" value="{{ $search['room'] }}">
            @endif

            <button type="submit" class="luxora-availability-btn">
                Update Search
            </button>
        </form>
    </details>

    {{-- RESULTS HEADING --}}
    <div class="luxora-results-heading">
        <div>
            <span class="luxora-eyebrow">EXPLORE YOUR OPTIONS</span>
            <h2>Available Room Types</h2>
        </div>

        <span class="luxora-results-count">
            {{ count($rooms) }} {{ count($rooms) === 1 ? 'option' : 'options' }}
        </span>
    </div>

    <p class="luxora-availability-notice">
        These results match your selected dates and room capacity.
        Final availability is subject to booking confirmation.
    </p>

    {{-- ROOM RESULTS --}}
    @if (count($rooms) > 0)
        <div class="luxora-availability-list">
            @foreach ($rooms as $room)
                <article class="luxora-availability-card">

                    <a
                        href="{{ route('rooms.show', $room['slug']) }}"
                        class="luxora-availability-image"
                    >
                        <img
                            src="{{ $room['image'] ?: 'https://images.unsplash.com/photo-1611892440504-42a792e24d32?auto=format&fit=crop&w=1000&q=85' }}"
                            alt="{{ $room['name'] }}"
                            loading="lazy"
                        >
                    </a>

                    <div class="luxora-availability-info">
                        <span class="luxora-availability-type">LUXORA ACCOMMODATION</span>

                        <h3>
                            <a href="{{ route('rooms.show', $room['slug']) }}">
                                {{ $room['name'] }}
                            </a>
                        </h3>

                        <p>{{ $room['description'] }}</p>

                        <div class="luxora-availability-features">
                            <span>Up to {{ $room['capacity'] }} guests per room</span>

                            @foreach (array_slice($room['features'] ?? [], 0, 3) as $feature)
                                <span>{{ $feature }}</span>
                            @endforeach
                        </div>

                        <a
                            href="{{ route('rooms.show', $room['slug']) }}"
                            class="luxora-availability-details"
                        >
                            View Room Details <span aria-hidden="true">→</span>
                        </a>
                    </div>

                    <div class="luxora-availability-price">
                        <span>Price per room</span>

                        <strong>₦{{ number_format($room['price'], 2) }}</strong>

                        <small>per night</small>

                        <div class="luxora-price-divider"></div>

                        <span>Estimated total for {{ $nights }} {{ $nights === 1 ? 'night' : 'nights' }}</span>

                        <strong class="luxora-total-price">
                            ₦{{ number_format($room['price'] * $nights, 2) }}
                        </strong>

                        <small>before additional charges</small>

                        <a
                            href="{{ route('rooms.show', $room['slug']) }}"
                            class="luxora-availability-btn"
                        >
                            Select Room
                        </a>
                    </div>

                </article>
            @endforeach
        </div>
    @else
        <div class="luxora-no-results">
            <span class="luxora-no-results-icon">✦</span>
            <h3>No matching room types found</h3>
            <p>
                Try reducing the number of guests per room or changing
                your search to explore other accommodation options.
            </p>

            <a href="{{ route('home') }}#booking" class="luxora-availability-btn">
                Search Again
            </a>
        </div>
    @endif

</section>

@endsection


@push('styles')
<style>
    .luxora-availability-hero {
        padding: 78px 7%;
        color: #fff;
        background:
            linear-gradient(rgba(23, 42, 34, .88), rgba(23, 42, 34, .88)),
            url('https://images.unsplash.com/photo-1611892440504-42a792e24d32?auto=format&fit=crop&w=1800&q=85')
            center 50% / cover no-repeat;
    }

    .luxora-availability-hero-inner {
        max-width: 1240px;
        margin: 0 auto;
    }

    .luxora-availability-hero h1 {
        margin: 13px 0;
        color: #fff;
        font-family: Georgia, 'Times New Roman', serif;
        font-size: clamp(36px, 5vw, 60px);
        font-weight: 400;
    }

    .luxora-availability-hero p {
        margin: 0;
        color: rgba(255,255,255,.8);
        font-size: 14px;
        line-height: 1.8;
    }

    .luxora-availability-page {
        max-width: 1400px;
        min-height: 500px;
        margin: 0 auto;
        padding: 50px 7% 100px;
        color: #242725;
        background: #faf9f6;
    }

    .luxora-search-summary {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 20px;
        padding: 26px;
        border: 1px solid #e8e2d7;
        background: #fff;
    }

    .luxora-search-summary > div {
        display: flex;
        flex-direction: column;
        gap: 9px;
    }

    .luxora-summary-label {
        color: #777a74;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 1.5px;
    }

    .luxora-search-summary strong {
        color: #20382f;
        font-size: 13px;
        font-weight: 600;
    }

    .luxora-change-search {
        margin: 16px 0 45px;
        border: 1px solid #e8e2d7;
        background: #fff;
    }

    .luxora-change-search summary {
        padding: 16px 20px;
        color: #20382f;
        font-size: 12px;
        font-weight: 700;
        cursor: pointer;
    }

    .luxora-change-search-form {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr)) auto;
        gap: 13px;
        align-items: end;
        padding: 0 20px 20px;
    }

    .luxora-change-search-form label {
        display: block;
        margin-bottom: 8px;
        color: #555a53;
        font-size: 11px;
        font-weight: 600;
    }

    .luxora-change-search-form input,
    .luxora-change-search-form select {
        width: 100%;
        min-width: 0;
        min-height: 44px;
        padding: 10px;
        border: 1px solid #e8e2d7;
        border-radius: 0;
        background: #fff;
        color: #242725;
        font: inherit;
        font-size: 12px;
    }

    .luxora-results-heading {
        display: flex;
        align-items: end;
        justify-content: space-between;
        gap: 20px;
        margin-bottom: 14px;
    }

    .luxora-results-heading h2 {
        margin: 8px 0 0;
        color: #20382f;
        font-family: Georgia, 'Times New Roman', serif;
        font-size: clamp(28px, 3vw, 39px);
        font-weight: 400;
    }

    .luxora-results-count {
        padding: 8px 12px;
        color: #20382f;
        background: #eeece4;
        font-size: 11px;
        white-space: nowrap;
    }

    .luxora-availability-notice {
        margin: 0 0 25px;
        color: #777a74;
        font-size: 12px;
        line-height: 1.8;
    }

    .luxora-availability-list {
        display: grid;
        gap: 20px;
    }

    .luxora-availability-card {
        display: grid;
        grid-template-columns: minmax(190px, .9fr) minmax(0, 1.5fr) minmax(190px, .8fr);
        gap: 25px;
        align-items: stretch;
        padding: 20px;
        border: 1px solid #e8e2d7;
        background: #fff;
    }

    .luxora-availability-image {
        display: block;
        min-height: 245px;
        overflow: hidden;
        background: #e8e2d7;
    }

    .luxora-availability-image img {
        display: block;
        width: 100%;
        height: 100%;
        min-height: 245px;
        object-fit: cover;
        transition: transform .4s ease;
    }

    .luxora-availability-image:hover img {
        transform: scale(1.04);
    }

    .luxora-availability-info {
        padding: 10px 0;
    }

    .luxora-availability-type {
        color: #a18758;
        font-size: 9px;
        font-weight: 700;
        letter-spacing: 1.7px;
    }

    .luxora-availability-info h3 {
        margin: 12px 0;
        font-family: Georgia, 'Times New Roman', serif;
        font-size: 27px;
        font-weight: 400;
    }

    .luxora-availability-info h3 a {
        color: #20382f;
        text-decoration: none;
    }

    .luxora-availability-info > p {
        margin: 0 0 17px;
        color: #777a74;
        font-size: 12px;
        line-height: 1.9;
    }

    .luxora-availability-features {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-bottom: 22px;
    }

    .luxora-availability-features span {
        padding: 7px 9px;
        color: #555a53;
        background: #f7f5ef;
        font-size: 10px;
    }

    .luxora-availability-details {
        display: inline-flex;
        gap: 9px;
        color: #20382f;
        font-size: 11px;
        font-weight: 700;
        text-decoration: none;
    }

    .luxora-availability-price {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        justify-content: center;
        padding: 12px 0 12px 22px;
        border-left: 1px solid #e8e2d7;
    }

    .luxora-availability-price > span {
        margin-bottom: 7px;
        color: #777a74;
        font-size: 10px;
        line-height: 1.6;
    }

    .luxora-availability-price > strong {
        color: #20382f;
        font-family: Georgia, 'Times New Roman', serif;
        font-size: 25px;
        font-weight: 400;
        overflow-wrap: anywhere;
    }

    .luxora-availability-price > small {
        margin-top: 4px;
        color: #777a74;
        font-size: 10px;
    }

    .luxora-price-divider {
        width: 100%;
        margin: 17px 0;
        border-top: 1px solid #e8e2d7;
    }

    .luxora-availability-price > strong.luxora-total-price {
        font-size: 22px;
    }

    .luxora-availability-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 43px;
        margin-top: 18px;
        padding: 12px 18px;
        border: 1px solid #20382f;
        color: #fff;
        background: #20382f;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: .7px;
        text-align: center;
        text-decoration: none;
        cursor: pointer;
    }

    .luxora-availability-btn:hover {
        color: #fff;
        background: #172a22;
    }

    .luxora-no-results {
        padding: 55px 25px;
        border: 1px solid #e8e2d7;
        background: #fff;
        text-align: center;
    }

    .luxora-no-results-icon {
        color: #c4a574;
        font-size: 27px;
    }

    .luxora-no-results h3 {
        margin: 15px 0 10px;
        color: #20382f;
        font-family: Georgia, 'Times New Roman', serif;
        font-size: 28px;
        font-weight: 400;
    }

    .luxora-no-results p {
        max-width: 500px;
        margin: 0 auto;
        color: #777a74;
        font-size: 13px;
        line-height: 1.8;
    }

    @media (max-width: 1000px) {
        .luxora-availability-card {
            grid-template-columns: minmax(180px, .8fr) minmax(0, 1.2fr);
        }

        .luxora-availability-price {
            grid-column: 1 / -1;
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 7px 15px;
            padding: 20px 0 0;
            border-top: 1px solid #e8e2d7;
            border-left: 0;
        }

        .luxora-availability-price > span,
        .luxora-availability-price > small {
            margin: 0;
        }

        .luxora-availability-price > strong {
            text-align: right;
        }

        .luxora-price-divider {
            display: none;
        }

        .luxora-availability-price > .luxora-availability-btn {
            grid-column: 1 / -1;
            width: 100%;
            margin-top: 10px;
        }
    }

    @media (max-width: 650px) {
        .luxora-availability-hero {
            padding: 58px 6%;
        }

        .luxora-availability-page {
            padding: 30px 5% 65px;
        }

        .luxora-search-summary {
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 22px 14px;
            padding: 20px;
        }

        .luxora-change-search-form {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .luxora-change-search-form > button {
            grid-column: 1 / -1;
        }

        .luxora-results-heading {
            align-items: flex-start;
        }

        .luxora-availability-card {
            grid-template-columns: 1fr;
            gap: 16px;
            padding: 14px;
        }

        .luxora-availability-image,
        .luxora-availability-image img {
            height: 235px;
            min-height: 235px;
        }

        .luxora-availability-info {
            padding: 5px 2px;
        }

        .luxora-availability-price {
            grid-column: auto;
        }
    }

    @media (max-width: 380px) {
        .luxora-change-search-form {
            grid-template-columns: 1fr;
        }

        .luxora-change-search-form > button {
            grid-column: auto;
        }
    }
</style>
@endpush


@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const checkIn = document.getElementById('availability_check_in');
        const checkOut = document.getElementById('availability_check_out');

        if (!checkIn || !checkOut) {
            return;
        }

        function updateCheckoutMinimum() {
            if (!checkIn.value) {
                return;
            }

            const nextDay = new Date(checkIn.value + 'T12:00:00');
            nextDay.setDate(nextDay.getDate() + 1);

            const minDate = [
                nextDay.getFullYear(),
                String(nextDay.getMonth() + 1).padStart(2, '0'),
                String(nextDay.getDate()).padStart(2, '0')
            ].join('-');

            checkOut.min = minDate;

            if (checkOut.value && checkOut.value < minDate) {
                checkOut.value = minDate;
            }
        }

        checkIn.addEventListener('change', updateCheckoutMinimum);
    });
</script>
@endpush
