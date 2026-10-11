@extends('layouts.admin')

@section('title', 'Room Management')
@section('page-title', 'Room Management')

@section('content')

    <div class="rooms-page-heading">
        <div>
            <p class="rooms-eyebrow">PROPERTY MANAGEMENT</p>
            <h2>Manage Rooms & Suites</h2>
            <p>Maintain your room catalogue, nightly rates, and room availability settings.</p>
        </div>

        <a href="{{ route('admin.rooms.create') }}" class="rooms-primary-btn">
            <span>+</span> Add New Room
        </a>
    </div>

    <div class="rooms-summary">
        <article class="rooms-summary-card">
            <span class="rooms-summary-icon">▤</span>
            <div>
                <p>Total Rooms</p>
                <strong>{{ number_format($stats['total']) }}</strong>
            </div>
        </article>

        <article class="rooms-summary-card">
            <span class="rooms-summary-icon rooms-icon-active">✓</span>
            <div>
                <p>Active Rooms</p>
                <strong>{{ number_format($stats['active']) }}</strong>
            </div>
        </article>

        <article class="rooms-summary-card">
            <span class="rooms-summary-icon rooms-icon-inactive">◷</span>
            <div>
                <p>Inactive Rooms</p>
                <strong>{{ number_format($stats['inactive']) }}</strong>
            </div>
        </article>
    </div>

    <section class="rooms-panel">

        <div class="rooms-panel-heading">
            <div>
                <h3>Room Catalogue</h3>
                <p>View and manage all rooms registered in Luxora.</p>
            </div>

            <span class="rooms-record-count">
                {{ $rooms->total() }} records
            </span>
        </div>

        <form
            action="{{ route('admin.rooms.index') }}"
            method="GET"
            class="rooms-filters"
        >
            <div class="rooms-search-field">
                <label for="room-search">Search rooms</label>
                <input
                    id="room-search"
                    type="search"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Room name, slug, or description..."
                >
            </div>

            <div class="rooms-status-field">
                <label for="room-status">Status</label>
                <select id="room-status" name="status">
                    <option value="">All rooms</option>
                    <option value="active" @selected(request('status') === 'active')>
                        Active
                    </option>
                    <option value="inactive" @selected(request('status') === 'inactive')>
                        Inactive
                    </option>
                </select>
            </div>

            <button type="submit" class="rooms-filter-btn">
                Apply Filters
            </button>

            @if (request()->filled('search') || request()->filled('status'))
                <a href="{{ route('admin.rooms.index') }}" class="rooms-reset-btn">
                    Clear
                </a>
            @endif
        </form>

        @if ($rooms->isEmpty())
            <div class="rooms-empty">
                <div class="rooms-empty-icon">▤</div>
                <h3>No rooms found</h3>
                <p>
                    No rooms match your current search. You can adjust the filters
                    or add a new room.
                </p>

                <a href="{{ route('admin.rooms.create') }}" class="rooms-primary-btn">
                    Add a Room
                </a>
            </div>
        @else
            <div class="rooms-table-wrapper">
                <table class="rooms-table">
                    <thead>
                        <tr>
                            <th>Room</th>
                            <th>Nightly Rate</th>
                            <th>Capacity</th>
                            <th>Features</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($rooms as $room)
                            <tr>
                                <td>
                                    <div class="room-identity">
                                        @if ($room->image)
                                            <img
                                                src="{{ $room->image }}"
                                                alt="{{ $room->name }}"
                                                class="room-thumbnail"
                                                loading="lazy"
                                            >
                                        @else
                                            <div class="room-thumbnail-placeholder">
                                                ▤
                                            </div>
                                        @endif

                                        <div class="room-identity-details">
                                            <strong>{{ $room->name }}</strong>
                                            <span>{{ $room->slug }}</span>
                                            <small>
                                                {{ \Illuminate\Support\Str::limit($room->description, 70) }}
                                            </small>
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    <strong class="room-price">
                                        ₦{{ number_format((float) $room->price, 2) }}
                                    </strong>
                                    <span class="room-price-unit">per night</span>
                                </td>

                                <td>
                                    <span class="room-capacity">
                                        <span>♙</span>
                                        {{ $room->capacity }}
                                        {{ $room->capacity === 1 ? 'guest' : 'guests' }}
                                    </span>
                                </td>

                                <td>
                                    @if (!empty($room->features))
                                        <div class="room-feature-list">
                                            @foreach (collect($room->features)->take(3) as $feature)
                                                <span>{{ $feature }}</span>
                                            @endforeach

                                            @if (count($room->features) > 3)
                                                <span>
                                                    +{{ count($room->features) - 3 }} more
                                                </span>
                                            @endif
                                        </div>
                                    @else
                                        <span class="room-no-features">No features added</span>
                                    @endif
                                </td>

                                <td>
                                    <span class="room-status {{ $room->is_active ? 'room-status-active' : 'room-status-inactive' }}">
                                        <span class="room-status-dot"></span>
                                        {{ $room->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>

                                <td>
                                    <div class="room-actions">
                                        <a
                                            href="{{ route('admin.rooms.edit', $room) }}"
                                            class="room-action-edit"
                                        >
                                            Edit
                                        </a>

                                        <form
                                            method="POST"
                                            action="{{ route('admin.rooms.status', $room) }}"
                                        >
                                            @csrf
                                            @method('PATCH')

                                            <button type="submit" class="room-action-toggle">
                                                {{ $room->is_active ? 'Deactivate' : 'Activate' }}
                                            </button>
                                        </form>

                                        @if ($room->bookings()->exists())
                                            <span
                                                class="room-delete-disabled"
                                                title="Rooms with booking records cannot be deleted."
                                            >
                                                Has bookings
                                            </span>
                                        @else
                                            <form
                                                method="POST"
                                                action="{{ route('admin.rooms.destroy', $room) }}"
                                                onsubmit="return confirm('Delete this room permanently? This cannot be undone.');"
                                            >
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="room-action-delete">
                                                    Delete
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="rooms-pagination">
                {{ $rooms->links() }}
            </div>
        @endif

    </section>

@endsection

@push('styles')
<style>
    .rooms-page-heading {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        margin-bottom: 26px;
    }

    .rooms-eyebrow {
        margin: 0 0 8px;
        color: #9b8053;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 1.6px;
    }

    .rooms-page-heading h2 {
        margin: 0;
        color: #20382f;
        font-family: 'Playfair Display', serif;
        font-size: clamp(24px, 3vw, 31px);
        font-weight: 600;
    }

    .rooms-page-heading p:not(.rooms-eyebrow) {
        margin: 8px 0 0;
        color: #777d76;
        font-size: 12px;
        line-height: 1.7;
    }

    .rooms-primary-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 9px;
        min-height: 43px;
        padding: 0 17px;
        border: 0;
        border-radius: 5px;
        background: #20382f;
        color: #fff;
        cursor: pointer;
        font-size: 11px;
        font-weight: 600;
        white-space: nowrap;
    }

    .rooms-primary-btn:hover {
        background: #2d4a3e;
    }

    .rooms-primary-btn span {
        color: #dfc18d;
        font-size: 19px;
    }

    .rooms-summary {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 15px;
        margin-bottom: 24px;
    }

    .rooms-summary-card {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 20px;
        border: 1px solid #e9e6de;
        border-radius: 8px;
        background: #fff;
    }

    .rooms-summary-icon {
        display: grid;
        width: 43px;
        height: 43px;
        flex-shrink: 0;
        place-items: center;
        border-radius: 8px;
        background: #f5f1e8;
        color: #8d744c;
        font-size: 20px;
    }

    .rooms-icon-active {
        background: #e6f4e9;
        color: #2f7141;
    }

    .rooms-icon-inactive {
        background: #f1f1ee;
        color: #777d76;
    }

    .rooms-summary-card p {
        margin: 0 0 7px;
        color: #777d76;
        font-size: 11px;
    }

    .rooms-summary-card strong {
        color: #20382f;
        font-family: 'Playfair Display', serif;
        font-size: 27px;
        font-weight: 600;
    }

    .rooms-panel {
        overflow: hidden;
        border: 1px solid #e9e6de;
        border-radius: 8px;
        background: #fff;
    }

    .rooms-panel-heading {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
        padding: 23px;
        border-bottom: 1px solid #efede7;
    }

    .rooms-panel-heading h3 {
        margin: 0;
        color: #20382f;
        font-family: 'Playfair Display', serif;
        font-size: 21px;
        font-weight: 600;
    }

    .rooms-panel-heading p {
        margin: 6px 0 0;
        color: #858a83;
        font-size: 11px;
    }

    .rooms-record-count {
        padding: 8px 10px;
        border-radius: 5px;
        background: #f5f1e8;
        color: #796441;
        font-size: 10px;
        font-weight: 700;
        white-space: nowrap;
    }

    .rooms-filters {
        display: flex;
        align-items: end;
        flex-wrap: wrap;
        gap: 13px;
        padding: 20px 23px;
        border-bottom: 1px solid #efede7;
        background: #fdfcf9;
    }

    .rooms-search-field {
        flex: 1 1 260px;
        min-width: 0;
    }

    .rooms-status-field {
        flex: 0 1 170px;
    }

    .rooms-filters label {
        display: block;
        margin-bottom: 8px;
        color: #4e574f;
        font-size: 10px;
        font-weight: 700;
    }

    .rooms-filters input,
    .rooms-filters select {
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

    .rooms-filters input:focus,
    .rooms-filters select:focus {
        border-color: #b39a6b;
        box-shadow: 0 0 0 3px rgba(196,165,116,.12);
    }

    .rooms-filter-btn,
    .rooms-reset-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 40px;
        padding: 0 14px;
        border: 1px solid #e5e2d9;
        border-radius: 5px;
        background: #fff;
        color: #4e574f;
        cursor: pointer;
        font-size: 11px;
        font-weight: 600;
        white-space: nowrap;
    }

    .rooms-filter-btn {
        border-color: #20382f;
        background: #20382f;
        color: #fff;
    }

    .rooms-filter-btn:hover {
        background: #2d4a3e;
    }

    .rooms-reset-btn:hover {
        border-color: #c4a574;
    }

    .rooms-table-wrapper {
        overflow-x: auto;
    }

    .rooms-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
    }

    .rooms-table thead {
        background: #fbfaf7;
    }

    .rooms-table th {
        padding: 14px 16px;
        color: #858a83;
        font-size: 9px;
        font-weight: 700;
        letter-spacing: .7px;
        text-transform: uppercase;
        white-space: nowrap;
    }

    .rooms-table td {
        padding: 16px;
        border-top: 1px solid #f0eee8;
        color: #596159;
        font-size: 11px;
        vertical-align: middle;
    }

    .rooms-table tbody tr:hover {
        background: #fdfcf9;
    }

    .room-identity {
        display: flex;
        align-items: center;
        gap: 12px;
        min-width: 230px;
    }

    .room-thumbnail,
    .room-thumbnail-placeholder {
        display: grid;
        width: 65px;
        height: 60px;
        flex-shrink: 0;
        place-items: center;
        border-radius: 6px;
        background: #f5f1e8;
        color: #9b8053;
        font-size: 21px;
        object-fit: cover;
    }

    .room-identity-details {
        min-width: 0;
    }

    .room-identity-details strong,
    .room-identity-details span,
    .room-identity-details small {
        display: block;
    }

    .room-identity-details strong {
        color: #344138;
        font-size: 12px;
        font-weight: 700;
    }

    .room-identity-details span {
        margin-top: 5px;
        color: #9b8053;
        font-size: 10px;
    }

    .room-identity-details small {
        max-width: 230px;
        margin-top: 5px;
        color: #858a83;
        font-size: 10px;
        line-height: 1.6;
    }

    .room-price {
        display: block;
        color: #20382f;
        font-weight: 700;
        white-space: nowrap;
    }

    .room-price-unit {
        display: block;
        margin-top: 5px;
        color: #858a83;
        font-size: 10px;
    }

    .room-capacity {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        color: #596159;
        white-space: nowrap;
    }

    .room-capacity span {
        color: #9b8053;
        font-size: 16px;
    }

    .room-feature-list {
        display: flex;
        flex-wrap: wrap;
        gap: 5px;
        min-width: 110px;
    }

    .room-feature-list span {
        padding: 5px 7px;
        border-radius: 4px;
        background: #f5f1e8;
        color: #796441;
        font-size: 9px;
        line-height: 1.4;
    }

    .room-no-features {
        color: #858a83;
        font-size: 10px;
    }

    .room-status {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 7px 9px;
        border-radius: 20px;
        font-size: 9px;
        font-weight: 700;
        white-space: nowrap;
    }

    .room-status-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: currentColor;
    }

    .room-status-active {
        background: #e6f4e9;
        color: #2f7141;
    }

    .room-status-inactive {
        background: #f1f1ee;
        color: #777d76;
    }

    .room-actions {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 7px;
        min-width: 160px;
    }

    .room-action-edit,
    .room-action-toggle,
    .room-action-delete,
    .room-delete-disabled {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 32px;
        padding: 0 9px;
        border: 1px solid #e5e2d9;
        border-radius: 4px;
        background: #fff;
        color: #4e574f;
        font-size: 10px;
        font-weight: 600;
        white-space: nowrap;
    }

    .room-action-edit:hover {
        border-color: #c4a574;
        color: #20382f;
    }

    .room-action-toggle {
        border-color: #d9e8db;
        color: #397248;
        cursor: pointer;
    }

    .room-action-toggle:hover {
        background: #f0f8f1;
    }

    .room-action-delete {
        border-color: #f0d9d6;
        color: #a3423a;
        cursor: pointer;
    }

    .room-action-delete:hover {
        background: #fff3f2;
    }

    .room-delete-disabled {
        border-color: #e9e6de;
        background: #f7f6f2;
        color: #858a83;
        cursor: help;
    }

    .rooms-empty {
        padding: 55px 20px;
        text-align: center;
    }

    .rooms-empty-icon {
        color: #b39a6b;
        font-size: 35px;
    }

    .rooms-empty h3 {
        margin: 12px 0 7px;
        color: #20382f;
        font-family: 'Playfair Display', serif;
        font-size: 21px;
    }

    .rooms-empty p {
        margin: 0 0 18px;
        color: #858a83;
        font-size: 12px;
        line-height: 1.7;
    }

    .rooms-pagination {
        padding: 20px 23px;
        border-top: 1px solid #efede7;
    }

    @media (max-width: 850px) {
        .rooms-summary {
            grid-template-columns: 1fr;
        }

        .rooms-summary-card {
            padding: 16px;
        }
    }

    @media (max-width: 640px) {
        .rooms-page-heading {
            align-items: flex-start;
            flex-direction: column;
        }

        .rooms-panel-heading {
            padding: 18px 15px;
        }

        .rooms-filters {
            align-items: stretch;
            flex-direction: column;
            padding: 17px 15px;
        }

        .rooms-search-field,
        .rooms-status-field {
            flex-basis: auto;
            width: 100%;
        }

        .rooms-table th,
        .rooms-table td {
            padding: 13px 12px;
        }

        .rooms-pagination {
            padding: 17px 15px;
            overflow-x: auto;
        }
    }
</style>
@endpush
