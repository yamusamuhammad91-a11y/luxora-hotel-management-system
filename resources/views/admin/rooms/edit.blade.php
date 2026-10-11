@extends('layouts.admin')

@section('page-title', 'Edit Room')

@section('content')
<div class="room-edit-page">
    <div class="room-edit-heading">
        <div>
            <span class="room-edit-eyebrow">ROOM MANAGEMENT</span>
            <h1>Edit Room</h1>
            <p>Update the details, pricing and availability of {{ $room->name }}.</p>
        </div>

        <a href="{{ route('admin.rooms.index') }}" class="room-edit-back">
            <span aria-hidden="true">&larr;</span> Back to Rooms
        </a>
    </div>

    @if ($errors->any())
        <div class="room-edit-errors">
            <strong>Please correct the following errors:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.rooms.update', $room) }}"
          method="POST"
          class="room-edit-form">
        @csrf
        @method('PUT')

        <div class="room-edit-grid">
            <section class="room-edit-card">
                <div class="room-edit-card-heading">
                    <span class="room-edit-number">01</span>
                    <div>
                        <h2>Room Information</h2>
                        <p>Basic details displayed to guests.</p>
                    </div>
                </div>

                <div class="room-edit-field">
                    <label for="name">Room Name <span>*</span></label>
                    <input
                        id="name"
                        name="name"
                        type="text"
                        value="{{ old('name', $room->name) }}"
                        placeholder="e.g. Executive Suite"
                        required
                    >
                </div>

                <div class="room-edit-field">
                    <label for="slug">URL Slug</label>
                    <input
                        id="slug"
                        name="slug"
                        type="text"
                        value="{{ old('slug', $room->slug) }}"
                        placeholder="executive-suite"
                    >
                    <small>Leave blank to generate a slug from the room name.</small>
                </div>

                <div class="room-edit-field">
                    <label for="description">Short Description <span>*</span></label>
                    <textarea
                        id="description"
                        name="description"
                        rows="3"
                        required
                        placeholder="A brief introduction to this room..."
                    >{{ old('description', $room->description) }}</textarea>
                </div>

                <div class="room-edit-field">
                    <label for="long_description">Full Description</label>
                    <textarea
                        id="long_description"
                        name="long_description"
                        rows="5"
                        placeholder="Describe the room, its atmosphere and amenities..."
                    >{{ old('long_description', $room->long_description) }}</textarea>
                </div>
            </section>

            <section class="room-edit-card">
                <div class="room-edit-card-heading">
                    <span class="room-edit-number">02</span>
                    <div>
                        <h2>Pricing & Capacity</h2>
                        <p>Set the room rate and guest limit.</p>
                    </div>
                </div>

                <div class="room-edit-field">
                    <label for="price">Price Per Night (₦) <span>*</span></label>
                    <input
                        id="price"
                        name="price"
                        type="number"
                        min="0"
                        step="0.01"
                        value="{{ old('price', $room->price) }}"
                        placeholder="75000"
                        required
                    >
                </div>

                <div class="room-edit-field">
                    <label for="capacity">Maximum Guests <span>*</span></label>
                    <input
                        id="capacity"
                        name="capacity"
                        type="number"
                        min="1"
                        max="50"
                        value="{{ old('capacity', $room->capacity) }}"
                        required
                    >
                </div>

                <div class="room-edit-field">
                    <label for="features">Room Features</label>
                    <textarea
                        id="features"
                        name="features"
                        rows="5"
                        placeholder="King-size bed&#10;City view&#10;Free Wi-Fi"
                    >{{ old('features', implode("\n", $room->features ?? [])) }}</textarea>
                    <small>Enter one feature per line.</small>
                </div>
            </section>

            <section class="room-edit-card room-edit-card-wide">
                <div class="room-edit-card-heading">
                    <span class="room-edit-number">03</span>
                    <div>
                        <h2>Room Image & Visibility</h2>
                        <p>Choose the image guests will see and control room visibility.</p>
                    </div>
                </div>

                @if ($room->image)
                    <div class="room-edit-current-image">
                        <img
                            src="{{ $room->image }}"
                            alt="{{ $room->name }}"
                            onerror="this.style.display='none'"
                        >
                        <div>
                            <strong>Current room image</strong>
                            <small>Enter a new image URL below to replace it.</small>
                        </div>
                    </div>
                @endif

                <div class="room-edit-field">
                    <label for="image">Image URL</label>
                    <input
                        id="image"
                        name="image"
                        type="url"
                        value="{{ old('image', $room->image) }}"
                        placeholder="https://example.com/room-image.jpg"
                    >
                    <small>Use a publicly accessible image URL. Leave unchanged to keep the current image.</small>
                </div>

                <label class="room-edit-toggle">
                    <input
                        type="checkbox"
                        name="is_active"
                        value="1"
                        @checked((bool) old('is_active', $room->is_active))
                    >
                    <span class="room-edit-toggle-track"></span>
                    <span class="room-edit-toggle-copy">
                        <strong>Room is active</strong>
                        <small>Active rooms can appear on the public website.</small>
                    </span>
                </label>
            </section>
        </div>

        <div class="room-edit-actions">
            <a href="{{ route('admin.rooms.index') }}" class="room-edit-cancel">
                Cancel
            </a>
            <button type="submit" class="room-edit-submit">
                Save Room Changes <span aria-hidden="true">&rarr;</span>
            </button>
        </div>
    </form>
</div>
@endsection

