{{-- resources/views/bookings/confirmation.blade.php --}}

@extends('layouts.public')

@section('content')

<section class="luxora-confirmation-hero">
    <div class="luxora-confirmation-hero-inner">
        <span class="luxora-eyebrow">THANK YOU FOR CHOOSING LUXORA</span>
        <h1>Your Stay Starts Here.</h1>
        <p>Your booking request has been received.</p>
    </div>
</section>

<section class="luxora-confirmation-page">
    <div class="luxora-confirmation-card">

        <div class="luxora-confirmation-icon" aria-hidden="true">
            ✓
        </div>

        <span class="luxora-eyebrow">BOOKING REQUEST RECEIVED</span>

        <h2>Thank You, {{ $booking->guest_name }}</h2>

        <p class="luxora-confirmation-intro">
            We have received your reservation request. Please keep your
            booking reference for future enquiries.
        </p>

        <div class="luxora-confirmation-reference">
            <span>YOUR BOOKING REFERENCE</span>
            <strong>{{ $booking->booking_reference }}</strong>
        </div>

        <div class="luxora-confirmation-status">
            <div>
                <span class="luxora-status-dot"></span>
                <div>
                    <strong>Booking: Pending</strong>
                    <small>Your reservation awaits hotel confirmation.</small>
                </div>
            </div>

            <div>
                <span class="luxora-status-dot luxora-status-unpaid"></span>
                <div>
                    <strong>Payment: {{ ucfirst($booking->payment_status) }}</strong>
                    <small>
                        @if ($booking->payment_method === 'pay_at_hotel')
                            You selected payment at the hotel. Please await confirmation of your reservation.
                        @else
                            Online payment has not been processed by this booking form.
                        @endif
                    </small>
                </div>
            </div>
        </div>

        <div class="luxora-confirmation-details">
            <h3>Reservation Summary</h3>

            <div class="luxora-confirmation-room">
                <div class="luxora-confirmation-room-image">
                    <img
                        src="{{ $booking->room->image ?: 'https://images.unsplash.com/photo-1611892440504-42a792e24d32?auto=format&fit=crop&w=800&q=85' }}"
                        alt="{{ $booking->room->name }}"
                    >
                </div>

                <div>
                    <span class="luxora-confirmation-room-label">SELECTED ACCOMMODATION</span>
                    <h4>{{ $booking->room->name }}</h4>
                    <p>{{ $booking->rooms_count }} {{ $booking->rooms_count === 1 ? 'room' : 'rooms' }}</p>
                </div>
            </div>

            <div class="luxora-confirmation-info-grid">
                <div>
                    <span>CHECK-IN</span>
                    <strong>{{ $booking->check_in->format('D, d M Y') }}</strong>
                </div>

                <div>
                    <span>CHECK-OUT</span>
                    <strong>{{ $booking->check_out->format('D, d M Y') }}</strong>
                </div>

                <div>
                    <span>LENGTH OF STAY</span>
                    <strong>{{ $booking->nights }} {{ $booking->nights === 1 ? 'night' : 'nights' }}</strong>
                </div>

                <div>
                    <span>GUESTS</span>
                    <strong>
                        {{ $booking->adults }} {{ $booking->adults === 1 ? 'adult' : 'adults' }}
                        @if ($booking->children > 0)
                            , {{ $booking->children }} {{ $booking->children === 1 ? 'child' : 'children' }}
                        @endif
                    </strong>
                </div>

                <div>
                    <span>PAYMENT PREFERENCE</span>
                    <strong>
                        {{ $booking->payment_method === 'pay_at_hotel' ? 'Pay at Hotel' : 'Online Payment' }}
                    </strong>
                </div>

                <div>
                    <span>EMAIL</span>
                    <strong class="luxora-confirmation-email">{{ $booking->guest_email }}</strong>
                </div>
            </div>

            <div class="luxora-confirmation-total">
                <div>
                    <span>Estimated reservation total</span>
                    <small>
                        {{ $booking->nights }} {{ $booking->nights === 1 ? 'night' : 'nights' }}
                        × {{ $booking->rooms_count }} {{ $booking->rooms_count === 1 ? 'room' : 'rooms' }}
                    </small>
                </div>

                <strong>₦{{ number_format((float) $booking->total_amount, 2) }}</strong>
            </div>

            <p class="luxora-confirmation-disclaimer">
                This is the estimated amount saved with your booking request.
                Your reservation is not confirmed, and payment has not been
                collected through this page.
            </p>
        </div>

        <div class="luxora-confirmation-next">
            <h3>What happens next?</h3>
            <p>
                The hotel team will need to review your request and confirm
                room availability. Keep your booking reference available
                when contacting the hotel.
            </p>
        </div>

        <div class="luxora-confirmation-actions">
            <a href="{{ route('home') }}" class="luxora-confirmation-primary">
                Return to Homepage <span aria-hidden="true">→</span>
            </a>

            <a href="{{ route('rooms.index') }}" class="luxora-confirmation-secondary">
                Explore More Rooms
            </a>
        </div>

    </div>
