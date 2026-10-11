@extends('layouts.admin')

@section('title', 'Bookings')
@section('page-title', 'Booking Management')

@section('content')

    <div class="booking-page-intro">
        <div>
            <p class="booking-eyebrow">RESERVATIONS</p>
            <h2>Manage Bookings</h2>
            <p>Review guest reservations, monitor payments, and update booking statuses.</p>
        </div>
    </div>

    <div class="booking-stats">
        <div class="booking-stat-card">
            <span class="booking-stat-label">Total Bookings</span>
            <strong>{{ number_format($stats['total']) }}</strong>
            <span class="booking-stat-icon">▦</span>
        </div>

        <div class="booking-stat-card">
            <span class="booking-stat-label">Pending</span>
            <strong>{{ number_format($stats['pending']) }}</strong>
            <span class="booking-stat-icon pending-icon">◷</span>
        </div>

        <div class="booking-stat-card">
            <span class="booking-stat-label">Confirmed</span>
            <strong>{{ number_format($stats['confirmed']) }}</strong>
            <span class="booking-stat-icon confirmed-icon">✓</span>
        </div>

        <div class="booking-stat-card">
            <span class="booking-stat-label">Cancelled</span>
            <strong>{{ number_format($stats['cancelled']) }}</strong>
            <span class="booking-stat-icon cancelled-icon">×</span>
        </div>
    </div>

    <section class="booking-panel">

        <div class="booking-panel-heading">
            <div>
                <h3>All Reservations</h3>
                <p>Search, filter, and manage guest bookings.</p>
            </div>

            <span class="booking-count">
                {{ $bookings->total() }} records
            </span>
        </div>

        <form method="GET"
              action="{{ route('admin.bookings.index') }}"
              class="booking-filters">

            <div class="booking-search">
                <label for="booking-search">Search bookings</label>

                <input
                    id="booking-search"
                    type="search"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Reference, guest name, or email..."
                >
            </div>

            <div class="booking-status-filter">
                <label for="booking-status">Booking status</label>

                <select id="booking-status" name="status">
                    <option value="">All statuses</option>
                    <option value="pending" @selected(request('status') === 'pending')>
                        Pending
                    </option>
                    <option value="confirmed" @selected(request('status') === 'confirmed')>
                        Confirmed
                    </option>
                    <option value="cancelled" @selected(request('status') === 'cancelled')>
                        Cancelled
                    </option>
                </select>
            </div>

            <button type="submit" class="booking-filter-btn">
                Apply Filters
            </button>

            @if (request()->filled('search') || request()->filled('status'))
                <a href="{{ route('admin.bookings.index') }}"
                   class="booking-reset-btn">
                    Clear
                </a>
            @endif
        </form>

        @if ($bookings->isEmpty())
            <div class="booking-empty">
                <div class="booking-empty-icon">▦</div>
                <h4>No bookings found</h4>
                <p>
                    There are no reservations matching your current search or filter.
                </p>

                @if (request()->filled('search') || request()->filled('status'))
                    <a href="{{ route('admin.bookings.index') }}"
                       class="booking-reset-btn">
                        View all bookings
                    </a>
                @endif
            </div>
        @else
            <div class="booking-table-wrapper">
                <table class="booking-table">
                    <thead>
                        <tr>
                            <th>Booking Reference</th>
                            <th>Guest</th>
                            <th>Room & Stay</th>
                            <th>Total Amount</th>
                            <th>Payment</th>
                            <th>Status</th>
                            <th>Update</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($bookings as $booking)
                            <tr>
                                <td>
                                    <span class="booking-reference">
                                        {{ $booking->booking_reference }}
                                    </span>

                                    <span class="booking-created">
                                        {{ $booking->created_at?->format('d M Y') }}
                                    </span>
                                </td>

                                <td>
                                    <span class="booking-guest-name">
                                        {{ $booking->guest_name }}
                                    </span>

                                    <span class="booking-guest-email">
                                        {{ $booking->guest_email }}
                                    </span>

                                    <span class="booking-guest-phone">
                                        {{ $booking->guest_phone }}
                                    </span>
                                </td>

                                <td>
                                    <span class="booking-room-name">
                                        {{ $booking->room?->name ?? 'Room unavailable' }}
                                    </span>

                                    <span class="booking-stay-date">
                                        {{ $booking->check_in?->format('d M Y') }}
                                    </span>

                                    <span class="booking-stay-date">
                                        to {{ $booking->check_out?->format('d M Y') }}
                                    </span>

                                    <span class="booking-stay-meta">
                                        {{ $booking->nights }} night(s)
                                        · {{ $booking->rooms_count }} room(s)
                                    </span>
                                </td>

                                <td>
                                    <span class="booking-amount">
                                        ₦{{ number_format((float) $booking->total_amount, 2) }}
                                    </span>
                                </td>

                                <td>
                                    <span class="payment-method">
                                        {{ $booking->payment_method === 'pay_at_hotel'
                                            ? 'Pay at hotel'
                                            : ucfirst(str_replace('_', ' ', $booking->payment_method ?? 'Not set')) }}
                                    </span>

                                    <span class="payment-status payment-{{ $booking->payment_status }}">
                                        {{ ucfirst($booking->payment_status ?? 'unpaid') }}
                                    </span>
                                </td>

                                <td>
                                    <span class="booking-status status-{{ $booking->status }}">
                                        {{ ucfirst($booking->status) }}
                                    </span>
                                </td>

                                <td>
                                    @if ($booking->status === 'cancelled')
                                        <span class="booking-locked">
                                            Cancelled
                                        </span>
                                    @else
                                        <form
                                            method="POST"
                                            action="{{ route('admin.bookings.status', $booking) }}"
                                            class="booking-update-form"
                                        >
                                            @csrf
                                            @method('PATCH')

                                            <select
                                                name="status"
                                                aria-label="New status for {{ $booking->booking_reference }}"
                                                required
                                            >
                                                <option value="pending"
                                                    @selected($booking->status === 'pending')>
                                                    Pending
                                                </option>

                                                <option value="confirmed"
                                                    @selected($booking->status === 'confirmed')>
                                                    Confirmed
                                                </option>

                                                <option value="cancelled">
                                                    Cancelled
                                                </option>
                                            </select>

                                            <button type="submit" class="booking-save-btn">
                                                Save
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="booking-pagination">
                {{ $bookings->links() }}
            </div>
        @endif

    </section>

