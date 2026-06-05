<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Review;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'service_id' => 'required|exists:services,id',
            'staff_id' => 'nullable|exists:staff,id',
            'rating' => 'required|integer|between:1,5',
            'comment' => 'nullable|string|max:500',
        ]);

        $booking = Booking::findOrFail($validated['booking_id']);

        if ($booking->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        if ((int) $booking->service_id !== (int) $validated['service_id']) {
            return back()->withErrors([
                'service_id' => 'Selected service does not match the booking.',
            ]);
        }

        if (isset($validated['staff_id']) && (int) ($booking->staff_id ?? 0) !== (int) $validated['staff_id']) {
            return back()->withErrors([
                'staff_id' => 'Selected staff member does not match the booking.',
            ]);
        }

        if ($booking->status !== 'completed') {
            return back()->withErrors([
                'booking_id' => 'You can only review completed bookings.',
            ]);
        }

        if ($booking->reviews()->where('user_id', Auth::id())->exists()) {
            return back()->withErrors([
                'booking_id' => 'You have already submitted a review for this booking.',
            ]);
        }

        Review::query()->create([
            'user_id' => Auth::id(),
            'booking_id' => $validated['booking_id'],
            'service_id' => $validated['service_id'],
            'staff_id' => $validated['staff_id'],
            'rating' => $validated['rating'],
            'comment' => $validated['comment'] ?? null,
        ]);

        return back()->with('success', 'Review submitted! It will appear after admin approval.');
    }

    public function getServiceRatings($serviceId)
    {
        $service = Service::findOrFail($serviceId);

        return response()->json([
            'average_rating' => round($service->getAverageRating(), 1),
            'total_reviews' => $service->reviews()->approved()->count(),
            'reviews' => $service->reviews()
                ->approved()
                ->latest()
                ->limit(5)
                ->with('user')
                ->get(['id', 'user_id', 'rating', 'comment', 'created_at']),
        ]);
    }
}
