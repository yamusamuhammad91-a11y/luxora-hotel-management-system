@extends('layouts.public')

@section('content')

<style>
    .booking-details-page {
        min-height: 75vh;
        padding: 65px 0 90px;
        background: #faf9f6;
    }

    .booking-details-container {
        width: min(1050px, calc(100% - 40px));
        margin: 0 auto;
    }

    .booking-back-link {
        display: inline-block;
        margin-bottom: 28px;
        color: #657067;
        font-size: 12px;
        text-decoration: none;
    }

    .booking-back-link:hover {
        color: #20382f;
    }

    .booking-eyebrow {
        margin-bottom: 12px;
        color: #a48758;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 2.5px;
        text-transform: uppercase;
    }

    .booking-heading {
        margin: 0;
        color: #20382f;
        font-family: 'Playfair Display', serif;
        font-size: clamp(30px, 5vw, 43px);
        font-weight: 500;
    }

    .booking-description {
        margin: 12px 0 30px;
        color: #777c74;
        font-size: 13px;
        line-height: 1.8;
    }

    .booking-summary {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        margin-bottom: 24px;
        padding: 24px;
        border: 1px solid #e8e3d9;
        background: #fff;
    }

    .booking-summary-label {
        margin-bottom: 8px;
        color: #858980;
        font-size: 10px;
        letter-spacing: 1.2px;
        text-transform: uppercase;
    }

    .booking-reference {
        color: #20382f;
        font-family: 'Playfair Display', serif;
        font-size: 25px;
        overflow-wrap: anywhere;
    }

    .booking-status {
        display: inline-block;
        padding: 8px 12px;
        border-radius: 3px;
        background: #edf4ee;
        color: #376548;
        font-size: 10px;
        font-weight: 700;
        text-transform: capitalize;
    }

    .booking-status.pending,
    .booking-status.unpaid {
        background: #fbf2df;
        color: #8a6932;
    }

    .booking-status.cancelled,
    .booking-status.failed,
    .booking-status.refunded {
        background: #f9eaea;
        color: #a34e4e;
    }

    .booking-details-grid {
        display: grid;
        grid-template-columns: minmax(0, 1.3fr) minmax(260px, .7fr);
        gap: 22px;
    }

    .booking-panel {
        min-width: 0;
        padding: 27px;
        border: 1px solid #e8e3d9;
        background: #fff;
    }

    .booking-panel-title {
        margin: 0 0 22px;
        color: #20382f;
        font-family: 'Playfair Display', serif;
        font-size: 22px;
        font-weight: 500;
    }

    .booking-info-list {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 24px 18px;
    }

    .booking-info-label {
        margin-bottom: 7px;
        color: #858980;
        font-size: 10px;
        letter-spacing: .8px;
        text-transform: uppercase;
    }

    .booking-info-value {
        color: #28332c;
        font-size: 13px;
        font-weight: 600;
        overflow-wrap: anywhere;
    }

    .booking-divider {
        height: 1px;
        margin: 24px 0;
        background: #eeeae2;
    }

    .booking-total-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
        margin-bottom: 15px;
        color: #777c74;
        font-size: 12px;
    }

    .booking-total-row strong {
        color: #20382f;
        text-align: right;
    }

    .booking-grand-total {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
        padding-top: 20px;
        border-top: 1px solid #e8e3d9;
    }

    .booking-grand-total span {
        color: #20382f;
        font-size: 12px;
        font-weight: 700;
    }

    .booking-grand-total strong {
        color: #20382f;
        font-family: 'Playfair Display', serif;
        font-size: 25px;
        text-align: right;
        overflow-wrap: anywhere;
    }

    .booking-note {
        margin-top: 23px;
        padding: 15px;
        background: #f7f3ea;
        color: #6f6b5f;
        font-size: 11px;
        line-height: 1.8;
    }

    .booking-special-request {
        margin-top: 24px;
        padding-top: 22px;
        border-top: 1px solid #eeeae2;
    }

    .booking-special-request p {
        margin: 9px 0 0;
        color: #62685f;
        font-size: 12px;
        line-height: 1.8;
        white-space: pre-line;
    }

    .booking-primary-link {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        min-height: 46px;
        margin-top: 22px;
        padding: 12px 18px;
        background: #20382f;
        color: #fff;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 1px;
        text-align: center;
        text-decoration: none;
    }

    .booking-primary-link:hover {
        background: #172a23;
    }

    .booking-secondary-link {
        display: block;
        margin-top: 17px;
        color: #8b7048;
        font-size: 11px;
        text-align: center;
        text-decoration: none;
    }

    .booking-secondary-link:hover {
        text-decoration: underline;
    }

    @media (max-width: 760px) {
        .booking-details-page {
            padding: 40px 0 60px;
        }

        .booking-details-grid {
            grid-template-columns: 1fr;
        }

        .booking-summary {
            align-items: flex-start;
            flex-direction: column;
            padding: 20px;
        }

        .booking-panel {
            padding: 21px;
        }
    }

    @media (max-width: 420px) {
        .booking-details-container {
            width: calc(100% - 28px);
        }

        .booking-info-list {
            grid-template-columns: 1fr;
            gap: 19px;
        }

        .booking-grand-total strong {
            font-size: 21px;
        }
    }
</style>

