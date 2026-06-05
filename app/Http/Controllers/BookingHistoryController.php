<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Services\StaffAssignmentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingHistoryController extends Controller
{
    public function __construct(private readonly StaffAssignmentService $staffAssignmentService) {}

    public function index()
    {
        $user = Auth::user();
        $bookings = $user->bookings()
            ->with('service', 'staff')
            ->orderBy('booking_date', 'desc')
            ->paginate(10);

        return view('bookings.history', compact('bookings'));
    }

    public function show(Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }

        $review = $booking->reviews()->first();

        return view('bookings.detail', compact('booking', 'review'));
    }

    public function reschedule(Request $request, Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }

        // Only allow rescheduling if booking is tomorrow or later
        if ($booking->booking_date->isPast()) {
            return back()->withErrors('Cannot reschedule past bookings.');
        }

        $validated = $request->validate([
            'new_date' => 'required|date|after:today',
            'new_time' => 'required|date_format:H:i',
        ]);

        if (! in_array($booking->status, ['pending', 'confirmed'], true)) {
            return back()->withErrors('Only pending or confirmed bookings can be rescheduled.');
        }

        $service = $booking->service;

        if (! $service) {
            return back()->withErrors('Booking service is missing and cannot be rescheduled.');
        }

        $resolvedStaffId = $this->staffAssignmentService->resolveStaffId(
            $service,
            $validated['new_date'],
            $validated['new_time'],
            $booking->preferred_staff_id,
        );

        if (! $resolvedStaffId) {
            return back()->withErrors('Selected slot is no longer available. Please pick another time.');
        }

        $booking->update([
            'booking_date' => $validated['new_date'],
            'booking_time' => $validated['new_time'],
            'staff_id' => $resolvedStaffId,
            'reminder_sent_at' => null,
        ]);

        return back()->with('success', 'Booking rescheduled successfully!');
    }

    public function cancel(Request $request, Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'reason' => 'nullable|string|max:200',
        ]);

        $booking->update([
            'status' => 'cancelled',
            'cancelled_at' => now(),
            'notes' => 'Cancelled by customer. Reason: '.($validated['reason'] ?? 'No reason provided'),
        ]);

        return back()->with('success', 'Booking cancelled successfully.');
    }
}
