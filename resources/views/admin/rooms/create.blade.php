@extends('layouts.admin')

@section('title', 'Add Room')
@section('page-title', 'Add New Room')

@section('content')

    <div class="room-form-heading">
        <div>
            <p class="room-form-eyebrow">PROPERTY MANAGEMENT</p>
            <h2>Add a Room or Suite</h2>
            <p>Introduce a new accommodation option to the Luxora collection.</p>
        </div>

        <a href="{{ route('admin.rooms.index') }}" class="room-back-btn">
            <span>←</span> Back to Rooms
        </a>
    </div>

    <form
        action="{{ route('admin.rooms.store') }}"
        method="POST"
        class="room-form"
    >
        @csrf

        <div class="room-form-grid">

            <section class="room-form-panel">
                <div class="room-form-panel-heading">
                    <div>
                        <h3>Room Information</h3>
                        <p>Enter the room details displayed to guests.</p>
                    </div>
                    <span class="room-form-panel-icon">▤</span>
                </div>

                <div class="room-form-body">

                    <div class="room-field">
                        <label for="name">Room Name <span>*</span></label>
                        <input
                            id="name"
                            type="text"
                            name="name"
                            value="{{ old('name') }}"
                            maxlength="255"
                            placeholder="e.g. Executive Suite"
                            required
                        >
                        @error('name')
                            <p class="room-field-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="room-field">
                        <label for="slug">URL Slug</label>
                        <input
                            id="slug"
                            type="text"
                            name="slug"
                            value="{{ old('slug') }}"
                            maxlength="255"
                            placeholder="e.g. executive-suite"
                        >
                        <small>Leave blank to generate a unique slug from the room name.</small>
                        @error('slug')
                            <p class="room-field-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="room-field">
                        <label for="description">Short Description <span>*</span></label>
                        <textarea
                            id="description"
                            name="description"
                            rows="3"
                            placeholder="A short introduction to this room..."
                            required
                        >{{ old('description') }}</textarea>
                        @error('description')
                            <p class="room-field-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="room-field">
                        <label for="long_description">Full Description</label>
                        <textarea
                            id="long_description"
                            name="long_description"
                            rows="6"
                            placeholder="Describe the room, its atmosphere, amenities, and guest experience..."
                        >{{ old('long_description') }}</textarea>
                        <small>This can be used on the room's public detail page.</small>
                        @error('long_description')
                            <p class="room-field-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="room-field">
                        <label for="image">Room Image URL</label>
                        <input
                            id="image"
                            type="url"
                            name="image"
                            value="{{ old('image') }}"
                            placeholder="https://example.com/room-image.jpg"
                        >
                        <small>Use a publicly accessible image URL.</small>
                        @error('image')
                            <p class="room-field-error">{{ $message }}</p>
                        @enderror
                    </div>

                </div>
            </section>

            <div class="room-form-side">

                <section class="room-form-panel">
                    <div class="room-form-panel-heading">
                        <div>
                            <h3>Rate & Capacity</h3>
                            <p>Set the nightly rate and guest limit.</p>
                        </div>
                        <span class="room-form-panel-icon">₦</span>
                    </div>

                    <div class="room-form-body">

                        <div class="room-field">
                            <label for="price">Price Per Night (₦) <span>*</span></label>
                            <input
                                id="price"
                                type="number"
                                name="price"
                                value="{{ old('price', '0.00') }}"
                                min="0"
                                max="9999999999.99"
                                step="0.01"
                                required
                            >
                            @error('price')
                                <p class="room-field-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="room-field">
                            <label for="capacity">Maximum Guest Capacity <span>*</span></label>
                            <input
                                id="capacity"
                                type="number"
                                name="capacity"
                                value="{{ old('capacity', 2) }}"
                                min="1"
                                max="100"
                                step="1"
                                required
                            >
                            @error('capacity')
                                <p class="room-field-error">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>
                </section>

                <section class="room-form-panel">
                    <div class="room-form-panel-heading">
                        <div>
                            <h3>Room Features</h3>
                            <p>Add amenities and room highlights.</p>
                        </div>
                        <span class="room-form-panel-icon">✧</span>
                    </div>

                    <div class="room-form-body">
                        <div class="room-field">
                            <label for="features">Features & Amenities</label>
                            <textarea
                                id="features"
                                name="features"
                                rows="6"
                                placeholder="King-size bed&#10;City view&#10;Free Wi-Fi&#10;Luxury bathroom"
                            >{{ old('features') }}</textarea>
                            <small>Enter one feature per line. Each feature will be saved separately.</small>
                            @error('features')
                                <p class="room-field-error">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </section>

                <section class="room-form-panel">
                    <div class="room-form-panel-heading">
                        <div>
                            <h3>Publishing</h3>
                            <p>Control public visibility.</p>
                        </div>
                        <span class="room-form-panel-icon">⚙</span>
                    </div>

                    <div class="room-form-body">
                        <label class="room-active-option" for="is_active">
                            <input
                                id="is_active"
                                type="checkbox"
                                name="is_active"
                                value="1"
                                @checked(old('is_active', '1') === '1' || old('is_active') === 1)
                            >

                            <span>
                                <strong>Publish this room</strong>
                                <small>Allow this room to appear in the public room catalogue.</small>
                            </span>
                        </label>

                        @error('is_active')
                            <p class="room-field-error">{{ $message }}</p>
                        @enderror
                    </div>
                </section>

                <section class="room-form-note">
                    <span class="room-note-icon">i</span>
                    <div>
                        <strong>Before saving</strong>
                        <p>Review the nightly price, capacity, description, and image URL. Room capacity is used when filtering rooms for guest searches.</p>
                    </div>
                </section>

            </div>
        </div>

        <div class="room-form-actions">
            <a href="{{ route('admin.rooms.index') }}" class="room-cancel-btn">
                Cancel
            </a>

            <button type="submit" class="room-submit-btn">
                Save Room <span>→</span>
            </button>
        </div>

    </form>

