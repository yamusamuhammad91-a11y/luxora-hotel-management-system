<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Create the bookings table.
     */
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();

            $table->string('booking_reference')->unique();

            // Room type selected for the reservation.
            $table->foreignId('room_id')
                ->constrained('rooms')
                ->restrictOnDelete();

            // Guest contact information.
            $table->string('guest_name');
            $table->string('guest_email')->index();
            $table->string('guest_phone', 30)->nullable();

            // Reservation dates and guest counts.
            $table->date('check_in');
            $table->date('check_out');

            $table->unsignedTinyInteger('adults')->default(1);
            $table->unsignedTinyInteger('children')->default(0);
            $table->unsignedTinyInteger('rooms_count')->default(1);

            // Preserve the price agreed at booking time.
            $table->decimal('price_per_night', 12, 2);
            $table->unsignedSmallInteger('nights');
            $table->decimal('total_amount', 12, 2);

            // Reservation workflow.
            $table->string('status')->default('pending')->index();

            // Payment workflow.
            $table->string('payment_method')->nullable();
            $table->string('payment_status')->default('unpaid')->index();
            $table->string('payment_reference')->nullable()->unique();

            $table->text('special_requests')->nullable();

            $table->timestamps();

            $table->index(['check_in', 'check_out']);
            $table->index(['room_id', 'status']);
        });
    }

    /**
     * Drop the bookings table on rollback.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
