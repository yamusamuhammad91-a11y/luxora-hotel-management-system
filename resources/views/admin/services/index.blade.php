@extends('layouts.admin')

@section('title', 'Hotel Services')
@section('page-title', 'Service Management')

@section('content')

    <div class="services-page-heading">
        <div>
            <p class="services-eyebrow">HOTEL OPERATIONS</p>
            <h2>Manage Services</h2>
            <p>Manage the experiences and additional services offered to your guests.</p>
        </div>

        <a href="{{ route('admin.services.create') }}" class="services-primary-btn">
            <span>+</span> Add New Service
        </a>
    </div>

    <div class="services-summary">
        <div class="services-summary-card">
            <span class="summary-icon">✧</span>
            <div>
                <p>Total Services</p>
                <strong>{{ $services->total() }}</strong>
            </div>
        </div>

        <div class="services-summary-card">
            <span class="summary-icon summary-icon-active">✓</span>
            <div>
                <p>Active on Website</p>
                <strong>
                    {{ \App\Models\Service::where('is_active', true)->count() }}
                </strong>
            </div>
        </div>

        <div class="services-summary-card">
            <span class="summary-icon summary-icon-inactive">◷</span>
            <div>
                <p>Inactive Services</p>
                <strong>
                    {{ \App\Models\Service::where('is_active', false)->count() }}
                </strong>
            </div>
        </div>
    </div>

    <section class="services-panel">
        <div class="services-panel-heading">
            <div>
                <h3>All Hotel Services</h3>
                <p>Manage service details, pricing, and visibility.</p>
            </div>

            <span class="services-count">
                {{ $services->total() }} records
            </span>
        </div>

        @if ($services->isEmpty())
            <div class="services-empty">
                <div class="services-empty-icon">✧</div>
                <h3>No services found</h3>
                <p>Add your first hotel service to get started.</p>

                <a href="{{ route('admin.services.create') }}"
                   class="services-primary-btn">
                    Add Your First Service
                </a>
            </div>
        @else
            <div class="services-table-wrapper">
                <table class="services-table">
                    <thead>
                        <tr>
                            <th>Service</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Pricing Type</th>
                            <th>Visibility</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($services as $service)
                            <tr>
                                <td>
                                    <div class="service-name-cell">
                                        @if ($service->image)
                                            <img
                                                src="{{ $service->image }}"
                                                alt="{{ $service->name }}"
                                                class="service-thumbnail"
                                                loading="lazy"
                                            >
                                        @else
                                            <div class="service-thumbnail-placeholder">
                                                ✧
                                            </div>
                                        @endif

                                        <div class="service-name-details">
                                            <strong>{{ $service->name }}</strong>
                                            <span>
                                                {{ \Illuminate\Support\Str::limit($service->description, 65) }}
                                            </span>
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    <span class="service-category">
                                        {{ ucwords(str_replace('_', ' ', $service->category)) }}
                                    </span>
                                </td>

                                <td>
                                    <strong class="service-price">
                                        ₦{{ number_format((float) $service->price, 2) }}
                                    </strong>
                                </td>

                                <td>
                                    <span class="service-pricing-type">
                                        {{ ucwords(str_replace('_', ' ', $service->price_type)) }}
                                    </span>
                                </td>

                                <td>
                                    <span class="service-status {{ $service->is_active ? 'service-status-active' : 'service-status-inactive' }}">
                                        <span class="service-status-dot"></span>
                                        {{ $service->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>

                                <td>
                                    <div class="service-actions">
                                        <a
                                            href="{{ route('admin.services.edit', $service) }}"
                                            class="service-edit-btn"
                                        >
                                            Edit
                                        </a>

                                        <form
                                            method="POST"
                                            action="{{ route('admin.services.status', $service) }}"
                                        >
                                            @csrf
                                            @method('PATCH')

                                            <button
                                                type="submit"
                                                class="service-toggle-btn"
                                            >
                                                {{ $service->is_active ? 'Deactivate' : 'Activate' }}
                                            </button>
                                        </form>

                                        <form
                                            method="POST"
                                            action="{{ route('admin.services.destroy', $service) }}"
                                            onsubmit="return confirm('Are you sure you want to delete this service? This action cannot be undone.');"
                                        >
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="service-delete-btn">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="services-pagination">
                {{ $services->links() }}
            </div>
        @endif
    </section>

@endsection

@push('styles')
<style>
    .services-page-heading {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        margin-bottom: 26px;
    }

    .services-eyebrow {
        margin: 0 0 8px;
        color: #9b8053;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 1.6px;
    }

    .services-page-heading h2 {
        margin: 0;
        color: #20382f;
        font-family: 'Playfair Display', serif;
        font-size: clamp(24px, 3vw, 31px);
        font-weight: 600;
    }

    .services-page-heading p:not(.services-eyebrow) {
        margin: 8px 0 0;
        color: #777d76;
        font-size: 12px;
        line-height: 1.7;
    }

    .services-primary-btn {
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
        transition: background .2s ease;
    }

    .services-primary-btn:hover {
        background: #2d4a3e;
    }

    .services-primary-btn span {
        color: #dfc18d;
        font-size: 19px;
    }

    .services-summary {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 15px;
        margin-bottom: 24px;
    }

    .services-summary-card {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 20px;
        border: 1px solid #e9e6de;
        border-radius: 8px;
        background: #fff;
    }

    .summary-icon {
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

    .summary-icon-active {
        background: #e6f4e9;
        color: #2f7141;
    }

    .summary-icon-inactive {
        background: #f1f1ee;
        color: #777d76;
    }

    .services-summary-card p {
        margin: 0 0 7px;
        color: #777d76;
        font-size: 11px;
    }

    .services-summary-card strong {
        color: #20382f;
        font-family: 'Playfair Display', serif;
        font-size: 27px;
        font-weight: 600;
    }

    .services-panel {
        overflow: hidden;
        border: 1px solid #e9e6de;
        border-radius: 8px;
        background: #fff;
    }

    .services-panel-heading {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
        padding: 23px;
        border-bottom: 1px solid #efede7;
    }

    .services-panel-heading h3 {
        margin: 0;
        color: #20382f;
        font-family: 'Playfair Display', serif;
        font-size: 21px;
        font-weight: 600;
    }

    .services-panel-heading p {
        margin: 6px 0 0;
        color: #858a83;
        font-size: 11px;
    }

    .services-count {
        padding: 8px 10px;
        border-radius: 5px;
        background: #f5f1e8;
        color: #796441;
        font-size: 10px;
        font-weight: 700;
        white-space: nowrap;
    }

    .services-table-wrapper {
        overflow-x: auto;
    }

    .services-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
    }

    .services-table thead {
        background: #fbfaf7;
    }

    .services-table th {
        padding: 14px 16px;
        color: #858a83;
        font-size: 9px;
        font-weight: 700;
        letter-spacing: .7px;
        text-transform: uppercase;
        white-space: nowrap;
    }

    .services-table td {
        padding: 16px;
        border-top: 1px solid #f0eee8;
        color: #596159;
        font-size: 11px;
        vertical-align: middle;
    }

    .services-table tbody tr:hover {
        background: #fdfcf9;
    }

    .service-name-cell {
        display: flex;
        align-items: center;
        gap: 12px;
        min-width: 210px;
    }

    .service-thumbnail,
    .service-thumbnail-placeholder {
        display: grid;
        width: 53px;
        height: 53px;
        flex-shrink: 0;
        place-items: center;
        border-radius: 6px;
        background: #f5f1e8;
        color: #9b8053;
        font-size: 20px;
        object-fit: cover;
    }

    .service-name-details {
        min-width: 0;
    }

    .service-name-details strong,
    .service-name-details span {
        display: block;
    }

    .service-name-details strong {
        color: #344138;
        font-size: 12px;
        font-weight: 700;
    }

    .service-name-details span {
        max-width: 230px;
        margin-top: 6px;
        color: #858a83;
        font-size: 10px;
        line-height: 1.6;
    }

    .service-category,
    .service-pricing-type {
        color: #596159;
        font-size: 10px;
        white-space: nowrap;
    }

    .service-price {
        color: #20382f;
        font-weight: 700;
        white-space: nowrap;
    }

    .service-status {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 7px 9px;
        border-radius: 20px;
        font-size: 9px;
        font-weight: 700;
        white-space: nowrap;
    }

    .service-status-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: currentColor;
    }

    .service-status-active {
        background: #e6f4e9;
        color: #2f7141;
    }

    .service-status-inactive {
        background: #f1f1ee;
        color: #777d76;
    }

    .service-actions {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 7px;
        min-width: 190px;
    }

    .service-edit-btn,
    .service-toggle-btn,
    .service-delete-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 32px;
        padding: 0 9px;
        border: 1px solid #e5e2d9;
        border-radius: 4px;
        background: #fff;
        color: #4e574f;
        cursor: pointer;
        font-size: 10px;
        font-weight: 600;
        white-space: nowrap;
    }

    .service-edit-btn:hover {
        border-color: #c4a574;
        color: #20382f;
    }

    .service-toggle-btn {
        border-color: #d9e8db;
        color: #397248;
    }

    .service-toggle-btn:hover {
        background: #f0f8f1;
    }

    .service-delete-btn {
        border-color: #f0d9d6;
        color: #a3423a;
    }

    .service-delete-btn:hover {
        background: #fff3f2;
    }

    .service-empty {
        padding: 55px 20px;
        text-align: center;
    }

    .services-empty {
        padding: 55px 20px;
        text-align: center;
    }

    .services-empty-icon {
        color: #b39a6b;
        font-size: 35px;
    }

    .services-empty h3 {
        margin: 12px 0 7px;
        color: #20382f;
        font-family: 'Playfair Display', serif;
        font-size: 21px;
    }

    .services-empty p {
        margin: 0 0 18px;
        color: #858a83;
        font-size: 12px;
    }

    .services-pagination {
        padding: 20px 23px;
        border-top: 1px solid #efede7;
    }

    @media (max-width: 850px) {
        .services-summary {
            grid-template-columns: 1fr;
        }

        .services-summary-card {
            padding: 16px;
        }
    }

    @media (max-width: 640px) {
        .services-page-heading {
            align-items: flex-start;
            flex-direction: column;
        }

        .services-panel-heading {
            padding: 18px 15px;
        }

        .services-table th,
        .services-table td {
            padding: 13px 12px;
        }

        .services-pagination {
            padding: 17px 15px;
            overflow-x: auto;
        }
    }
</style>
@endpush
