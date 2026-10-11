@extends('layouts.admin')

@section('page-title', 'Reports & Analytics')

@section('content')
@php
    $currency = '₦';

    $formatMoney = function ($amount) use ($currency) {
        return $currency . ' ' . number_format((float) $amount, 2);
    };

    $maxBookings = max(1, (int) $dailyBookings->max('total'));
    $maxRevenue = max(1, (float) $dailyRevenue->max('total'));
@endphp

<style>
    .report-intro {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 22px;
        margin-bottom: 26px;
    }

    .report-eyebrow {
        margin-bottom: 8px;
        color: #9c8053;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 2px;
        text-transform: uppercase;
    }

    .report-heading {
        margin: 0;
        color: #20382f;
        font-family: 'Playfair Display', serif;
        font-size: 28px;
        font-weight: 500;
    }

    .report-description {
        margin-top: 9px;
        color: #858980;
        font-size: 13px;
        line-height: 1.7;
    }

    .report-filter {
        display: flex;
        flex-wrap: wrap;
        align-items: end;
        gap: 12px;
        padding: 18px;
        border: 1px solid #e9e7e0;
        border-radius: 6px;
        background: #fff;
    }

    .report-field {
        display: grid;
        gap: 7px;
    }

    .report-field label {
        color: #747970;
        font-size: 11px;
        font-weight: 600;
    }

    .report-field input {
        min-height: 41px;
        padding: 9px 11px;
        border: 1px solid #e1ded5;
        border-radius: 4px;
        background: #fff;
        color: #282c29;
        font-size: 12px;
    }

    .report-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 41px;
        padding: 10px 17px;
        border: 1px solid #20382f;
        border-radius: 4px;
        background: #20382f;
        color: #fff;
        cursor: pointer;
        font-size: 12px;
        font-weight: 600;
    }

    .report-button:hover {
        background: #172a23;
    }

    .report-button-secondary {
        border-color: #e1ded5;
        background: #fff;
        color: #20382f;
    }

    .report-button-secondary:hover {
        background: #f7f3ea;
    }

    .report-stats {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 16px;
        margin: 23px 0;
    }

    .report-card {
        position: relative;
        min-width: 0;
        padding: 21px;
        overflow: hidden;
        border: 1px solid #e9e7e0;
        border-radius: 6px;
        background: #fff;
    }

    .report-card::after {
        position: absolute;
        right: -17px;
        bottom: -24px;
        width: 78px;
        height: 78px;
        border: 1px solid rgba(196,165,116,.24);
        border-radius: 50%;
        content: '';
    }

    .report-card-label {
        color: #858980;
        font-size: 11px;
    }

    .report-card-value {
        margin-top: 15px;
        color: #20382f;
        font-family: 'Playfair Display', serif;
        font-size: clamp(22px, 2.3vw, 30px);
        line-height: 1.25;
        overflow-wrap: anywhere;
    }

    .report-card-note {
        margin-top: 9px;
        color: #858980;
        font-size: 10px;
    }

    .report-card-icon {
        display: grid;
        width: 35px;
        height: 35px;
        margin-bottom: 17px;
        place-items: center;
        border-radius: 4px;
        background: #f7f3ea;
        color: #9c8053;
        font-size: 17px;
    }

    .report-grid {
        display: grid;
        grid-template-columns: minmax(0, 1.15fr) minmax(0, .85fr);
        gap: 20px;
        margin-bottom: 22px;
    }

    .report-panel {
        min-width: 0;
        padding: 23px;
        border: 1px solid #e9e7e0;
        border-radius: 6px;
        background: #fff;
    }

    .report-panel-heading {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 23px;
    }

    .report-panel-title {
        margin: 0;
        color: #20382f;
        font-family: 'Playfair Display', serif;
        font-size: 20px;
        font-weight: 500;
    }

    .report-panel-subtitle {
        margin-top: 6px;
        color: #858980;
        font-size: 11px;
        line-height: 1.6;
    }

    .report-count {
        padding: 6px 9px;
        border-radius: 3px;
        background: #f7f3ea;
        color: #8d7046;
        font-size: 10px;
        white-space: nowrap;
    }

    .report-bar-list {
        display: grid;
        gap: 20px;
    }

    .report-bar-top {
        display: flex;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 9px;
        color: #555b54;
        font-size: 12px;
    }

    .report-bar-track {
        height: 7px;
        overflow: hidden;
        border-radius: 10px;
        background: #f0eee8;
    }

    .report-bar-fill {
        height: 100%;
        border-radius: 10px;
        background: #20382f;
    }

    .report-bar-fill.gold {
        background: #c4a574;
    }

    .report-empty {
        padding: 28px 12px;
        color: #858980;
        font-size: 12px;
        line-height: 1.7;
        text-align: center;
    }

    .report-table-wrap {
        overflow-x: auto;
    }

    .report-table {
        width: 100%;
        border-collapse: collapse;
        white-space: nowrap;
    }

    .report-table th {
        padding: 13px 12px;
        border-bottom: 1px solid #e9e7e0;
        background: #faf9f6;
        color: #858980;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: .7px;
        text-align: left;
        text-transform: uppercase;
    }

    .report-table td {
        padding: 15px 12px;
        border-bottom: 1px solid #f0eee8;
        color: #555b54;
        font-size: 12px;
    }

    .report-table tbody tr:last-child td {
        border-bottom: none;
    }

    .report-table td strong {
        color: #20382f;
        font-weight: 600;
    }

    .report-status {
        display: inline-block;
        padding: 5px 8px;
        border-radius: 3px;
        background: #eef4ef;
        color: #376548;
        font-size: 10px;
        font-weight: 600;
    }

    .report-status.pending {
        background: #fbf3e3;
        color: #8a6932;
    }

    .report-status.cancelled {
        background: #fbeeee;
        color: #a34e4e;
    }

    @media (max-width: 1100px) {
        .report-stats {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .report-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 650px) {
        .report-intro {
            flex-direction: column;
        }

        .report-heading {
            font-size: 24px;
        }

        .report-filter {
            width: 100%;
        }

        .report-field {
            flex: 1 1 130px;
        }

        .report-field input {
            width: 100%;
        }

        .report-stats {
            gap: 10px;
        }

        .report-card {
            padding: 15px;
        }

        .report-card-value {
            font-size: 22px;
        }

        .report-panel {
            padding: 16px;
        }
    }
</style>

<div class="report-intro">
    <div>
        <div class="report-eyebrow">Hotel Performance</div>
        <h2 class="report-heading">Reports & Analytics</h2>
        <p class="report-description">
            Review booking activity, payment performance and room demand
            for your selected reporting period.
        </p>
    </div>
</div>

<form method="GET" action="{{ route('admin.reports.index') }}" class="report-filter">
    <div class="report-field">
        <label for="start_date">Start date</label>
        <input
            type="date"
            id="start_date"
            name="start_date"
            value="{{ $startDate }}"
            required
        >
    </div>

    <div class="report-field">
        <label for="end_date">End date</label>
        <input
            type="date"
            id="end_date"
            name="end_date"
            value="{{ $endDate }}"
            min="{{ $startDate }}"
            required
        >
    </div>

    <button type="submit" class="report-button">Apply filters</button>

    <a href="{{ route('admin.reports.index') }}"
       class="report-button report-button-secondary">
        This month
    </a>
</form>

<div class="report-stats">
    <article class="report-card">
        <div class="report-card-icon">▤</div>
        <div class="report-card-label">Total bookings</div>
        <div class="report-card-value">{{ number_format($totalBookings) }}</div>
        <div class="report-card-note">Check-ins during selected period</div>
    </article>

    <article class="report-card">
        <div class="report-card-icon">₦</div>
        <div class="report-card-label">Paid revenue</div>
        <div class="report-card-value" style="font-size:clamp(18px, 2vw, 26px)">
            {{ $formatMoney($paidRevenue) }}
        </div>
        <div class="report-card-note">{{ number_format($paidBookings) }} bookings marked paid</div>
    </article>

    <article class="report-card">
        <div class="report-card-icon">◷</div>
        <div class="report-card-label">Outstanding payments</div>
        <div class="report-card-value" style="font-size:clamp(18px, 2vw, 26px)">
            {{ $formatMoney($unpaidAmount) }}
        </div>
        <div class="report-card-note">{{ number_format($unpaidBookings) }} bookings marked unpaid</div>
    </article>

    <article class="report-card">
        <div class="report-card-icon">✓</div>
        <div class="report-card-label">Confirmed bookings</div>
        <div class="report-card-value">{{ number_format($confirmedBookings) }}</div>
        <div class="report-card-note">
            {{ number_format($pendingBookings) }} pending ·
            {{ number_format($cancelledBookings) }} cancelled
        </div>
    </article>
</div>

<div class="report-grid">
    <section class="report-panel">
        <div class="report-panel-heading">
            <div>
                <h3 class="report-panel-title">Room Performance</h3>
                <div class="report-panel-subtitle">
                    Rooms ranked by non-cancelled bookings during this period.
                </div>
            </div>
            <span class="report-count">Top 5</span>
        </div>

        @php
            $maxRoomBookings = max(1, (int) $popularRooms->max('bookings_count'));
        @endphp

        @if ($popularRooms->isNotEmpty())
            <div class="report-bar-list">
                @foreach ($popularRooms as $room)
                    <div>
                        <div class="report-bar-top">
                            <span>{{ $room->name }}</span>
                            <strong>{{ number_format($room->bookings_count) }} bookings</strong>
                        </div>
                        <div class="report-bar-track">
                            <div
                                class="report-bar-fill"
                                style="width:{{ min(100, ($room->bookings_count / $maxRoomBookings) * 100) }}%"
                            ></div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="report-empty">
                No room booking data is available for this period.
            </div>
        @endif
    </section>

    <section class="report-panel">
        <div class="report-panel-heading">
            <div>
                <h3 class="report-panel-title">Booking Activity</h3>
                <div class="report-panel-subtitle">
                    Daily bookings grouped by check-in date.
                </div>
            </div>
            <span class="report-count">{{ $dailyBookings->count() }} dates</span>
        </div>

        @if ($dailyBookings->isNotEmpty())
            <div class="report-bar-list">
                @foreach ($dailyBookings as $day)
                    <div>
                        <div class="report-bar-top">
                            <span>{{ \Illuminate\Support\Carbon::parse($day->booking_date)->format('d M Y') }}</span>
                            <strong>{{ number_format($day->total) }}</strong>
                        </div>
                        <div class="report-bar-track">
                            <div
                                class="report-bar-fill gold"
                                style="width:{{ min(100, ($day->total / $maxBookings) * 100) }}%"
                            ></div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="report-empty">
                No bookings were found for these dates.
            </div>
        @endif
    </section>
</div>

<section class="report-panel" style="margin-bottom:22px;">
    <div class="report-panel-heading">
        <div>
            <h3 class="report-panel-title">Daily Paid Revenue</h3>
            <div class="report-panel-subtitle">
                Booking totals grouped by check-in date for bookings marked paid.
            </div>
        </div>
        <span class="report-count">{{ $dailyRevenue->count() }} dates</span>
    </div>

    @if ($dailyRevenue->isNotEmpty())
        <div class="report-bar-list">
            @foreach ($dailyRevenue as $day)
                <div>
                    <div class="report-bar-top">
                        <span>{{ \Illuminate\Support\Carbon::parse($day->revenue_date)->format('d M Y') }}</span>
                        <strong>{{ $formatMoney($day->total) }}</strong>
                    </div>
                    <div class="report-bar-track">
                        <div
                            class="report-bar-fill"
                            style="width:{{ min(100, (((float) $day->total) / $maxRevenue) * 100) }}%"
                        ></div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="report-empty">
            No paid revenue was recorded for this reporting period.
        </div>
    @endif
</section>

<section class="report-panel">
    <div class="report-panel-heading">
        <div>
            <h3 class="report-panel-title">Reporting Summary</h3>
            <div class="report-panel-subtitle">
                An overview of booking and payment records within your chosen dates.
            </div>
        </div>
        <span class="report-count">Summary</span>
    </div>

    <div class="report-table-wrap">
        <table class="report-table">
            <thead>
                <tr>
                    <th>Metric</th>
                    <th>Result</th>
                    <th>Meaning</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><strong>Confirmed bookings</strong></td>
                    <td>{{ number_format($confirmedBookings) }}</td>
                    <td><span class="report-status">Confirmed</span></td>
                </tr>
                <tr>
                    <td><strong>Pending bookings</strong></td>
                    <td>{{ number_format($pendingBookings) }}</td>
                    <td><span class="report-status pending">Awaiting confirmation</span></td>
                </tr>
                <tr>
                    <td><strong>Cancelled bookings</strong></td>
                    <td>{{ number_format($cancelledBookings) }}</td>
                    <td><span class="report-status cancelled">Cancelled</span></td>
                </tr>
                <tr>
                    <td><strong>Paid revenue</strong></td>
                    <td><strong>{{ $formatMoney($paidRevenue) }}</strong></td>
                    <td>Bookings recorded as paid</td>
                </tr>
                <tr>
                    <td><strong>Outstanding payments</strong></td>
                    <td><strong>{{ $formatMoney($unpaidAmount) }}</strong></td>
                    <td>Bookings recorded as unpaid</td>
                </tr>
            </tbody>
        </table>
    </div>
</section>

@endsection