@php
    $bookingStatus = strtolower($booking->status ?? 'pending');
    $paymentStatus = strtolower($booking->payment_status ?? 'unpaid');
    $room = $booking->room;
@endphp

<section class="booking-details-page">
    <div class="booking-details-container">

        <a href="{{ route('guest.dashboard') }}" class="booking-back-link">
            ← Back to My Reservations
        </a>

        <div class="booking-eyebrow">Your Luxora Reservation</div>

        <h1 class="booking-heading">Booking Details</h1>

        <p class="booking-description">
            Review your reservation information and payment status below.
            Keep your booking reference for future enquiries.
        </p>

        <section class="booking-summary">
            <div>
                <div class="booking-summary-label">Booking reference</div>
                <div class="booking-reference">
                    {{ $booking->booking_reference }}
                </div>
            </div>

            <div>
                <div class="booking-summary-label">Reservation status</div>
                <span class="booking-status {{ $bookingStatus }}">
                    {{ ucfirst(str_replace('_', ' ', $bookingStatus)) }}
                </span>
            </div>
        </section>

        <div class="booking-details-grid">

            <section class="booking-panel">
                <h2 class="booking-panel-title">Your Stay</h2>

                <div class="booking-info-list">
                    <div>
                        <div class="booking-info-label">Guest name</div>
                        <div class="booking-info-value">
                            {{ $booking->guest_name }}
                        </div>
                    </div>

                    <div>
                        <div class="booking-info-label">Room type</div>
                        <div class="booking-info-value">
                            {{ $room?->name ?? 'Room unavailable' }}
                        </div>
                    </div>

                    <div>
                        <div class="booking-info-label">Check-in</div>
                        <div class="booking-info-value">
                            {{ \Illuminate\Support\Carbon::parse($booking->check_in)->format('l, d F Y') }}
                        </div>
                    </div>

                    <div>
                        <div class="booking-info-label">Check-out</div>
                        <div class="booking-info-value">
                            {{ \Illuminate\Support\Carbon::parse($booking->check_out)->format('l, d F Y') }}
                        </div>
                    </div>

                    <div>
                        <div class="booking-info-label">Length of stay</div>
                        <div class="booking-info-value">
                            {{ $booking->nights }} night(s)
                        </div>
                    </div>

                    <div>
                        <div class="booking-info-label">Rooms reserved</div>
                        <div class="booking-info-value">
                            {{ $booking->rooms_count }} room(s)
                        </div>
                    </div>

                    <div>
                        <div class="booking-info-label">Adults</div>
                        <div class="booking-info-value">
                            {{ $booking->adults }}
                        </div>
                    </div>

                    <div>
                        <div class="booking-info-label">Children</div>
                        <div class="booking-info-value">
                            {{ $booking->children }}
                        </div>
                    </div>

                    <div>
                        <div class="booking-info-label">Contact email</div>
                        <div class="booking-info-value">
                            {{ $booking->guest_email }}
                        </div>
                    </div>

                    <div>
                        <div class="booking-info-label">Contact phone</div>
                        <div class="booking-info-value">
                            {{ $booking->guest_phone }}
                        </div>
                    </div>
                </div>

                @if ($booking->special_requests)
                    <div class="booking-special-request">
                        <div class="booking-info-label">Special requests</div>
                        <p>{{ $booking->special_requests }}</p>
                    </div>
                @endif
            </section>

            <aside class="booking-panel">
                <h2 class="booking-panel-title">Payment Summary</h2>

                <div class="booking-total-row">
                    <span>Price per night</span>
                    <strong>
                        ₦{{ number_format((float) $booking->price_per_night, 2) }}
                    </strong>
                </div>

                <div class="booking-total-row">
                    <span>Number of nights</span>
                    <strong>{{ $booking->nights }}</strong>
                </div>

                <div class="booking-total-row">
                    <span>Number of rooms</span>
                    <strong>{{ $booking->rooms_count }}</strong>
                </div>

                <div class="booking-divider"></div>

                <div class="booking-grand-total">
                    <span>Total amount</span>
                    <strong>
                        ₦{{ number_format((float) $booking->total_amount, 2) }}
                    </strong>
                </div>

                <div style="margin-top:23px;">
                    <div class="booking-info-label">Payment method</div>
                    <div class="booking-info-value">
                        {{ $booking->payment_method === 'pay_at_hotel' ? 'Pay at hotel' : 'Online payment' }}
                    </div>
                </div>

                <div style="margin-top:20px;">
                    <div class="booking-info-label">Payment status</div>
                    <span class="booking-status {{ $paymentStatus }}">
                        {{ ucfirst(str_replace('_', ' ', $paymentStatus)) }}
                    </span>
                </div>

                @if ($booking->payment_reference)
                    <div style="margin-top:20px;">
                        <div class="booking-info-label">Payment reference</div>
                        <div class="booking-info-value">
                            {{ $booking->payment_reference }}
                        </div>
                    </div>
                @endif

                <div class="booking-note">
                    Your payment status reflects the information currently
                    recorded in the reservation. Online payment confirmation
                    requires an integrated payment provider.
                </div>

                <a href="{{ route('rooms.index') }}" class="booking-primary-link">
                    EXPLORE MORE ROOMS
                </a>

                <a href="{{ route('guest.dashboard') }}" class="booking-secondary-link">
                    Return to my reservations
                </a>
            </aside>

        </div>
    </div>
</section>

@endsection
