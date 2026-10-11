{{-- resources/views/bookings/create.blade.php --}}

@extends('layouts.public')

@section('content')

<section class="luxora-booking-page-hero">
    <div class="luxora-booking-page-hero-inner">
        <span class="luxora-eyebrow">YOUR LUXORA EXPERIENCE</span>
        <h1>Reserve Your Stay</h1>
        <p>Complete your details below to request your reservation.</p>
    </div>
</section>

<section class="luxora-booking-page">
    <div class="luxora-booking-layout">

        {{-- GUEST BOOKING FORM --}}
        <div class="luxora-booking-form-panel">
            <div class="luxora-booking-panel-heading">
                <span class="luxora-eyebrow">GUEST INFORMATION</span>
                <h2>Tell Us About Your Stay</h2>
                <p>Fields marked with * are required.</p>
            </div>

            @if ($errors->any())
                <div class="luxora-booking-errors" role="alert">
                    <strong>Please check the following:</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('booking.store') }}"
                  method="POST"
                  id="luxoraGuestBookingForm">
                @csrf

                <input type="hidden" name="room_id" value="{{ $room->id }}">

                <div class="luxora-booking-form-section">
                    <h3>01. Contact Details</h3>

                    <div class="luxora-booking-fields">
                        <div class="luxora-booking-field luxora-field-full">
                            <label for="guest_name">Full name *</label>
                            <input
                                type="text"
                                id="guest_name"
                                name="guest_name"
                                value="{{ old('guest_name') }}"
                                maxlength="150"
                                autocomplete="name"
                                placeholder="Enter your full name"
                                required
                            >
                        </div>

                        <div class="luxora-booking-field">
                            <label for="guest_email">Email address *</label>
                            <input
                                type="email"
                                id="guest_email"
                                name="guest_email"
                                value="{{ old('guest_email') }}"
                                maxlength="255"
                                autocomplete="email"
                                placeholder="you@example.com"
                                required
                            >
                        </div>

                        <div class="luxora-booking-field">
                            <label for="guest_phone">Phone number</label>
                            <input
                                type="tel"
                                id="guest_phone"
                                name="guest_phone"
                                value="{{ old('guest_phone') }}"
                                maxlength="30"
                                autocomplete="tel"
                                placeholder="Enter phone number"
                            >
                        </div>
                    </div>
                </div>

                <div class="luxora-booking-form-section">
                    <h3>02. Your Stay</h3>

                    <div class="luxora-booking-fields">
                        <div class="luxora-booking-field">
                            <label for="check_in">Check-in date *</label>
                            <input
                                type="date"
                                id="check_in"
                                name="check_in"
                                value="{{ old('check_in', request('check_in')) }}"
                                min="{{ now()->toDateString() }}"
                                required
                            >
                        </div>

                        <div class="luxora-booking-field">
                            <label for="check_out">Check-out date *</label>
                            <input
                                type="date"
                                id="check_out"
                                name="check_out"
                                value="{{ old('check_out', request('check_out')) }}"
                                min="{{ now()->addDay()->toDateString() }}"
                                required
                            >
                        </div>

                        <div class="luxora-booking-field">
                            <label for="adults">Adults *</label>
                            <select id="adults" name="adults" required>
                                @for ($i = 1; $i <= 6; $i++)
                                    <option
                                        value="{{ $i }}"
                                        @selected((int) old('adults', request('adults', 2)) === $i)
                                    >
                                        {{ $i }} {{ $i === 1 ? 'Adult' : 'Adults' }}
                                    </option>
                                @endfor
                            </select>
                        </div>

                        <div class="luxora-booking-field">
                            <label for="children">Children</label>
                            <select id="children" name="children">
                                @for ($i = 0; $i <= 6; $i++)
                                    <option
                                        value="{{ $i }}"
                                        @selected((int) old('children', 0) === $i)
                                    >
                                        {{ $i }} {{ $i === 1 ? 'Child' : 'Children' }}
                                    </option>
                                @endfor
                            </select>
                        </div>

                        <div class="luxora-booking-field luxora-field-full">
                            <label for="rooms_count">Number of rooms *</label>
                            <select id="rooms_count" name="rooms_count" required>
                                @for ($i = 1; $i <= 4; $i++)
                                    <option
                                        value="{{ $i }}"
                                        @selected((int) old('rooms_count', request('rooms', 1)) === $i)
                                    >
                                        {{ $i }} {{ $i === 1 ? 'Room' : 'Rooms' }}
                                    </option>
                                @endfor
                            </select>
                            <small>Each selected room uses the room type shown in your summary.</small>
                        </div>
                    </div>
                </div>

                <div class="luxora-booking-form-section">
                    <h3>03. Payment Preference</h3>

                    <p class="luxora-payment-explanation">
                        Choose how you would prefer to pay. Online payment is
                        not processed on this form; payment instructions will
                        be provided once the payment integration is configured.
                    </p>

                    <div class="luxora-payment-options">
                        <label class="luxora-payment-option">
                            <input
                                type="radio"
                                name="payment_method"
                                value="online"
                                @checked(old('payment_method', 'online') === 'online')
                                required
                            >
                            <span class="luxora-payment-option-content">
                                <strong>Online Payment</strong>
                                <small>Payment processing will be integrated separately.</small>
                            </span>
                        </label>

                        <label class="luxora-payment-option">
                            <input
                                type="radio"
                                name="payment_method"
                                value="pay_at_hotel"
                                @checked(old('payment_method') === 'pay_at_hotel')
                                required
                            >
                            <span class="luxora-payment-option-content">
                                <strong>Pay at the Hotel</strong>
                                <small>Payment remains subject to hotel confirmation.</small>
                            </span>
                        </label>
                    </div>
                </div>

                <div class="luxora-booking-form-section">
                    <h3>04. Special Requests</h3>

                    <div class="luxora-booking-field">
                        <label for="special_requests">Additional information (optional)</label>
                        <textarea
                            id="special_requests"
                            name="special_requests"
                            rows="4"
                            maxlength="2000"
                            placeholder="Tell us about any preferences or requests..."
                        >{{ old('special_requests') }}</textarea>
                    </div>
                </div>

                <label class="luxora-booking-consent">
                    <input type="checkbox" name="booking_acknowledgement" value="1" required>
                    <span>
                        I confirm that the details provided are accurate and
                        understand that this submission is a booking request,
                        not a guarantee of room availability.
                    </span>
                </label>

                <button type="submit" class="luxora-booking-submit">
                    Submit Booking Request
                    <span aria-hidden="true">→</span>
                </button>

                <p class="luxora-booking-security-note">
                    Your reservation will remain pending until it is reviewed
                    and confirmed by the hotel.
                </p>
            </form>
        </div>

        {{-- ROOM SUMMARY --}}
        <aside class="luxora-booking-summary">
            <div class="luxora-booking-summary-image">
                <img
                    src="{{ $room->image ?: 'https://images.unsplash.com/photo-1611892440504-42a792e24d32?auto=format&fit=crop&w=1000&q=85' }}"
                    alt="{{ $room->name }}"
                >
                <span>YOUR SELECTED ROOM</span>
            </div>

            <div class="luxora-booking-summary-body">
                <span class="luxora-eyebrow">LUXORA ACCOMMODATION</span>
                <h2>{{ $room->name }}</h2>
                <p>{{ $room->description }}</p>

                <div class="luxora-summary-detail">
                    <span>Room capacity</span>
                    <strong>Up to {{ $room->capacity }} guests per room</strong>
                </div>

                @if ($room->features)
                    <div class="luxora-booking-room-features">
                        @foreach ($room->features as $feature)
                            <span>✦ {{ $feature }}</span>
                        @endforeach
                    </div>
                @endif

                <div class="luxora-booking-summary-price">
                    <span>Room rate</span>
                    <strong>₦{{ number_format((float) $room->price, 2) }}</strong>
                    <small>per room, per night</small>
                </div>

                <div class="luxora-booking-estimate">
                    <span>Estimated stay total</span>
                    <strong id="luxoraEstimatedTotal">Select your dates</strong>
                    <small id="luxoraEstimateNote">
                        Final charges depend on the reservation details.
                    </small>
                </div>

                <a href="{{ route('rooms.show', $room->slug) }}"
                   class="luxora-booking-back-link">
                    ← Back to room details
                </a>
            </div>
        </aside>

    </div>
