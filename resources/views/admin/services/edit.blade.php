@extends('layouts.admin')

@section('title', 'Edit Service')
@section('page-title', 'Edit Service')

@section('content')

    <div class="service-form-heading">
        <div>
            <p class="service-form-eyebrow">HOTEL OPERATIONS</p>
            <h2>Edit {{ $service->name }}</h2>
            <p>Update the service details, pricing, and visibility settings.</p>
        </div>

        <a href="{{ route('admin.services.index') }}" class="service-back-btn">
            <span>←</span> Back to Services
        </a>
    </div>

    <form
        action="{{ route('admin.services.update', $service) }}"
        method="POST"
        class="service-form"
    >
        @csrf
        @method('PUT')

        <div class="service-form-grid">

            <section class="service-form-panel">
                <div class="service-form-panel-heading">
                    <div>
                        <h3>Service Information</h3>
                        <p>Update the information displayed to guests.</p>
                    </div>
                    <span class="service-form-panel-icon">✧</span>
                </div>

                <div class="service-form-body">

                    <div class="service-field">
                        <label for="name">Service Name <span>*</span></label>
                        <input
                            id="name"
                            type="text"
                            name="name"
                            value="{{ old('name', $service->name) }}"
                            maxlength="150"
                            required
                        >
                        @error('name')
                            <p class="service-field-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="service-field">
                        <label for="slug">URL Slug <span>*</span></label>
                        <input
                            id="slug"
                            type="text"
                            name="slug"
                            value="{{ old('slug', $service->slug) }}"
                            maxlength="180"
                            required
                        >
                        <small>Used to identify this service in its URL.</small>
                        @error('slug')
                            <p class="service-field-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="service-field">
                        <label for="category">Category <span>*</span></label>
                        <select id="category" name="category" required>
                            @foreach ([
                                'room_service' => 'Room Service',
                                'wellness' => 'Wellness & Spa',
                                'transport' => 'Transport',
                                'laundry' => 'Laundry',
                                'dining' => 'Dining',
                                'general' => 'General',
                            ] as $value => $label)
                                <option
                                    value="{{ $value }}"
                                    @selected(old('category', $service->category) === $value)
                                >
                                    {{ $label }}
                                </option>
                            @endforeach

                            @if (
                                $service->category &&
                                ! in_array($service->category, [
                                    'room_service',
                                    'wellness',
                                    'transport',
                                    'laundry',
                                    'dining',
                                    'general',
                                ], true)
                            )
                                <option
                                    value="{{ $service->category }}"
                                    @selected(old('category', $service->category) === $service->category)
                                >
                                    {{ ucwords(str_replace('_', ' ', $service->category)) }}
                                </option>
                            @endif
                        </select>
                        @error('category')
                            <p class="service-field-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="service-field">
                        <label for="description">Description <span>*</span></label>
                        <textarea
                            id="description"
                            name="description"
                            rows="5"
                            required
                        >{{ old('description', $service->description) }}</textarea>
                        @error('description')
                            <p class="service-field-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="service-field">
                        <label for="image">Image URL</label>
                        <input
                            id="image"
                            type="url"
                            name="image"
                            value="{{ old('image', $service->image) }}"
                            placeholder="https://example.com/service-image.jpg"
                        >
                        <small>Use a publicly accessible image URL.</small>
                        @error('image')
                            <p class="service-field-error">{{ $message }}</p>
                        @enderror

                        @if ($service->image)
                            <div class="service-current-image">
                                <span>Current image</span>
                                <img
                                    src="{{ $service->image }}"
                                    alt="{{ $service->name }}"
                                    loading="lazy"
                                >
                            </div>
                        @endif
                    </div>

                </div>
            </section>

            <div class="service-form-side">

                <section class="service-form-panel">
                    <div class="service-form-panel-heading">
                        <div>
                            <h3>Pricing</h3>
                            <p>Configure the service charge.</p>
                        </div>
                        <span class="service-form-panel-icon">₦</span>
                    </div>

                    <div class="service-form-body">

                        <div class="service-field">
                            <label for="price">Price (₦) <span>*</span></label>
                            <input
                                id="price"
                                type="number"
                                name="price"
                                value="{{ old('price', $service->price) }}"
                                min="0"
                                max="9999999999.99"
                                step="0.01"
                                required
                            >
                            @error('price')
                                <p class="service-field-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="service-field">
                            <label for="price_type">Pricing Type <span>*</span></label>
                            <select id="price_type" name="price_type" required>
                                @foreach ([
                                    'fixed' => 'Fixed Price',
                                    'per_service' => 'Per Service',
                                    'per_trip' => 'Per Trip',
                                    'per_session' => 'Per Session',
                                ] as $value => $label)
                                    <option
                                        value="{{ $value }}"
                                        @selected(old('price_type', $service->price_type) === $value)
                                    >
                                        {{ $label }}
                                    </option>
                                @endforeach

                                @if (
                                    $service->price_type &&
                                    ! in_array($service->price_type, [
                                        'fixed',
                                        'per_service',
                                        'per_trip',
                                        'per_session',
                                    ], true)
                                )
                                    <option
                                        value="{{ $service->price_type }}"
                                        @selected(old('price_type', $service->price_type) === $service->price_type)
                                    >
                                        {{ ucwords(str_replace('_', ' ', $service->price_type)) }}
                                    </option>
                                @endif
                            </select>
                            @error('price_type')
                                <p class="service-field-error">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>
                </section>

                <section class="service-form-panel">
                    <div class="service-form-panel-heading">
                        <div>
                            <h3>Display Settings</h3>
                            <p>Control visibility and ordering.</p>
                        </div>
                        <span class="service-form-panel-icon">⚙</span>
                    </div>

                    <div class="service-form-body">

                        <div class="service-field">
                            <label for="display_order">Display Order</label>
                            <input
                                id="display_order"
                                type="number"
                                name="display_order"
                                value="{{ old('display_order', $service->display_order) }}"
                                min="0"
                                max="2147483647"
                            >
                            <small>Lower numbers appear first where sorting is applied.</small>
                            @error('display_order')
                                <p class="service-field-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <label class="service-active-option" for="is_active">
                            <input
                                id="is_active"
                                type="checkbox"
                                name="is_active"
                                value="1"
                                @checked((bool) old('is_active', $service->is_active))
                            >

                            <span>
                                <strong>Publish service</strong>
                                <small>Make this service visible on the public website.</small>
                            </span>
                        </label>

                        @error('is_active')
                            <p class="service-field-error">{{ $message }}</p>
                        @enderror

                    </div>
                </section>

                <section class="service-form-note">
                    <span class="service-note-icon">i</span>
                    <div>
                        <strong>Changes take effect after saving</strong>
                        <p>Review your updates carefully before saving. The service's visibility depends on its active status.</p>
                    </div>
                </section>

            </div>
        </div>

        <div class="service-form-actions">
            <a
                href="{{ route('admin.services.index') }}"
                class="service-cancel-btn"
            >
                Cancel
            </a>

            <button type="submit" class="service-submit-btn">
                Save Changes <span>→</span>
            </button>
        </div>

    </form>

