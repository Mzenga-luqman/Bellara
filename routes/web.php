<?php

use App\Http\Controllers\AdminAnalyticsController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BookingHistoryController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SpaController;
use Illuminate\Support\Facades\Route;

Route::get('/', [SpaController::class, 'index'])->name('home');
Route::post('/bookings', [SpaController::class, 'storeBooking'])
    ->middleware('throttle:booking-submit')
    ->name('bookings.store');
Route::get('/availability', [SpaController::class, 'availability'])
    ->middleware('throttle:availability-check')
    ->name('availability.index');
Route::get('/services/{service}/ratings', [ReviewController::class, 'getServiceRatings'])
    ->middleware('throttle:availability-check');

Route::middleware(['auth', 'verified', 'admin'])->group(function () {
    Route::get('dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::post('/admin/bookings/{booking}/approve', [AdminController::class, 'approve'])->name('admin.bookings.approve');
    Route::post('/admin/bookings/{booking}/cancel', [AdminController::class, 'cancel'])->name('admin.bookings.cancel');
    Route::post('/admin/staff', [AdminController::class, 'storeStaff'])->name('admin.staff.store');
    Route::post('/admin/expenses', [AdminController::class, 'storeExpense'])->name('admin.expenses.store');
    Route::post('/admin/payroll', [AdminController::class, 'storePayroll'])->name('admin.payroll.store');

    // Categories
    Route::post('/admin/categories', [AdminController::class, 'storeServiceCategory'])->name('admin.categories.store');
    Route::put('/admin/categories/{category}', [AdminController::class, 'updateServiceCategory'])->name('admin.categories.update');
    Route::delete('/admin/categories/{category}', [AdminController::class, 'deleteServiceCategory'])->name('admin.categories.destroy');

    // Services
    Route::post('/admin/services', [AdminController::class, 'storeService'])->name('admin.services.store');
    Route::put('/admin/services/{service}', [AdminController::class, 'updateService'])->name('admin.services.update');
    Route::delete('/admin/services/{service}', [AdminController::class, 'deleteService'])->name('admin.services.destroy');

    // Admin Analytics & Management
    Route::get('/admin/analytics', [AdminAnalyticsController::class, 'dashboard'])->name('admin.analytics');
    Route::get('/admin/broadcasts', [AdminAnalyticsController::class, 'broadcastIndex'])->name('admin.broadcasts.index');
    Route::get('/admin/broadcasts/create', [AdminAnalyticsController::class, 'broadcastCreate'])->name('admin.broadcasts.create');
    Route::post('/admin/broadcasts', [AdminAnalyticsController::class, 'broadcastStore'])->name('admin.broadcasts.store');
    Route::get('/admin/reviews', [AdminAnalyticsController::class, 'reviewsIndex'])->name('admin.reviews.index');
    Route::post('/admin/reviews/{review}/approve', [AdminAnalyticsController::class, 'approveReview'])->name('admin.reviews.approve');
    Route::delete('/admin/reviews/{review}', [AdminAnalyticsController::class, 'rejectReview'])->name('admin.reviews.delete');
    Route::get('/admin/staff-availability', [AdminAnalyticsController::class, 'staffAvailability'])->name('admin.staff-availability');
});

Route::middleware(['auth', 'verified'])->group(function () {
    // Customer Booking History & Reviews
    Route::get('/bookings/history', [BookingHistoryController::class, 'index'])->name('bookings.history');
    Route::get('/bookings/{booking}', [BookingHistoryController::class, 'show'])->name('bookings.show');
    Route::put('/bookings/{booking}/reschedule', [BookingHistoryController::class, 'reschedule'])->name('bookings.reschedule');
    Route::post('/bookings/{booking}/cancel', [BookingHistoryController::class, 'cancel'])->name('bookings.cancel');
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
});

require __DIR__.'/settings.php';