</section>

@endsection


@push('styles')
<style>
    .luxora-booking-page-hero {
        padding: 70px 7%;
        color: #fff;
        background: #20382f;
    }

    .luxora-booking-page-hero-inner {
        max-width: 1240px;
        margin: 0 auto;
    }

    .luxora-booking-page-hero h1 {
        margin: 12px 0;
        color: #fff;
        font-family: Georgia, 'Times New Roman', serif;
        font-size: clamp(36px, 5vw, 58px);
        font-weight: 400;
    }

    .luxora-booking-page-hero p {
        margin: 0;
        color: rgba(255,255,255,.8);
        font-size: 14px;
        line-height: 1.8;
    }

    .luxora-booking-page {
        padding: 60px 7% 100px;
        background: #faf9f6;
    }

    .luxora-booking-layout {
        display: grid;
        grid-template-columns: minmax(0, 1.6fr) minmax(280px, .8fr);
        align-items: start;
        gap: 30px;
        max-width: 1240px;
        margin: 0 auto;
    }

    .luxora-booking-form-panel,
    .luxora-booking-summary {
        border: 1px solid #e8e2d7;
        background: #fff;
    }

    .luxora-booking-form-panel {
        padding: 35px;
    }

    .luxora-booking-panel-heading {
        padding-bottom: 25px;
        border-bottom: 1px solid #e8e2d7;
    }

    .luxora-booking-panel-heading h2 {
        margin: 9px 0;
        color: #20382f;
        font-family: Georgia, 'Times New Roman', serif;
        font-size: 32px;
        font-weight: 400;
    }

    .luxora-booking-panel-heading p {
        margin: 0;
        color: #777a74;
        font-size: 12px;
    }

    .luxora-booking-errors {
        margin-top: 22px;
        padding: 17px 20px;
        border: 1px solid #e9b8b8;
        color: #842c2c;
        background: #fff5f5;
        font-size: 12px;
        line-height: 1.8;
    }

    .luxora-booking-errors ul {
        margin: 8px 0 0;
        padding-left: 20px;
    }

    .luxora-booking-form-section {
        padding: 28px 0;
        border-bottom: 1px solid #e8e2d7;
    }

    .luxora-booking-form-section h3 {
        margin: 0 0 20px;
        color: #20382f;
        font-family: Georgia, 'Times New Roman', serif;
        font-size: 21px;
        font-weight: 400;
    }

    .luxora-booking-fields {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 18px;
    }

    .luxora-booking-field {
        min-width: 0;
    }

    .luxora-field-full {
        grid-column: 1 / -1;
    }

    .luxora-booking-field label {
        display: block;
        margin-bottom: 8px;
        color: #383d38;
        font-size: 11px;
        font-weight: 700;
    }

    .luxora-booking-field input,
    .luxora-booking-field select,
    .luxora-booking-field textarea {
        display: block;
        width: 100%;
        min-height: 46px;
        padding: 12px;
        border: 1px solid #e2ddd3;
        border-radius: 0;
        color: #242725;
        background: #fff;
        font: inherit;
        font-size: 12px;
    }

    .luxora-booking-field textarea {
        min-height: 110px;
        resize: vertical;
        line-height: 1.7;
    }

    .luxora-booking-field input:focus,
    .luxora-booking-field select:focus,
    .luxora-booking-field textarea:focus {
        border-color: #c4a574;
        outline: 2px solid rgba(196,165,116,.18);
    }

    .luxora-booking-field > small {
        display: block;
        margin-top: 7px;
        color: #777a74;
        font-size: 10px;
        line-height: 1.6;
    }

    .luxora-payment-explanation {
        margin: -5px 0 17px;
        color: #777a74;
        font-size: 12px;
        line-height: 1.8;
    }

    .luxora-payment-options {
        display: grid;
        gap: 12px;
    }

    .luxora-payment-option {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        padding: 17px;
        border: 1px solid #e8e2d7;
        cursor: pointer;
    }

    .luxora-payment-option:has(input:checked) {
        border-color: #c4a574;
        background: #fcfaf5;
    }

    .luxora-payment-option input {
        margin-top: 4px;
        accent-color: #20382f;
    }

    .luxora-payment-option-content {
        display: grid;
        gap: 6px;
    }

    .luxora-payment-option-content strong {
        color: #20382f;
        font-size: 12px;
    }

    .luxora-payment-option-content small {
        color: #777a74;
        font-size: 11px;
        line-height: 1.6;
    }

    .luxora-booking-consent {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        margin: 25px 0;
        color: #656961;
        font-size: 11px;
        line-height: 1.8;
        cursor: pointer;
    }

    .luxora-booking-consent input {
        margin-top: 4px;
        accent-color: #20382f;
    }

    .luxora-booking-submit {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
        width: 100%;
        min-height: 52px;
        padding: 15px 20px;
        border: 0;
        color: #fff;
        background: #20382f;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: .8px;
        cursor: pointer;
    }

    .luxora-booking-submit:hover {
        background: #172a22;
    }

    .luxora-booking-security-note {
        margin: 13px 0 0;
        color: #777a74;
        font-size: 10px;
        line-height: 1.7;
        text-align: center;
    }

    .luxora-booking-summary {
        position: sticky;
        top: 25px;
        overflow: hidden;
    }

    .luxora-booking-summary-image {
        position: relative;
        height: 225px;
        background: #e8e2d7;
    }

    .luxora-booking-summary-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .luxora-booking-summary-image > span {
        position: absolute;
        right: 12px;
        bottom: 12px;
        padding: 9px 11px;
        color: #20382f;
        background: #faf9f6;
        font-size: 9px;
        font-weight: 700;
        letter-spacing: 1px;
    }

    .luxora-booking-summary-body {
        padding: 25px;
    }

    .luxora-booking-summary-body h2 {
        margin: 9px 0;
        color: #20382f;
        font-family: Georgia, 'Times New Roman', serif;
        font-size: 28px;
        font-weight: 400;
    }

    .luxora-booking-summary-body > p {
        margin: 0 0 22px;
        color: #777a74;
        font-size: 12px;
        line-height: 1.8;
    }

    .luxora-summary-detail {
        display: flex;
        flex-direction: column;
        gap: 7px;
        padding: 15px 0;
        border-top: 1px solid #e8e2d7;
        border-bottom: 1px solid #e8e2d7;
    }

    .luxora-summary-detail span {
        color: #777a74;
        font-size: 10px;
    }

    .luxora-summary-detail strong {
        color: #20382f;
        font-size: 12px;
    }

    .luxora-booking-room-features {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin: 17px 0;
    }

    .luxora-booking-room-features span {
        padding: 7px 9px;
        color: #555a53;
        background: #f7f5ef;
        font-size: 10px;
    }

    .luxora-booking-summary-price,
    .luxora-booking-estimate {
        display: flex;
        flex-direction: column;
        gap: 7px;
        padding: 18px 0;
        border-top: 1px solid #e8e2d7;
    }

    .luxora-booking-summary-price > span,
    .luxora-booking-estimate > span {
        color: #777a74;
        font-size: 11px;
    }

    .luxora-booking-summary-price > strong,
    .luxora-booking-estimate > strong {
        color: #20382f;
        font-family: Georgia, 'Times New Roman', serif;
        font-size: 25px;
        font-weight: 400;
        overflow-wrap: anywhere;
    }

    .luxora-booking-summary-price > small,
    .luxora-booking-estimate > small {
        color: #777a74;
        font-size: 10px;
        line-height: 1.6;
    }

    .luxora-booking-estimate {
        padding-bottom: 22px;
        border-bottom: 1px solid #e8e2d7;
    }

    .luxora-booking-back-link {
        display: inline-block;
        margin-top: 20px;
        color: #20382f;
        font-size: 11px;
        font-weight: 700;
        text-decoration: none;
    }

    @media (max-width: 950px) {
        .luxora-booking-layout {
            grid-template-columns: minmax(0, 1.3fr) minmax(250px, .8fr);
            gap: 20px;
        }

        .luxora-booking-form-panel {
            padding: 25px;
        }

        .luxora-booking-summary-body {
            padding: 20px;
        }
    }

    @media (max-width: 760px) {
        .luxora-booking-page-hero {
            padding: 55px 6%;
        }

        .luxora-booking-page {
            padding: 35px 5% 65px;
        }

        .luxora-booking-layout {
            grid-template-columns: 1fr;
        }

        .luxora-booking-summary {
            position: static;
            grid-row: 1;
        }

        .luxora-booking-form-panel {
            padding: 25px 20px;
        }

        .luxora-booking-summary-image {
            height: 250px;
        }
    }

    @media (max-width: 430px) {
        .luxora-booking-fields {
            grid-template-columns: 1fr;
        }

        .luxora-field-full {
            grid-column: auto;
        }

        .luxora-booking-panel-heading h2 {
            font-size: 27px;
        }
    }
