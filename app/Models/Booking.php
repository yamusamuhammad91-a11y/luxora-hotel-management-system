<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    use HasFactory;

    /**
     * Fields that can be assigned when creating a booking.
     */
    protected $fillable = [
        'booking_reference',
        'room_id',
        'guest_name',
        'guest_email',
        'guest_phone',
        'check_in',
        'check_out',
        'adults',
        'children',
        'rooms_count',
        'price_per_night',
        'nights',
        'total_amount',
        'status',
        'payment_method',
        'payment_status',
        'payment_reference',
        'special_requests',
    ];

    /**
     * Cast database values to useful PHP types.
     */
    protected function casts(): array
    {
        return [
            'check_in' => 'date',
            'check_out' => 'date',
            'adults' => 'integer',
            'children' => 'integer',
            'rooms_count' => 'integer',
            'price_per_night' => 'decimal:2',
            'nights' => 'integer',
            'total_amount' => 'decimal:2',
        ];
    }

    /**
     * The room type associated with this booking.
     */
    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    /**
     * Check whether this booking is confirmed.
     */
    public function isConfirmed(): bool
    {
        return $this->status === 'confirmed';
    }

    /**
     * Check whether payment has been completed.
     */
    public function isPaid(): bool
    {
        return $this->payment_status === 'paid';
    }
}
