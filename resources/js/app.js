document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('booking-form');

    if (!form) {
        return;
    }

    const serviceSelect = document.getElementById('service_id');
    const preferredStaffSelect = document.getElementById('preferred_staff_id');
    const dateInput = document.getElementById('booking_date');
    const timeSelect = document.getElementById('booking_time');
    const availabilityStatus = document.getElementById('availability-status');
    const slotPreview = document.getElementById('slot-preview');

    const availabilityUrl = form.dataset.availabilityUrl;

    const resetTimeInput = (message) => {
        timeSelect.innerHTML = `<option value="">${message}</option>`;
        timeSelect.disabled = true;
        slotPreview.innerHTML = '';
    };

    const renderSlots = (slots) => {
        slotPreview.innerHTML = '';

        slots.forEach((slot) => {
            const pill = document.createElement('span');
            pill.className = `slot-pill ${slot.available ? 'is-open' : 'is-closed'}`;
            pill.textContent = slot.time;
            slotPreview.appendChild(pill);
        });
    };

    const loadAvailability = async () => {
        const serviceId = serviceSelect.value;
        const preferredStaffId = preferredStaffSelect?.value || '';
        const date = dateInput.value;

        if (!serviceId || !date) {
            resetTimeInput('Choose service and date first');
            availabilityStatus.textContent = '';
            return;
        }

        availabilityStatus.textContent = 'Checking available times...';

        try {
            const response = await fetch(`${availabilityUrl}?service_id=${encodeURIComponent(serviceId)}&date=${encodeURIComponent(date)}&preferred_staff_id=${encodeURIComponent(preferredStaffId)}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                },
            });

            if (!response.ok) {
                throw new Error('Unable to fetch availability');
            }

            const data = await response.json();
            const availableSlots = data.available_slots || [];

            if (!availableSlots.length) {
                resetTimeInput('No slots available for this date');
                availabilityStatus.textContent = 'This date is currently fully booked.';
                renderSlots(data.slots || []);
                return;
            }

            timeSelect.innerHTML = '<option value="">Select time</option>';
            availableSlots.forEach((slot) => {
                const option = document.createElement('option');
                option.value = slot;
                option.textContent = slot;
                timeSelect.appendChild(option);
            });
            timeSelect.disabled = false;

            availabilityStatus.textContent = `${availableSlots.length} slot(s) available on selected date.`;
            renderSlots(data.slots || []);
        } catch (error) {
            resetTimeInput('Could not load availability');
            availabilityStatus.textContent = 'Could not load availability. Please try again.';
        }
    };

    serviceSelect.addEventListener('change', loadAvailability);
    preferredStaffSelect?.addEventListener('change', loadAvailability);
    dateInput.addEventListener('change', loadAvailability);

    if (serviceSelect.value && dateInput.value) {
        loadAvailability();
    }
});

// ── Cart ──────────────────────────────────────────────────────────────────────
document.addEventListener('DOMContentLoaded', () => {
    const CART_KEY = 'bellara_cart';

    const getCart = () => {
        try { return JSON.parse(localStorage.getItem(CART_KEY)) || []; }
        catch { return []; }
    };

    const saveCart = (cart) => localStorage.setItem(CART_KEY, JSON.stringify(cart));

    const esc = (s) => String(s)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;');

    const toast = (msg) => {
        const el = document.createElement('div');
        el.className = 'cart-toast';
        el.textContent = msg;
        document.body.appendChild(el);
        requestAnimationFrame(() => el.classList.add('cart-toast--show'));
        setTimeout(() => {
            el.classList.remove('cart-toast--show');
            setTimeout(() => el.remove(), 300);
        }, 2000);
    };

    const syncCart = () => {
        const cart = getCart();
        const itemsEl = document.getElementById('cart-items');
        const footerEl = document.getElementById('cart-footer');
        const badgeEl = document.getElementById('cart-badge');
        const totalPriceEl = document.getElementById('cart-total-price');
        const totalDurEl = document.getElementById('cart-total-duration');
        const bookBtn = document.getElementById('cart-book-btn');

        if (!itemsEl) return;

        // Badge
        if (cart.length > 0) {
            badgeEl.removeAttribute('hidden');
            badgeEl.textContent = cart.length;
        } else {
            badgeEl.setAttribute('hidden', '');
        }

        // Items list
        if (cart.length === 0) {
            itemsEl.innerHTML = '<p class="cart-empty">No services added yet.<br><small>Tap &ldquo;+ Add&rdquo; on any service to get started.</small></p>';
            footerEl.setAttribute('hidden', '');
        } else {
            itemsEl.innerHTML = cart.map((item) => `
                <div class="cart-item">
                    <div class="cart-item-info">
                        <p class="cart-item-name">${esc(item.name)}</p>
                        <span class="cart-item-meta">TSh ${item.price.toFixed(2)} &middot; ${item.duration} mins</span>
                    </div>
                    <button class="cart-item-remove" data-remove="${esc(item.id)}" aria-label="Remove ${esc(item.name)}" type="button">&#x2715;</button>
                </div>
            `).join('');

            totalPriceEl.textContent = `TSh ${cart.reduce((s, i) => s + i.price, 0).toFixed(2)}`;
            totalDurEl.textContent = cart.reduce((s, i) => s + i.duration, 0);
            footerEl.removeAttribute('hidden');
            bookBtn.textContent = cart.length === 1 ? 'Book This Service \u2192' : 'Book First Service \u2192';
        }

        // Highlight cards that are in the cart
        document.querySelectorAll('.service-card[data-id]').forEach((card) => {
            const inCart = cart.some((i) => String(i.id) === String(card.dataset.id));
            card.classList.toggle('in-cart', inCart);
            const btn = card.querySelector('.add-to-cart-btn');
            if (btn) btn.textContent = inCart ? '\u2713 Added' : '+ Add';
        });
    };

    const openCart = () => {
        document.getElementById('cart-drawer').classList.add('is-open');
        document.getElementById('cart-overlay').classList.add('is-open');
    };

    const closeCart = () => {
        document.getElementById('cart-drawer').classList.remove('is-open');
        document.getElementById('cart-overlay').classList.remove('is-open');
    };

    // Toggle / close
    document.getElementById('cart-toggle')?.addEventListener('click', openCart);
    document.getElementById('cart-close')?.addEventListener('click', closeCart);
    document.getElementById('cart-overlay')?.addEventListener('click', closeCart);

    // Clear cart
    document.getElementById('cart-clear-btn')?.addEventListener('click', () => {
        saveCart([]);
        syncCart();
    });

    // Book first item — pre-fills the booking form and scrolls to it
    document.getElementById('cart-book-btn')?.addEventListener('click', () => {
        const cart = getCart();
        if (!cart.length) return;
        const serviceSelect = document.getElementById('service_id');
        if (serviceSelect) {
            serviceSelect.value = String(cart[0].id);
            serviceSelect.dispatchEvent(new Event('change'));
        }
        closeCart();
        document.getElementById('book')?.scrollIntoView({ behavior: 'smooth' });
    });

    // Add / toggle a service via the "Add" button on each card
    document.addEventListener('click', (e) => {
        const btn = e.target.closest('.add-to-cart-btn');
        if (!btn) return;
        const card = btn.closest('.service-card[data-id]');
        if (!card) return;

        const { id, name, price, duration } = card.dataset;
        const cart = getCart();
        const idx = cart.findIndex((i) => String(i.id) === String(id));

        if (idx !== -1) {
            cart.splice(idx, 1);
            saveCart(cart);
            toast(`${name} removed`);
        } else {
            cart.push({ id, name, price: parseFloat(price), duration: parseInt(duration, 10) });
            saveCart(cart);
            toast(`${name} added to cart`);
        }
        syncCart();
    });

    // Remove from inside the drawer
    document.getElementById('cart-items')?.addEventListener('click', (e) => {
        const btn = e.target.closest('.cart-item-remove');
        if (!btn) return;
        saveCart(getCart().filter((i) => String(i.id) !== String(btn.dataset.remove)));
        syncCart();
    });

    // Initialise on load
    syncCart();

    // Clear cart after a successful booking (server sets data-booking-success on <body>)
    if (document.body.dataset.bookingSuccess === '1') {
        saveCart([]);
        syncCart();
    }
});