</style>
@endpush


@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const checkIn = document.getElementById('check_in');
        const checkOut = document.getElementById('check_out');
        const adults = document.getElementById('adults');
        const children = document.getElementById('children');
        const roomsCount = document.getElementById('rooms_count');
        const totalElement = document.getElementById('luxoraEstimatedTotal');
        const noteElement = document.getElementById('luxoraEstimateNote');
        const form = document.getElementById('luxoraGuestBookingForm');

        if (!checkIn || !checkOut || !totalElement || !form) {
            return;
        }

        const pricePerNight = {{ json_encode((float) $room->price) }};

        function localDateString(date) {
            return [
                date.getFullYear(),
                String(date.getMonth() + 1).padStart(2, '0'),
                String(date.getDate()).padStart(2, '0')
            ].join('-');
        }

        function updateCheckoutMinimum() {
            if (!checkIn.value) {
                return;
            }

            const nextDay = new Date(checkIn.value + 'T12:00:00');
            nextDay.setDate(nextDay.getDate() + 1);

            checkOut.min = localDateString(nextDay);

            if (checkOut.value && checkOut.value < checkOut.min) {
                checkOut.value = '';
            }
        }

        function updateEstimate() {
            if (!checkIn.value || !checkOut.value ||
                checkOut.value <= checkIn.value) {
                totalElement.textContent = 'Select your dates';
                noteElement.textContent =
                    'Choose valid check-in and check-out dates to estimate your stay.';
                return;
            }

            const start = new Date(checkIn.value + 'T12:00:00');
            const end = new Date(checkOut.value + 'T12:00:00');
            const nights = Math.round((end - start) / 86400000);
            const roomQuantity = Number(roomsCount.value || 1);
            const total = pricePerNight * nights * roomQuantity;

            totalElement.textContent = new Intl.NumberFormat('en-NG', {
                style: 'currency',
                currency: 'NGN',
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }).format(total);

            noteElement.textContent =
                nights + (nights === 1 ? ' night' : ' nights') +
                ' × ' + roomQuantity +
                (roomQuantity === 1 ? ' room' : ' rooms') +
                '. Estimated only; final availability and charges require confirmation.';
        }

        checkIn.addEventListener('change', function () {
            updateCheckoutMinimum();
            updateEstimate();
        });

        checkOut.addEventListener('change', updateEstimate);
        roomsCount.addEventListener('change', updateEstimate);
        adults.addEventListener('change', updateEstimate);

        if (children) {
            children.addEventListener('change', updateEstimate);
        }

        form.addEventListener('submit', function (event) {
            updateCheckoutMinimum();

            if (!checkIn.value || !checkOut.value ||
                checkOut.value <= checkIn.value) {
                event.preventDefault();

                if (!checkIn.value) {
                    checkIn.reportValidity();
                } else {
                    checkOut.setCustomValidity(
                        'Check-out must be after check-in.'
                    );
                    checkOut.reportValidity();
                }
            }
        });

        checkOut.addEventListener('input', function () {
            checkOut.setCustomValidity('');
        });

        updateCheckoutMinimum();
        updateEstimate();
    });
</script>
@endpush