@push('styles')
<style>
.room-edit-page {
    max-width: 1180px;
    margin: 0 auto;
    color: #26372f;
}
.room-edit-heading {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
    margin-bottom: 30px;
}
.room-edit-eyebrow {
    color: #a18450;
    font-size: 10px;
    font-weight: 800;
    letter-spacing: 2.2px;
}
.room-edit-heading h1 {
    margin: 8px 0;
    font-family: 'Playfair Display', Georgia, serif;
    font-size: clamp(28px, 4vw, 38px);
    font-weight: 500;
}
.room-edit-heading p,
.room-edit-card-heading p {
    margin: 0;
    color: #81877f;
    font-size: 13px;
}
.room-edit-back,
.room-edit-cancel {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    min-height: 42px;
    padding: 0 15px;
    border: 1px solid #e4e4dc;
    border-radius: 5px;
    color: #35473d;
    text-decoration: none;
    font-size: 12px;
    font-weight: 700;
    white-space: nowrap;
}
.room-edit-back:hover,
.room-edit-cancel:hover {
    background: #f0eee7;
}
.room-edit-errors {
    margin-bottom: 22px;
    padding: 16px 20px;
    border: 1px solid #e8b9b4;
    border-radius: 6px;
    background: #fff5f4;
    color: #8b3029;
    font-size: 13px;
}
.room-edit-errors ul {
    margin: 8px 0 0;
    padding-left: 20px;
}
.room-edit-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 20px;
}
.room-edit-card {
    min-width: 0;
    padding: 25px;
    border: 1px solid #e8e6de;
    border-radius: 7px;
    background: #fff;
}
.room-edit-card-wide {
    grid-column: 1 / -1;
}
.room-edit-card-heading {
    display: flex;
    align-items: flex-start;
    gap: 13px;
    margin-bottom: 25px;
}
.room-edit-number {
    display: grid;
    place-items: center;
    flex-shrink: 0;
    width: 34px;
    height: 34px;
    border-radius: 50%;
    background: #edf0e9;
    color: #536b58;
    font-size: 11px;
    font-weight: 800;
}
.room-edit-card-heading h2 {
    margin: 3px 0 6px;
    font-family: 'Playfair Display', Georgia, serif;
    font-size: 21px;
    font-weight: 500;
}
.room-edit-field {
    margin-bottom: 19px;
}
.room-edit-field:last-child {
    margin-bottom: 0;
}
.room-edit-field label {
    display: block;
    margin-bottom: 8px;
    color: #37453c;
    font-size: 12px;
    font-weight: 750;
}
.room-edit-field label span {
    color: #a18450;
}
.room-edit-field input,
.room-edit-field textarea {
    display: block;
    box-sizing: border-box;
    width: 100%;
    padding: 12px 13px;
    border: 1px solid #dfdfd6;
    border-radius: 4px;
    outline: none;
    background: #fdfdfb;
    color: #29372f;
    font: inherit;
    font-size: 13px;
}
.room-edit-field textarea {
    resize: vertical;
    line-height: 1.7;
}
.room-edit-field input:focus,
.room-edit-field textarea:focus {
    border-color: #8a9b84;
    box-shadow: 0 0 0 3px rgba(80, 111, 83, .09);
}
.room-edit-field small,
.room-edit-toggle-copy small {
    display: block;
    margin-top: 7px;
    color: #8a8e85;
    font-size: 11px;
    line-height: 1.6;
}
.room-edit-current-image {
    display: flex;
    align-items: center;
    gap: 15px;
    margin-bottom: 20px;
    padding: 12px;
    border: 1px solid #eceae3;
    border-radius: 5px;
    background: #fbfaf7;
}
.room-edit-current-image img {
    width: 110px;
    height: 75px;
    border-radius: 4px;
    object-fit: cover;
}
.room-edit-current-image strong {
    display: block;
    font-size: 13px;
}
.room-edit-current-image small {
    display: block;
    margin-top: 6px;
    color: #858980;
    font-size: 11px;
}
.room-edit-toggle {
    display: flex;
    align-items: center;
    gap: 13px;
    margin-top: 20px;
    padding: 17px;
    border: 1px solid #e6e7de;
    border-radius: 5px;
    background: #fafbf8;
    cursor: pointer;
}
.room-edit-toggle input {
    position: absolute;
    width: 1px;
    height: 1px;
    opacity: 0;
}
.room-edit-toggle-track {
    position: relative;
    width: 39px;
    height: 22px;
    flex-shrink: 0;
    border-radius: 20px;
    background: #c7c9c1;
    transition: background .2s;
}
.room-edit-toggle-track::after {
    position: absolute;
    top: 3px;
    left: 3px;
    width: 16px;
    height: 16px;
    border-radius: 50%;
    background: #fff;
    content: '';
    transition: transform .2s;
}
.room-edit-toggle input:checked + .room-edit-toggle-track {
    background: #355443;
}
.room-edit-toggle input:checked + .room-edit-toggle-track::after {
    transform: translateX(17px);
}
.room-edit-toggle-copy strong {
    display: block;
    font-size: 12px;
}
.room-edit-toggle-copy small {
    margin-top: 4px;
}
.room-edit-actions {
    display: flex;
    justify-content: flex-end;
    gap: 12px;
    margin-top: 24px;
}
.room-edit-submit {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 15px;
    min-height: 45px;
    padding: 0 20px;
    border: 0;
    border-radius: 4px;
    background: #263e32;
    color: #fff;
    font-size: 12px;
    font-weight: 750;
    cursor: pointer;
}
.room-edit-submit:hover {
    background: #365643;
}
@media (max-width: 760px) {
    .room-edit-heading {
        align-items: flex-start;
        flex-direction: column;
    }
    .room-edit-grid {
        grid-template-columns: 1fr;
    }
    .room-edit-card-wide {
        grid-column: auto;
    }
    .room-edit-card {
        padding: 19px;
    }
    .room-edit-actions {
        flex-wrap: wrap;
    }
    .room-edit-cancel,
    .room-edit-submit {
        flex: 1;
    }
}
</style>
@endpush
