{{-- ============================================================ --}}
{{--  CART WIDGET  –  button + hover preview + full modal popup   --}}
{{-- ============================================================ --}}

{{-- ── 1. Wrapper ─────────────────────────────────────────────── --}}
<div class="relative group" id="cart-widget-wrapper" style="padding-bottom: 4px; margin-bottom: -4px;">

    {{-- Cart button --}}
    <button
        id="cart-btn"
        type="button"
        onclick="openCartModal()"
        class="relative inline-flex items-center justify-center h-10 w-10 rounded-full border border-zinc-300 dark:border-zinc-700 hover:border-zinc-400 dark:hover:border-zinc-500 bg-white dark:bg-zinc-900/50 hover:bg-zinc-100 dark:hover:bg-zinc-900 text-zinc-800 dark:text-zinc-200 hover:text-zinc-950 dark:hover:text-white transition shadow-sm"
        aria-label="Keranjang Belanja"
    >
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" class="w-4 h-4">
            <path d="M6 6h15l-1.5 9h-12z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M6 6l-2-3H2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            <circle cx="9" cy="20" r="1"/>
            <circle cx="18" cy="20" r="1"/>
        </svg>
        <span
            id="cart-badge"
            style="display:none; position:absolute; top:-4px; right:-4px; min-width:1.25rem; height:1.25rem; padding:0 4px; border-radius:9999px; background:#dc2626; color:#fff; font-size:10px; font-weight:700; align-items:center; justify-content:center; line-height:1; box-shadow:0 1px 4px rgba(0,0,0,.3);"
        >0</span>
    </button>

    {{-- ── 2. Hover mini-dropdown ──────────────────────────────── --}}
    <div
        id="cart-hover-dropdown"
        class="absolute right-0 w-80 bg-zinc-900 border border-zinc-800 rounded-2xl shadow-2xl z-[200] opacity-0 translate-y-1 pointer-events-none transition group-hover:opacity-100 group-hover:translate-y-0 group-hover:pointer-events-auto group-focus-within:opacity-100 group-focus-within:translate-y-0 group-focus-within:pointer-events-auto"
        style="top: calc(100% + 4px);"
    >
        <div style="position:absolute; top:-12px; left:0; right:0; height:16px; background:transparent;"></div>

        <div class="flex items-center justify-between px-5 pt-4 pb-3 border-b border-zinc-800">
            <p class="font-bold text-sm text-white" id="cart-hover-title">Keranjang (0)</p>
            <button onclick="openCartModal(); event.stopPropagation();" class="text-blue-400 text-xs font-semibold hover:underline">Lihat Semua</button>
        </div>

        <div id="cart-hover-items" class="divide-y divide-zinc-800 max-h-60 overflow-y-auto"></div>

        <div id="cart-hover-empty" class="p-6 flex flex-col items-center text-center gap-2">
            <svg class="w-10 h-10 text-zinc-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M6 6h15l-1.5 9h-12z" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M6 6l-2-3H2" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                <circle cx="9" cy="20" r="1"/><circle cx="18" cy="20" r="1"/>
            </svg>
            <p class="text-xs font-semibold text-zinc-400">Keranjang masih kosong</p>
        </div>

        <div id="cart-hover-more" class="hidden px-5 py-3 bg-zinc-950/50 border-t border-zinc-800">
            <button onclick="openCartModal()" class="w-full text-xs text-zinc-400 font-semibold hover:text-white transition text-center">
                Tap cart untuk lihat semua →
            </button>
        </div>
    </div>
</div>