</section>

@endsection


@push('styles')
<style>
    .luxora-confirmation-hero {
        padding: 65px 7%;
        color: #fff;
        background: #20382f;
    }

    .luxora-confirmation-hero-inner {
        max-width: 1240px;
        margin: 0 auto;
    }

    .luxora-confirmation-hero h1 {
        margin: 13px 0;
        color: #fff;
        font-family: Georgia, 'Times New Roman', serif;
        font-size: clamp(36px, 5vw, 58px);
        font-weight: 400;
    }

    .luxora-confirmation-hero p {
        margin: 0;
        color: rgba(255,255,255,.8);
        font-size: 14px;
        line-height: 1.8;
    }

    .luxora-confirmation-page {
        min-height: 600px;
        padding: 65px 6%;
        background: #faf9f6;
    }

    .luxora-confirmation-card {
        max-width: 850px;
        margin: 0 auto;
        padding: 45px;
        border: 1px solid #e8e2d7;
        background: #fff;
    }

    .luxora-confirmation-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 54px;
        height: 54px;
        margin-bottom: 24px;
        border: 1px solid #c4a574;
        border-radius: 50%;
        color: #20382f;
        background: #f7f3ea;
        font-size: 25px;
    }

    .luxora-confirmation-card > h2 {
        margin: 12px 0;
        color: #20382f;
        font-family: Georgia, 'Times New Roman', serif;
        font-size: clamp(28px, 4vw, 39px);
        font-weight: 400;
    }

    .luxora-confirmation-intro {
        max-width: 600px;
        margin: 0;
        color: #777a74;
        font-size: 13px;
        line-height: 1.9;
    }

    .luxora-confirmation-reference {
        display: flex;
        flex-direction: column;
        gap: 10px;
        margin: 28px 0;
        padding: 22px;
        border: 1px dashed #c4a574;
        background: #fcfaf5;
    }

    .luxora-confirmation-reference > span {
        color: #777a74;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 1.7px;
    }

    .luxora-confirmation-reference > strong {
        color: #20382f;
        font-family: Georgia, 'Times New Roman', serif;
        font-size: 26px;
        font-weight: 400;
        overflow-wrap: anywhere;
    }

    .luxora-confirmation-status {
        display: grid;
        gap: 18px;
        margin-bottom: 35px;
        padding: 22px;
        background: #f7f5ef;
    }

    .luxora-confirmation-status > div {
        display: flex;
        align-items: flex-start;
        gap: 12px;
    }

    .luxora-status-dot {
        flex: 0 0 9px;
        width: 9px;
        height: 9px;
        margin-top: 5px;
        border-radius: 50%;
        background: #b58b3b;
    }

    .luxora-status-unpaid {
        background: #888b83;
    }

    .luxora-confirmation-status strong {
        display: block;
        margin-bottom: 5px;
        color: #20382f;
        font-size: 12px;
    }

    .luxora-confirmation-status small {
        display: block;
        color: #777a74;
        font-size: 11px;
        line-height: 1.7;
    }

    .luxora-confirmation-details > h3,
    .luxora-confirmation-next h3 {
        margin: 0 0 20px;
        color: #20382f;
        font-family: Georgia, 'Times New Roman', serif;
        font-size: 24px;
        font-weight: 400;
    }

    .luxora-confirmation-room {
        display: flex;
        align-items: center;
        gap: 18px;
        padding-bottom: 23px;
        border-bottom: 1px solid #e8e2d7;
    }

    .luxora-confirmation-room-image {
        flex: 0 0 120px;
        height: 100px;
        overflow: hidden;
        background: #e8e2d7;
    }

    .luxora-confirmation-room-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .luxora-confirmation-room-label {
        color: #a18758;
        font-size: 9px;
        font-weight: 700;
        letter-spacing: 1px;
    }

    .luxora-confirmation-room h4 {
        margin: 8px 0;
        color: #20382f;
        font-family: Georgia, 'Times New Roman', serif;
        font-size: 22px;
        font-weight: 400;
    }

    .luxora-confirmation-room p {
        margin: 0;
        color: #777a74;
        font-size: 11px;
    }

    .luxora-confirmation-info-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 24px 20px;
        padding: 25px 0;
        border-bottom: 1px solid #e8e2d7;
    }

    .luxora-confirmation-info-grid > div {
        display: flex;
        flex-direction: column;
        gap: 8px;
        min-width: 0;
    }

    .luxora-confirmation-info-grid span {
        color: #777a74;
        font-size: 9px;
        font-weight: 700;
        letter-spacing: 1px;
    }

    .luxora-confirmation-info-grid strong {
        color: #20382f;
        font-size: 12px;
        font-weight: 600;
        overflow-wrap: anywhere;
    }

    .luxora-confirmation-total {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        padding: 25px 0 15px;
    }

    .luxora-confirmation-total > div {
        display: flex;
        flex-direction: column;
        gap: 7px;
    }

    .luxora-confirmation-total > div > span {
        color: #20382f;
        font-size: 12px;
        font-weight: 700;
    }

    .luxora-confirmation-total small {
        color: #777a74;
        font-size: 10px;
    }

    .luxora-confirmation-total > strong {
        color: #20382f;
        font-family: Georgia, 'Times New Roman', serif;
        font-size: clamp(20px, 3vw, 28px);
        font-weight: 400;
        text-align: right;
        overflow-wrap: anywhere;
    }

    .luxora-confirmation-disclaimer {
        margin: 0;
        color: #777a74;
        font-size: 10px;
        line-height: 1.8;
    }

    .luxora-confirmation-next {
        margin-top: 30px;
        padding: 25px;
        background: #f7f5ef;
    }

    .luxora-confirmation-next h3 {
        margin-bottom: 10px;
        font-size: 21px;
    }

    .luxora-confirmation-next p {
        margin: 0;
        color: #777a74;
        font-size: 12px;
        line-height: 1.9;
    }

    .luxora-confirmation-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        margin-top: 28px;
    }

    .luxora-confirmation-primary,
    .luxora-confirmation-secondary {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
        min-height: 47px;
        padding: 13px 19px;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: .5px;
        text-align: center;
        text-decoration: none;
    }

    .luxora-confirmation-primary {
        color: #fff;
        background: #20382f;
    }

    .luxora-confirmation-primary:hover {
        color: #fff;
        background: #172a22;
    }

    .luxora-confirmation-secondary {
        border: 1px solid #20382f;
        color: #20382f;
        background: #fff;
    }

    .luxora-confirmation-secondary:hover {
        color: #20382f;
        background: #f7f5ef;
    }

    @media (max-width: 600px) {
        .luxora-confirmation-hero {
            padding: 48px 6%;
        }

        .luxora-confirmation-page {
            padding: 30px 5% 55px;
        }

        .luxora-confirmation-card {
            padding: 25px 20px;
        }

        .luxora-confirmation-reference {
            padding: 17px;
        }

        .luxora-confirmation-room {
            align-items: flex-start;
        }

        .luxora-confirmation-room-image {
            flex-basis: 90px;
            height: 85px;
        }

        .luxora-confirmation-info-grid {
            gap: 20px 12px;
        }

        .luxora-confirmation-total {
            align-items: flex-start;
            flex-direction: column;
            gap: 12px;
        }

        .luxora-confirmation-total > strong {
            text-align: left;
        }

        .luxora-confirmation-actions {
            flex-direction: column;
        }

        .luxora-confirmation-actions a {
            width: 100%;
        }
    }
</style>
@endpush
