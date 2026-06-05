@php
    $now = now();
    $activeSection = session('admin_section', 'overview');
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard — Bellara</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=Manrope:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bellara-admin-body">
<div class="admin-shell">

    {{-- ─── Sidebar ─────────────────────────────────────────────── --}}
    <aside class="admin-sidebar">
        <div class="admin-sidebar-brand">
            <p class="brand-script">Bellara</p>
            <p class="brand-subtitle" style="margin:0.15rem 0 0.5rem;">Beauty &amp; Spa Lounge</p>
            <span class="admin-portal-tag">Admin Portal</span>
        </div>

        <nav class="admin-nav" id="adminNav">
            <a href="#" class="admin-nav-item" data-section="overview">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                Overview
            </a>
            <a href="#" class="admin-nav-item" data-section="orders">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                Orders
                @if($pendingCount > 0)
                    <span class="nav-badge">{{ $pendingCount }}</span>
                @endif
            </a>
            <a href="#" class="admin-nav-item" data-section="staff">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                Staff
            </a>
            <a href="#" class="admin-nav-item" data-section="finances">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7H14.5a3.5 3.5 0 0 1 0 7H6"/></svg>
                Finances
            </a>
            <a href="#" class="admin-nav-item" data-section="payroll">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                Payroll
            </a>
            <a href="#" class="admin-nav-item" data-section="services">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9h12M6 9a3 3 0 0 1 3-3h6a3 3 0 0 1 3 3M6 9v10a3 3 0 0 0 3 3h6a3 3 0 0 0 3-3V9M10 14h4"/></svg>
                Services
            </a>
            <a href="#" class="admin-nav-item" data-section="categories">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2H6a2 2 0 0 0-2 2v4a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2z"/><path d="M18 2h-6a2 2 0 0 0-2 2v4a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2z"/><path d="M12 14H6a2 2 0 0 0-2 2v4a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-4a2 2 0 0 0-2-2z"/><path d="M18 14h-6a2 2 0 0 0-2 2v4a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-4a2 2 0 0 0-2-2z"/></svg>
                Categories
            </a>

            <div class="admin-nav-divider"></div>

               <a href="#" class="admin-nav-item" data-section="analytics">
                   <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                   Analytics
               </a>
               <a href="#" class="admin-nav-item" data-section="broadcasts">
                   <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="2 6 12 13 22 6"/></svg>
                   Broadcasts
               </a>
               <a href="#" class="admin-nav-item" data-section="reviews">
                   <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                   Reviews
               </a>
               <a href="#" class="admin-nav-item" data-section="availability">
                   <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
                   Availability
               </a>

            <a href="{{ route('home') }}" class="admin-nav-item" target="_blank">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                Public Site
            </a>
        </nav>

        <div class="admin-sidebar-footer">
            <p class="admin-user-name">{{ auth()->user()->name }}</p>
            <p class="admin-user-email">{{ auth()->user()->email }}</p>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="admin-logout-btn">Sign out</button>
            </form>
            <p class="ngome-sidebar-credit">Ngome Technologies</p>
        </div>
    </aside>

    {{-- ─── Main Content ─────────────────────────────────────────── --}}
    <main class="admin-content">

        @if (session('admin_success'))
            <div class="admin-flash">{{ session('admin_success') }}</div>
        @endif
        @if ($errors->has('admin_assignment'))
            <div class="alert-error" style="margin-bottom:1rem;">{{ $errors->first('admin_assignment') }}</div>
        @endif

        {{-- ═══ OVERVIEW SECTION ══════════════════════════════════════ --}}
        <section class="admin-page-section" id="section-overview">
            <div class="admin-page-header">
                <div>
                    <h1 class="admin-page-title">Overview</h1>
                    <p class="admin-page-sub">Your business at a glance &mdash; powered by <strong style="color:var(--gold-2)">Ngome Technologies</strong></p>
                </div>
                <span class="admin-page-date">{{ now()->format('l, d M Y') }}</span>
            </div>

            <div class="admin-overview-grid">
                <div class="overview-card overview-card--gold" data-goto="orders">
                    <div class="overview-card-icon">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                    </div>
                    <p class="overview-card-label">Today&rsquo;s Orders</p>
                    <p class="overview-card-value">{{ $todayCount }}</p>
                    @if($pendingCount > 0)
                        <p class="overview-card-hint">{{ $pendingCount }} pending approval</p>
                    @endif
                </div>

                <div class="overview-card" data-goto="orders">
                    <div class="overview-card-icon">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    </div>
                    <p class="overview-card-label">All-Time Bookings</p>
                    <p class="overview-card-value">{{ $totalCount }}</p>
                </div>

                <div class="overview-card" data-goto="finances">
                    <div class="overview-card-icon">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7H14.5a3.5 3.5 0 0 1 0 7H6"/></svg>
                    </div>
                    <p class="overview-card-label">Net Balance</p>
                    <p class="overview-card-value" style="font-size:1.25rem;">TSh {{ number_format($netTotal) }}</p>
                </div>

                <div class="overview-card" data-goto="staff">
                    <div class="overview-card-icon">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    </div>
                    <p class="overview-card-label">Active Staff</p>
                    <p class="overview-card-value">{{ $staffMembers->count() }}</p>
                </div>
            </div>

            {{-- Quick-access rows --}}
            <div class="admin-two-col" style="margin-top:1.5rem;">
                <div class="admin-panel">
                    <h3 class="admin-panel-title">Pending Approvals</h3>
                    @php $pendingList = $bookings->filter(fn($b) => $b->status === 'pending')->take(5); @endphp
                    @if($pendingList->isEmpty())
                        <p class="admin-empty" style="padding:0.6rem 0;">No pending bookings right now.</p>
                    @else
                        <div class="admin-simple-list">
                            @foreach($pendingList as $b)
                                <div class="admin-simple-item">
                                    <div>
                                        <strong>{{ $b->customer_name }}</strong>
                                        <div class="admin-staff-meta">{{ $b->service?->name }} &mdash; {{ \Carbon\Carbon::parse($b->booking_date)->format('d M') }} at {{ \Carbon\Carbon::parse($b->booking_time)->format('H:i') }}</div>
                                    </div>
                                    <div class="admin-actions">
                                        <form method="POST" action="{{ route('admin.bookings.approve', $b) }}" style="margin:0">
                                            @csrf
                                            <button type="submit" class="admin-btn admin-btn-approve">Approve</button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="admin-panel">
                    <h3 class="admin-panel-title">Staff On Duty Today</h3>
                    <div class="admin-simple-list">
                        @foreach($staffMembers->take(6) as $member)
                            @php
                                $isBusy = $member->assignedBookings()
                                    ->whereDate('booking_date', today())
                                    ->whereIn('status', ['pending','confirmed'])
                                    ->exists();
                            @endphp
                            <div class="admin-simple-item">
                                <div>
                                    <strong>{{ $member->name }}</strong>
                                    <div class="admin-staff-meta">{{ $member->role_title ?: $member->serviceCategory?->name }}</div>
                                </div>
                                <span class="admin-status-dot {{ $isBusy ? 'is-busy' : 'is-free' }}">{{ $isBusy ? 'Booked' : 'Free' }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>

        {{-- ═══ ORDERS SECTION ════════════════════════════════════════ --}}
        <section class="admin-page-section" id="section-orders" style="display:none;">
            <div class="admin-page-header">
                <div>
                    <h1 class="admin-page-title">Orders</h1>
                    <p class="admin-page-sub">All bookings &mdash; approve, cancel and track assigned workers</p>
                </div>
                <div class="admin-header-stats">
                    <div class="header-stat">
                        <span class="header-stat-num">{{ $todayCount }}</span>
                        <span class="header-stat-lbl">Today</span>
                    </div>
                    <div class="header-stat header-stat--gold">
                        <span class="header-stat-num">{{ $pendingCount }}</span>
                        <span class="header-stat-lbl">Pending</span>
                    </div>
                    <div class="header-stat">
                        <span class="header-stat-num">{{ $totalCount }}</span>
                        <span class="header-stat-lbl">All-Time</span>
                    </div>
                </div>
            </div>

            <div class="admin-table-wrap">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Customer</th>
                            <th>Service</th>
                            <th>Date &amp; Time</th>
                            <th>Assigned Staff</th>
                            <th>Status</th>
                            <th>Booked</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($bookings as $booking)
                            <tr>
                                <td style="color:rgba(58,45,31,0.4);font-size:0.78rem;">{{ $booking->id }}</td>
                                <td>
                                    <p class="admin-customer-name">{{ $booking->customer_name }}</p>
                                    <p class="admin-customer-note">{{ $booking->customer_email }}</p>
                                </td>
                                <td>{{ $booking->service?->name ?? '—' }}</td>
                                <td style="white-space:nowrap;">
                                    {{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }}<br>
                                    <span style="color:rgba(58,45,31,0.5);font-size:0.78rem;">
                                        {{ \Carbon\Carbon::parse($booking->booking_time)->format('H:i') }}
                                    </span>
                                </td>
                                <td style="font-size:0.8rem;">
                                    @if ($booking->staff)
                                        {{ $booking->staff->name }}
                                    @else
                                        <span style="color:rgba(58,45,31,0.45);">Unassigned</span>
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $badge = match($booking->status) {
                                            'pending'   => ['#f8f3e0','#8a6c20','rgba(183,160,72,0.4)'],
                                            'confirmed' => ['#e8f5e9','#2d6b35','rgba(100,160,100,0.4)'],
                                            'completed' => ['#e8f0fd','#2a4f8a','rgba(72,100,183,0.4)'],
                                            'cancelled' => ['#fdecea','#8f3a3a','rgba(183,100,100,0.4)'],
                                            default     => ['#f5f5f5','#555','#ccc'],
                                        };
                                    @endphp
                                    <span style="background:{{ $badge[0] }};color:{{ $badge[1] }};border:1px solid {{ $badge[2] }};border-radius:999px;padding:0.2rem 0.7rem;font-size:0.72rem;font-weight:700;white-space:nowrap;">
                                        {{ ucfirst($booking->status) }}
                                    </span>
                                </td>
                                <td style="font-size:0.76rem;color:rgba(58,45,31,0.4);white-space:nowrap;">
                                    {{ $booking->created_at->diffForHumans() }}
                                </td>
                                <td>
                                    <div class="admin-actions">
                                        @if ($booking->status === 'pending')
                                            <form method="POST" action="{{ route('admin.bookings.approve', $booking) }}">
                                                @csrf
                                                <button type="submit" class="admin-btn admin-btn-approve">Approve</button>
                                            </form>
                                        @endif
                                        @if (in_array($booking->status, ['pending', 'confirmed']))
                                            <form method="POST" action="{{ route('admin.bookings.cancel', $booking) }}">
                                                @csrf
                                                <button type="submit" class="admin-btn admin-btn-cancel"
                                                    onclick="return confirm('Cancel this booking?')">Cancel</button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="admin-empty">No bookings yet. They will appear here once clients book.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                @if ($bookings->hasPages())
                    <div style="padding:0.9rem 1rem;border-top:1px solid var(--line);">
                        {{ $bookings->links() }}
                    </div>
                @endif
            </div>
        </section>

        {{-- ═══ STAFF SECTION ═════════════════════════════════════════ --}}
        <section class="admin-page-section" id="section-staff" style="display:none;">
            <div class="admin-page-header">
                <div>
                    <h1 class="admin-page-title">Staff</h1>
                    <p class="admin-page-sub">Manage workers, service categories, and live availability</p>
                </div>
            </div>

            <div class="admin-two-col">
                <div class="admin-panel">
                    <h3 class="admin-panel-title">Add Staff Member</h3>
                    <form method="POST" action="{{ route('admin.staff.store') }}" class="admin-form-grid">
                        @csrf
                        <div>
                            <label>Name</label>
                            <input type="text" name="name" required>
                        </div>
                        <div>
                            <label>Email</label>
                            <input type="email" name="email">
                        </div>
                        <div>
                            <label>Phone</label>
                            <input type="text" name="phone">
                        </div>
                        <div>
                            <label>Role title</label>
                            <input type="text" name="role_title" placeholder="Nail Technician, Massage Therapist...">
                        </div>
                        <div>
                            <label>Service category</label>
                            <select name="service_category_id" required>
                                <option value="">Choose category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label>Hired date</label>
                            <input type="date" name="hired_at">
                        </div>
                        <button type="submit" class="button button-primary">Add Staff</button>
                    </form>
                </div>

                <div class="admin-panel">
                    <h3 class="admin-panel-title">Worker Availability — Now</h3>
                    <div class="admin-staff-list">
                        @forelse ($staffMembers as $member)
                            @php
                                $todayBookings = $member->assignedBookings()
                                    ->with('service:id,duration')
                                    ->whereDate('booking_date', today())
                                    ->whereIn('status', ['pending', 'confirmed'])
                                    ->get();

                                $isBusyNow = $todayBookings->contains(function ($booking) use ($now) {
                                    $start = \Carbon\Carbon::parse($booking->booking_date->toDateString().' '.$booking->booking_time->format('H:i'));
                                    $end = $start->copy()->addMinutes((int) ($booking->service?->duration ?? 60));
                                    return $now->between($start, $end);
                                });
                            @endphp
                            <div class="admin-staff-item">
                                <div>
                                    <p class="admin-staff-name">{{ $member->name }}</p>
                                    <p class="admin-staff-meta">{{ $member->role_title ?: 'Staff' }} &mdash; {{ $member->serviceCategory?->name }}</p>
                                </div>
                                <div>
                                    <span class="admin-status-dot {{ $isBusyNow ? 'is-busy' : 'is-free' }}">
                                        {{ $isBusyNow ? 'Booked' : 'Free' }}
                                    </span>
                                    <p class="admin-staff-meta" style="text-align:right; margin-top:0.3rem;">Today: {{ $todayBookings->count() }} booking(s)</p>
                                </div>
                            </div>
                        @empty
                            <p class="admin-empty" style="padding:1rem 0;">No staff members yet.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </section>

        {{-- ═══ FINANCES SECTION ══════════════════════════════════════ --}}
        <section class="admin-page-section" id="section-finances" style="display:none;">
            <div class="admin-page-header">
                <div>
                    <h1 class="admin-page-title">Finances</h1>
                    <p class="admin-page-sub">Track income, record operational expenses, and view your net balance</p>
                </div>
            </div>

            {{-- Summary cards --}}
            <div class="admin-finance-cards">
                <div class="admin-fin-card admin-fin-card--income">
                    <p class="fin-card-label">Total Income</p>
                    <strong class="fin-card-value">TSh {{ number_format($incomeTotal) }}</strong>
                    <p class="fin-card-hint">Confirmed &amp; completed bookings</p>
                </div>
                <div class="admin-fin-card admin-fin-card--expense">
                    <p class="fin-card-label">Total Expenses</p>
                    <strong class="fin-card-value">TSh {{ number_format($expenseTotal) }}</strong>
                    <p class="fin-card-hint">All recorded operational costs</p>
                </div>
                <div class="admin-fin-card admin-fin-card--payroll">
                    <p class="fin-card-label">Total Payroll</p>
                    <strong class="fin-card-value">TSh {{ number_format($payrollTotal) }}</strong>
                    <p class="fin-card-hint">Staff salaries paid</p>
                </div>
                <div class="admin-fin-card admin-fin-card--net {{ $netTotal >= 0 ? 'is-positive' : 'is-negative' }}">
                    <p class="fin-card-label">Net Balance</p>
                    <strong class="fin-card-value">TSh {{ number_format($netTotal) }}</strong>
                    <p class="fin-card-hint">Income &minus; Expenses &minus; Payroll</p>
                </div>
            </div>

            {{-- Record expense form + recent list --}}
            <div class="admin-two-col" style="margin-top:1.5rem;">
                <div class="admin-panel">
                    <h3 class="admin-panel-title">Record Expense</h3>
                    <form method="POST" action="{{ route('admin.expenses.store') }}" class="admin-form-grid">
                        @csrf
                        <div>
                            <label>Expense title</label>
                            <input type="text" name="title" required>
                        </div>
                        <div>
                            <label>Category</label>
                            <input type="text" name="category" placeholder="Utilities, Supplies, Rent...">
                        </div>
                        <div>
                            <label>Amount (TSh)</label>
                            <input type="number" step="0.01" min="0" name="amount" required>
                        </div>
                        <div>
                            <label>Expense date</label>
                            <input type="date" name="expense_date" required>
                        </div>
                        <div style="grid-column: 1 / -1;">
                            <label>Notes</label>
                            <textarea rows="3" name="notes"></textarea>
                        </div>
                        <button type="submit" class="button button-primary">Save Expense</button>
                    </form>
                </div>

                <div class="admin-panel">
                    <h3 class="admin-panel-title">Recent Expenses</h3>
                    <div class="admin-simple-list">
                        @forelse ($expenses as $expense)
                            <div class="admin-simple-item">
                                <div>
                                    <strong>{{ $expense->title }}</strong>
                                    <div class="admin-staff-meta">{{ $expense->expense_date->format('d M Y') }}{{ $expense->category ? ' &mdash; '.$expense->category : '' }}</div>
                                </div>
                                <strong style="color:#8f3a3a;">TSh {{ number_format((float) $expense->amount) }}</strong>
                            </div>
                        @empty
                            <p class="admin-empty" style="padding:0.6rem 0;">No expenses recorded yet.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </section>

        {{-- ═══ PAYROLL SECTION ═══════════════════════════════════════ --}}
        <section class="admin-page-section" id="section-payroll" style="display:none;">
            <div class="admin-page-header">
                <div>
                    <h1 class="admin-page-title">Payroll</h1>
                    <p class="admin-page-sub">Manage staff salary payments and view payroll history</p>
                </div>
                <div class="admin-header-stats">
                    <div class="header-stat">
                        <span class="header-stat-num" style="font-size:1rem;">TSh {{ number_format($payrollTotal) }}</span>
                        <span class="header-stat-lbl">Total Paid</span>
                    </div>
                    <div class="header-stat">
                        <span class="header-stat-num">{{ $staffMembers->count() }}</span>
                        <span class="header-stat-lbl">Staff</span>
                    </div>
                </div>
            </div>

            <div class="admin-two-col">
                <div class="admin-panel">
                    <h3 class="admin-panel-title">Record Payroll</h3>
                    <form method="POST" action="{{ route('admin.payroll.store') }}" class="admin-form-grid">
                        @csrf
                        <div>
                            <label>Staff member</label>
                            <select name="staff_id" required>
                                <option value="">Choose staff</option>
                                @foreach ($staffMembers as $member)
                                    <option value="{{ $member->id }}">{{ $member->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label>Amount (TSh)</label>
                            <input type="number" step="0.01" min="0" name="amount" required>
                        </div>
                        <div>
                            <label>Pay date</label>
                            <input type="date" name="pay_date" required>
                        </div>
                        <div style="grid-column: 1 / -1;">
                            <label>Notes</label>
                            <textarea rows="3" name="notes"></textarea>
                        </div>
                        <button type="submit" class="button button-primary">Save Payroll</button>
                    </form>
                </div>

                <div class="admin-panel">
                    <h3 class="admin-panel-title">Per-Staff Summary</h3>
                    <div class="admin-staff-list">
                        @foreach($staffMembers as $member)
                            @php
                                $memberTotal = $payrolls->where('staff_id', $member->id)->sum('amount');
                            @endphp
                            <div class="admin-staff-item">
                                <div>
                                    <p class="admin-staff-name">{{ $member->name }}</p>
                                    <p class="admin-staff-meta">{{ $member->role_title ?: $member->serviceCategory?->name }}</p>
                                </div>
                                <strong style="font-size:0.85rem;">TSh {{ number_format($memberTotal) }}</strong>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="admin-panel" style="margin-top:1rem;">
                <h3 class="admin-panel-title">Payroll History</h3>
                <div class="admin-simple-list">
                    @forelse ($payrolls as $payroll)
                        <div class="admin-simple-item">
                            <div>
                                <strong>{{ $payroll->staff?->name ?? 'Staff' }}</strong>
                                <div class="admin-staff-meta">{{ $payroll->pay_date->format('d M Y') }}{{ $payroll->notes ? ' &mdash; '.$payroll->notes : '' }}</div>
                            </div>
                            <strong style="color:#2d6b35;">TSh {{ number_format((float) $payroll->amount) }}</strong>
                        </div>
                    @empty
                        <p class="admin-empty" style="padding:0.6rem 0;">No payroll entries recorded yet.</p>
                    @endforelse
                </div>
            </div>
        </section>

        {{-- ═══ SERVICES SECTION ══════════════════════════════════════ --}}
        <section class="admin-page-section" id="section-services" style="display:none;">
            <div class="admin-page-header">
                <div>
                    <h1 class="admin-page-title">Services</h1>
                    <p class="admin-page-sub">Manage services, pricing, and service durations</p>
                </div>
            </div>

            <div class="admin-two-col">
                <div class="admin-panel">
                    <h3 class="admin-panel-title">Add New Service</h3>
                    <form method="POST" action="{{ route('admin.services.store') }}" class="admin-form-grid" enctype="multipart/form-data">
                        @csrf
                        <div>
                            <label>Service name</label>
                            <input type="text" name="name" placeholder="e.g., Facial, Massage, Pedicure" required>
                        </div>
                        <div>
                            <label>Category</label>
                            <select name="category_id" required>
                                <option value="">Choose category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label>Price (TSh)</label>
                            <input type="number" step="0.01" min="0" name="price" placeholder="0.00" required>
                        </div>
                        <div>
                            <label>Duration (minutes)</label>
                            <input type="number" step="15" min="15" name="duration" value="60" required>
                        </div>
                        <div style="grid-column: 1 / -1;">
                            <label>Description</label>
                            <textarea rows="3" name="description" placeholder="Brief description of the service..."></textarea>
                        </div>
                        <div style="grid-column: 1 / -1;">
                            <label>Background image (optional)</label>
                            <input type="file" name="background_image" accept="image/png,image/jpeg,image/webp">
                        </div>
                        <div style="display:flex;align-items:center;gap:0.5rem;">
                            <input type="hidden" name="is_active" value="0">
                            <input type="checkbox" name="is_active" value="1" id="service_active" checked>
                            <label for="service_active" style="margin:0;">Active service</label>
                        </div>
                        <button type="submit" class="button button-primary">Create Service</button>
                    </form>
                </div>

                <div class="admin-panel">
                    <h3 class="admin-panel-title">All Services</h3>
                    <div class="admin-service-list">
                        @forelse ($services as $service)
                            <div class="admin-service-item">
                                <div style="flex:1;">
                                    <strong class="admin-service-name">{{ $service->name }}</strong>
                                    <div class="admin-staff-meta">{{ $service->category?->name }}</div>
                                    <div class="admin-staff-meta">{{ $service->duration }} min • TSh {{ number_format($service->price) }}</div>
                                    <div class="admin-staff-meta">{{ $service->is_active ? 'Active' : 'Inactive' }}</div>
                                    @if($service->image)
                                        <div class="admin-staff-meta">Custom background image added</div>
                                    @endif
                                </div>
                                <div class="admin-actions" style="display:flex;gap:0.5rem;min-width:fit-content;">
                                    <button type="button" class="admin-btn admin-btn-secondary" onclick="toggleEditor('service-editor-{{ $service->id }}')">Edit</button>
                                    <form method="POST" action="{{ route('admin.services.destroy', $service) }}" style="margin:0;" onsubmit="return confirm('Delete this service? This cannot be undone if bookings exist.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="admin-btn admin-btn-cancel">Delete</button>
                                    </form>
                                </div>
                            </div>
                            <div id="service-editor-{{ $service->id }}" class="admin-inline-editor" hidden>
                                <form method="POST" action="{{ route('admin.services.update', $service) }}" class="admin-form-grid" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div>
                                        <label>Service name</label>
                                        <input type="text" name="name" value="{{ $service->name }}" required>
                                    </div>
                                    <div>
                                        <label>Category</label>
                                        <select name="category_id" required>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}" @selected($service->category_id === $category->id)>{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label>Price (TSh)</label>
                                        <input type="number" step="0.01" min="0" name="price" value="{{ $service->price }}" required>
                                    </div>
                                    <div>
                                        <label>Duration (minutes)</label>
                                        <input type="number" step="15" min="15" name="duration" value="{{ $service->duration }}" required>
                                    </div>
                                    <div style="grid-column: 1 / -1;">
                                        <label>Description</label>
                                        <textarea rows="3" name="description">{{ $service->description }}</textarea>
                                    </div>
                                    <div style="grid-column: 1 / -1;">
                                        <label>Replace background image (optional)</label>
                                        <input type="file" name="background_image" accept="image/png,image/jpeg,image/webp">
                                        @if($service->image)
                                            <div class="admin-image-preview-wrap">
                                                <img src="{{ $service->image }}" alt="{{ $service->name }} background" class="admin-image-preview">
                                            </div>
                                        @endif
                                    </div>
                                    <div class="admin-inline-editor-toggle">
                                        <input type="hidden" name="is_active" value="0">
                                        <input type="checkbox" name="is_active" value="1" id="service_active_{{ $service->id }}" @checked($service->is_active)>
                                        <label for="service_active_{{ $service->id }}" style="margin:0;">Active service</label>
                                    </div>
                                    <div class="admin-inline-editor-actions">
                                        <button type="submit" class="button button-primary">Save Service</button>
                                        <button type="button" class="admin-btn admin-btn-secondary" onclick="toggleEditor('service-editor-{{ $service->id }}')">Cancel</button>
                                    </div>
                                </form>
                            </div>
                        @empty
                            <p class="admin-empty" style="padding:0.6rem 0;">No services yet. Create one to get started.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </section>

        {{-- ═══ CATEGORIES SECTION ════════════════════════════════════ --}}
        <section class="admin-page-section" id="section-categories" style="display:none;">
            <div class="admin-page-header">
                <div>
                    <h1 class="admin-page-title">Service Categories</h1>
                    <p class="admin-page-sub">Organize services into categories for better management</p>
                </div>
            </div>

            <div class="admin-two-col">
                <div class="admin-panel">
                    <h3 class="admin-panel-title">Add Category</h3>
                    <form method="POST" action="{{ route('admin.categories.store') }}" class="admin-form-grid">
                        @csrf
                        <div>
                            <label>Category name</label>
                            <input type="text" name="name" placeholder="e.g., Hair, Nails, Skincare" required>
                        </div>
                        <div style="grid-column: 1 / -1;">
                            <label>Description</label>
                            <textarea rows="3" name="description" placeholder="What services are in this category?"></textarea>
                        </div>
                        <button type="submit" class="button button-primary">Create Category</button>
                    </form>
                </div>

                <div class="admin-panel">
                    <h3 class="admin-panel-title">All Categories</h3>
                    <div class="admin-category-list">
                        @forelse ($categories as $category)
                            @php $serviceCount = $category->services_count; @endphp
                            <div class="admin-category-item">
                                <div>
                                    <strong class="admin-category-name">{{ $category->name }}</strong>
                                    <div class="admin-staff-meta">{{ $serviceCount }} service(s)</div>
                                    @if($category->description)
                                        <div class="admin-staff-meta" style="font-size:0.75rem;">{{ $category->description }}</div>
                                    @endif
                                </div>
                                <div class="admin-actions" style="display:flex;gap:0.5rem;min-width:fit-content;">
                                    <button type="button" class="admin-btn admin-btn-secondary" onclick="toggleEditor('category-editor-{{ $category->id }}')">Edit</button>
                                    <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" style="margin:0;" onsubmit="return confirm('Delete this category?{{ $serviceCount > 0 ? ' It has '.$serviceCount.' service(s).' : '' }}');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="admin-btn admin-btn-cancel" {{ $serviceCount > 0 ? 'disabled title="Cannot delete categories with services"' : '' }}>Delete</button>
                                    </form>
                                </div>
                            </div>
                            <div id="category-editor-{{ $category->id }}" class="admin-inline-editor" hidden>
                                <form method="POST" action="{{ route('admin.categories.update', $category) }}" class="admin-form-grid">
                                    @csrf
                                    @method('PUT')
                                    <div>
                                        <label>Category name</label>
                                        <input type="text" name="name" value="{{ $category->name }}" required>
                                    </div>
                                    <div style="grid-column: 1 / -1;">
                                        <label>Description</label>
                                        <textarea rows="3" name="description">{{ $category->description }}</textarea>
                                    </div>
                                    <div class="admin-inline-editor-actions">
                                        <button type="submit" class="button button-primary">Save Category</button>
                                        <button type="button" class="admin-btn admin-btn-secondary" onclick="toggleEditor('category-editor-{{ $category->id }}')">Cancel</button>
                                    </div>
                                </form>
                            </div>
                        @empty
                            <p class="admin-empty" style="padding:0.6rem 0;">No categories yet. Create one to organize your services.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </section>

        {{-- ═══ ANALYTICS SECTION ═════════════════════════════════════ --}}
        <section class="admin-page-section" id="section-analytics" style="display:none;">
            <div class="admin-page-header">
                <div>
                    <h1 class="admin-page-title">Analytics</h1>
                    <p class="admin-page-sub">Performance, revenue and service trends in one place</p>
                </div>
            </div>

            <div class="admin-overview-grid">
                <div class="overview-card overview-card--gold">
                    <p class="overview-card-label">Total Bookings</p>
                    <p class="overview-card-value">{{ $totalCount }}</p>
                </div>
                <div class="overview-card">
                    <p class="overview-card-label">Revenue</p>
                    <p class="overview-card-value" style="font-size:1.25rem;">TSh {{ number_format($incomeTotal) }}</p>
                </div>
                <div class="overview-card">
                    <p class="overview-card-label">Customers</p>
                    <p class="overview-card-value">{{ $totalCustomers }}</p>
                </div>
                <div class="overview-card">
                    <p class="overview-card-label">Pending Reviews</p>
                    <p class="overview-card-value">{{ $pendingReviews->count() }}</p>
                </div>
            </div>

            <div class="admin-two-col" style="margin-top:1.5rem;">
                <div class="admin-panel">
                    <h3 class="admin-panel-title">Bookings by Service</h3>
                    <div class="admin-simple-list">
                        @forelse ($bookingsByService as $item)
                            <div class="admin-simple-item">
                                <strong>{{ $item['service'] }}</strong>
                                <strong>{{ $item['count'] }}</strong>
                            </div>
                        @empty
                            <p class="admin-empty" style="padding:0.6rem 0;">No bookings yet.</p>
                        @endforelse
                    </div>
                </div>

                <div class="admin-panel">
                    <h3 class="admin-panel-title">Staff Performance</h3>
                    <div class="admin-simple-list">
                        @forelse ($staffPerformance as $item)
                            <div class="admin-simple-item">
                                <div>
                                    <strong>{{ $item['name'] }}</strong>
                                    <div class="admin-staff-meta">{{ $item['bookings'] }} bookings • {{ $item['reviews'] }} reviews</div>
                                </div>
                                <strong>⭐ {{ $item['rating'] }}</strong>
                            </div>
                        @empty
                            <p class="admin-empty" style="padding:0.6rem 0;">No staff performance data available.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </section>

        {{-- ═══ BROADCASTS SECTION ════════════════════════════════════ --}}
        <section class="admin-page-section" id="section-broadcasts" style="display:none;">
            <div class="admin-page-header">
                <div>
                    <h1 class="admin-page-title">Broadcasts</h1>
                    <p class="admin-page-sub">Send one message to all customers with booking history</p>
                </div>
            </div>

            <div class="admin-two-col">
                <div class="admin-panel">
                    <h3 class="admin-panel-title">Create Broadcast</h3>
                    <form method="POST" action="{{ route('admin.broadcasts.store') }}" class="admin-form-grid">
                        @csrf
                        <div>
                            <label>Subject</label>
                            <input type="text" name="title" required>
                        </div>
                        <div style="grid-column: 1 / -1;">
                            <label>Message</label>
                            <textarea name="message" rows="6" required></textarea>
                        </div>
                        <button type="submit" class="button button-primary">Send Broadcast</button>
                    </form>
                </div>

                <div class="admin-panel">
                    <h3 class="admin-panel-title">Recent Broadcasts</h3>
                    <div class="admin-simple-list">
                        @forelse ($broadcasts as $broadcast)
                            <div class="admin-simple-item">
                                <div>
                                    <strong>{{ $broadcast->title }}</strong>
                                    <div class="admin-staff-meta">{{ $broadcast->created_at->format('d M Y H:i') }} • {{ $broadcast->recipient_count }} recipients</div>
                                </div>
                                <span class="admin-status-dot {{ $broadcast->isSent() ? 'is-free' : 'is-busy' }}">
                                    {{ $broadcast->isSent() ? 'Sent' : 'Pending' }}
                                </span>
                            </div>
                        @empty
                            <p class="admin-empty" style="padding:0.6rem 0;">No broadcasts yet.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </section>

        {{-- ═══ REVIEWS SECTION ═══════════════════════════════════════ --}}
        <section class="admin-page-section" id="section-reviews" style="display:none;">
            <div class="admin-page-header">
                <div>
                    <h1 class="admin-page-title">Reviews</h1>
                    <p class="admin-page-sub">Moderate customer reviews before publishing</p>
                </div>
            </div>

            <div class="admin-panel">
                <h3 class="admin-panel-title">Pending Reviews</h3>
                <div class="admin-simple-list">
                    @forelse ($pendingReviews as $review)
                        <div class="admin-simple-item" style="align-items:flex-start;">
                            <div>
                                <strong>{{ $review->user->name }} on {{ $review->service->name }}</strong>
                                <div class="admin-staff-meta">Rating: {{ str_repeat('★', (int) $review->rating) }}{{ str_repeat('☆', 5 - (int) $review->rating) }}</div>
                                @if ($review->comment)
                                    <div class="admin-staff-meta" style="margin-top:0.4rem;max-width:560px;">{{ $review->comment }}</div>
                                @endif
                            </div>
                            <div class="admin-actions">
                                <form method="POST" action="{{ route('admin.reviews.approve', $review) }}">
                                    @csrf
                                    <button type="submit" class="admin-btn admin-btn-approve">Approve</button>
                                </form>
                                <form method="POST" action="{{ route('admin.reviews.delete', $review) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="admin-btn admin-btn-cancel" onclick="return confirm('Delete this review?')">Reject</button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <p class="admin-empty" style="padding:0.6rem 0;">No pending reviews.</p>
                    @endforelse
                </div>
            </div>
        </section>

        {{-- ═══ AVAILABILITY SECTION ══════════════════════════════════ --}}
        <section class="admin-page-section" id="section-availability" style="display:none;">
            <div class="admin-page-header">
                <div>
                    <h1 class="admin-page-title">Staff Availability</h1>
                    <p class="admin-page-sub">Upcoming assignments and workload for each team member</p>
                </div>
            </div>

            <div class="admin-panel">
                <h3 class="admin-panel-title">Next 30 Days</h3>
                <div class="admin-staff-list">
                    @forelse ($availabilityStaff as $member)
                        <div class="admin-staff-item" style="display:block;">
                            <div style="display:flex;justify-content:space-between;gap:1rem;align-items:flex-start;">
                                <div>
                                    <p class="admin-staff-name">{{ $member->name }}</p>
                                    <p class="admin-staff-meta">{{ $member->serviceCategory?->name }} Specialist</p>
                                </div>
                                <span class="admin-status-dot">{{ $member->assignedBookings->count() }} booked</span>
                            </div>

                            @if ($member->assignedBookings->isNotEmpty())
                                <div class="admin-simple-list" style="margin-top:0.8rem;">
                                    @foreach ($member->assignedBookings->take(5) as $booking)
                                        <div class="admin-simple-item">
                                            <span>{{ $booking->service?->name ?? 'Service' }}</span>
                                            <span>{{ $booking->booking_date->format('d M') }} {{ $booking->booking_time->format('H:i') }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="admin-empty" style="padding:0.6rem 0 0;">No upcoming bookings.</p>
                            @endif
                        </div>
                    @empty
                        <p class="admin-empty" style="padding:0.6rem 0;">No active staff members.</p>
                    @endforelse
                </div>
            </div>
        </section>

        <p style="text-align:center;font-size:0.72rem;color:rgba(58,45,31,0.35);margin-top:2rem;padding-bottom:1rem;">
            &copy; {{ date('Y') }} Ngome Technologies &mdash; Business solutions for emerging markets
        </p>
    </main>
</div>

<script>
(function () {
    const SECTIONS = ['overview','orders','staff','finances','payroll','services','categories','analytics','broadcasts','reviews','availability'];

    window.toggleEditor = function (id) {
        const editor = document.getElementById(id);

        if (!editor) return;

        editor.hidden = !editor.hidden;

        if (!editor.hidden) {
            editor.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }
    };

    function showSection(name) {
        if (!SECTIONS.includes(name)) name = 'overview';

        SECTIONS.forEach(function (id) {
            const el = document.getElementById('section-' + id);
            if (el) el.style.display = id === name ? '' : 'none';
        });

        document.querySelectorAll('#adminNav .admin-nav-item[data-section]').forEach(function (a) {
            a.classList.toggle('is-active', a.dataset.section === name);
        });

        // Overview cards that navigate to a section
        document.querySelectorAll('[data-goto]').forEach(function (card) {
            card.style.cursor = 'pointer';
            card.onclick = function () { showSection(card.dataset.goto); };
        });

        sessionStorage.setItem('bellaraSection', name);
        window.scrollTo(0, 0);
    }

    // Bind nav clicks
    document.querySelectorAll('#adminNav .admin-nav-item[data-section]').forEach(function (a) {
        a.addEventListener('click', function (e) {
            e.preventDefault();
            showSection(a.dataset.section);
        });
    });

    // Restore last section or default to overview
    const serverSection = @json($activeSection);
    const saved = (serverSection && SECTIONS.includes(serverSection) ? serverSection : null)
        || sessionStorage.getItem('bellaraSection')
        || 'overview';
    showSection(saved);

    // If a form was submitted and redirected back, check for a flash → stay on relevant section
    @if(session('admin_success'))
        const msg = @json(session('admin_success'));
        if (msg.toLowerCase().includes('staff')) showSection('staff');
        else if (msg.toLowerCase().includes('expense')) showSection('finances');
        else if (msg.toLowerCase().includes('payroll')) showSection('payroll');
        else if (msg.toLowerCase().includes('review')) showSection('reviews');
        else if (msg.toLowerCase().includes('message') || msg.toLowerCase().includes('broadcast')) showSection('broadcasts');
        else if (msg.toLowerCase().includes('service')) showSection('services');
        else if (msg.toLowerCase().includes('category')) showSection('categories');
        else if (msg.toLowerCase().includes('booking') || msg.toLowerCase().includes('approved') || msg.toLowerCase().includes('cancel')) showSection('orders');
    @endif
})();
</script>
</body>
</html>