{{-- ── 3. Full Cart Modal ──────────────────────────────────────── --}}
<div id="cart-modal" style="display:none; position:fixed; inset:0; z-index:9999; overflow-y:auto;">

    {{-- Backdrop --}}
    <div onclick="closeCartModal()" style="position:fixed; inset:0; background:rgba(0,0,0,0.6); backdrop-filter:blur(4px);"></div>

    {{-- Centering wrapper --}}
    <div style="display:flex; align-items:center; justify-content:center; min-height:100%; padding:1rem;">

        {{-- Panel --}}
        <div style="position:relative; width:100%; max-width:56rem; max-height:90vh; overflow:hidden; display:flex; flex-direction:column; background:#18181b; border-radius:1.5rem; border:1px solid #27272a; box-shadow:0 25px 60px rgba(0,0,0,.25);"
             class="cart-modal-panel">

            {{-- Header --}}
            <div class="flex items-center justify-between px-8 py-5 border-b border-zinc-800 shrink-0">
                <h2 class="text-xl font-bengkel tracking-wider uppercase text-white">
                    Keranjang Belanja
                </h2>
                <button onclick="closeCartModal()" class="text-zinc-400 hover:text-white transition p-1.5 rounded-lg hover:bg-zinc-800">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M6 18L18 6M6 6l12 12" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                </button>
            </div>

            {{-- Body --}}
            <div id="cart-modal-body" style="display:flex; flex:1; overflow:hidden; flex-direction:column;">

                {{-- Left: Items --}}
                <div style="flex:1; overflow-y:auto;">

                    {{-- Controls --}}
                    <div id="cart-modal-controls" class="flex items-center justify-between px-8 py-4 border-b border-zinc-800">
                        <label class="flex items-center gap-2 cursor-pointer text-sm font-semibold text-zinc-300 select-none">
                            <input type="checkbox" id="cart-select-all" onchange="toggleSelectAll(this.checked)" class="w-4 h-4 accent-blue-600 cursor-pointer">
                            Pilih Semua
                        </label>
                        <div class="flex items-center gap-4">
                            <button onclick="cancelSelectedItems()" class="text-xs text-zinc-400 hover:text-zinc-200 font-semibold transition">Batalkan</button>
                            <button onclick="deleteSelectedItems()" class="text-xs text-red-500 hover:text-red-400 font-semibold transition flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                Hapus Pilihan
                            </button>
                        </div>
                    </div>

                    {{-- Empty state --}}
                    <div id="cart-modal-empty" style="display:none; flex-direction:column; align-items:center; justify-content:center; gap:1rem; padding:5rem 2rem; text-align:center;">
                        <div class="w-24 h-24 rounded-full bg-zinc-800 flex items-center justify-center">
                            <svg class="w-12 h-12 text-zinc-650" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M6 6h15l-1.5 9h-12z" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M6 6l-2-3H2" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
                                <circle cx="9" cy="20" r="1"/><circle cx="18" cy="20" r="1"/>
                            </svg>
                        </div>
                        <p class="font-bold text-zinc-300">Keranjangmu masih kosong</p>
                        <p class="text-sm text-zinc-400">Tambahkan produk dari halaman toko dan mulai belanja!</p>
                        @php
                            $belanjaRoute = route('toko.banmotor');
                            if (request()->routeIs('toko.banmotor') || request()->is('*ban*')) {
                                $belanjaRoute = route('toko.banmotor');
                            } elseif (request()->routeIs('toko.oli') || request()->is('*oli*')) {
                                $belanjaRoute = route('toko.oli');
                            } elseif (request()->routeIs('toko.sparepart') || request()->is('*sparepart*')) {
                                $belanjaRoute = route('toko.sparepart');
                            }
                        @endphp
                        <a href="{{ $belanjaRoute }}" onclick="closeCartModal()" class="mt-1 px-6 py-2.5 bg-blue-600 text-white text-sm font-bold rounded-full hover:bg-blue-700 transition inline-block">
                            Belanja Sekarang
                        </a>
                    </div>

                    {{-- Items list --}}
                    <div id="cart-modal-items" class="divide-y divide-zinc-800/60"></div>
                </div>

                {{-- Right: Summary --}}
                <div class="lg:w-80 shrink-0 border-t lg:border-t-0 lg:border-l border-zinc-800 bg-zinc-950/50 p-6 flex flex-col gap-5">
                    <p class="text-xs font-bold uppercase tracking-widest text-zinc-400">Ringkasan Belanja</p>

                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between text-zinc-400">
                            <span id="cart-summary-count">Total harga (0 Barang)</span>
                            <span id="cart-summary-subtotal" class="font-semibold text-white">Rp 0</span>
                        </div>
                        <div class="flex justify-between text-zinc-400">
                            <span>Biaya Layanan</span>
                            <span class="font-semibold text-emerald-400">GRATIS</span>
                        </div>
                        <div class="pt-3 border-t border-zinc-800 flex justify-between items-baseline">
                            <span class="text-sm font-bold text-white">Total</span>
                            <span id="cart-summary-total" class="text-2xl font-bengkel tracking-wider text-white">Rp 0</span>
                        </div>
                    </div>

                    <button
                        id="cart-checkout-btn"
                        onclick="cartCheckout()"
                        disabled
                        class="w-full py-4 bg-blue-600 text-white text-sm font-bold rounded-2xl hover:bg-blue-700 disabled:opacity-40 disabled:cursor-not-allowed transition flex items-center justify-center gap-2 shadow-lg shadow-blue-600/20"
                    >
                        Checkout
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M9 5l7 7-7 7" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                    <p class="text-[10px] text-zinc-500 text-center leading-relaxed">
                        Harga sudah termasuk PPN.<br>Pembayaran COD / Transfer Bank tersedia.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ── 4. Toast notification container ────────────────────────── --}}
