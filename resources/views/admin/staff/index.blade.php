@extends('layouts.admin')

@section('page-title', 'Staff Management')

@section('content')
<div class="staff-page">

    <div class="staff-heading">
        <div>
            <span class="staff-eyebrow">PEOPLE & OPERATIONS</span>
            <h1>Staff Management</h1>
            <p>Manage your team, departments and employment records in one place.</p>
        </div>

        <a href="{{ route('admin.staff.create') }}" class="staff-primary-button">
            <span aria-hidden="true">+</span> Add Staff Member
        </a>
    </div>

    <div class="staff-stats">
        <article class="staff-stat-card">
            <div class="staff-stat-top">
                <span>Total Staff</span>
                <span class="staff-stat-icon">♙</span>
            </div>
            <strong>{{ number_format($stats['total']) }}</strong>
            <small>All employee records</small>
        </article>

        <article class="staff-stat-card">
            <div class="staff-stat-top">
                <span>Active Staff</span>
                <span class="staff-stat-icon staff-icon-active">✓</span>
            </div>
            <strong>{{ number_format($stats['active']) }}</strong>
            <small>Currently marked active</small>
        </article>

        <article class="staff-stat-card">
            <div class="staff-stat-top">
                <span>Inactive Staff</span>
                <span class="staff-stat-icon staff-icon-inactive">−</span>
            </div>
            <strong>{{ number_format($stats['inactive']) }}</strong>
            <small>Currently marked inactive</small>
        </article>

        <article class="staff-stat-card">
            <div class="staff-stat-top">
                <span>Departments</span>
                <span class="staff-stat-icon">▤</span>
            </div>
            <strong>{{ number_format($stats['departments']) }}</strong>
            <small>Departments represented</small>
        </article>
    </div>

    <section class="staff-directory">
        <div class="staff-directory-heading">
            <div>
                <h2>Team Directory</h2>
                <p>Employee information and employment status.</p>
            </div>

            <span class="staff-record-count">
                {{ $staff->total() }} records
            </span>
        </div>

        <form action="{{ route('admin.staff.index') }}"
              method="GET"
              class="staff-filters">

            <div class="staff-search">
                <span aria-hidden="true">⌕</span>
                <input
                    type="search"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Search name, ID, email or position..."
                    aria-label="Search staff"
                >
            </div>

            <select name="department" aria-label="Filter by department">
                <option value="">All Departments</option>
                @foreach ($departments as $department)
                    <option
                        value="{{ $department }}"
                        @selected(request('department') === $department)
                    >
                        {{ $department }}
                    </option>
                @endforeach
            </select>

            <select name="status" aria-label="Filter by employment status">
                <option value="">All Statuses</option>
                <option value="active" @selected(request('status') === 'active')>
                    Active
                </option>
                <option value="inactive" @selected(request('status') === 'inactive')>
                    Inactive
                </option>
            </select>

            <button type="submit" class="staff-filter-button">
                Apply Filters
            </button>

            @if (request()->hasAny(['search', 'department', 'status']))
                <a href="{{ route('admin.staff.index') }}" class="staff-reset">
                    Reset
                </a>
            @endif
        </form>

        <div class="staff-table-wrap">
            <table class="staff-table">
                <thead>
                    <tr>
                        <th>STAFF MEMBER</th>
                        <th>DEPARTMENT & POSITION</th>
                        <th>CONTACT</th>
                        <th>EMPLOYMENT</th>
                        <th>STATUS</th>
                        <th>ACTIONS</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($staff as $member)
                        <tr>
                            <td>
                                <div class="staff-identity">
                                    <span class="staff-avatar">
                                        {{ strtoupper(substr($member->first_name, 0, 1) . substr($member->last_name, 0, 1)) }}
                                    </span>

                                    <div>
                                        <strong>{{ $member->full_name }}</strong>
                                        <small>{{ $member->staff_number }}</small>
                                    </div>
                                </div>
                            </td>

                            <td>
                                <div class="staff-role">
                                    <strong>{{ $member->position }}</strong>
                                    <small>{{ $member->department }}</small>
                                </div>
                            </td>

                            <td>
                                <div class="staff-contact">
                                    <span>{{ $member->email }}</span>
                                    <small>{{ $member->phone ?: 'No phone provided' }}</small>
                                </div>
                            </td>

                            <td>
                                <span class="staff-employment-type">
                                    {{ ucfirst(str_replace('_', ' ', $member->employment_type)) }}
                                </span>
                                <small class="staff-hire-date">
                                    Joined
                                    {{ $member->hire_date ? $member->hire_date->format('d M Y') : '—' }}
                                </small>
                            </td>

                            <td>
                                <span class="staff-status {{ $member->status === 'active' ? 'status-active' : 'status-inactive' }}">
                                    <span></span>
                                    {{ ucfirst($member->status) }}
                                </span>
                            </td>

                            <td>
                                <div class="staff-actions">
                                    <a
                                        href="{{ route('admin.staff.edit', $member) }}"
                                        class="staff-action-edit"
                                        aria-label="Edit {{ $member->full_name }}"
                                    >
                                        Edit
                                    </a>

                                    <form
                                        action="{{ route('admin.staff.toggle-status', $member) }}"
                                        method="POST"
                                        onsubmit="return confirm('Change the employment status for this staff member?')"
                                    >
                                        @csrf
                                        @method('PATCH')

                                        <button
                                            type="submit"
                                            class="staff-action-status"
                                        >
                                            {{ $member->status === 'active' ? 'Deactivate' : 'Activate' }}
                                        </button>
                                    </form>

                                    <form
                                        action="{{ route('admin.staff.destroy', $member) }}"
                                        method="POST"
                                        onsubmit="return confirm('Permanently delete this staff record? This action cannot be undone.')"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="staff-action-delete">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">
                                <div class="staff-empty">
                                    <span class="staff-empty-icon">♙</span>
                                    <h3>No staff records found</h3>
                                    <p>
                                        @if (request()->hasAny(['search', 'department', 'status']))
                                            Try changing your search or filters.
                                        @else
                                            Add your first employee to start building the team directory.
                                        @endif
                                    </p>

                                    @if (request()->hasAny(['search', 'department', 'status']))
                                        <a href="{{ route('admin.staff.index') }}">Clear filters</a>
                                    @else
                                        <a href="{{ route('admin.staff.create') }}">Add your first staff member</a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($staff->hasPages())
            <div class="staff-pagination">
                {{ $staff->links() }}
            </div>
        @endif
    </section>

    <div class="staff-note">
        <span aria-hidden="true">◇</span>
        <p>
            <strong>Staff data protection.</strong>
            Employment records and salary information should only be accessible to
            authorised administrators.
        </p>
    </div>

