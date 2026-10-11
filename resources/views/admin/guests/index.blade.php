@extends('layouts.admin')

@section('page-title', 'Guest Management')

@section('content')
<div class="guest-page">

    <div class="guest-heading">
        <div>
            <span class="guest-eyebrow">GUEST RELATIONSHIPS</span>
            <h1>Guest Directory</h1>
            <p>Discover your guests, understand their stays and recognise returning visitors.</p>
        </div>
    </div>

    <div class="guest-stats">
        <article class="guest-stat-card">
            <div class="guest-stat-top">
                <span>Total Guests</span>
                <span class="guest-stat-icon">♙</span>
            </div>
            <strong>{{ number_format($stats['total_guests']) }}</strong>
            <small>Unique guest email addresses</small>
        </article>

        <article class="guest-stat-card">
            <div class="guest-stat-top">
                <span>Total Bookings</span>
                <span class="guest-stat-icon">▤</span>
            </div>
            <strong>{{ number_format($stats['total_bookings']) }}</strong>
            <small>All recorded reservations</small>
        </article>

        <article class="guest-stat-card">
            <div class="guest-stat-top">
                <span>Returning Guests</span>
                <span class="guest-stat-icon">↻</span>
            </div>
            <strong>{{ number_format($stats['returning_guests']) }}</strong>
            <small>Guests with multiple bookings</small>
        </article>
    </div>

    <section class="guest-directory-card">
        <div class="guest-directory-heading">
            <div>
                <h2>Your Guests</h2>
                <p>Guest records collected from existing bookings.</p>
            </div>
            <span class="guest-record-count">
                {{ $guests->total() }} records
            </span>
        </div>

        <form action="{{ route('admin.guests.index') }}"
              method="GET"
              class="guest-filters">

            <div class="guest-search">
                <span aria-hidden="true">⌕</span>
                <input
                    type="search"
                    name="search"
                    value="{{ $search }}"
                    placeholder="Search name, email or phone..."
                    aria-label="Search guests"
                >
            </div>

            <select name="sort" aria-label="Sort guests">
                <option value="recent" @selected($sort === 'recent')>
                    Most Recent
                </option>
                <option value="name" @selected($sort === 'name')>
                    Guest Name
                </option>
                <option value="bookings" @selected($sort === 'bookings')>
                    Most Bookings
                </option>
            </select>

            <button type="submit" class="guest-filter-button">
                Apply Filters
            </button>

            @if ($search || $sort !== 'recent')
                <a href="{{ route('admin.guests.index') }}"
                   class="guest-reset-button">
                    Reset
                </a>
            @endif
        </form>

        <div class="guest-table-wrap">
            <table class="guest-table">
                <thead>
                    <tr>
                        <th>GUEST</th>
                        <th>CONTACT DETAILS</th>
                        <th>BOOKINGS</th>
                        <th>LATEST BOOKING</th>
                        <th>GUEST TYPE</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($guests as $guest)
                        <tr>
                            <td>
                                <div class="guest-identity">
                                    <span class="guest-avatar">
                                        {{ strtoupper(substr(trim($guest->guest_name ?: 'Guest'), 0, 1)) }}
                                    </span>

                                    <div>
                                        <strong>
                                            {{ $guest->guest_name ?: 'Guest' }}
                                        </strong>
                                        <small>
                                            {{ $guest->guest_email }}
                                        </small>
                                    </div>
                                </div>
                            </td>

                            <td>
                                <div class="guest-contact">
                                    <span>
                                        {{ $guest->guest_phone ?: 'No phone provided' }}
                                    </span>
                                    <small>{{ $guest->guest_email }}</small>
                                </div>
                            </td>

                            <td>
                                <span class="guest-booking-count">
                                    {{ number_format($guest->bookings_count) }}
                                    {{ (int) $guest->bookings_count === 1 ? 'booking' : 'bookings' }}
                                </span>
                            </td>

                            <td>
                                <span class="guest-date">
                                    @if ($guest->last_booking_at)
                                        {{ \Illuminate\Support\Carbon::parse($guest->last_booking_at)->format('d M Y') }}
                                    @else
                                        —
                                    @endif
                                </span>
                            </td>

                            <td>
                                @if ((int) $guest->bookings_count > 1)
                                    <span class="guest-type guest-type-returning">
                                        Returning
                                    </span>
                                @else
                                    <span class="guest-type guest-type-new">
                                        First-time
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">
                                <div class="guest-empty">
                                    <span class="guest-empty-icon">♙</span>
                                    <h3>No guests found</h3>

                                    @if ($search)
                                        <p>Try another search term or reset your filters.</p>
                                        <a href="{{ route('admin.guests.index') }}">
                                            View all guests
                                        </a>
                                    @else
                                        <p>Guest records will appear here when bookings have been made.</p>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($guests->hasPages())
            <div class="guest-pagination">
                {{ $guests->links() }}
            </div>
        @endif
    </section>

    <div class="guest-privacy-note">
        <span aria-hidden="true">◇</span>
        <p>
            <strong>Guest privacy matters.</strong>
            Guest information is available only through the protected administration area.
            Handle contact details responsibly.
        </p>
    </div>

