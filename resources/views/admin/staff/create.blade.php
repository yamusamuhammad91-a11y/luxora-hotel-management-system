@extends('layouts.admin')

@section('page-title', 'Add Staff Member')

@section('content')
<div class="staff-form-page">
    <div class="staff-form-heading">
        <div>
            <span class="staff-form-eyebrow">PEOPLE & OPERATIONS</span>
            <h1>Add Staff Member</h1>
            <p>Create an employee record for the Luxora hotel team.</p>
        </div>

        <a href="{{ route('admin.staff.index') }}" class="staff-form-back">
            &larr; Back to Staff
        </a>
    </div>

    @if ($errors->any())
        <div class="staff-form-errors">
            <strong>Please correct the following errors:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.staff.store') }}"
          method="POST"
          class="staff-form">
        @csrf

        <section class="staff-form-card">
            <div class="staff-form-card-heading">
                <span>01</span>
                <div>
                    <h2>Personal Information</h2>
                    <p>Enter the employee's basic details and contact information.</p>
                </div>
            </div>

            <div class="staff-form-grid">
                <div class="staff-form-field">
                    <label for="first_name">First Name <b>*</b></label>
                    <input id="first_name" name="first_name" type="text"
                           value="{{ old('first_name') }}"
                           autocomplete="given-name" required>
                </div>

                <div class="staff-form-field">
                    <label for="last_name">Last Name <b>*</b></label>
                    <input id="last_name" name="last_name" type="text"
                           value="{{ old('last_name') }}"
                           autocomplete="family-name" required>
                </div>

                <div class="staff-form-field">
                    <label for="email">Email Address <b>*</b></label>
                    <input id="email" name="email" type="email"
                           value="{{ old('email') }}"
                           autocomplete="email" required>
                </div>

                <div class="staff-form-field">
                    <label for="phone">Phone Number</label>
                    <input id="phone" name="phone" type="tel"
                           value="{{ old('phone') }}"
                           autocomplete="tel">
                </div>

                <div class="staff-form-field staff-form-full">
                    <label for="address">Home Address</label>
                    <textarea id="address" name="address" rows="3"
                              autocomplete="street-address"
                              placeholder="Employee's home address">{{ old('address') }}</textarea>
                </div>
            </div>
        </section>

        <section class="staff-form-card">
            <div class="staff-form-card-heading">
                <span>02</span>
                <div>
                    <h2>Employment Details</h2>
                    <p>Assign the employee to a department and position.</p>
                </div>
            </div>

            <div class="staff-form-grid">
                <div class="staff-form-field">
                    <label for="staff_number">Staff Number <b>*</b></label>
                    <input id="staff_number" name="staff_number" type="text"
                           value="{{ old('staff_number') }}"
                           placeholder="e.g. LUX-001" required>
                    <small>Must be unique for each employee.</small>
                </div>

                <div class="staff-form-field">
                    <label for="department">Department <b>*</b></label>
                    <select id="department" name="department" required>
                        <option value="">Select department</option>
                        @foreach ([
                            'Management',
                            'Front Office',
                            'Housekeeping',
                            'Food & Beverage',
                            'Kitchen',
                            'Finance',
                            'Human Resources',
                            'Maintenance',
                            'Security',
                            'Sales & Marketing',
                            'Spa & Wellness',
                            'Information Technology',
                        ] as $department)
                            <option value="{{ $department }}"
                                @selected(old('department') === $department)>
                                {{ $department }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="staff-form-field">
                    <label for="position">Job Position <b>*</b></label>
                    <input id="position" name="position" type="text"
                           value="{{ old('position') }}"
                           placeholder="e.g. Front Desk Manager" required>
                </div>

                <div class="staff-form-field">
                    <label for="hire_date">Hire Date</label>
                    <input id="hire_date" name="hire_date" type="date"
                           value="{{ old('hire_date') }}">
                </div>

                <div class="staff-form-field">
                    <label for="employment_type">Employment Type <b>*</b></label>
                    <select id="employment_type" name="employment_type" required>
                        <option value="full_time"
                            @selected(old('employment_type', 'full_time') === 'full_time')>
                            Full-time
                        </option>
                        <option value="part_time"
                            @selected(old('employment_type') === 'part_time')>
                            Part-time
                        </option>
                        <option value="contract"
                            @selected(old('employment_type') === 'contract')>
                            Contract
                        </option>
                    </select>
                </div>

                <div class="staff-form-field">
                    <label for="status">Employment Status <b>*</b></label>
                    <select id="status" name="status" required>
                        <option value="active"
                            @selected(old('status', 'active') === 'active')>
                            Active
                        </option>
                        <option value="inactive"
                            @selected(old('status') === 'inactive')>
                            Inactive
                        </option>
                    </select>
                </div>
            </div>
        </section>

        <section class="staff-form-card">
            <div class="staff-form-card-heading">
                <span>03</span>
                <div>
                    <h2>Compensation & Notes</h2>
                    <p>Optional payroll information and internal staff notes.</p>
                </div>
            </div>

            <div class="staff-form-grid">
                <div class="staff-form-field">
                    <label for="salary">Salary (₦)</label>
                    <input id="salary" name="salary" type="number"
                           min="0" max="9999999999.99" step="0.01"
                           value="{{ old('salary') }}"
                           placeholder="Enter salary">
                    <small>Optional. Restrict access to compensation data.</small>
                </div>

                <div class="staff-form-field staff-form-full">
                    <label for="notes">Internal Notes</label>
                    <textarea id="notes" name="notes" rows="4"
                              placeholder="Additional employment notes...">{{ old('notes') }}</textarea>
                </div>
            </div>
        </section>

        <div class="staff-form-actions">
            <a href="{{ route('admin.staff.index') }}" class="staff-form-cancel">
                Cancel
            </a>

            <button type="submit" class="staff-form-submit">
                Save Staff Member <span aria-hidden="true">&rarr;</span>
            </button>
        </div>
    </form>
</div>
@endsection

@push('styles')
<style>
.staff-form-page {
    max-width: 1100px;
    margin: 0 auto;
    color: #28382f;
}
.staff-form-heading {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
    margin-bottom: 28px;
}
.staff-form-eyebrow {
    color: #a18450;
    font-size: 10px;
    font-weight: 800;
    letter-spacing: 2px;
}
.staff-form-heading h1 {
    margin: 8px 0;
    font-family: 'Playfair Display', Georgia, serif;
    font-size: clamp(28px, 4vw, 37px);
    font-weight: 500;
}
.staff-form-heading p {
    margin: 0;
    color: #858980;
    font-size: 12px;
    line-height: 1.7;
}
.staff-form-back,
.staff-form-cancel {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-height: 42px;
    padding: 0 15px;
    border: 1px solid #e4e4dc;
    border-radius: 4px;
    color: #35473d;
    font-size: 12px;
    font-weight: 700;
    text-decoration: none;
    white-space: nowrap;
}
.staff-form-back:hover,
.staff-form-cancel:hover {
    background: #f0eee7;
}
.staff-form-errors {
    margin-bottom: 20px;
    padding: 16px 20px;
    border: 1px solid #e8b9b4;
    border-radius: 5px;
    background: #fff5f4;
    color: #8b3029;
    font-size: 12px;
}
.staff-form-errors ul {
    margin: 8px 0 0;
    padding-left: 20px;
}
.staff-form-card {
    margin-bottom: 20px;
    padding: 25px;
    border: 1px solid #e8e6de;
    border-radius: 7px;
    background: #fff;
}
.staff-form-card-heading {
    display: flex;
    align-items: flex-start;
    gap: 13px;
    margin-bottom: 25px;
}
.staff-form-card-heading > span {
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
.staff-form-card-heading h2 {
    margin: 3px 0 6px;
    font-family: 'Playfair Display', Georgia, serif;
    font-size: 21px;
    font-weight: 500;
}
.staff-form-card-heading p {
    margin: 0;
    color: #858980;
    font-size: 11px;
    line-height: 1.7;
}
.staff-form-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 20px;
}
.staff-form-field {
    min-width: 0;
}
.staff-form-full {
    grid-column: 1 / -1;
}
.staff-form-field label {
    display: block;
    margin-bottom: 8px;
    color: #37453c;
    font-size: 12px;
    font-weight: 750;
}
.staff-form-field label b {
    color: #a18450;
}
.staff-form-field input,
.staff-form-field select,
.staff-form-field textarea {
    box-sizing: border-box;
    display: block;
    width: 100%;
    min-height: 43px;
    padding: 11px 12px;
    border: 1px solid #dfdfd6;
    border-radius: 4px;
    outline: none;
    background: #fdfdfb;
    color: #29372f;
    font: inherit;
    font-size: 12px;
}
.staff-form-field textarea {
    resize: vertical;
    line-height: 1.7;
}
.staff-form-field input:focus,
.staff-form-field select:focus,
.staff-form-field textarea:focus {
    border-color: #8a9b84;
    box-shadow: 0 0 0 3px rgba(80, 111, 83, .09);
}
.staff-form-field small {
    display: block;
    margin-top: 7px;
    color: #8a8e85;
    font-size: 10px;
    line-height: 1.6;
}
.staff-form-actions {
    display: flex;
    justify-content: flex-end;
    gap: 12px;
    margin-top: 25px;
}
.staff-form-submit {
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
.staff-form-submit:hover {
    background: #395844;
}
@media (max-width: 650px) {
    .staff-form-heading {
        align-items: flex-start;
        flex-direction: column;
    }
    .staff-form-card {
        padding: 19px;
    }
    .staff-form-grid {
        grid-template-columns: 1fr;
        gap: 17px;
    }
    .staff-form-full {
        grid-column: auto;
    }
    .staff-form-actions {
        flex-wrap: wrap;
    }
    .staff-form-cancel,
    .staff-form-submit {
        flex: 1;
    }
}
</style>
@endpush
