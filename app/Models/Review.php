<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    protected $fillable = ['user_id', 'service_id', 'staff_id', 'booking_id', 'rating', 'comment', 'is_approved'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function staff(): BelongsTo
    {
        return $this->belongsTo(Staff::class);
    }

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }

    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    public function scopeForService($query, $serviceId)
    {
        return $query->where('service_id', $serviceId)->approved();
    }

    public function scopeForStaff($query, $staffId)
    {
        return $query->where('staff_id', $staffId)->approved();
    }

    public function getAverageRating()
    {
        return $this->where('is_approved', true)->avg('rating') ?? 0;
    }
}
