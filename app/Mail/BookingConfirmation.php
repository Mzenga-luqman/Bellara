<?php

namespace App\Mail;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BookingConfirmation extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(public Booking $booking) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Booking Confirmation - Bellara Beauty & Spa Lounge',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.booking-confirmation',
            with: [
                'booking' => $this->booking,
                'serviceName' => $this->booking->service->name,
                'customerName' => $this->booking->customer_name,
                'bookingDate' => $this->booking->booking_date->format('D, M d, Y'),
                'bookingTime' => $this->booking->booking_time->format('H:i'),
                'price' => $this->booking->service->price,
            ],
        );
    }
}
