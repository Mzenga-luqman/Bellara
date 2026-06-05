<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bellara Beauty & Spa Lounge</title>
    <meta name="description" content="Luxury white-and-gold spa experience. Explore services, check availability, and book your Bellara appointment.">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=Manrope:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bellara-body" @if(session('booking_success')) data-booking-success="1" @endif>
    @php
        $galleryReady = collect($galleryImages)->every(fn ($image) => file_exists(public_path(ltrim($image, '/'))));
    @endphp

    <header class="site-header">
        <div class="container shell nav-wrap">
            <div class="brand-lockup">
                <p class="brand-script">Bellara</p>
                <p class="brand-subtitle">Beauty & Spa Lounge</p>
            </div>
            <div class="header-actions">
                @auth
                    <a href="{{ route('dashboard') }}" class="button button-ghost" style="font-size:0.78rem;padding:0.5rem 0.9rem;">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="button button-ghost" style="font-size:0.78rem;padding:0.5rem 0.9rem;">Admin Login</a>
                @endauth
                <button class="cart-fab" id="cart-toggle" type="button" aria-label="View cart">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                    Cart
                    <span class="cart-badge" id="cart-badge" hidden>0</span>
                </button>
                <a href="#book" class="button button-primary">Book Appointment</a>
            </div>
        </div>
    </header>

    <main>
        @if (session('booking_success'))
            <section class="container shell notice-wrap">
                <div class="booking-success-banner" role="status" aria-live="polite">
                    {{ session('booking_success') }}
                </div>
            </section>
        @endif

        <section class="hero section-shell">
            <div class="container shell hero-grid">
                <div class="hero-copy reveal">
                    <p class="eyebrow">Luxury Wellness Destination</p>
                    <h1>Experience Bellara Elegance in Every Ritual</h1>
                    <p>
                        Discover elevated beauty and spa care with curated treatments in nails, massage,
                        facial therapies, waxing, sauna, body scrub, and sculpting.
                    </p>
                    <div class="hero-cta-row">
                        <a href="#services" class="button button-primary">Explore Services</a>
                        <a href="#book" class="button button-ghost">Check Availability</a>
                    </div>
                </div>
                <div class="hero-media reveal delay-1">
                    <div class="image-frame">
                        <img src="{{ $galleryImages[0] }}" alt="Bellara reception" loading="lazy">
                    </div>
                    <div class="floating-note">White. Gold. Serenity.</div>
                </div>
            </div>
        </section>

        @if (! $galleryReady)
            <section class="container shell notice-wrap">
                <div class="photo-notice">
                    Place Bellara brand photos here with these exact filenames so the site uses them automatically:
                    1) reception.jpg 2) lounge-smile.jpg 3) lounge-champagne.jpg 4) massage-rest.jpg 5) massage-stones.jpg
                </div>
            </section>
        @endif

        <section id="services" class="section-shell">
            <div class="container shell">
                <div class="section-heading reveal">
                    <p class="eyebrow">Curated Treatments</p>
                    <h2>Our Signature Service Collection</h2>
                </div>

                @foreach ($categories as $category)
                    <article class="category-panel reveal">
                        <header class="category-header">
                            <h3>{{ $category->name }}</h3>
                            <p>{{ $category->description }}</p>
                        </header>
                        <div class="service-grid">
                            @foreach ($category->services as $service)
                                @php
                                    $focusPositions = [
                                        'Signature Manicure' => 'center 42%',
                                        'Classic Pedicure' => 'center 58%',
                                        'Gel Manicure' => 'center 40%',
                                        'Swedish Massage' => 'center 46%',
                                        'Deep Tissue Massage' => 'center 44%',
                                        'Hot Stone Massage' => 'center 48%',
                                        'Hydrating Facial' => 'center 35%',
                                        'Brightening Facial' => 'center 34%',
                                        'Anti-Aging Facial' => 'center 38%',
                                        'Bikini Wax' => 'center 42%',
                                        'Full Leg Wax' => 'center 45%',
                                        'Underarm Wax' => 'center 40%',
                                        'Detox Body Scrub' => 'center 43%',
                                        'Body Sculpting Session' => 'center 40%',
                                        'Mineral Mud Wrap' => 'center 44%',
                                        'Infrared Sauna Session' => 'center 52%',
                                        'Steam Sauna Session' => 'center 50%',
                                        'Recovery Wellness Package' => 'center 46%',
                                    ];

                                    $fitSizes = [
                                        'Signature Manicure' => '94% auto',
                                        'Classic Pedicure' => '95% auto',
                                        'Gel Manicure' => '93% auto',
                                        'Swedish Massage' => '96% auto',
                                        'Deep Tissue Massage' => '95% auto',
                                        'Hot Stone Massage' => '94% auto',
                                        'Hydrating Facial' => '92% auto',
                                        'Brightening Facial' => '92% auto',
                                        'Anti-Aging Facial' => '93% auto',
                                        'Bikini Wax' => '94% auto',
                                        'Full Leg Wax' => '95% auto',
                                        'Underarm Wax' => '93% auto',
                                        'Detox Body Scrub' => '95% auto',
                                        'Body Sculpting Session' => '95% auto',
                                        'Mineral Mud Wrap' => '94% auto',
                                        'Infrared Sauna Session' => '97% auto',
                                        'Steam Sauna Session' => '97% auto',
                                        'Recovery Wellness Package' => '96% auto',
                                    ];

                                    $focusPosition = $focusPositions[$service->name] ?? 'center center';
                                    $fitSize = $fitSizes[$service->name] ?? '95% auto';

                                    $cardStyle = $service->image
                                        ? "background-image: linear-gradient(180deg, rgba(33, 24, 17, 0.26), rgba(33, 24, 17, 0.66)), url('".e($service->image)."'); background-size: cover, {$fitSize}; background-position: center center, {$focusPosition}; background-repeat: no-repeat, no-repeat;"
                                        : null;
                                @endphp
                                <div class="service-card"
                                     @class(['has-image' => filled($service->image)])
                                     @if($cardStyle) style="{{ $cardStyle }}" @endif
                                     data-id="{{ $service->id }}"
                                     data-name="{{ $service->name }}"
                                     data-price="{{ $service->price }}"
                                     data-duration="{{ $service->duration }}">
                                    <div class="service-content-glow">
                                        <h4>{{ $service->name }}</h4>
                                        <p>{{ $service->description }}</p>
                                        <div class="service-meta">
                                            <span>TSh {{ number_format((float) $service->price, 2) }}</span>
                                            <span>{{ $service->duration }} mins</span>
                                        </div>
                                           @php
                                               $avgRating = (float) ($service->approved_avg_rating ?? 0);
                                               $reviewCount = (int) ($service->approved_reviews_count ?? 0);
                                           @endphp
                                           @if ($avgRating > 0)
                                               <div style="margin-top: 0.6rem; display: flex; align-items: center; gap: 0.4rem; font-size: 0.85rem;">
                                                   <div style="display: flex; gap: 0.2rem;">
                                                       @for ($i = 0; $i < 5; $i++)
                                                           <span style="color: #ffd700;">{{ $i < floor($avgRating) ? '★' : '☆' }}</span>
                                                       @endfor
                                                   </div>
                                                   <span style="color: #fff; opacity: 0.85;">{{ number_format($avgRating, 1) }}</span>
                                                   @if ($reviewCount > 0)
                                                       <span style="color: #fff; opacity: 0.65; font-size: 0.75rem;">({{ $reviewCount }})</span>
                                                   @endif
                                               </div>
                                           @endif
                                    </div>
                                    <button class="add-to-cart-btn" type="button">+ Add</button>
                                </div>
                            @endforeach
                        </div>
                    </article>
                @endforeach
            </div>
        </section>

        <section class="section-shell">
            <div class="container shell">
                <div class="section-heading reveal">
                    <p class="eyebrow">Bellara Atmosphere</p>
                    <h2>Inspired by your Space and Rituals</h2>
                </div>
                <div class="gallery-grid">
                    @foreach ($galleryImages as $image)
                        <figure class="gallery-card reveal">
                            <img src="{{ $image }}" alt="Bellara experience photo" loading="lazy">
                        </figure>
                    @endforeach
                </div>
            </div>
        </section>

        <section id="book" class="section-shell booking-shell">
            <div class="container shell booking-grid">
                <div class="booking-copy reveal">
                    <p class="eyebrow">Instant Booking</p>
                    <h2>Reserve Your Bellara Moment</h2>
                    <p>
                        Choose your service, date, and available time slot. We will confirm your appointment quickly.
                    </p>
                    <ul class="booking-points">
                        <li>Live time-slot availability</li>
                        <li>Luxury service catalog in one place</li>
                        <li>Fast confirmation workflow</li>
                    </ul>
                </div>

                <div class="booking-card reveal delay-1">
                    @if (session('booking_success'))
                        <p class="alert-success">{{ session('booking_success') }}</p>
                    @endif

                    @if ($errors->any())
                        <div class="alert-error">
                            @foreach ($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif

                    <form id="booking-form" action="{{ route('bookings.store') }}" method="POST" data-availability-url="{{ route('availability.index') }}">
                        @csrf

                        <label for="service_id">Select Service</label>
                        <select id="service_id" name="service_id" required>
                            <option value="">Choose a service</option>
                            @foreach ($services as $service)
                                <option value="{{ $service->id }}" @selected(old('service_id') == $service->id)>
                                    {{ $service->name }} ({{ $service->duration }} mins)
                                </option>
                            @endforeach
                        </select>

                        <label for="preferred_staff_id">Preferred Staff (optional)</label>
                        <select id="preferred_staff_id" name="preferred_staff_id">
                            <option value="">No preference (auto assign)</option>
                            @foreach ($staff as $member)
                                <option value="{{ $member->id }}" @selected(old('preferred_staff_id') == $member->id)>
                                    {{ $member->name }} - {{ $member->serviceCategory?->name }}
                                </option>
                            @endforeach
                        </select>

                        <label for="booking_date">Appointment Date</label>
                        <input id="booking_date" name="booking_date" type="date" value="{{ old('booking_date') }}" min="{{ now()->toDateString() }}" required>

                        <label for="booking_time">Available Time</label>
                        <select id="booking_time" name="booking_time" required disabled>
                            <option value="">Choose service and date first</option>
                        </select>

                        <div id="availability-status" class="availability-status" aria-live="polite"></div>
                        <div id="slot-preview" class="slot-preview"></div>

                        <label for="customer_name">Full Name</label>
                        <input id="customer_name" name="customer_name" type="text" value="{{ old('customer_name') }}" required>

                        <label for="customer_email">Email</label>
                        <input id="customer_email" name="customer_email" type="email" value="{{ old('customer_email') }}" required>

                        <label for="customer_phone">Phone</label>
                        <input id="customer_phone" name="customer_phone" type="text" value="{{ old('customer_phone') }}" required>

                        <label for="notes">Notes (optional)</label>
                        <textarea id="notes" name="notes" rows="3" placeholder="Any preferences or notes">{{ old('notes') }}</textarea>

                        <button class="button button-primary button-full" type="submit">Confirm Booking Request</button>
                    </form>
                </div>
            </div>
        </section>

        <section id="location" class="section-shell">
            <div class="container shell">
                <div class="section-heading reveal">
                    <p class="eyebrow">Find Us</p>
                    <h2>Bellara Near Mwananyamala Bwawani</h2>
                </div>

                <div class="location-grid reveal delay-1">
                    <div class="location-copy">
                        <p>
                            Visit Bellara Beauty &amp; Spa Lounge around Mwananyamala Bwawani, Dar es Salaam.
                            Use the map to quickly locate us and plan your route.
                        </p>
                        <a
                            class="button button-ghost"
                            href="https://www.google.com/maps/search/?api=1&query=Bellara+Beauty+and+Spa+Mwananyamala+Bwawani+Dar+es+Salaam"
                            target="_blank"
                            rel="noopener noreferrer"
                        >
                            Open In Google Maps
                        </a>
                    </div>

                    <div class="location-map-frame" aria-label="Map showing Bellara around Mwananyamala Bwawani">
                        <iframe
                            title="Bellara Beauty and Spa map near Mwananyamala Bwawani"
                            src="https://www.google.com/maps?q=Mwananyamala%20Bwawani%2C%20Dar%20es%20Salaam&z=15&output=embed"
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"
                        ></iframe>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="ngome-footer">
        <div class="container shell ngome-footer-inner">
            <div class="ngome-footer-brand">
                <p class="ngome-wordmark">Ngome Technologies</p>
                <p class="ngome-tagline">Intelligent systems for modern business operations</p>
            </div>
            <p class="ngome-credit">
                Bellara Beauty &amp; Spa Lounge &mdash; powered by
                <span class="ngome-highlight">Ngome Technologies</span>.
                Built to help SMEs operate, control, and scale with confidence.
            </p>
        </div>
    </footer>
    {{-- Cart drawer --}}
    <aside class="cart-drawer" id="cart-drawer" aria-label="Service cart">
        <div class="cart-header">
            <h2>Selected Services</h2>
            <button class="cart-close" id="cart-close" type="button" aria-label="Close cart">&#x2715;</button>
        </div>
        <div class="cart-items" id="cart-items">
            <p class="cart-empty">No services added yet.<br><small>Tap &ldquo;+ Add&rdquo; on any service to get started.</small></p>
        </div>
        <div class="cart-footer" id="cart-footer" hidden>
            <div class="cart-totals">
                <span>Est. total: <strong id="cart-total-price">TSh 0.00</strong></span>
                <span><strong id="cart-total-duration">0</strong> mins</span>
            </div>
            <button class="button button-primary button-full" id="cart-book-btn" type="button">Book This Service &rarr;</button>
            <button class="button button-ghost button-full" id="cart-clear-btn" type="button">Clear Cart</button>
        </div>
    </aside>
    <div class="cart-overlay" id="cart-overlay"></div>
</body>
</html>
