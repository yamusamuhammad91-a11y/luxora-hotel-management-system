<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\AvailabilityController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\GuestPortalController;
use App\Http\Controllers\GuestProfileController;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\RoomController as AdminRoomController;
use App\Http\Controllers\Admin\GuestController;
use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\Admin\ServiceController as AdminServiceController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\ReportController;

/*
|--------------------------------------------------------------------------
| Public Website
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])
    ->name('home');

Route::get('/rooms', [RoomController::class, 'index'])
    ->name('rooms.index');

Route::get('/rooms/{slug}', [RoomController::class, 'show'])
    ->name('rooms.show');

Route::get('/availability', [AvailabilityController::class, 'index'])
    ->name('availability');

Route::get('/services', [ServiceController::class, 'index'])
    ->name('services.index');

/*
|--------------------------------------------------------------------------
| Public Booking
|--------------------------------------------------------------------------
*/

Route::get('/booking/{slug}', [BookingController::class, 'create'])
    ->name('booking.create');

Route::post('/booking', [BookingController::class, 'store'])
    ->name('booking.store');

Route::get('/booking/confirmation/{reference}', [
    BookingController::class,
    'confirmation',
])->name('booking.confirmation');

/*
|--------------------------------------------------------------------------
| Guest Authentication
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'create'])
        ->name('login');

    Route::post('/login', [LoginController::class, 'store'])
        ->name('login.store');

    Route::get('/register', [RegisterController::class, 'create'])
        ->name('register');

    Route::post('/register', [RegisterController::class, 'store'])
        ->name('register.store');
});

Route::post('/logout', [LoginController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| Authenticated Guest Portal
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::get('/my-account', [GuestPortalController::class, 'index'])
        ->name('guest.dashboard');

    Route::get('/my-account/bookings/{booking}', [
        GuestPortalController::class,
        'show',
    ])->name('guest.bookings.show');

    Route::get('/my-account/profile', [
        GuestProfileController::class,
        'edit',
    ])->name('guest.profile.edit');

    Route::patch('/my-account/profile', [
        GuestProfileController::class,
        'update',
    ])->name('guest.profile.update');
});

/*
|--------------------------------------------------------------------------
| Administration
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Dashboard
        Route::get('/', [DashboardController::class, 'index'])
            ->name('dashboard');

        // Booking Management
        Route::get('/bookings', [AdminBookingController::class, 'index'])
            ->name('bookings.index');

        Route::patch('/bookings/{booking}/status', [
            AdminBookingController::class,
            'updateStatus',
        ])->name('bookings.status');

        // Room Management
        Route::get('/rooms', [AdminRoomController::class, 'index'])
            ->name('rooms.index');

        Route::get('/rooms/create', [AdminRoomController::class, 'create'])
            ->name('rooms.create');

        Route::post('/rooms', [AdminRoomController::class, 'store'])
            ->name('rooms.store');

        Route::get('/rooms/{room}/edit', [
            AdminRoomController::class,
            'edit',
        ])->name('rooms.edit');

        Route::put('/rooms/{room}', [
            AdminRoomController::class,
            'update',
        ])->name('rooms.update');

        Route::patch('/rooms/{room}/status', [
            AdminRoomController::class,
            'toggleStatus',
        ])->name('rooms.status');

        Route::delete('/rooms/{room}', [
            AdminRoomController::class,
            'destroy',
        ])->name('rooms.destroy');

        // Guest Management
        Route::get('/guests', [GuestController::class, 'index'])
            ->name('guests.index');

        // Staff Management
        Route::get('/staff', [StaffController::class, 'index'])
            ->name('staff.index');

        Route::get('/staff/create', [StaffController::class, 'create'])
            ->name('staff.create');

        Route::post('/staff', [StaffController::class, 'store'])
            ->name('staff.store');

        Route::get('/staff/{staff}/edit', [
            StaffController::class,
            'edit',
        ])->name('staff.edit');

        Route::put('/staff/{staff}', [
            StaffController::class,
            'update',
        ])->name('staff.update');

        Route::patch('/staff/{staff}/status', [
            StaffController::class,
            'toggleStatus',
        ])->name('staff.status');

        Route::delete('/staff/{staff}', [
            StaffController::class,
            'destroy',
        ])->name('staff.destroy');

        // Hotel Service Management
        Route::get('/services', [AdminServiceController::class, 'index'])
            ->name('services.index');

        Route::get('/services/create', [
            AdminServiceController::class,
            'create',
        ])->name('services.create');

        Route::post('/services', [AdminServiceController::class, 'store'])
            ->name('services.store');

        Route::get('/services/{service}/edit', [
            AdminServiceController::class,
            'edit',
        ])->name('services.edit');

        Route::put('/services/{service}', [
            AdminServiceController::class,
            'update',
        ])->name('services.update');

        Route::patch('/services/{service}/status', [
            AdminServiceController::class,
            'toggleStatus',
        ])->name('services.status');

        Route::delete('/services/{service}', [
            AdminServiceController::class,
            'destroy',
        ])->name('services.destroy');

        // Payment Records
        Route::get('/payments', [PaymentController::class, 'index'])
            ->name('payments.index');

        // Reports and Analytics
        Route::get('/reports', [ReportController::class, 'index'])
            ->name('reports.index');
    });
