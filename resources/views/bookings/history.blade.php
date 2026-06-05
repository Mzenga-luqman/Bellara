<x-layouts::app>
    <x-slot:title>My Bookings</x-slot:title>
<div class="container shell" style="padding: 3rem 0;">
    <div class="section-heading reveal">
        <p class="eyebrow">My Bookings</p>
        <h2>Your Appointment History</h2>
    </div>

    @if ($bookings->count() > 0)
        <div style="display: grid; gap: 1rem; margin-top: 1.5rem;">
            @foreach ($bookings as $booking)
                <div style="border: 1px solid rgba(183, 146, 95, 0.35); border-radius: 14px; padding: 1.2rem; background: rgba(255, 249, 240, 0.94);">
                    <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 1rem;">
                        <div>
                            <h4 style="margin: 0 0 0.5rem; color: #5f4523; font-size: 1.1rem;">{{ $booking->service->name }}</h4>
                            <p style="margin: 0; color: #8f6b3d; font-size: 0.95rem;">{{ $booking->booking_date->format('D, M d, Y') }} at {{ $booking->booking_time->format('H:i') }}</p>
                        </div>
                        <span style="background: linear-gradient(125deg, #d8b784, #b7925f); color: white; padding: 0.5rem 0.75rem; border-radius: 20px; font-size: 0.75rem; text-transform: uppercase; font-weight: 700;">{{ ucfirst($booking->status) }}</span>
                    </div>

                    <div style="display: flex; gap: 0.5rem; flex-wrap: wrap; margin-bottom: 1rem;">
                        <span style="background: rgba(255, 246, 232, 0.6); padding: 0.4rem 0.8rem; border-radius: 20px; font-size: 0.85rem; color: #5f4523;">TSh {{ number_format($booking->service->price, 2) }}</span>
                        <span style="background: rgba(255, 246, 232, 0.6); padding: 0.4rem 0.8rem; border-radius: 20px; font-size: 0.85rem; color: #5f4523;">{{ $booking->service->duration }} mins</span>
                        @if ($booking->staff)
                            <span style="background: rgba(255, 246, 232, 0.6); padding: 0.4rem 0.8rem; border-radius: 20px; font-size: 0.85rem; color: #5f4523;">with {{ $booking->staff->name }}</span>
                        @endif
                    </div>

                    <div style="display: flex; gap: 0.7rem; flex-wrap: wrap;">
                        <a href="{{ route('bookings.show', $booking->id) }}" style="background: linear-gradient(125deg, #d8b784, #b7925f); color: white; padding: 0.5rem 1rem; border-radius: 6px; text-decoration: none; font-size: 0.85rem; font-weight: 600;">View Details</a>
                        
                        @if ($booking->booking_date->isFuture() && $booking->status !== 'cancelled')
                            <form action="{{ route('bookings.reschedule', $booking->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('PUT')
                                <button type="submit" style="background: rgba(255, 246, 232, 0.94); color: #5f4523; padding: 0.5rem 1rem; border-radius: 6px; border: 1px solid rgba(255, 238, 212, 0.75); font-size: 0.85rem; font-weight: 600; cursor: pointer;">Reschedule</button>
                            </form>

                            <form action="{{ route('bookings.cancel', $booking->id) }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" style="background: rgba(200, 100, 100, 0.15); color: #8f4a4a; padding: 0.5rem 1rem; border-radius: 6px; border: 1px solid rgba(186, 111, 111, 0.45); font-size: 0.85rem; font-weight: 600; cursor: pointer; onclick='return confirm(\"Are you sure?\")'>Cancel</button>
                            </form>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        {{ $bookings->links() }}
    @else
        <div style="text-align: center; padding: 3rem; background: rgba(255, 249, 240, 0.94); border-radius: 14px; margin-top: 2rem;">
            <p style="color: #8f6b3d; margin: 0;">No bookings yet. <a href="{{ route('home') }}#book" style="color: #b7925f; font-weight: 600;">Book an appointment</a></p>
        </div>
    @endif
</div>
</x-layouts::app>