</div>
@endsection

@push('styles')
<style>
.guest-page {
    max-width: 1450px;
    margin: 0 auto;
    color: #28382f;
}

.guest-heading {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 20px;
    margin-bottom: 28px;
}

.guest-eyebrow {
    color: #a18450;
    font-size: 10px;
    font-weight: 800;
    letter-spacing: 2.1px;
}

.guest-heading h1 {
    margin: 8px 0;
    font-family: 'Playfair Display', Georgia, serif;
    font-size: clamp(29px, 4vw, 38px);
    font-weight: 500;
    letter-spacing: -.6px;
}

.guest-heading p {
    margin: 0;
    color: #858980;
    font-size: 13px;
    line-height: 1.7;
}

.guest-stats {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 18px;
    margin-bottom: 25px;
}

.guest-stat-card {
    padding: 22px 24px;
    border: 1px solid #e8e6de;
    border-radius: 7px;
    background: #fff;
}

.guest-stat-top {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 12px;
    color: #747b72;
    font-size: 12px;
    font-weight: 600;
}

.guest-stat-icon {
    display: grid;
    place-items: center;
    width: 36px;
    height: 36px;
    border-radius: 5px;
    background: #edf1e9;
    color: #49634f;
    font-size: 20px;
}

.guest-stat-card > strong {
    display: block;
    margin: 17px 0 6px;
    color: #263b30;
    font-family: 'Playfair Display', Georgia, serif;
    font-size: 32px;
    font-weight: 500;
}

.guest-stat-card > small {
    color: #93958c;
    font-size: 11px;
}

.guest-directory-card {
    overflow: hidden;
    border: 1px solid #e8e6de;
    border-radius: 7px;
    background: #fff;
}

.guest-directory-heading {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 15px;
    padding: 24px 25px;
    border-bottom: 1px solid #eeece5;
}

.guest-directory-heading h2 {
    margin: 0 0 6px;
    font-family: 'Playfair Display', Georgia, serif;
    font-size: 22px;
    font-weight: 500;
}

.guest-directory-heading p {
    margin: 0;
    color: #858980;
    font-size: 12px;
}

.guest-record-count {
    padding: 7px 10px;
    border-radius: 4px;
    background: #f2f1eb;
    color: #56664f;
    font-size: 11px;
    font-weight: 700;
    white-space: nowrap;
}

.guest-filters {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 10px;
    padding: 18px 25px;
    border-bottom: 1px solid #eeece5;
}

.guest-search {
    display: flex;
    flex: 1 1 250px;
    align-items: center;
    gap: 10px;
    min-height: 42px;
    padding: 0 12px;
    border: 1px solid #e2e1d8;
    border-radius: 4px;
    background: #fdfdfb;
}

.guest-search > span {
    color: #8b947f;
    font-size: 22px;
}

.guest-search input {
    width: 100%;
    min-width: 0;
    border: 0;
    outline: none;
    background: transparent;
    color: #28382f;
    font-size: 12px;
}

.guest-filters select {
    min-height: 42px;
    padding: 0 12px;
    border: 1px solid #e2e1d8;
    border-radius: 4px;
    background: #fff;
    color: #455348;
    font-size: 12px;
}

.guest-filter-button {
    min-height: 42px;
    padding: 0 17px;
    border: 0;
    border-radius: 4px;
    background: #263e32;
    color: #fff;
    font-size: 12px;
    font-weight: 700;
    cursor: pointer;
}

