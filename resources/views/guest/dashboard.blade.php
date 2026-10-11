@extends('layouts.public')

@section('content')
<style>
    .guest-dashboard {
        min-height: 70vh;
        padding: 65px 0 90px;
        background: #faf9f6;
    }

    .guest-container {
        width: min(1160px, calc(100% - 40px));
        margin: 0 auto;
    }

    .guest-eyebrow {
        margin-bottom: 12px;
        color: #a48758;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 2.5px;
        text-transform: uppercase;
    }

    .guest-title {
        margin: 0;
        color: #20382f;
        font-family: 'Playfair Display', serif;
        font-size: clamp(32px, 5vw, 46px);
        font-weight: 500;
    }

    .guest-subtitle {
        margin: 12px 0 0;
        color: #777c74;
        font-size: 14px;
        line-height: 1.8;
    }

    .guest-welcome {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 25px;
        margin-bottom: 35px;
    }

    .guest-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
    }

    .guest-book-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 46px;
        padding: 13px 22px;
        border: 1px solid #20382f;
        background: #20382f;
        color: #fff;
        font-size: 11px;
        font-weight: 600;
        letter-spacing: .5px;
        text-decoration: none;
        transition: background .2s ease;
    }

    .guest-book-button:hover {
        background: #172a23;
        color: #fff;
    }

    .guest-profile-button {
        border-color: #c4a574;
        background: transparent;
        color: #20382f;
    }

    .guest-profile-button:hover {
        background: #f0eadf;
        color: #20382f;
    }

    .guest-stats {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 18px;
        margin-bottom: 35px;
    }

    .guest-stat {
        padding: 25px;
        border: 1px solid #e9e5dc;
        background: #fff;
    }

    .guest-stat-label {
        color: #777c74;
        font-size: 12px;
    }

    .guest-stat-value {
        margin-top: 13px;
        color: #20382f;
        font-family: 'Playfair Display', serif;
        font-size: 34px;
    }

    .guest-panel {
        border: 1px solid #e9e5dc;
        background: #fff;
    }

    .guest-panel-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
        padding: 24px;
        border-bottom: 1px solid #e9e5dc;
    }

    .guest-panel-title {
        margin: 0;
        color: #20382f;
        font-family: 'Playfair Display', serif;
        font-size: 23px;
        font-weight: 500;
    }

    .guest-panel-note {
        margin-top: 6px;
        color: #858980;
        font-size: 12px;
    }

    .guest-table-wrap {
        overflow-x: auto;
    }

    .guest-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
        white-space: nowrap;
    }

    .guest-table th {
        padding: 15px 22px;
        background: #f7f5ef;
        color: #777c74;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: .8px;
        text-transform: uppercase;
    }

    .guest-table td {
        padding: 19px 22px;
        border-bottom: 1px solid #efede7;
        color: #555b54;
        font-size: 12px;
    }

    .guest-table tbody tr:last-child td {
        border-bottom: none;
    }

    .guest-reference {
        color: #20382f;
        font-weight: 700;
    }

    .guest-room-name {
        color: #20382f;
        font-weight: 600;
    }

    .guest-room-meta {
        margin-top: 5px;
        color: #858980;
        font-size: 11px;
    }

    .guest-status {
        display: inline-block;
        padding: 6px 9px;
        border-radius: 3px;
        background: #edf4ee;
        color: #376548;
        font-size: 10px;
        font-weight: 600;
        text-transform: capitalize;
    }

    .guest-status.pending,
    .guest-status.unpaid {
        background: #fbf2df;
        color: #8a6932;
    }

    .guest-status.cancelled,
    .guest-status.failed,
    .guest-status.refunded {
        background: #f9eaea;
        color: #a34e4e;
    }

    .guest-status.paid {
        background: #edf4ee;
        color: #376548;
    }

    .guest-view-link {
        color: #8b7048;
        font-size: 11px;
        font-weight: 700;
        text-decoration: none;
    }

    .guest-view-link:hover {
        text-decoration: underline;
    }

    .guest-empty {
        padding: 55px 25px;
        text-align: center;
    }

    .guest-empty-icon {
        display: grid;
        width: 56px;
        height: 56px;
        margin: 0 auto 18px;
        place-items: center;
        border: 1px solid #e8dfce;
        border-radius: 50%;
        color: #a48758;
        font-size: 24px;
    }

    .guest-empty h3 {
        margin: 0;
        color: #20382f;
        font-family: 'Playfair Display', serif;
        font-size: 24px;
        font-weight: 500;
    }

    .guest-empty p {
        margin: 10px 0 23px;
        color: #777c74;
        font-size: 13px;
        line-height: 1.8;
    }

    .guest-pagination {
        padding: 20px 24px;
        border-top: 1px solid #efede7;
    }

    @media (max-width: 760px) {
        .guest-dashboard {
            padding: 42px 0 65px;
        }

        .guest-welcome {
            align-items: flex-start;
            flex-direction: column;
        }

        .guest-stats {
            gap: 10px;
        }

        .guest-stat {
            padding: 16px;
        }

        .guest-stat-value {
            font-size: 27px;
        }

        .guest-panel-header {
            align-items: flex-start;
            flex-direction: column;
            padding: 20px;
        }
    }

    @media (max-width: 480px) {
        .guest-container {
            width: calc(100% - 28px);
        }

        .guest-stats {
            grid-template-columns: 1fr;
        }

        .guest-stat {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
        }

        .guest-stat-value {
            margin-top: 0;
        }

        .guest-actions {
            width: 100%;
            flex-direction: column;
        }

        .guest-actions .guest-book-button {
            width: 100%;
            box-sizing: border-box;
        }
    }
