<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Staff extends Model
{
    use HasFactory;

    protected $table = 'staff';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'role_title',
        'service_category_id',
        'is_active',
        'hired_at',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'hired_at' => 'date',
    ];

    public function serviceCategory(): BelongsTo
    {
        return $this->belongsTo(ServiceCategory::class, 'service_category_id');
    }

    public function assignedBookings(): HasMany
    {
        return $this->hasMany(Booking::class, 'staff_id');
    }

    public function preferredBookings(): HasMany
    {
        return $this->hasMany(Booking::class, 'preferred_staff_id');
    }

    public function payrolls(): HasMany
    {
        return $this->hasMany(Payroll::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function getAverageRating()
    {
        return $this->reviews()->approved()->avg('rating') ?? 0;
    }
}
