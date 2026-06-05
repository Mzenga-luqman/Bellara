<x-layouts::app>
    <x-slot:title>Booking Details</x-slot:title>
<div class="container shell" style="padding: 3rem 0;">
    <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 2rem;">
        <a href="{{ route('bookings.history') }}" style="color: #b7925f; text-decoration: none;">← Back to Bookings</a>
    </div>

    <div style="border: 1px solid rgba(183, 146, 95, 0.35); border-radius: 14px; padding: 2rem; background: rgba(255, 249, 240, 0.94); margin-bottom: 2rem;">
        <h2 style="margin-top: 0; color: #5f4523;">{{ $booking->service->name }}</h2>
        <p style="color: #8f6b3d; margin: 0.5rem 0 2rem;">{{ $booking->booking_date->format('l, F d, Y') }} at {{ $booking->booking_time->format('H:i A') }}</p>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin: 1.5rem 0;">
            <div>
                <p style="color: #8f6b3d; font-size: 0.9rem; margin-bottom: 0.5rem;">Service</p>
                <p style="margin: 0; font-weight: 600; color: #5f4523;">{{ $booking->service->name }}</p>
            </div>
            <div>
                <p style="color: #8f6b3d; font-size: 0.9rem; margin-bottom: 0.5rem;">Duration</p>
                <p style="margin: 0; font-weight: 600; color: #5f4523;">{{ $booking->service->duration }} minutes</p>
            </div>
            <div>
                <p style="color: #8f6b3d; font-size: 0.9rem; margin-bottom: 0.5rem;">Price</p>
                <p style="margin: 0; font-weight: 600; color: #5f4523;">TSh {{ number_format($booking->service->price, 2) }}</p>
            </div>
            <div>
                <p style="color: #8f6b3d; font-size: 0.9rem; margin-bottom: 0.5rem;">Status</p>
                <p style="margin: 0; font-weight: 600; color: #5f4523;">{{ ucfirst($booking->status) }}</p>
            </div>
        </div>

        @if ($booking->staff)
            <p style="color: #8f6b3d; margin: 0.5rem 0;">
                <strong>Assigned to:</strong> {{ $booking->staff->name }}
            </p>
        @endif

        @if ($booking->notes)
            <p style="color: #8f6b3d; margin: 1rem 0 0;">
                <strong>Notes:</strong> {{ $booking->notes }}
            </p>
        @endif
    </div>

    @if ($booking->status === 'completed' && !$review)
        <div style="border: 1px solid rgba(255, 230, 193, 0.45); border-radius: 14px; padding: 2rem; background: rgba(255, 253, 249, 0.92);">
            <h3 style="margin-top: 0; color: #5f4523;">Leave a Review</h3>
            <p style="color: #8f6b3d;">Help us improve! Share your experience.</p>

            <form action="{{ route('reviews.store') }}" method="POST">
                @csrf
                <input type="hidden" name="booking_id" value="{{ $booking->id }}">
                <input type="hidden" name="service_id" value="{{ $booking->service_id }}">
                @if ($booking->staff_id)
                    <input type="hidden" name="staff_id" value="{{ $booking->staff_id }}">
                @endif

                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; margin-bottom: 0.5rem; color: #5f4523; font-weight: 600;">Rating *</label>
                    <div style="display: flex; gap: 0.5rem;">
                        @for ($i = 1; $i <= 5; $i++)
                            <input type="radio" name="rating" value="{{ $i }}" id="rating_{{ $i }}" style="display: none;">
                            <label for="rating_{{ $i }}" style="cursor: pointer; font-size: 2rem;">★</label>
                        @endfor
                    </div>
                </div>

                <div style="margin-bottom: 1.5rem;">
                    <label for="comment" style="display: block; margin-bottom: 0.5rem; color: #5f4523; font-weight: 600;">Comment (Optional)</label>
                    <textarea name="comment" id="comment" rows="4" style="width: 100%; padding: 0.75rem; border: 1px solid rgba(183, 146, 95, 0.36); border-radius: 8px; font-family: inherit;"></textarea>
                </div>

                <button type="submit" style="background: linear-gradient(125deg, #d8b784, #b7925f); color: white; padding: 0.7rem 1.5rem; border-radius: 6px; border: none; font-size: 0.9rem; font-weight: 600; cursor: pointer;">Submit Review</button>
            </form>
        </div>
    @elseif ($review)
        <div style="border: 1px solid rgba(100, 180, 100, 0.45); border-radius: 14px; padding: 1.5rem; background: rgba(200, 250, 200, 0.1);">
            <h4 style="margin-top: 0; color: #5f4523;">Your Review</h4>
            <div style="display: flex; gap: 0.3rem; margin-bottom: 0.5rem;">
                @for ($i = 0; $i < 5; $i++)
                    <span style="font-size: 1.3rem;">{{ $i < $review->rating ? '★' : '☆' }}</span>
                @endfor
            </div>
            @if ($review->comment)
                <p style="margin: 0; color: #5f4523;">{{ $review->comment }}</p>
            @endif
            <p style="margin: 0.5rem 0 0; color: #8f6b3d; font-size: 0.9rem;">
                {{ $review->is_approved ? 'Approved' : 'Pending review' }}
            </p>
        </div>
    @endif
</div>

<style>
    input[type="radio"]:checked + label,
    input[type="radio"]:hover + label {
        color: #d8b784;
    }
</style>
</x-layouts::app>