</div>
@endsection

@push('styles')
<style>
.staff-page {
    max-width: 1500px;
    margin: 0 auto;
    color: #28382f;
}

.staff-heading {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
    margin-bottom: 28px;
}

.staff-eyebrow {
    color: #a18450;
    font-size: 10px;
    font-weight: 800;
    letter-spacing: 2.1px;
}

.staff-heading h1 {
    margin: 8px 0;
    font-family: 'Playfair Display', Georgia, serif;
    font-size: clamp(29px, 4vw, 38px);
    font-weight: 500;
}

.staff-heading p,
.staff-directory-heading p {
    margin: 0;
    color: #858980;
    font-size: 12px;
    line-height: 1.7;
}

.staff-primary-button {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    min-height: 44px;
    padding: 0 17px;
    border-radius: 4px;
    background: #263e32;
    color: #fff;
    font-size: 12px;
    font-weight: 700;
    text-decoration: none;
    white-space: nowrap;
}

.staff-primary-button:hover {
    background: #395844;
}

.staff-primary-button > span {
    font-size: 20px;
    font-weight: 400;
}

.staff-stats {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 16px;
    margin-bottom: 25px;
}

.staff-stat-card {
    padding: 21px;
    border: 1px solid #e8e6de;
    border-radius: 7px;
    background: #fff;
}

.staff-stat-top {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
    color: #747b72;
    font-size: 11px;
    font-weight: 650;
}

.staff-stat-icon {
    display: grid;
    place-items: center;
    width: 34px;
    height: 34px;
    border-radius: 5px;
    background: #edf0e9;
    color: #49634f;
    font-size: 19px;
}

.staff-icon-active {
    background: #e8f1e8;
    color: #47764d;
}

.staff-icon-inactive {
    background: #f3eee1;
    color: #927543;
}

.staff-stat-card > strong {
    display: block;
    margin: 15px 0 5px;
    color: #263b30;
    font-family: 'Playfair Display', Georgia, serif;
    font-size: 30px;
    font-weight: 500;
}

.staff-stat-card > small {
    color: #92958b;
    font-size: 10px;
}

.staff-directory {
    overflow: hidden;
    border: 1px solid #e8e6de;
    border-radius: 7px;
    background: #fff;
}

.staff-directory-heading {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 15px;
    padding: 23px 24px;
    border-bottom: 1px solid #eeece5;
}

.staff-directory-heading h2 {
    margin: 0 0 6px;
    font-family: 'Playfair Display', Georgia, serif;
    font-size: 22px;
    font-weight: 500;
}

.staff-record-count {
    padding: 7px 10px;
    border-radius: 4px;
    background: #f2f1eb;
    color: #56664f;
    font-size: 10px;
    font-weight: 750;
    white-space: nowrap;
}

.staff-filters {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 10px;
    padding: 17px 24px;
    border-bottom: 1px solid #eeece5;
}

.staff-search {
    display: flex;
    flex: 1 1 230px;
    align-items: center;
    gap: 10px;
    min-height: 41px;
    padding: 0 12px;
    border: 1px solid #e2e1d8;
    border-radius: 4px;
    background: #fdfdfb;
}

.staff-search > span {
    color: #8b947f;
    font-size: 22px;
}

.staff-search input {
    width: 100%;
    min-width: 0;
    border: 0;
    outline: none;
    background: transparent;
    color: #28382f;
    font-size: 11px;
}