.guest-filter-button:hover {
    background: #395844;
}

.guest-reset-button {
    padding: 10px 5px;
    color: #687267;
    font-size: 12px;
    text-decoration: none;
}

.guest-table-wrap {
    overflow-x: auto;
    width: 100%;
}

.guest-table {
    width: 100%;
    border-collapse: collapse;
    text-align: left;
}

.guest-table thead {
    background: #faf9f6;
}

.guest-table th {
    padding: 14px 18px;
    color: #85877e;
    font-size: 9px;
    font-weight: 800;
    letter-spacing: 1px;
    white-space: nowrap;
}

.guest-table td {
    padding: 17px 18px;
    border-top: 1px solid #f0eee8;
    font-size: 12px;
    vertical-align: middle;
}

.guest-table tbody tr:hover {
    background: #fdfcf9;
}

.guest-identity {
    display: flex;
    align-items: center;
    gap: 11px;
    min-width: 180px;
}

.guest-avatar {
    display: grid;
    place-items: center;
    flex-shrink: 0;
    width: 39px;
    height: 39px;
    border: 1px solid #e1e5d9;
    border-radius: 50%;
    background: #edf1e8;
    color: #405b46;
    font-family: 'Playfair Display', Georgia, serif;
    font-size: 16px;
}

.guest-identity strong {
    display: block;
    color: #344238;
    font-size: 12px;
    font-weight: 750;
}

.guest-identity small,
.guest-contact small {
    display: block;
    margin-top: 5px;
    color: #96978f;
    font-size: 10px;
    overflow-wrap: anywhere;
}

.guest-contact {
    min-width: 145px;
    color: #566157;
    line-height: 1.5;
}

.guest-booking-count {
    display: inline-block;
    padding: 6px 9px;
    border-radius: 4px;
    background: #f3f2ed;
    color: #56634f;
    font-size: 11px;
    white-space: nowrap;
}

.guest-date {
    color: #697268;
    white-space: nowrap;
}

.guest-type {
    display: inline-block;
    padding: 6px 9px;
    border-radius: 3px;
    font-size: 10px;
    font-weight: 750;
    white-space: nowrap;
}

.guest-type-returning {
    background: #e8f1e8;
    color: #3f6a47;
}

.guest-type-new {
    background: #f3eee1;
    color: #927543;
}

.guest-empty {
    padding: 55px 20px;
    text-align: center;
}

.guest-empty-icon {
    display: inline-grid;
    place-items: center;
    width: 54px;
    height: 54px;
    border-radius: 50%;
    background: #f0f1e9;
    color: #68785f;
    font-size: 25px;
}

.guest-empty h3 {
    margin: 15px 0 8px;
    font-family: 'Playfair Display', Georgia, serif;
    font-size: 22px;
    font-weight: 500;
}

.guest-empty p {
    margin: 0 0 15px;
    color: #8a8e85;
    font-size: 12px;
}

.guest-empty a {
    color: #49664f;
    font-size: 12px;
    font-weight: 700;
}

.guest-pagination {
    padding: 20px 25px;
    border-top: 1px solid #eeece5;
}

.guest-privacy-note {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    margin-top: 20px;
    padding: 17px 19px;
    border: 1px solid #e9e6dc;
    border-radius: 5px;
    background: #f8f7f1;
}

.guest-privacy-note > span {
    color: #9b8050;
    font-size: 20px;
}

.guest-privacy-note p {
    margin: 0;
    color: #777e73;
    font-size: 11px;
    line-height: 1.8;
}

.guest-privacy-note strong {
    color: #3d4d40;
}

@media (max-width: 900px) {
    .guest-stats {
        grid-template-columns: 1fr;
        gap: 12px;
    }

    .guest-stat-card {
        padding: 18px 20px;
    }

    .guest-stat-card > strong {
        margin-top: 12px;
    }
}

@media (max-width: 600px) {
    .guest-directory-heading {
        align-items: flex-start;
        flex-direction: column;
        padding: 19px;
    }

    .guest-filters {
        padding: 15px;
    }

    .guest-search {
        flex-basis: 100%;
    }

    .guest-filters select,
    .guest-filter-button {
        flex: 1;
    }

    .guest-table th,
    .guest-table td {
        padding: 13px 14px;
    }
}
</style>
@endpush