<div id="cart-toast" style="position:fixed; bottom:1.5rem; left:50%; transform:translateX(-50%) translateY(1rem); z-index:9999; display:flex; align-items:center; gap:0.75rem; background:#18181b; color:#fff; padding:0.75rem 1.25rem; border-radius:1rem; box-shadow:0 10px 40px rgba(0,0,0,.3); font-size:0.875rem; font-weight:600; opacity:0; transition:opacity 0.25s ease, transform 0.25s ease; pointer-events:none; white-space:nowrap;">
    <svg class="w-4 h-4 shrink-0" fill="none" stroke="#34d399" stroke-width="2.5" viewBox="0 0 24 24">
        <path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round"/>
    </svg>
    <span id="cart-toast-text">Ditambahkan ke keranjang</span>
</div>

{{-- ══════════════════════════════════════════════════════════════ --}}
{{--  CART ENGINE  (localStorage-based, no framework needed)       --}}
{{-- ══════════════════════════════════════════════════════════════ --}}
<style>
    .cart-modal-panel { animation: cartPanelIn 0.22s cubic-bezier(0.16,1,0.3,1) both; }
    @keyframes cartPanelIn {
        from { opacity:0; transform: scale(0.97) translateY(12px); }
        to   { opacity:1; transform: scale(1) translateY(0); }
    }
    @media (min-width: 1024px) {
        #cart-modal-body { flex-direction: row !important; }
    }
    /* Dark mode bg for toast */
    .dark #cart-toast { background: #fff !important; color: #18181b !important; }
</style>

