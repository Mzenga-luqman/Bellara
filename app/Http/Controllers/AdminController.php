<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Broadcast;
use App\Models\Expense;
use App\Models\Payroll;
use App\Models\Review;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\Staff;
use App\Models\User;
use App\Services\StaffAssignmentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function __construct(private readonly StaffAssignmentService $staffAssignmentService) {}

    public function dashboard(): View
    {
        $bookings = Booking::query()
            ->with(['service:id,name,price,duration', 'staff:id,name', 'preferredStaff:id,name'])
            ->orderByDesc('created_at')
            ->paginate(25);

        $staffMembers = Staff::query()
            ->with('serviceCategory:id,name')
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        $categories = ServiceCategory::query()
            ->withCount('services')
            ->orderBy('order')
            ->get(['id', 'name', 'description']);

        $services = Service::query()
            ->with('category:id,name')
            ->orderBy('name')
            ->get();

        $payrolls = Payroll::query()
            ->with('staff:id,name')
            ->orderByDesc('pay_date')
            ->limit(20)
            ->get();

        $expenses = Expense::query()->orderByDesc('expense_date')->limit(20)->get();

        $incomeTotal = Booking::query()
            ->with('service:id,price')
            ->whereIn('status', ['confirmed', 'completed'])
            ->get()
            ->sum(fn (Booking $booking) => (float) ($booking->service?->price ?? 0));

        $totalCustomers = User::query()->whereHas('bookings')->count();

        $bookingsByService = Booking::query()
            ->with('service:id,name')
            ->get()
            ->groupBy('service_id')
            ->map(fn ($group) => [
                'service' => $group->first()->service->name,
                'count' => $group->count(),
            ])
            ->values();

        $staffPerformance = Staff::query()
            ->withCount('assignedBookings')
            ->with(['reviews' => fn ($query) => $query->approved()])
            ->orderBy('name')
            ->get()
            ->map(fn ($staff) => [
                'name' => $staff->name,
                'bookings' => $staff->assigned_bookings_count,
                'rating' => round($staff->getAverageRating(), 1),
                'reviews' => $staff->reviews->count(),
            ]);

        $pendingReviews = Review::query()
            ->where('is_approved', false)
            ->with(['user:id,name', 'service:id,name'])
            ->latest()
            ->limit(20)
            ->get();

        $broadcasts = Broadcast::query()->latest()->limit(15)->get();

        $availabilityStaff = Staff::query()
            ->with([
                'serviceCategory:id,name',
                'assignedBookings' => fn ($query) => $query
                    ->with('service:id,name')
                    ->whereIn('status', ['confirmed', 'completed'])
                    ->whereDate('booking_date', '>=', now()->startOfDay())
                    ->orderBy('booking_date')
                    ->orderBy('booking_time'),
            ])
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        $expenseTotal = (float) Expense::query()->sum('amount');
        $payrollTotal = (float) Payroll::query()->sum('amount');

        return view('dashboard', [
            'bookings' => $bookings,
            'staffMembers' => $staffMembers,
            'categories' => $categories,
            'services' => $services,
            'payrolls' => $payrolls,
            'expenses' => $expenses,
            'todayCount' => Booking::query()->whereDate('booking_date', today())->count(),
            'pendingCount' => Booking::query()->where('status', 'pending')->count(),
            'totalCount' => Booking::query()->count(),
            'incomeTotal' => $incomeTotal,
            'expenseTotal' => $expenseTotal,
            'payrollTotal' => $payrollTotal,
            'netTotal' => $incomeTotal - $expenseTotal - $payrollTotal,
            'totalCustomers' => $totalCustomers,
            'bookingsByService' => $bookingsByService,
            'staffPerformance' => $staffPerformance,
            'pendingReviews' => $pendingReviews,
            'broadcasts' => $broadcasts,
            'availabilityStaff' => $availabilityStaff,
        ]);
    }

    public function approve(Booking $booking): RedirectResponse
    {
        $service = Service::query()->find($booking->service_id);

        if ($service && ! $booking->staff_id) {
            $booking->staff_id = $this->staffAssignmentService->resolveStaffId(
                $service,
                $booking->booking_date->toDateString(),
                $booking->booking_time->format('H:i'),
                $booking->preferred_staff_id,
            );
        }

        if (! $booking->staff_id) {
            return back()->withErrors([
                'admin_assignment' => 'Could not approve booking because no qualified staff member is available at that time.',
            ]);
        }

        $booking->update([
            'staff_id' => $booking->staff_id,
            'status' => 'confirmed',
            'confirmed_at' => now(),
        ]);

        return back()->with('admin_success', "Booking #{$booking->id} for {$booking->customer_name} has been confirmed.");
    }

    public function cancel(Booking $booking): RedirectResponse
    {
        $booking->update([
            'status' => 'cancelled',
            'cancelled_at' => now(),
        ]);

        return back()->with('admin_success', "Booking #{$booking->id} for {$booking->customer_name} has been cancelled.");
    }

    public function storeStaff(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255', 'unique:staff,email'],
            'phone' => ['nullable', 'string', 'max:30'],
            'role_title' => ['nullable', 'string', 'max:255'],
            'service_category_id' => ['required', 'exists:service_categories,id'],
            'hired_at' => ['nullable', 'date'],
        ]);

        Staff::query()->create(array_merge($validated, ['is_active' => true]));

        return back()->with('admin_success', 'Staff member added successfully.');
    }

    public function storeExpense(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'max:255'],
            'amount' => ['required', 'numeric', 'min:0'],
            'expense_date' => ['required', 'date'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        Expense::query()->create($validated);

        return back()->with('admin_success', 'Expense recorded successfully.');
    }

    public function storePayroll(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'staff_id' => ['required', 'exists:staff,id'],
            'amount' => ['required', 'numeric', 'min:0'],
            'pay_date' => ['required', 'date'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        Payroll::query()->create($validated);

        return back()->with('admin_success', 'Payroll entry saved successfully.');
    }

    public function storeServiceCategory(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:service_categories,name'],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);

        ServiceCategory::query()->create($validated);

        return back()->with('admin_success', 'Service category created successfully.');
    }

    public function updateServiceCategory(Request $request, ServiceCategory $category): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:service_categories,name,'.$category->id],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);

        $category->update($validated);

        return back()->with('admin_success', 'Service category updated successfully.');
    }

    public function deleteServiceCategory(ServiceCategory $category): RedirectResponse
    {
        if ($category->services()->count() > 0) {
            return back()->withErrors([
                'admin_error' => 'Cannot delete a service category that has associated services.',
            ]);
        }

        $category->delete();

        return back()->with('admin_success', 'Service category deleted successfully.');
    }

    public function storeService(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'category_id' => ['required', 'exists:service_categories,id'],
            'duration' => ['required', 'integer', 'min:15'],
            'price' => ['required', 'numeric', 'min:0'],
            'is_active' => ['boolean'],
            'background_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
        ]);

        $payload = collect($validated)->except('background_image')->all();
        $payload['is_active'] = $validated['is_active'] ?? true;

        if ($request->hasFile('background_image')) {
            $payload['image'] = $this->storeServiceImage($request->file('background_image'));
        }

        Service::query()->create($payload);

        return back()->with('admin_success', 'Service created successfully.');
    }

    public function updateService(Request $request, Service $service): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'category_id' => ['required', 'exists:service_categories,id'],
            'duration' => ['required', 'integer', 'min:15'],
            'price' => ['required', 'numeric', 'min:0'],
            'is_active' => ['boolean'],
            'background_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
        ]);

        $payload = collect($validated)->except('background_image')->all();

        if ($request->hasFile('background_image')) {
            $this->deleteStoredServiceImage($service->image);
            $payload['image'] = $this->storeServiceImage($request->file('background_image'));
        }

        $service->update($payload);

        return back()->with('admin_success', 'Service updated successfully.');
    }

    public function deleteService(Service $service): RedirectResponse
    {
        if ($service->bookings()->count() > 0) {
            return back()->withErrors([
                'admin_error' => 'Cannot delete a service that has associated bookings.',
            ]);
        }

        $this->deleteStoredServiceImage($service->image);

        $service->delete();

        return back()->with('admin_success', 'Service deleted successfully.');
    }

    private function storeServiceImage(UploadedFile $imageFile): string
    {
        $path = $imageFile->store('services', 'public');

        return Storage::url($path);
    }

    private function deleteStoredServiceImage(?string $imagePath): void
    {
        if (! $imagePath || ! str_starts_with($imagePath, '/storage/services/')) {
            return;
        }

        $relativePath = ltrim(str_replace('/storage/', '', $imagePath), '/');

        if ($relativePath !== '') {
            Storage::disk('public')->delete($relativePath);
        }
    }
}