.staff-filters select {
    min-height: 41px;
    max-width: 190px;
    padding: 0 10px;
    border: 1px solid #e2e1d8;
    border-radius: 4px;
    background: #fff;
    color: #455348;
    font-size: 11px;
}

.staff-filter-button {
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

.staff-filter-button:hover {
    background: #395844;
}

.staff-reset {
    color: #687267;
    font-size: 11px;
    text-decoration: none;
}

.staff-table-wrap {
    width: 100%;
    overflow-x: auto;
}

.staff-table {
    width: 100%;
    border-collapse: collapse;
    text-align: left;
}

.staff-table thead {
    background: #faf9f6;
}

.staff-table th {
    padding: 14px 16px;
    color: #85877e;
    font-size: 9px;
    font-weight: 800;
    letter-spacing: .8px;
    white-space: nowrap;
}

.staff-table td {
    padding: 16px;
    border-top: 1px solid #f0eee8;
    font-size: 11px;
    vertical-align: middle;
}

.staff-table tbody tr:hover {
    background: #fdfcf9;
}

.staff-identity {
    display: flex;
    align-items: center;
    gap: 10px;
    min-width: 175px;
}

.staff-avatar {
    display: grid;
    place-items: center;
    flex-shrink: 0;
    width: 38px;
    height: 38px;
    border: 1px solid #e1e5d9;
    border-radius: 50%;
    background: #edf1e8;
    color: #405b46;
    font-family: 'Playfair Display', Georgia, serif;
    font-size: 12px;
}

.staff-identity strong,
.staff-role strong {
    display: block;
    color: #344238;
    font-size: 11px;
    font-weight: 750;
}

.staff-identity small,
.staff-role small,
.staff-contact small,
.staff-hire-date {
    display: block;
    margin-top: 5px;
    color: #92958b;
    font-size: 10px;
}

.staff-role {
    min-width: 130px;
}

.staff-contact {
    min-width: 155px;
    color: #566157;
    overflow-wrap: anywhere;
}

.staff-employment-type {
    display: inline-block;
    padding: 6px 8px;
    border-radius: 3px;
    background: #f3f2ed;
    color: #626d5f;
    font-size: 10px;
    white-space: nowrap;
}

.staff-hire-date {
    white-space: nowrap;
}

.staff-status {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 8px;
    border-radius: 3px;
    font-size: 10px;
    font-weight: 750;
}

.staff-status > span {
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: currentColor;
}

.status-active {
    background: #e8f1e8;
    color: #3f7046;
}

.status-inactive {
    background: #f3eee1;
    color: #927543;
}

.staff-actions {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 9px;
    min-width: 145px;
}

.staff-actions a,
.staff-actions button {
    padding: 0;
    border: 0;
    background: none;
    font: inherit;
    font-size: 10px;
    font-weight: 750;
    text-decoration: none;
    cursor: pointer;
}

.staff-action-edit {
    color: #3e6248;
}

.staff-action-status {
    color: #8a7546;
}

.staff-action-delete {
    color: #a64e45;
}

.staff-empty {
    padding: 50px 20px;
    text-align: center;
}

.staff-empty-icon {
    display: inline-grid;
    place-items: center;
    width: 52px;
    height: 52px;
    border-radius: 50%;
    background: #f0f1e9;
    color: #68785f;
    font-size: 25px;
}

.staff-empty h3 {
    margin: 15px 0 8px;
    font-family: 'Playfair Display', Georgia, serif;
    font-size: 22px;
    font-weight: 500;
}

.staff-empty p {
    margin: 0 0 15px;
    color: #8a8e85;
    font-size: 12px;
}

.staff-empty a {
    color: #49664f;
    font-size: 12px;
    font-weight: 750;
}

.staff-pagination {
    padding: 20px 24px;
    border-top: 1px solid #eeece5;
}

.staff-note {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    margin-top: 20px;
    padding: 16px 19px;
    border: 1px solid #e9e6dc;
    border-radius: 5px;
    background: #f8f7f1;
}

.staff-note > span {
    color: #9b8050;
    font-size: 20px;
}

.staff-note p {
    margin: 0;
    color: #777e73;
    font-size: 11px;
    line-height: 1.8;
}

.staff-note strong {
    color: #3d4d40;
}

@media (max-width: 1150px) {
    .staff-stats {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }
}

@media (max-width: 700px) {
    .staff-heading {
        align-items: flex-start;
        flex-direction: column;
    }

    .staff-stats {
        gap: 10px;
    }

    .staff-stat-card {
        padding: 16px;
    }

    .staff-directory-heading {
        align-items: flex-start;
        flex-direction: column;
        padding: 19px;
    }

    .staff-filters {
        padding: 15px;
    }

    .staff-search {
        flex-basis: 100%;
    }

    .staff-filters select {
        flex: 1;
        max-width: none;
    }

    .staff-filter-button {
        flex: 1;
    }

    .staff-table th,
    .staff-table td {
        padding: 13px;
    }
}
</style>
@endpush
