<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Broadcast;
use App\Models\Review;
use App\Mail\BroadcastMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class AdminAnalyticsController extends Controller
{
    public function dashboard()
    {
        return redirect()
            ->route('dashboard')
            ->with('admin_section', 'analytics');
    }

    public function broadcastIndex()
    {
        return redirect()
            ->route('dashboard')
            ->with('admin_section', 'broadcasts');
    }

    public function broadcastCreate()
    {
        return redirect()
            ->route('dashboard')
            ->with('admin_section', 'broadcasts');
    }

    public function broadcastStore(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:200',
            'message' => 'required|string',
        ]);

        $broadcast = Broadcast::create($validated);

        // Send to unique emails captured during booking.
        $customers = Booking::query()
            ->whereNotNull('customer_email')
            ->where('customer_email', '!=', '')
            ->pluck('customer_email')
            ->map(fn (string $email) => strtolower(trim($email)))
            ->filter(fn (string $email) => filter_var($email, FILTER_VALIDATE_EMAIL) !== false)
            ->unique()
            ->values();

        foreach ($customers as $email) {
            Mail::to($email)->send(new BroadcastMessage($validated['title'], $validated['message']));
        }

        $broadcast->update([
            'recipient_count' => $customers->count(),
            'sent_at' => now(),
        ]);

        return redirect()
            ->route('dashboard')
            ->with('admin_section', 'broadcasts')
            ->with('admin_success', "Message sent to {$broadcast->recipient_count} customers!");
    }

    public function reviewsIndex()
    {
        return redirect()
            ->route('dashboard')
            ->with('admin_section', 'reviews');
    }

    public function approveReview(Review $review)
    {
        $review->update(['is_approved' => true]);
        return redirect()
            ->route('dashboard')
            ->with('admin_section', 'reviews')
            ->with('admin_success', 'Review approved!');
    }

    public function rejectReview(Review $review)
    {
        $review->delete();
        return redirect()
            ->route('dashboard')
            ->with('admin_section', 'reviews')
            ->with('admin_success', 'Review deleted.');
    }

    public function staffAvailability()
    {
        return redirect()
            ->route('dashboard')
            ->with('admin_section', 'availability');
    }
}