@endsection

@push('styles')
<style>
    .booking-page-intro {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 25px;
    }

    .booking-eyebrow {
        margin: 0 0 8px;
        color: #9b8053;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 1.6px;
    }

    .booking-page-intro h2 {
        margin: 0;
        color: #20382f;
        font-family: 'Playfair Display', serif;
        font-size: clamp(24px, 3vw, 31px);
        font-weight: 600;
    }

    .booking-page-intro p:not(.booking-eyebrow) {
        margin: 8px 0 0;
        color: #777d76;
        font-size: 12px;
        line-height: 1.7;
    }

    .booking-stats {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 15px;
        margin-bottom: 24px;
    }

    .booking-stat-card {
        position: relative;
        overflow: hidden;
        min-width: 0;
        padding: 21px;
        border: 1px solid #e9e6de;
        border-radius: 8px;
        background: #fff;
    }

    .booking-stat-label {
        display: block;
        padding-right: 27px;
        color: #777d76;
        font-size: 11px;
    }

    .booking-stat-card strong {
        display: block;
        margin-top: 16px;
        color: #20382f;
        font-family: 'Playfair Display', serif;
        font-size: 30px;
        font-weight: 600;
    }

    .booking-stat-icon {
        position: absolute;
        top: 17px;
        right: 17px;
        display: grid;
        width: 34px;
        height: 34px;
        place-items: center;
        border-radius: 7px;
        background: #f5f1e8;
        color: #8d744c;
        font-size: 18px;
    }

    .booking-stat-icon.pending-icon {
        background: #fff4dc;
        color: #936b19;
    }

    .booking-stat-icon.confirmed-icon {
        background: #e6f4e9;
        color: #2f7141;
    }

    .booking-stat-icon.cancelled-icon {
        background: #fbe9e7;
        color: #a3423a;
    }

    .booking-panel {
        overflow: hidden;
        border: 1px solid #e9e6de;
        border-radius: 8px;
        background: #fff;
    }

    .booking-panel-heading {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
        padding: 23px;
        border-bottom: 1px solid #efede7;
    }

    .booking-panel-heading h3 {
        margin: 0;
        color: #20382f;
        font-family: 'Playfair Display', serif;
        font-size: 21px;
        font-weight: 600;
    }

    .booking-panel-heading p {
        margin: 6px 0 0;
        color: #858a83;
        font-size: 11px;
    }

    .booking-count {
        flex-shrink: 0;
        padding: 8px 10px;
        border-radius: 5px;
        background: #f5f1e8;
        color: #796441;
        font-size: 10px;
        font-weight: 700;
    }

    .booking-filters {
        display: flex;
        align-items: end;
        flex-wrap: wrap;
        gap: 13px;
        padding: 20px 23px;
        border-bottom: 1px solid #efede7;
        background: #fdfcf9;
    }

    .booking-search {
        flex: 1 1 260px;
        min-width: 0;
    }

    .booking-status-filter {
        flex: 0 1 175px;
    }

    .booking-filters label {
        display: block;
        margin-bottom: 8px;
        color: #4e574f;
        font-size: 10px;
        font-weight: 700;
    }

    .booking-filters input,
    .booking-filters select,
    .booking-update-form select {
        width: 100%;
        min-height: 40px;
        padding: 9px 11px;
        border: 1px solid #e5e2d9;
        border-radius: 5px;
        outline: none;
        background: #fff;
        color: #424941;
        font-size: 11px;
    }

    .booking-filters input:focus,
    .booking-filters select:focus,
    .booking-update-form select:focus {
        border-color: #b39a6b;
        box-shadow: 0 0 0 3px rgba(196,165,116,.12);
    }

    .booking-filter-btn,
    .booking-save-btn {
        min-height: 40px;
        padding: 0 15px;
        border: 0;
        border-radius: 5px;
        background: #20382f;
        color: #fff;
        cursor: pointer;
        font-size: 11px;
        font-weight: 600;
        white-space: nowrap;
    }

    .booking-filter-btn:hover,
    .booking-save-btn:hover {
        background: #2d4a3e;
    }

    .booking-reset-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 40px;
        padding: 0 12px;
        border: 1px solid #e5e2d9;
        border-radius: 5px;
        background: #fff;
        color: #596159;
        font-size: 11px;
        white-space: nowrap;
    }

    .booking-table-wrapper {
        overflow-x: auto;
    }

    .booking-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
    }

    .booking-table thead {
        background: #fbfaf7;
    }

    .booking-table th {
        padding: 14px 16px;
        color: #858a83;
        font-size: 9px;
        font-weight: 700;
        letter-spacing: .7px;
        text-transform: uppercase;
        white-space: nowrap;
    }

    .booking-table td {
        padding: 17px 16px;
        border-top: 1px solid #f0eee8;
        color: #596159;
        font-size: 11px;
        vertical-align: top;
    }

    .booking-table tbody tr:hover {
        background: #fdfcf9;
    }

    .booking-reference,
    .booking-created,
    .booking-guest-name,
    .booking-guest-email,
    .booking-guest-phone,
    .booking-room-name,
    .booking-stay-date,
    .booking-stay-meta,
    .booking-amount,
    .payment-method,
    .payment-status {
        display: block;
    }

    .booking-reference {
        color: #20382f;
        font-size: 10px;
        font-weight: 700;
        white-space: nowrap;
    }

    .booking-created,
    .booking-guest-email,
    .booking-guest-phone,
    .booking-stay-date,
    .booking-stay-meta {
        margin-top: 6px;
        color: #858a83;
        font-size: 10px;
        line-height: 1.5;
    }

    .booking-guest-name,
    .booking-room-name {
        color: #344138;
        font-weight: 700;
    }

    .booking-guest-email {
        overflow-wrap: anywhere;
    }

    .booking-amount {
        color: #20382f;
        font-weight: 700;
        white-space: nowrap;
    }

    .payment-method {
        color: #596159;
        white-space: nowrap;
    }

    .payment-status {
        width: fit-content;
        margin-top: 7px;
        padding: 5px 7px;
        border-radius: 20px;
        background: #f1f1ee;
        color: #646b64;
        font-size: 9px;
        font-weight: 700;
    }

    .payment-paid {
        background: #e6f4e9;
        color: #2f7141;
    }

    .payment-unpaid {
        background: #fff4dc;
        color: #936b19;
    }

    .booking-status {
        display: inline-block;
        padding: 6px 8px;
        border-radius: 20px;
        font-size: 9px;
        font-weight: 700;
        white-space: nowrap;
    }

    .status-pending {
        background: #fff4dc;
        color: #936b19;
    }

    .status-confirmed {
        background: #e6f4e9;
        color: #2f7141;
    }

    .status-cancelled {
        background: #fbe9e7;
        color: #a3423a;
    }

    .booking-update-form {
        display: flex;
        flex-direction: column;
        gap: 7px;
        min-width: 105px;
    }

    .booking-update-form select {
        min-height: 34px;
        padding: 7px;
        font-size: 10px;
    }

    .booking-save-btn {
        min-height: 32px;
        padding: 0 10px;
        font-size: 10px;
    }

    .booking-locked {
        color: #a3423a;
        font-size: 10px;
        font-weight: 600;
    }

    .booking-empty {
        padding: 55px 20px;
        text-align: center;
    }

    .booking-empty-icon {
        color: #b39a6b;
        font-size: 35px;
    }

    .booking-empty h4 {
        margin: 12px 0 7px;
        color: #20382f;
        font-family: 'Playfair Display', serif;
        font-size: 21px;
    }

    .booking-empty p {
        margin: 0 0 18px;
        color: #858a83;
        font-size: 12px;
        line-height: 1.7;
    }

    .booking-pagination {
        padding: 20px 23px;
        border-top: 1px solid #efede7;
    }

    .booking-pagination nav p {
        color: #777d76;
        font-size: 11px;
    }

    @media (max-width: 1050px) {
        .booking-stats {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 640px) {
        .booking-stats {
            gap: 10px;
        }

        .booking-stat-card {
            padding: 15px;
        }

        .booking-stat-card strong {
            font-size: 25px;
        }

        .booking-panel-heading {
            padding: 18px 15px;
        }

        .booking-filters {
            align-items: stretch;
            flex-direction: column;
            padding: 17px 15px;
        }

        .booking-search,
        .booking-status-filter {
            flex-basis: auto;
            width: 100%;
        }

        .booking-table th,
        .booking-table td {
            padding: 13px 12px;
        }

        .booking-pagination {
            padding: 17px 15px;
            overflow-x: auto;
        }
    }
</style>
@endpush
