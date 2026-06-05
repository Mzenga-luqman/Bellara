<?php

namespace App\Console\Commands;

use App\Models\Booking;
use App\Mail\BookingReminder;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class SendBookingReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bookings:send-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send booking reminders to customers 24 hours before their appointment';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Get tomorrow's date
        $tomorrow = Carbon::tomorrow();

        // Find all bookings for tomorrow that haven't been reminded yet
        $bookings = Booking::where('booking_date', $tomorrow)
            ->where('status', 'confirmed')
            ->whereNull('reminder_sent_at')
            ->with(['user', 'service', 'staff'])
            ->get();

        $count = 0;

        foreach ($bookings as $booking) {
            try {
                if ($booking->user->email) {
                    Mail::to($booking->user->email)->send(new BookingReminder($booking));
                    
                    // Mark reminder as sent
                    $booking->update(['reminder_sent_at' => now()]);
                    $count++;
                }
            } catch (\Exception $e) {
                $this->error("Failed to send reminder for booking ID {$booking->id}: {$e->getMessage()}");
            }
        }

        $this->info("Sent {$count} booking reminders.");
    }
}
