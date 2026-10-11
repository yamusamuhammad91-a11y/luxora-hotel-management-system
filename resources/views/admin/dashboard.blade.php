@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')

    <div class="dashboard-welcome">
        <div>
            <p class="dashboard-eyebrow">OVERVIEW</p>
            <h2>Welcome back, {{ auth()->user()->name ?? 'Administrator' }}</h2>
            <p class="dashboard-subtitle">
                Here is what is happening across your hotel today.
            </p>
        </div>

        <a href="{{ route('admin.bookings.index') }}" class="dashboard-primary-btn">
            View Bookings <span>→</span>
        </a>
    </div>

    <div class="dashboard-stats">
        <article class="dashboard-stat-card">
            <div class="stat-top">
                <span class="stat-label">Total Rooms</span>
                <span class="stat-icon">▤</span>
            </div>
            <div class="stat-number">{{ number_format($stats['total_rooms']) }}</div>
            <div class="stat-note">Rooms in the catalogue</div>
        </article>

        <article class="dashboard-stat-card">
            <div class="stat-top">
                <span class="stat-label">Active Rooms</span>
                <span class="stat-icon">⌂</span>
            </div>
            <div class="stat-number">{{ number_format($stats['available_rooms']) }}</div>
            <div class="stat-note">Rooms currently listed as active</div>
        </article>

        <article class="dashboard-stat-card">
            <div class="stat-top">
                <span class="stat-label">Total Bookings</span>
                <span class="stat-icon">▦</span>
            </div>
            <div class="stat-number">{{ number_format($stats['total_bookings']) }}</div>
            <div class="stat-note">All recorded reservations</div>
        </article>

        <article class="dashboard-stat-card">
            <div class="stat-top">
                <span class="stat-label">Pending Bookings</span>
                <span class="stat-icon">◷</span>
            </div>
            <div class="stat-number">{{ number_format($stats['pending_bookings']) }}</div>
            <div class="stat-note">Reservations awaiting review</div>
        </article>

        <article class="dashboard-stat-card">
            <div class="stat-top">
                <span class="stat-label">Confirmed Bookings</span>
                <span class="stat-icon">✓</span>
            </div>
            <div class="stat-number">{{ number_format($stats['confirmed_bookings']) }}</div>
            <div class="stat-note">Confirmed reservations</div>
        </article>

        <article class="dashboard-stat-card">
            <div class="stat-top">
                <span class="stat-label">Registered Guests</span>
                <span class="stat-icon">♙</span>
            </div>
            <div class="stat-number">{{ number_format($stats['total_guests']) }}</div>
            <div class="stat-note">Guest accounts recorded</div>
        </article>

        <article class="dashboard-stat-card">
            <div class="stat-top">
                <span class="stat-label">Hotel Services</span>
                <span class="stat-icon">✧</span>
            </div>
            <div class="stat-number">{{ number_format($stats['total_services']) }}</div>
            <div class="stat-note">
                {{ number_format($stats['active_services']) }} active services
            </div>
        </article>

        <article class="dashboard-stat-card dashboard-revenue-card">
            <div class="stat-top">
                <span class="stat-label">Recorded Paid Revenue</span>
                <span class="stat-icon">₦</span>
            </div>
            <div class="stat-number revenue-number">
                ₦{{ number_format((float) $stats['paid_revenue'], 2) }}
            </div>
            <div class="stat-note">Bookings marked as paid</div>
        </article>
    </div>

    <div class="dashboard-main-grid">

        <section class="dashboard-panel">
            <div class="panel-heading">
                <div>
                    <p class="dashboard-eyebrow">RECENT ACTIVITY</p>
                    <h3>Recent Bookings</h3>
                </div>

                <a href="{{ route('admin.bookings.index') }}" class="panel-link">
                    View all →
                </a>
            </div>

            @if ($recentBookings->isEmpty())
                <div class="dashboard-empty">
                    <div class="empty-icon">▦</div>
                    <h4>No bookings yet</h4>
                    <p>New reservations will appear here when guests make bookings.</p>
                </div>
            @else
                <div class="dashboard-table-wrap">
                    <table class="dashboard-table">
                        <thead>
                            <tr>
                                <th>Booking</th>
                                <th>Guest</th>
                                <th>Room</th>
                                <th>Amount</th>
                                <th>Status</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($recentBookings as $booking)
                                <tr>
                                    <td>
                                        <span class="booking-reference">
                                            {{ $booking->booking_reference }}
                                        </span>
                                        <span class="booking-date">
                                            {{ $booking->created_at?->format('d M Y') }}
                                        </span>
                                    </td>

                                    <td>
                                        <span class="table-primary-text">
                                            {{ $booking->guest_name }}
                                        </span>
                                        <span class="table-secondary-text">
                                            {{ $booking->guest_email }}
                                        </span>
                                    </td>

                                    <td>
                                        {{ $booking->room?->name ?? 'Room unavailable' }}
                                    </td>

                                    <td class="table-amount">
                                        ₦{{ number_format((float) $booking->total_amount, 2) }}
                                    </td>

                                    <td>
                                        <span class="status-badge status-{{ $booking->status }}">
                                            {{ ucfirst($booking->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </section>

        <section class="dashboard-panel dashboard-actions-panel">
            <div class="panel-heading">
                <div>
                    <p class="dashboard-eyebrow">SHORTCUTS</p>
                    <h3>Quick Actions</h3>
                </div>
            </div>

            <div class="dashboard-quick-actions">
                <a href="{{ route('admin.bookings.index') }}" class="dashboard-quick-link">
                    <span class="quick-link-icon">▦</span>
                    <span class="quick-link-copy">
                        <strong>Manage Bookings</strong>
                        <small>Review and update reservations</small>
                    </span>
                    <span class="quick-link-arrow">→</span>
                </a>

                <a href="{{ route('admin.services.index') }}" class="dashboard-quick-link">
                    <span class="quick-link-icon">✧</span>
                    <span class="quick-link-copy">
                        <strong>Manage Services</strong>
                        <small>Maintain hotel services and prices</small>
                    </span>
                    <span class="quick-link-arrow">→</span>
                </a>

                <a href="{{ route('rooms.index') }}" class="dashboard-quick-link">
                    <span class="quick-link-icon">▤</span>
                    <span class="quick-link-copy">
                        <strong>View Public Rooms</strong>
                        <small>See the guest-facing room catalogue</small>
                    </span>
                    <span class="quick-link-arrow">→</span>
                </a>

                <a href="{{ route('availability') }}" class="dashboard-quick-link">
                    <span class="quick-link-icon">⌕</span>
                    <span class="quick-link-copy">
                        <strong>Check Availability</strong>
                        <small>Open the public availability search</small>
                    </span>
                    <span class="quick-link-arrow">→</span>
                </a>
            </div>
        </section>

    </div>

@endsection

@push('styles')
<style>
    .dashboard-welcome {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        margin-bottom: 27px;
    }

    .dashboard-eyebrow {
        margin: 0 0 8px;
        color: #9b8053;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 1.6px;
    }

    .dashboard-welcome h2 {
        margin: 0;
        color: #20382f;
        font-family: 'Playfair Display', serif;
        font-size: clamp(23px, 3vw, 31px);
        font-weight: 600;
    }

    .dashboard-subtitle {
        margin: 8px 0 0;
        color: #777d76;
        font-size: 13px;
        line-height: 1.7;
    }

    .dashboard-primary-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 14px;
        flex-shrink: 0;
        padding: 13px 17px;
        border-radius: 5px;
        background: #20382f;
        color: #fff;
        font-size: 12px;
        font-weight: 600;
        transition: background .2s ease;
    }

    .dashboard-primary-btn:hover {
        background: #2d4a3e;
    }

    .dashboard-primary-btn span {
        color: #d8bd8d;
        font-size: 17px;
    }

    .dashboard-stats {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 16px;
        margin-bottom: 25px;
    }

    .dashboard-stat-card {
        min-width: 0;
        padding: 20px;
        border: 1px solid #e9e6de;
        border-radius: 8px;
        background: #fff;
    }

    .stat-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 8px;
    }

    .stat-label {
        color: #777d76;
        font-size: 11px;
        font-weight: 500;
    }

    .stat-icon {
        display: grid;
        width: 34px;
        height: 34px;
        flex-shrink: 0;
        place-items: center;
        border-radius: 7px;
        background: #f5f1e8;
        color: #8d744c;
        font-size: 18px;
    }

    .stat-number {
        margin-top: 18px;
        color: #20382f;
        font-family: 'Playfair Display', serif;
        font-size: clamp(24px, 2.2vw, 31px);
        font-weight: 600;
        overflow-wrap: anywhere;
    }

    .stat-note {
        margin-top: 7px;
        color: #858a83;
        font-size: 10px;
        line-height: 1.6;
    }

    .dashboard-revenue-card {
        background: #20382f;
        border-color: #20382f;
    }

    .dashboard-revenue-card .stat-label,
    .dashboard-revenue-card .stat-note {
        color: #d0d9d2;
    }

    .dashboard-revenue-card .stat-icon {
        background: rgba(255,255,255,.1);
        color: #e3c895;
    }

    .dashboard-revenue-card .stat-number {
        color: #e3c895;
    }

    .revenue-number {
        font-size: clamp(19px, 2vw, 27px);
    }

    .dashboard-main-grid {
        display: grid;
        grid-template-columns: minmax(0, 1.7fr) minmax(280px, .9fr);
        align-items: start;
        gap: 20px;
    }

    .dashboard-panel {
        min-width: 0;
        overflow: hidden;
        border: 1px solid #e9e6de;
        border-radius: 8px;
        background: #fff;
    }

    .panel-heading {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
        padding: 22px 22px 18px;
        border-bottom: 1px solid #efede7;
    }

    .panel-heading .dashboard-eyebrow {
        margin-bottom: 6px;
    }

    .panel-heading h3 {
        margin: 0;
        color: #20382f;
        font-family: 'Playfair Display', serif;
        font-size: 20px;
        font-weight: 600;
    }

    .panel-link {
        color: #8e744a;
        font-size: 11px;
        font-weight: 600;
        white-space: nowrap;
    }

    .dashboard-table-wrap {
        overflow-x: auto;
    }

    .dashboard-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
    }

    .dashboard-table th {
        padding: 13px 16px;
        background: #fbfaf7;
        color: #858a83;
        font-size: 9px;
        font-weight: 700;
        letter-spacing: .8px;
        text-transform: uppercase;
        white-space: nowrap;
    }

    .dashboard-table td {
        padding: 16px;
        border-top: 1px solid #f0eee8;
        color: #555d56;
        font-size: 11px;
        vertical-align: middle;
    }

    .booking-reference,
    .booking-date,
    .table-primary-text,
    .table-secondary-text {
        display: block;
    }

    .booking-reference {
        color: #20382f;
        font-size: 10px;
        font-weight: 700;
    }

    .booking-date,
    .table-secondary-text {
        margin-top: 5px;
        color: #8a8f89;
        font-size: 10px;
    }

    .table-primary-text {
        color: #343a35;
        font-weight: 600;
    }

    .table-amount {
        color: #20382f !important;
        font-weight: 700;
        white-space: nowrap;
    }

    .status-badge {
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

    .dashboard-empty {
        padding: 44px 20px;
        text-align: center;
    }

    .empty-icon {
        color: #b39a6b;
        font-size: 32px;
    }

    .dashboard-empty h4 {
        margin: 12px 0 7px;
        color: #20382f;
        font-family: 'Playfair Display', serif;
        font-size: 19px;
    }

    .dashboard-empty p {
        margin: 0;
        color: #858a83;
        font-size: 12px;
        line-height: 1.7;
    }

    .dashboard-quick-actions {
        padding: 5px 20px;
    }

    .dashboard-quick-link {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 17px 0;
        border-bottom: 1px solid #efede7;
    }

    .dashboard-quick-link:last-child {
        border-bottom: 0;
    }

    .quick-link-icon {
        display: grid;
        width: 39px;
        height: 39px;
        flex-shrink: 0;
        place-items: center;
        border-radius: 7px;
        background: #f5f1e8;
        color: #8d744c;
        font-size: 18px;
    }

    .quick-link-copy {
        flex: 1;
        min-width: 0;
    }

    .quick-link-copy strong,
    .quick-link-copy small {
        display: block;
    }

    .quick-link-copy strong {
        color: #344138;
        font-size: 11px;
        font-weight: 700;
    }

    .quick-link-copy small {
        margin-top: 5px;
        color: #858a83;
        font-size: 10px;
        line-height: 1.5;
    }

    .quick-link-arrow {
        color: #9b8053;
        font-size: 17px;
    }

    @media (max-width: 1250px) {
        .dashboard-stats {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .dashboard-main-grid {
            grid-template-columns: minmax(0, 1fr);
        }
    }

    @media (max-width: 640px) {
        .dashboard-welcome {
            align-items: flex-start;
            flex-direction: column;
        }

        .dashboard-stats {
            gap: 10px;
        }

        .dashboard-stat-card {
            padding: 15px;
        }

        .stat-number {
            margin-top: 13px;
        }

        .panel-heading {
            padding: 18px 15px;
        }

        .dashboard-table th,
        .dashboard-table td {
            padding: 13px 12px;
        }
    }
</style>
@endpush
