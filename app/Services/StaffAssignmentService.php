<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Service;
use App\Models\Staff;
use Carbon\Carbon;

class StaffAssignmentService
{
    public function isSlotBookable(Service $service, string $date, string $time, ?int $preferredStaffId = null): bool
    {
        return $this->resolveStaffId($service, $date, $time, $preferredStaffId) !== null;
    }

    public function resolveStaffId(Service $service, string $date, string $time, ?int $preferredStaffId = null): ?int
    {
        $duration = (int) $service->duration;

        $qualified = Staff::query()
            ->where('is_active', true)
            ->where('service_category_id', $service->category_id)
            ->get(['id']);

        if ($qualified->isEmpty()) {
            return null;
        }

        if ($preferredStaffId) {
            $isQualified = $qualified->contains(fn (Staff $staff) => $staff->id === $preferredStaffId);
            if (! $isQualified) {
                return null;
            }

            return $this->isStaffAvailable($preferredStaffId, $date, $time, $duration) ? $preferredStaffId : null;
        }

        foreach ($qualified as $staff) {
            if ($this->isStaffAvailable($staff->id, $date, $time, $duration)) {
                return $staff->id;
            }
        }

        return null;
    }

    public function isStaffAvailable(int $staffId, string $date, string $time, int $duration): bool
    {
        $slotStart = Carbon::parse("{$date} {$time}");
        $slotEnd = $slotStart->copy()->addMinutes($duration);

        $bookings = Booking::query()
            ->with('service:id,duration')
            ->where('staff_id', $staffId)
            ->whereDate('booking_date', $date)
            ->whereIn('status', ['pending', 'confirmed'])
            ->get();

        foreach ($bookings as $booking) {
            $bookingDate = Carbon::parse($booking->getRawOriginal('booking_date'))->toDateString();
            $bookingTime = Carbon::parse($booking->getRawOriginal('booking_time'))->format('H:i');
            $bookingStart = Carbon::parse("{$bookingDate} {$bookingTime}");
            $bookingEnd = $bookingStart->copy()->addMinutes((int) ($booking->service?->duration ?? 60));

            if ($slotStart->lt($bookingEnd) && $slotEnd->gt($bookingStart)) {
                return false;
            }
        }

        return true;
    }
}
