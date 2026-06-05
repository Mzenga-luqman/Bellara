<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\Staff;
use App\Services\StaffAssignmentService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SpaController extends Controller
{
    public function __construct(private readonly StaffAssignmentService $staffAssignmentService) {}

    public function index(): View
    {
        $categories = ServiceCategory::query()
            ->with(['services' => fn ($query) => $query->where('is_active', true)->orderBy('name')])
            ->orderBy('order')
            ->get();

        $services = Service::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->withAvg([
                'reviews as approved_avg_rating' => fn ($query) => $query->where('is_approved', true),
            ], 'rating')
            ->withCount([
                'reviews as approved_reviews_count' => fn ($query) => $query->where('is_approved', true),
            ])
            ->get();

        $staff = Staff::query()
            ->with('serviceCategory:id,name')
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        $galleryImages = [
            '/images/bellara/reception.jpg',
            '/images/bellara/lounge-smile.jpg',
            '/images/bellara/lounge-champagne.jpg',
            '/images/bellara/massage-rest.jpg',
            '/images/bellara/massage-stones.jpg',
        ];

        $galleryImages = $this->resolveGalleryImages($galleryImages);

        return view('welcome', [
            'categories' => $categories,
            'services' => $services,
            'staff' => $staff,
            'galleryImages' => $galleryImages,
        ]);
    }

    /**
     * @param  list<string>  $images
     * @return list<string>
     */
    private function resolveGalleryImages(array $images): array
    {
        $fallback = '/images/bellara/placeholder.svg';

        return array_map(function (string $image) use ($fallback): string {
            $filePath = public_path(ltrim($image, '/'));

            return file_exists($filePath) ? $image : $fallback;
        }, $images);
    }

    public function availability(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'service_id' => ['required', 'exists:services,id'],
            'date' => ['required', 'date_format:Y-m-d', 'after_or_equal:today'],
            'preferred_staff_id' => ['nullable', 'exists:staff,id'],
        ]);

        $service = Service::query()->findOrFail($validated['service_id']);

        $slots = $this->generateSlots($service->duration);

        $availability = collect($slots)->map(fn (string $slot) => [
            'time' => $slot,
            'available' => $this->staffAssignmentService->isSlotBookable(
                $service,
                $validated['date'],
                $slot,
                isset($validated['preferred_staff_id']) ? (int) $validated['preferred_staff_id'] : null,
            ),
        ]);

        return response()->json([
            'slots' => $availability,
            'available_slots' => $availability->where('available', true)->pluck('time')->values(),
            'unavailable_slots' => $availability->where('available', false)->pluck('time')->values(),
        ]);
    }

    public function storeBooking(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'service_id' => ['required', 'exists:services,id'],
            'preferred_staff_id' => ['nullable', 'exists:staff,id'],
            'booking_date' => ['required', 'date_format:Y-m-d', 'after_or_equal:today'],
            'booking_time' => ['required', 'date_format:H:i'],
            'customer_name' => ['required', 'string', 'max:255'],
            'customer_email' => ['required', 'email', 'max:255'],
            'customer_phone' => ['required', 'string', 'max:30'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $service = Service::query()->findOrFail($validated['service_id']);
        $preferredStaffId = isset($validated['preferred_staff_id']) ? (int) $validated['preferred_staff_id'] : null;
        $assignedStaffId = $this->staffAssignmentService->resolveStaffId(
            $service,
            $validated['booking_date'],
            $validated['booking_time'],
            $preferredStaffId,
        );

        if (! $assignedStaffId) {
            return back()->withInput()->withErrors([
                'booking_time' => 'No qualified staff member is available for that slot. Please choose a different time.',
            ]);
        }

        Booking::query()->create([
            'user_id' => auth()->id(),
            'service_id' => (int) $validated['service_id'],
            'preferred_staff_id' => $preferredStaffId,
            'staff_id' => $assignedStaffId,
            'booking_date' => $validated['booking_date'],
            'booking_time' => $validated['booking_time'],
            'status' => 'pending',
            'customer_name' => $validated['customer_name'],
            'customer_email' => $validated['customer_email'],
            'customer_phone' => $validated['customer_phone'],
            'notes' => $validated['notes'] ?? null,
        ]);

        return redirect()->route('home')->with('booking_success', 'Your booking request has been sent. We will confirm your appointment shortly.');
    }

    /**
     * Build appointment slots from 09:00 to 19:00 in 30-minute increments.
     * A slot is valid only when the service can finish before closing time.
     *
     * @return list<string>
     */
    private function generateSlots(int $durationInMinutes): array
    {
        $opening = Carbon::createFromTimeString('09:00');
        $closing = Carbon::createFromTimeString('19:00');

        $slots = [];

        for ($cursor = $opening->copy(); $cursor->copy()->addMinutes($durationInMinutes)->lte($closing); $cursor->addMinutes(30)) {
            $slots[] = $cursor->format('H:i');
        }

        return $slots;
    }
}