@endsection

@push('styles')
<style>
    .service-form-heading {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        margin-bottom: 25px;
    }

    .service-form-eyebrow {
        margin: 0 0 8px;
        color: #9b8053;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 1.6px;
    }

    .service-form-heading h2 {
        margin: 0;
        color: #20382f;
        font-family: 'Playfair Display', serif;
        font-size: clamp(24px, 3vw, 31px);
        font-weight: 600;
        overflow-wrap: anywhere;
    }

    .service-form-heading p:not(.service-form-eyebrow) {
        margin: 8px 0 0;
        color: #777d76;
        font-size: 12px;
        line-height: 1.7;
    }

    .service-back-btn,
    .service-cancel-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 9px;
        min-height: 41px;
        padding: 0 14px;
        border: 1px solid #e5e2d9;
        border-radius: 5px;
        background: #fff;
        color: #4e574f;
        font-size: 11px;
        font-weight: 600;
        white-space: nowrap;
    }

    .service-back-btn:hover,
    .service-cancel-btn:hover {
        border-color: #c4a574;
    }

    .service-back-btn span {
        font-size: 16px;
    }

    .service-form-grid {
        display: grid;
        grid-template-columns: minmax(0, 1.5fr) minmax(290px, .85fr);
        align-items: start;
        gap: 20px;
    }

    .service-form-side {
        display: grid;
        gap: 20px;
    }

    .service-form-panel {
        overflow: hidden;
        border: 1px solid #e9e6de;
        border-radius: 8px;
        background: #fff;
    }

    .service-form-panel-heading {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
        padding: 21px 23px;
        border-bottom: 1px solid #efede7;
    }

    .service-form-panel-heading h3 {
        margin: 0;
        color: #20382f;
        font-family: 'Playfair Display', serif;
        font-size: 19px;
        font-weight: 600;
    }

    .service-form-panel-heading p {
        margin: 6px 0 0;
        color: #858a83;
        font-size: 10px;
    }

    .service-form-panel-icon {
        display: grid;
        width: 37px;
        height: 37px;
        flex-shrink: 0;
        place-items: center;
        border-radius: 7px;
        background: #f5f1e8;
        color: #8d744c;
        font-size: 19px;
    }

    .service-form-body {
        display: grid;
        gap: 20px;
        padding: 23px;
    }

    .service-field label {
        display: block;
        margin-bottom: 8px;
        color: #424941;
        font-size: 11px;
        font-weight: 700;
    }

    .service-field label span {
        color: #a3423a;
    }

    .service-field input,
    .service-field select,
    .service-field textarea {
        display: block;
        width: 100%;
        min-height: 43px;
        padding: 11px 12px;
        border: 1px solid #e5e2d9;
        border-radius: 5px;
        outline: none;
        background: #fff;
        color: #343a35;
        font-size: 12px;
        transition: border-color .2s ease, box-shadow .2s ease;
    }

    .service-field textarea {
        min-height: 130px;
        resize: vertical;
        line-height: 1.7;
    }

    .service-field input:focus,
    .service-field select:focus,
    .service-field textarea:focus {
        border-color: #b39a6b;
        box-shadow: 0 0 0 3px rgba(196,165,116,.12);
    }

    .service-field input::placeholder,
    .service-field textarea::placeholder {
        color: #a0a49d;
    }

    .service-field small {
        display: block;
        margin-top: 7px;
        color: #858a83;
        font-size: 10px;
        line-height: 1.6;
    }

    .service-field-error {
        margin: 7px 0 0;
        color: #a3423a;
        font-size: 11px;
    }

    .service-current-image {
        display: grid;
        gap: 9px;
        margin-top: 15px;
        color: #777d76;
        font-size: 10px;
    }

    .service-current-image img {
        width: 100%;
        max-width: 240px;
        max-height: 160px;
        border-radius: 6px;
        object-fit: cover;
    }

    .service-active-option {
        display: flex;
        align-items: flex-start;
        gap: 11px;
        padding: 15px;
        border: 1px solid #e9e6de;
        border-radius: 6px;
        background: #fdfcf9;
        cursor: pointer;
    }

    .service-active-option input {
        width: 16px;
        height: 16px;
        margin: 2px 0 0;
        accent-color: #20382f;
    }

    .service-active-option strong,
    .service-active-option small {
        display: block;
    }

    .service-active-option strong {
        color: #344138;
        font-size: 11px;
    }

    .service-active-option small {
        margin-top: 5px;
        color: #858a83;
        font-size: 10px;
        line-height: 1.6;
    }

    .service-form-note {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        padding: 17px;
        border: 1px solid #e7dfce;
        border-radius: 7px;
        background: #f8f5ed;
    }

    .service-note-icon {
        display: grid;
        width: 24px;
        height: 24px;
        flex-shrink: 0;
        place-items: center;
        border-radius: 50%;
        background: #e9dfc9;
        color: #6f5a37;
        font-size: 12px;
        font-weight: 700;
    }

    .service-form-note strong {
        color: #55472f;
        font-size: 11px;
    }

    .service-form-note p {
        margin: 6px 0 0;
        color: #766b57;
        font-size: 10px;
        line-height: 1.7;
    }

    .service-form-actions {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 12px;
        margin-top: 22px;
        padding: 18px 0;
    }

    .service-submit-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 14px;
        min-height: 44px;
        padding: 0 20px;
        border: 0;
        border-radius: 5px;
        background: #20382f;
        color: #fff;
        cursor: pointer;
        font-size: 11px;
        font-weight: 600;
    }

    .service-submit-btn:hover {
        background: #2d4a3e;
    }

    .service-submit-btn span {
        color: #dfc18d;
        font-size: 16px;
    }

    @media (max-width: 900px) {
        .service-form-grid {
            grid-template-columns: minmax(0, 1fr);
        }

        .service-form-side {
            grid-template-columns: repeat(2, minmax(0, 1fr));
            align-items: start;
        }

        .service-form-note {
            grid-column: 1 / -1;
        }
    }

    @media (max-width: 600px) {
        .service-form-heading {
            align-items: flex-start;
            flex-direction: column;
        }

        .service-form-side {
            grid-template-columns: minmax(0, 1fr);
        }

        .service-form-panel-heading {
            padding: 18px;
        }

        .service-form-body {
            padding: 18px;
        }

        .service-form-actions {
            justify-content: stretch;
        }

        .service-form-actions > * {
            flex: 1;
        }
    }
</style>
@endpush
