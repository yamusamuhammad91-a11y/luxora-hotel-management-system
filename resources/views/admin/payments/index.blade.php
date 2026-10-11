@extends('layouts.admin')

@section('page-title', 'Payments Management')

@section('content')
<div class="payment-page">

    <div class="payment-heading">
        <div>
            <span class="payment-eyebrow">FINANCE & TRANSACTIONS</span>
            <h1>Payments Management</h1>
            <p>Review booking payments, outstanding amounts and transaction references.</p>
        </div>
    </div>

    <div class="payment-stats">
        <article class="payment-stat-card">
            <div class="payment-stat-top">
                <span>Total Records</span>
                <span class="payment-stat-icon">▤</span>
            </div>
            <strong>{{ number_format($stats['total_records']) }}</strong>
            <small>Booking payment records</small>
        </article>

        <article class="payment-stat-card">
            <div class="payment-stat-top">
                <span>Paid Revenue</span>
                <span class="payment-stat-icon payment-icon-paid">₦</span>
            </div>
            <strong>₦{{ number_format((float) $stats['paid_revenue'], 2) }}</strong>
            <small>Bookings marked as paid</small>
        </article>

        <article class="payment-stat-card">
            <div class="payment-stat-top">
                <span>Outstanding Amount</span>
                <span class="payment-stat-icon payment-icon-pending">◷</span>
            </div>
            <strong>₦{{ number_format((float) $stats['pending_amount'], 2) }}</strong>
            <small>Bookings marked unpaid</small>
        </article>

        <article class="payment-stat-card">
            <div class="payment-stat-top">
                <span>Paid Transactions</span>
                <span class="payment-stat-icon payment-icon-count">✓</span>
            </div>
            <strong>{{ number_format($stats['paid_count']) }}</strong>
            <small>Records marked paid</small>
        </article>
    </div>

    <section class="payment-directory">
        <div class="payment-directory-heading">
            <div>
                <h2>Payment Records</h2>
                <p>Payment information linked to hotel bookings.</p>
            </div>

            <span class="payment-record-count">
                {{ $payments->total() }} records
            </span>
        </div>

        <form action="{{ route('admin.payments.index') }}"
              method="GET"
              class="payment-filters">

            <div class="payment-search">
                <span aria-hidden="true">⌕</span>
                <input
                    type="search"
                    name="search"
                    value="{{ $search }}"
                    placeholder="Search booking, guest or payment reference..."
                    aria-label="Search payment records"
                >
            </div>

            <select name="status" aria-label="Filter by payment status">
                <option value="">All Payment Statuses</option>
                <option value="paid" @selected($status === 'paid')>Paid</option>
                <option value="unpaid" @selected($status === 'unpaid')>Unpaid</option>
                <option value="refunded" @selected($status === 'refunded')>Refunded</option>
                <option value="failed" @selected($status === 'failed')>Failed</option>
            </select>

            <select name="method" aria-label="Filter by payment method">
                <option value="">All Payment Methods</option>
                <option value="online" @selected($method === 'online')>Online</option>
                <option value="pay_at_hotel" @selected($method === 'pay_at_hotel')>
                    Pay at Hotel
                </option>
            </select>

            <button type="submit" class="payment-filter-button">
                Apply Filters
            </button>

            @if ($search || $status || $method)
                <a href="{{ route('admin.payments.index') }}" class="payment-reset">
                    Reset
                </a>
            @endif
        </form>

        <div class="payment-table-wrap">
            <table class="payment-table">
                <thead>
                    <tr>
                        <th>BOOKING / GUEST</th>
                        <th>ROOM</th>
                        <th>PAYMENT METHOD</th>
                        <th>TRANSACTION REFERENCE</th>
                        <th>AMOUNT</th>
                        <th>PAYMENT STATUS</th>
                        <th>DATE</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($payments as $payment)
                        <tr>
                            <td>
                                <div class="payment-booking">
                                    <strong>{{ $payment->booking_reference }}</strong>
                                    <small>{{ $payment->guest_name }}</small>
                                    <small>{{ $payment->guest_email }}</small>
                                </div>
                            </td>

                            <td>
                                <div class="payment-room">
                                    <strong>{{ $payment->room?->name ?? 'Room unavailable' }}</strong>
                                    <small>
                                        {{ $payment->nights }}
                                        {{ (int) $payment->nights === 1 ? 'night' : 'nights' }}
                                    </small>
                                </div>
                            </td>

                            <td>
                                <span class="payment-method">
                                    @switch($payment->payment_method)
                                        @case('online')
                                            Online
                                            @break
                                        @case('pay_at_hotel')
                                            Pay at Hotel
                                            @break
                                        @default
                                            {{ $payment->payment_method ? ucfirst(str_replace('_', ' ', $payment->payment_method)) : 'Not specified' }}
                                    @endswitch
                                </span>
                            </td>

                            <td>
                                <span class="payment-reference">
                                    {{ $payment->payment_reference ?: '—' }}
                                </span>
                            </td>

                            <td>
                                <strong class="payment-amount">
                                    ₦{{ number_format((float) $payment->total_amount, 2) }}
                                </strong>
                            </td>

                            <td>
                                @php
                                    $paymentStatus = $payment->payment_status ?: 'unpaid';
                                @endphp

                                <span class="payment-status payment-status-{{ in_array($paymentStatus, ['paid', 'unpaid', 'refunded', 'failed'], true) ? $paymentStatus : 'unknown' }}">
                                    <span></span>
                                    {{ ucfirst(str_replace('_', ' ', $paymentStatus)) }}
                                </span>
                            </td>

                            <td>
                                <span class="payment-date">
                                    {{ $payment->created_at?->format('d M Y') ?? '—' }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">
                                <div class="payment-empty">
                                    <span class="payment-empty-icon">₦</span>
                                    <h3>No payment records found</h3>

                                    @if ($search || $status || $method)
                                        <p>Try changing your search terms or filters.</p>
                                        <a href="{{ route('admin.payments.index') }}">
                                            View all payment records
                                        </a>
                                    @else
                                        <p>Payment records will appear when bookings are created.</p>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($payments->hasPages())
            <div class="payment-pagination">
                {{ $payments->links() }}
            </div>
        @endif
    </section>

    <div class="payment-notice">
        <span aria-hidden="true">◇</span>
        <p>
            <strong>Financial reporting notice.</strong>
            Amounts shown here come from booking records and their recorded payment status.
            They are not independently verified bank settlements or confirmed payment-provider transactions.
        </p>
    </div>

</div>
@endsection

@push('styles')
<style>
.payment-page {
    max-width: 1500px;
    margin: 0 auto;
    color: #28382f;
}

.payment-heading {
    margin-bottom: 28px;
}

.payment-eyebrow {
    color: #a18450;
    font-size: 10px;
    font-weight: 800;
    letter-spacing: 2.1px;
}

.payment-heading h1 {
    margin: 8px 0;
    font-family: 'Playfair Display', Georgia, serif;
    font-size: clamp(29px, 4vw, 38px);
    font-weight: 500;
}

.payment-heading p {
    margin: 0;
    color: #858980;
    font-size: 12px;
    line-height: 1.7;
}

.payment-stats {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 16px;
    margin-bottom: 25px;
}

.payment-stat-card {
    min-width: 0;
    padding: 21px;
    border: 1px solid #e8e6de;
    border-radius: 7px;
    background: #fff;
}

.payment-stat-top {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
    color: #747b72;
    font-size: 11px;
    font-weight: 650;
}

.payment-stat-icon {
    display: grid;
    place-items: center;
    flex-shrink: 0;
    width: 34px;
    height: 34px;
    border-radius: 5px;
    background: #edf0e9;
    color: #49634f;
    font-size: 18px;
}

.payment-icon-paid {
    background: #e8f1e8;
    color: #47764d;
}

.payment-icon-pending {
    background: #f3eee1;
    color: #927543;
}

.payment-icon-count {
    background: #e8f1e8;
    color: #47764d;
}

.payment-stat-card > strong {
    display: block;
    margin: 15px 0 5px;
    color: #263b30;
    font-family: 'Playfair Display', Georgia, serif;
    font-size: clamp(21px, 2.2vw, 29px);
    font-weight: 500;
    overflow-wrap: anywhere;
}

.payment-stat-card > small {
    color: #92958b;
    font-size: 10px;
}

.payment-directory {
    overflow: hidden;
    border: 1px solid #e8e6de;
    border-radius: 7px;
    background: #fff;
}

.payment-directory-heading {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 15px;
    padding: 23px 24px;
    border-bottom: 1px solid #eeece5;
}

.payment-directory-heading h2 {
    margin: 0 0 6px;
    font-family: 'Playfair Display', Georgia, serif;
    font-size: 22px;
    font-weight: 500;
}

.payment-directory-heading p {
    margin: 0;
    color: #858980;
    font-size: 12px;
}

.payment-record-count {
    padding: 7px 10px;
    border-radius: 4px;
    background: #f2f1eb;
    color: #56664f;
    font-size: 10px;
    font-weight: 750;
    white-space: nowrap;
}

.payment-filters {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 10px;
    padding: 17px 24px;
    border-bottom: 1px solid #eeece5;
}

.payment-search {
    display: flex;
    flex: 1 1 250px;
    align-items: center;
    gap: 10px;
    min-height: 41px;
    padding: 0 12px;
    border: 1px solid #e2e1d8;
    border-radius: 4px;
    background: #fdfdfb;
}

.payment-search > span {
    color: #8b947f;
    font-size: 22px;
}

.payment-search input {
    width: 100%;
    min-width: 0;
    border: 0;
    outline: none;
    background: transparent;
    color: #28382f;
    font-size: 11px;
}

.payment-filters select {
    min-height: 41px;
    max-width: 200px;
    padding: 0 10px;
    border: 1px solid #e2e1d8;
    border-radius: 4px;
    background: #fff;
    color: #455348;
    font-size: 11px;
}

.payment-filter-button {
    min-height: 41px;
    padding: 0 15px;
    border: 0;
    border-radius: 4px;
    background: #263e32;
    color: #fff;
    font-size: 11px;
    font-weight: 700;
    cursor: pointer;
}

.payment-filter-button:hover {
    background: #395844;
}

.payment-reset {
    color: #687267;
    font-size: 11px;
    text-decoration: none;
}

.payment-table-wrap {
    width: 100%;
    overflow-x: auto;
}

.payment-table {
    width: 100%;
    border-collapse: collapse;
    text-align: left;
}

.payment-table thead {
    background: #faf9f6;
}

.payment-table th {
    padding: 14px 16px;
    color: #85877e;
    font-size: 9px;
    font-weight: 800;
    letter-spacing: .7px;
    white-space: nowrap;
}

.payment-table td {
    padding: 16px;
    border-top: 1px solid #f0eee8;
    font-size: 11px;
    vertical-align: middle;
}

.payment-table tbody tr:hover {
    background: #fdfcf9;
}

.payment-booking,
.payment-room {
    min-width: 145px;
}

.payment-booking strong,
.payment-room strong {
    display: block;
    color: #344238;
    font-size: 11px;
    font-weight: 750;
}

.payment-booking small,
.payment-room small {
    display: block;
    margin-top: 5px;
    color: #92958b;
    font-size: 10px;
    overflow-wrap: anywhere;
}

.payment-method {
    display: inline-block;
    padding: 6px 8px;
    border-radius: 3px;
    background: #f3f2ed;
    color: #626d5f;
    font-size: 10px;
    white-space: nowrap;
}

.payment-reference {
    color: #677367;
    overflow-wrap: anywhere;
}

.payment-amount {
    color: #344b39;
    font-size: 11px;
    white-space: nowrap;
}

.payment-status {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 8px;
    border-radius: 3px;
    font-size: 10px;
    font-weight: 750;
    white-space: nowrap;
}

.payment-status > span {
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: currentColor;
}

.payment-status-paid {
    background: #e8f1e8;
    color: #3f7046;
}

.payment-status-unpaid {
    background: #f3eee1;
    color: #927543;
}

.payment-status-refunded {
    background: #e9edf5;
    color: #51688e;
}

.payment-status-failed {
    background: #f8e9e7;
    color: #a64e45;
}

.payment-status-unknown {
    background: #f0efeb;
    color: #77796f;
}

.payment-date {
    color: #697268;
    white-space: nowrap;
}

.payment-empty {
    padding: 50px 20px;
    text-align: center;
}

.payment-empty-icon {
    display: inline-grid;
    place-items: center;
    width: 52px;
    height: 52px;
    border-radius: 50%;
    background: #f0f1e9;
    color: #68785f;
    font-size: 22px;
}

.payment-empty h3 {
    margin: 15px 0 8px;
    font-family: 'Playfair Display', Georgia, serif;
    font-size: 22px;
    font-weight: 500;
}

.payment-empty p {
    margin: 0 0 15px;
    color: #8a8e85;
    font-size: 12px;
}

.payment-empty a {
    color: #49664f;
    font-size: 12px;
    font-weight: 750;
}

.payment-pagination {
    padding: 20px 24px;
    border-top: 1px solid #eeece5;
}

.payment-notice {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    margin-top: 20px;
    padding: 16px 19px;
    border: 1px solid #e9e6dc;
    border-radius: 5px;
    background: #f8f7f1;
}

.payment-notice > span {
    color: #9b8050;
    font-size: 20px;
}

.payment-notice p {
    margin: 0;
    color: #777e73;
    font-size: 11px;
    line-height: 1.8;
}

.payment-notice strong {
    color: #3d4d40;
}

@media (max-width: 1150px) {
    .payment-stats {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }
}

@media (max-width: 650px) {
    .payment-stats {
        gap: 10px;
    }

    .payment-stat-card {
        padding: 15px;
    }

    .payment-directory-heading {
        align-items: flex-start;
        flex-direction: column;
        padding: 19px;
    }

    .payment-filters {
        padding: 15px;
    }

    .payment-search {
        flex-basis: 100%;
    }

    .payment-filters select {
        flex: 1;
        max-width: none;
    }

    .payment-filter-button {
        flex: 1;
    }

    .payment-table th,
    .payment-table td {
        padding: 13px;
    }
}
</style>
@endpush
