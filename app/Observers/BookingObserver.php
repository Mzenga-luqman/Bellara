<?php

namespace App\Observers;

use App\Models\Booking;
use App\Mail\BookingConfirmation;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

class BookingObserver
{
    /**
     * Handle the Booking "created" event.
     */
    public function created(Booking $booking): void
    {
        // Prefer booking contact email for guest bookings; fallback to linked user email.
        $recipientEmail = $booking->customer_email ?: $booking->user?->email;

        if ($recipientEmail && filter_var($recipientEmail, FILTER_VALIDATE_EMAIL)) {
            $this->sendConfirmationSafely($booking, $recipientEmail, 'created');
        }
    }

    /**
     * Handle the Booking "updated" event.
     */
    public function updated(Booking $booking): void
    {
        // Send confirmation if status changed to confirmed.
        if ($booking->isDirty('status') && $booking->status === 'confirmed') {
            $recipientEmail = $booking->customer_email ?: $booking->user?->email;

            if ($recipientEmail && filter_var($recipientEmail, FILTER_VALIDATE_EMAIL)) {
                $this->sendConfirmationSafely($booking, $recipientEmail, 'updated');
            }
        }
    }

    /**
     * Send booking confirmation without blocking the booking flow if SMTP fails.
     */
    private function sendConfirmationSafely(Booking $booking, string $recipientEmail, string $event): void
    {
        try {
            Mail::to($recipientEmail)->send(new BookingConfirmation($booking));
        } catch (Throwable $e) {
            Log::warning('Booking confirmation email failed.', [
                'booking_id' => $booking->id,
                'event' => $event,
                'recipient' => $recipientEmail,
                'error' => $e->getMessage(),
            ]);
        }
    }
}