</style>

<section class="guest-dashboard">
    <div class="guest-container">

        <div class="guest-welcome">
            <div>
                <div class="guest-eyebrow">Your Luxora Account</div>

                <h1 class="guest-title">
                    Welcome back, {{ auth()->user()->name }}.
                </h1>

                <p class="guest-subtitle">
                    Manage your reservations and prepare for your next
                    exceptional stay with us.
                </p>
            </div>

            <div class="guest-actions">
                <a href="{{ route('rooms.index') }}" class="guest-book-button">
                    EXPLORE ROOMS &amp; SUITES
                </a>

                <a href="{{ route('guest.profile.edit') }}"
                   class="guest-book-button guest-profile-button">
                    MANAGE MY PROFILE
                </a>
            </div>
        </div>

        <div class="guest-stats">
            <article class="guest-stat">
                <div class="guest-stat-label">Total reservations</div>
                <div class="guest-stat-value">
                    {{ number_format($stats['total']) }}
                </div>
            </article>

            <article class="guest-stat">
                <div class="guest-stat-label">Upcoming stays</div>
                <div class="guest-stat-value">
                    {{ number_format($stats['upcoming']) }}
                </div>
            </article>

            <article class="guest-stat">
                <div class="guest-stat-label">Completed stays</div>
                <div class="guest-stat-value">
                    {{ number_format($stats['completed']) }}
                </div>
            </article>
        </div>

        <section class="guest-panel">
            <div class="guest-panel-header">
                <div>
                    <h2 class="guest-panel-title">My Reservations</h2>
                    <p class="guest-panel-note">
                        Your booking history and current reservation status.
                    </p>
                </div>

                <span class="guest-panel-note">
                    {{ $bookings->total() }} reservation(s)
                </span>
            </div>

            @if ($bookings->isNotEmpty())
                <div class="guest-table-wrap">
                    <table class="guest-table">
                        <thead>
                            <tr>
                                <th>Booking</th>
                                <th>Room</th>
                                <th>Stay dates</th>
                                <th>Total</th>
                                <th>Booking status</th>
                                <th>Payment</th>
                                <th>Details</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($bookings as $booking)
                                <tr>
                                    <td>
                                        <span class="guest-reference">
                                            {{ $booking->booking_reference }}
                                        </span>
                                    </td>

                                    <td>
                                        <div class="guest-room-name">
                                            {{ $booking->room?->name ?? 'Room unavailable' }}
                                        </div>
                                        <div class="guest-room-meta">
                                            {{ $booking->rooms_count }} room(s)
                                        </div>
                                    </td>

                                    <td>
                                        <div>
                                            {{ \Illuminate\Support\Carbon::parse($booking->check_in)->format('d M Y') }}
                                        </div>
                                        <div class="guest-room-meta">
                                            to
                                            {{ \Illuminate\Support\Carbon::parse($booking->check_out)->format('d M Y') }}
                                        </div>
                                    </td>

                                    <td>
                                        <strong>
                                            ₦{{ number_format((float) $booking->total_amount, 2) }}
                                        </strong>
                                    </td>

                                    <td>
                                        <span class="guest-status {{ strtolower($booking->status) }}">
                                            {{ str_replace('_', ' ', $booking->status) }}
                                        </span>
                                    </td>

                                    <td>
                                        <span class="guest-status {{ strtolower($booking->payment_status) }}">
                                            {{ str_replace('_', ' ', $booking->payment_status) }}
                                        </span>
                                    </td>

                                    <td>
                                        <a
                                            class="guest-view-link"
                                            href="{{ route('guest.bookings.show', ['booking' => $booking->id]) }}"
                                        >
                                            VIEW BOOKING →
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if ($bookings->hasPages())
                    <div class="guest-pagination">
                        {{ $bookings->links() }}
                    </div>
                @endif
            @else
                <div class="guest-empty">
                    <div class="guest-empty-icon">✧</div>

                    <h3>Your next stay awaits</h3>

                    <p>
                        You don't have any reservations associated with your
                        account yet. Explore our rooms and discover your next
                        Luxora experience.
                    </p>

                    <a href="{{ route('rooms.index') }}" class="guest-book-button">
                        DISCOVER OUR ROOMS
                    </a>
                </div>
            @endif
        </section>

    </div>
</section>
@endsection