<script>
(function() {
    // ── Constants ──────────────────────────────────────────────────
    const CART_KEY = 'bengkelin_cart';

    // ── Storage helpers ────────────────────────────────────────────
    function cartLoad() {
        try { return JSON.parse(localStorage.getItem(CART_KEY)) || []; }
        catch { return []; }
    }
    function cartSave(items) {
        localStorage.setItem(CART_KEY, JSON.stringify(items));
    }

    // ── Public: add item to cart ───────────────────────────────────
    window.addToCart = function(item) {
        const cart = cartLoad();
        const idx  = cart.findIndex(i => i.id === item.id && i.kategori === item.kategori);
        if (idx > -1) {
            cart[idx].qty = (cart[idx].qty || 1) + 1;
        } else {
            cart.push({ ...item, qty: 1, checked: true });
        }
        cartSave(cart);
        refreshAll();
        showToast(item.nama);
    };

    // ── Refresh all UI pieces ──────────────────────────────────────
    function refreshAll() {
        const cart = cartLoad();
        refreshBadge(cart);
        refreshHoverDropdown(cart);
        // If modal open — refresh it too
        const modal = document.getElementById('cart-modal');
        if (modal && modal.style.display !== 'none') refreshCartModal(cart);
    }
    window.cartRefreshUI = refreshAll;

    // ── Badge ──────────────────────────────────────────────────────
    function refreshBadge(cart) {
        const badge = document.getElementById('cart-badge');
        if (!badge) return;
        const total = cart.reduce((s, i) => s + (i.qty || 1), 0);
        if (total > 0) {
            badge.textContent = total > 99 ? '99+' : total;
            badge.style.display = 'flex';
        } else {
            badge.style.display = 'none';
        }
    }

    // ── Hover mini-dropdown ────────────────────────────────────────
    function refreshHoverDropdown(cart) {
        const title   = document.getElementById('cart-hover-title');
        const itemsEl = document.getElementById('cart-hover-items');
        const emptyEl = document.getElementById('cart-hover-empty');
        const moreEl  = document.getElementById('cart-hover-more');
        if (!title) return;

        const total = cart.reduce((s, i) => s + (i.qty || 1), 0);
        title.textContent = 'Keranjang (' + total + ')';

        if (cart.length === 0) {
            emptyEl.style.display = 'flex';
            itemsEl.innerHTML = '';
            moreEl.classList.add('hidden');
            return;
        }

        emptyEl.style.display = 'none';
        itemsEl.innerHTML = cart.slice(0, 3).map(function(item) {
            return '<div style="display:flex; align-items:center; gap:0.75rem; padding:0.75rem 1.25rem;">'
                + '<div style="width:48px; height:48px; flex-shrink:0; border-radius:0.75rem; border:1px solid #27272a; background:#18181b; overflow:hidden; display:flex; align-items:center; justify-content:center;">'
                + (item.gambar ? '<img src="' + sanitizeImgUrl(item.gambar) + '" style="width:100%;height:100%;object-fit:cover;">' : '<svg style="width:24px;height:24px;color:#52525b;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>')
                + '</div>'
                + '<div style="flex:1; min-width:0;">'
                + '<p style="font-size:0.7rem; font-weight:700; color:inherit; text-transform:uppercase; overflow:hidden; white-space:nowrap; text-overflow:ellipsis;">' + esc(item.nama) + '</p>'
                + '<p style="font-size:0.65rem; color:#a1a1aa; margin-top:2px;">' + (item.qty || 1) + ' item</p>'
                + '</div>'
                + '<p style="font-size:0.7rem; font-weight:700; white-space:nowrap;">Rp ' + fmt(item.harga * (item.qty || 1)) + '</p>'
                + '</div>';
        }).join('');

        if (cart.length > 3) moreEl.classList.remove('hidden');
        else moreEl.classList.add('hidden');
    }

    // ── Modal open/close ───────────────────────────────────────────
    window.openCartModal = function() {
        const modal = document.getElementById('cart-modal');
        if (!modal) return;
        hideHoverDropdown();
        modal.style.display = 'block';
        document.body.style.overflow = 'hidden';
        refreshCartModal(cartLoad());
    };
    window.closeCartModal = function() {
        const modal = document.getElementById('cart-modal');
        if (!modal) return;
        modal.style.display = 'none';
        document.body.style.overflow = '';
    };

    // ── Full modal render ──────────────────────────────────────────
    function refreshCartModal(cart) {
        const itemsEl    = document.getElementById('cart-modal-items');
        const emptyEl    = document.getElementById('cart-modal-empty');
        const controlEl  = document.getElementById('cart-modal-controls');
        const countEl    = document.getElementById('cart-summary-count');
        const subtotalEl = document.getElementById('cart-summary-subtotal');
        const totalEl    = document.getElementById('cart-summary-total');
        const checkoutBtn= document.getElementById('cart-checkout-btn');
        const selectAll  = document.getElementById('cart-select-all');
        if (!itemsEl) return;

        if (cart.length === 0) {
            emptyEl.style.display  = 'flex';
            itemsEl.innerHTML      = '';
            controlEl.style.display= 'none';
            checkoutBtn.disabled   = true;
            countEl.textContent    = 'Total harga (0 Barang)';
            subtotalEl.textContent = 'Rp 0';
            totalEl.textContent    = 'Rp 0';
            return;
        }

        emptyEl.style.display   = 'none';
        controlEl.style.display = '';

        itemsEl.innerHTML = cart.map(function(item, idx) {
            var checked = item.checked !== false ? 'checked' : '';
            var imgHtml = item.gambar
                ? '<img src="' + sanitizeImgUrl(item.gambar) + '" style="width:100%;height:100%;object-fit:cover;" alt="">'
                : '<svg style="width:2rem;height:2rem;color:#52525b;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>';
            return '<div style="display:flex;align-items:center;gap:1rem;padding:1rem 1.5rem;border-bottom:1px solid #27272a;" class="hover:bg-zinc-800/30 transition">'
                + '<input type="checkbox" ' + checked + ' class="w-4 h-4 accent-blue-600 cursor-pointer shrink-0" onchange="toggleItemCheck(' + idx + ',this.checked)">'
                + '<div style="width:4rem;height:4rem;flex-shrink:0;border-radius:0.75rem;border:1px solid #27272a;background:#18181b;overflow:hidden;display:flex;align-items:center;justify-content:center;">' + imgHtml + '</div>'
                + '<div style="flex:1;min-width:0;">'
                + '<span style="display:inline-block;padding:2px 6px;border-radius:4px;font-size:0.55rem;font-weight:700;text-transform:uppercase;letter-spacing:0.05em;background:rgba(59,130,246,0.1);color:#60a5fa;">' + esc(item.kategori || '') + '</span>'
                + '<p style="font-size:0.875rem;font-weight:700;text-transform:uppercase;margin-top:2px;" class="text-white">' + esc(item.nama) + '</p>'
                + '<p style="font-size:0.75rem;color:#a1a1aa;margin-top:2px;">Rp ' + fmt(item.harga) + '</p>'
                + '</div>'
                + '<div style="display:flex;align-items:center;gap:4px;background:#18181b;border:1px solid #27272a;border-radius:1rem;padding:4px;flex-shrink:0;">'
                + '<button onclick="changeQty(' + idx + ',-1)" style="width:1.75rem;height:1.75rem;border-radius:0.6rem;background:#27272a;border:1px solid #3f3f46;color:#fff;font-size:1rem;font-weight:700;display:flex;align-items:center;justify-content:center;cursor:pointer;transition:background 0.15s;" class="hover:bg-blue-500 hover:text-white hover:border-blue-500">−</button>'
                + '<span style="width:2rem;text-align:center;font-size:0.875rem;font-weight:700;" class="text-white">' + (item.qty || 1) + '</span>'
                + '<button onclick="changeQty(' + idx + ',1)" style="width:1.75rem;height:1.75rem;border-radius:0.6rem;background:#27272a;border:1px solid #3f3f46;color:#fff;font-size:1rem;font-weight:700;display:flex;align-items:center;justify-content:center;cursor:pointer;transition:background 0.15s;" class="hover:bg-blue-500 hover:text-white hover:border-blue-500">+</button>'
                + '</div>'
                + '<button onclick="removeCartItem(' + idx + ')" style="flex-shrink:0;width:2rem;height:2rem;border-radius:0.5rem;display:flex;align-items:center;justify-content:center;color:#d4d4d8;cursor:pointer;transition:color 0.15s,background 0.15s;" class="hover:text-red-500 hover:bg-red-950/20 dark:text-zinc-650">'
                + '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>'
                + '</button>'
                + '</div>';
        }).join('');

        var checkedItems = cart.filter(function(i) { return i.checked !== false; });
        var subtotal = checkedItems.reduce(function(s, i) { return s + i.harga * (i.qty || 1); }, 0);
        var totalQty = checkedItems.reduce(function(s, i) { return s + (i.qty || 1); }, 0);

        countEl.textContent    = 'Total harga (' + totalQty + ' Barang)';
        subtotalEl.textContent = 'Rp ' + fmt(subtotal);
        totalEl.textContent    = 'Rp ' + fmt(subtotal);
        checkoutBtn.disabled   = checkedItems.length === 0;

        var allChecked = cart.every(function(i) { return i.checked !== false; });
        selectAll.checked       = allChecked;
        selectAll.indeterminate = !allChecked && cart.some(function(i) { return i.checked !== false; });
    }

    // ── Cart actions ───────────────────────────────────────────────
    window.changeQty = function(idx, delta) {
        var cart = cartLoad();
        if (!cart[idx]) return;
        cart[idx].qty = Math.max(1, (cart[idx].qty || 1) + delta);
        cartSave(cart);
        refreshAll();
    };
    window.removeCartItem = function(idx) {
        var cart = cartLoad();
        cart.splice(idx, 1);
        cartSave(cart);
        refreshAll();
    };
    window.toggleItemCheck = function(idx, checked) {
        var cart = cartLoad();
        if (cart[idx]) cart[idx].checked = checked;
        cartSave(cart);
        refreshCartModal(cart);
    };
    window.toggleSelectAll = function(checked) {
        var cart = cartLoad().map(function(i) { return Object.assign({}, i, { checked: checked }); });
        cartSave(cart);
        refreshCartModal(cart);
    };
    window.cancelSelectedItems = function() {
        var cart = cartLoad().map(function(i) { return Object.assign({}, i, { checked: false }); });
        cartSave(cart);
        refreshCartModal(cart);
    };
    window.deleteSelectedItems = function() {
        window.showConfirm('HAPUS ITEM', 'Hapus semua item yang dipilih?').then(function(confirmed) {
            if (!confirmed) return;
            var cart = cartLoad().filter(function(i) { return i.checked === false; });
            cartSave(cart);
            refreshAll();
        });
    };
    window.cartCheckout = function() {
        var checkedItems = cartLoad().filter(function(i) { return i.checked !== false; });
        if (checkedItems.length === 0) {
            window.showAlert('PERINGATAN', 'Pilih minimal satu produk terlebih dahulu!');
            return;
        }
        window.location.href = @auth '{{ route("cart.checkout") }}' @else '{{ route("login", ["redirect" => route("cart.checkout")]) }}' @endauth;
    };

    // ── Toast ──────────────────────────────────────────────────────
    var toastTimer;
    function showToast(nama) {
        var t = document.getElementById('cart-toast');
        var txt = document.getElementById('cart-toast-text');
        if (!t) return;
        txt.textContent = (nama || 'Produk') + ' ditambahkan ke keranjang';
        t.style.opacity   = '1';
        t.style.transform = 'translateX(-50%) translateY(0)';
        clearTimeout(toastTimer);
        toastTimer = setTimeout(function() {
            t.style.opacity   = '0';
            t.style.transform = 'translateX(-50%) translateY(1rem)';
        }, 2500);
    }

    // ── Hover logic ──────────────────
    function hideHoverDropdown() {
        // Hover dropdown is fully controlled by CSS classes (Tailwind group-hover)
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Relocate modal and toast to document.body to fix stacking context / z-index issues
        var modal = document.getElementById('cart-modal');
        if (modal && modal.parentElement !== document.body) {
            document.body.appendChild(modal);
        }
        var toast = document.getElementById('cart-toast');
        if (toast && toast.parentElement !== document.body) {
            document.body.appendChild(toast);
        }
    });

    // ── Keyboard close ─────────────────────────────────────────────
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeCartModal();
            hideHoverDropdown();
        }
    });

    // ── Utils ──────────────────────────────────────────────────────
    function fmt(num) {
        return Math.round(num).toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }
    function esc(s) {
        return String(s || '').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
    }
    function sanitizeImgUrl(url) {
        if (!url) return '';
        if (url.includes('/storage/img/')) {
            url = url.replace('/storage/img/', '/img/');
        } else if (url.includes('storage/img/')) {
            url = url.replace('storage/img/', 'img/');
        }
        return url;
    }

    // ── Init ───────────────────────────────────────────────────────
    document.addEventListener('DOMContentLoaded', refreshAll);
    window.addEventListener('storage', refreshAll);
})();
</script>