@endsection

@push('styles')
<style>
    .room-form-heading {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        margin-bottom: 25px;
    }

    .room-form-eyebrow {
        margin: 0 0 8px;
        color: #9b8053;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 1.6px;
    }

    .room-form-heading h2 {
        margin: 0;
        color: #20382f;
        font-family: 'Playfair Display', serif;
        font-size: clamp(24px, 3vw, 31px);
        font-weight: 600;
    }

    .room-form-heading p:not(.room-form-eyebrow) {
        margin: 8px 0 0;
        color: #777d76;
        font-size: 12px;
        line-height: 1.7;
    }

    .room-back-btn,
    .room-cancel-btn {
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

    .room-back-btn:hover,
    .room-cancel-btn:hover {
        border-color: #c4a574;
    }

    .room-back-btn span {
        font-size: 16px;
    }

    .room-form-grid {
        display: grid;
        grid-template-columns: minmax(0, 1.5fr) minmax(290px, .85fr);
        align-items: start;
        gap: 20px;
    }

    .room-form-side {
        display: grid;
        gap: 20px;
    }

    .room-form-panel {
        overflow: hidden;
        border: 1px solid #e9e6de;
        border-radius: 8px;
        background: #fff;
    }

    .room-form-panel-heading {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
        padding: 21px 23px;
        border-bottom: 1px solid #efede7;
    }

    .room-form-panel-heading h3 {
        margin: 0;
        color: #20382f;
        font-family: 'Playfair Display', serif;
        font-size: 19px;
        font-weight: 600;
    }

    .room-form-panel-heading p {
        margin: 6px 0 0;
        color: #858a83;
        font-size: 10px;
    }

    .room-form-panel-icon {
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

    .room-form-body {
        display: grid;
        gap: 20px;
        padding: 23px;
    }

    .room-field label {
        display: block;
        margin-bottom: 8px;
        color: #424941;
        font-size: 11px;
        font-weight: 700;
    }

    .room-field label span {
        color: #a3423a;
    }

    .room-field input,
    .room-field textarea {
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

    .room-field textarea {
        min-height: 100px;
        resize: vertical;
        line-height: 1.7;
    }

    .room-field input:focus,
    .room-field textarea:focus {
        border-color: #b39a6b;
        box-shadow: 0 0 0 3px rgba(196,165,116,.12);
    }

    .room-field input::placeholder,
    .room-field textarea::placeholder {
        color: #a0a49d;
    }

    .room-field small {
        display: block;
        margin-top: 7px;
        color: #858a83;
        font-size: 10px;
        line-height: 1.6;
    }

    .room-field-error {
        margin: 7px 0 0;
        color: #a3423a;
        font-size: 11px;
    }

    .room-active-option {
        display: flex;
        align-items: flex-start;
        gap: 11px;
        padding: 15px;
        border: 1px solid #e9e6de;
        border-radius: 6px;
        background: #fdfcf9;
        cursor: pointer;
    }

    .room-active-option input {
        width: 16px;
        height: 16px;
        margin: 2px 0 0;
        accent-color: #20382f;
    }

    .room-active-option strong,
    .room-active-option small {
        display: block;
    }

    .room-active-option strong {
        color: #344138;
        font-size: 11px;
    }

    .room-active-option small {
        margin-top: 5px;
        color: #858a83;
        font-size: 10px;
        line-height: 1.6;
    }

    .room-form-note {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        padding: 17px;
        border: 1px solid #e7dfce;
        border-radius: 7px;
        background: #f8f5ed;
    }

    .room-note-icon {
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

    .room-form-note strong {
        color: #55472f;
        font-size: 11px;
    }

    .room-form-note p {
        margin: 6px 0 0;
        color: #766b57;
        font-size: 10px;
        line-height: 1.7;
    }

    .room-form-actions {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 12px;
        margin-top: 22px;
        padding: 18px 0;
    }

    .room-submit-btn {
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

    .room-submit-btn:hover {
        background: #2d4a3e;
    }

    .room-submit-btn span {
        color: #dfc18d;
        font-size: 16px;
    }

    @media (max-width: 900px) {
        .room-form-grid {
            grid-template-columns: minmax(0, 1fr);
        }
    }

    @media (max-width: 600px) {
        .room-form-heading {
            align-items: flex-start;
            flex-direction: column;
        }

        .room-form-panel-heading {
            padding: 18px;
        }

        .room-form-body {
            padding: 18px;
        }

        .room-form-actions {
            justify-content: stretch;
        }

        .room-form-actions > * {
            flex: 1;
        }
    }
</style>
@endpush
