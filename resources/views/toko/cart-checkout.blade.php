@extends('layouts.guest')

@section('content')
<div class="min-h-screen bg-zinc-950 text-white">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        {{-- Back Button --}}
        <div class="mb-8">
            <a href="{{ route('toko.banmotor') }}" class="inline-flex items-center gap-2 text-xs font-semibold text-zinc-400 hover:text-red-500 uppercase tracking-widest transition group">
                <svg class="w-4 h-4 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                </svg>
                Kembali
            </a>
        </div>

        <h1 class="text-3xl font-bengkel tracking-wider uppercase mb-2">
            Checkout <span class="text-red-600">Keranjang</span>
        </h1>
        <p class="text-zinc-500 text-xs uppercase tracking-widest mb-8">Periksa pesanan dan isi data pengiriman</p>

        @if ($errors->any())
        <div class="mb-6 bg-red-950/30 border border-red-700 text-red-400 p-4 rounded-2xl text-xs uppercase tracking-wider font-bold">
            <ul class="space-y-1">
                @foreach ($errors->all() as $error)
                    <li>• {{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        @if(session('error'))
        <div class="mb-6 bg-red-950/30 border border-red-700 text-red-400 p-4 rounded-2xl text-xs uppercase tracking-wider font-bold">
            ✗ {{ session('error') }}
        </div>
        @endif

        <form action="{{ route('cart.buy') }}" method="POST" id="cart-checkout-form">
            @csrf

            {{-- Hidden field for cart items JSON (filled by JS) --}}
            <input type="hidden" name="items" id="form-cart-items">

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

                {{-- Left: Shipping Info --}}
                <div class="lg:col-span-7 space-y-6">

                    {{-- Order Summary (read from localStorage) --}}
                    <div class="bg-zinc-900 border border-zinc-800 rounded-3xl p-6 md:p-8 shadow-sm">
                        <h2 class="text-lg font-bengkel tracking-wider uppercase border-b border-zinc-800 pb-4 mb-4">
                            Item yang Dipesan
                        </h2>
                        <div id="checkout-cart-items" class="space-y-3">
                            {{-- Filled by JavaScript --}}
                            <div class="text-zinc-500 text-sm italic text-center py-4">Memuat keranjang...</div>
                        </div>
                        <div id="checkout-cart-empty" class="hidden text-center py-8">
                            <p class="text-zinc-500 text-sm">Keranjang kosong. <a href="{{ route('toko.banmotor') }}" class="text-red-500 hover:underline">Belanja sekarang</a></p>
                        </div>
                    </div>

                    {{-- Shipping Info --}}
                    <div class="bg-zinc-900 border border-zinc-800 rounded-3xl p-6 md:p-8 shadow-sm space-y-6">
                        <h2 class="text-lg font-bengkel tracking-wider uppercase border-b border-zinc-800 pb-4">
                            Informasi Pengiriman
                        </h2>

                        {{-- Nama --}}
                        <div class="space-y-2">
                            <label class="text-[10px] text-zinc-500 uppercase tracking-widest font-bold block">Nama Lengkap</label>
                            <input type="text" value="{{ $user->name }}" readonly disabled
                                class="w-full px-4 py-3 bg-zinc-800 text-zinc-400 rounded-xl text-sm border border-zinc-700 cursor-not-allowed uppercase font-medium">
                        </div>

                        {{-- Telepon --}}
                        <div class="space-y-2">
                            <label for="telepon" class="text-[10px] text-zinc-500 uppercase tracking-widest font-bold block">
                                Nomor Telepon / WhatsApp <span class="text-red-600">*</span>
                            </label>
                            <input type="text" name="telepon" id="telepon"
                                value="{{ old('telepon', $user->nomor_telepon) }}" required
                                class="w-full px-4 py-3 bg-zinc-800 text-white rounded-xl text-sm border border-zinc-700 focus:border-red-600 focus:outline-none transition"
                                placeholder="0812-3456-7890">
                        </div>

                        {{-- Alamat --}}
                        <div class="space-y-2">
                            <label for="alamat" class="text-[10px] text-zinc-500 uppercase tracking-widest font-bold block">
                                Alamat Pengiriman Lengkap <span class="text-red-600">*</span>
                            </label>
                            <textarea name="alamat" id="alamat" rows="3" required
                                class="w-full px-4 py-3 bg-zinc-800 text-white rounded-xl text-sm border border-zinc-700 focus:border-red-600 focus:outline-none transition"
                                placeholder="Tuliskan alamat pengiriman secara detail (jalan, nomor rumah, RT/RW, kecamatan, kota)">{{ old('alamat') }}</textarea>
                        </div>

                        {{-- Catatan --}}
                        <div class="space-y-2">
                            <label for="catatan" class="text-[10px] text-zinc-500 uppercase tracking-widest font-bold block">
                                Catatan (Opsional)
                            </label>
                            <textarea name="catatan" id="catatan" rows="2"
                                class="w-full px-4 py-3 bg-zinc-800 text-white rounded-xl text-sm border border-zinc-700 focus:border-red-600 focus:outline-none transition"
                                placeholder="Contoh: Titipkan di satpam, atau catatan tambahan lainnya">{{ old('catatan') }}</textarea>
                        </div>
                    </div>

                    {{-- Payment Method --}}
                    <div class="bg-zinc-900 border border-zinc-800 rounded-3xl p-6 md:p-8 shadow-sm space-y-4">
                        <h2 class="text-lg font-bengkel tracking-wider uppercase border-b border-zinc-800 pb-4">Metode Pembayaran</h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-2">
                            <label class="relative border border-zinc-800 rounded-2xl p-4 flex items-center gap-4 cursor-pointer hover:border-red-600 transition has-[:checked]:border-red-600">
                                <input type="radio" name="metode_pembayaran" value="COD" checked class="h-4 w-4 text-red-600 border-zinc-600">
                                <div>
                                    <span class="block font-bold text-sm uppercase tracking-wide">COD (Bayar di Tempat)</span>
                                    <span class="block text-zinc-500 text-[10px] mt-0.5">Bayar tunai saat barang diterima</span>
                                </div>
                            </label>

                            <label class="relative border border-zinc-800 rounded-2xl p-4 flex items-center gap-4 cursor-pointer hover:border-red-600 transition has-[:checked]:border-red-600">
                                <input type="radio" name="metode_pembayaran" value="Transfer Bank" class="h-4 w-4 text-red-600 border-zinc-600">
                                <div>
                                    <span class="block font-bold text-sm uppercase tracking-wide">Transfer Bank</span>
                                    <span class="block text-zinc-500 text-[10px] mt-0.5">Transfer ke rekening Bengkelin</span>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                {{-- Right: Order Summary --}}
                <div class="lg:col-span-5">
                    <div class="sticky top-6 bg-zinc-900 border border-zinc-800 rounded-3xl p-6 md:p-8 shadow-xl">
                        <h2 class="text-lg font-bengkel tracking-wider uppercase border-b border-zinc-800 pb-4 mb-6">Ringkasan Pesanan</h2>

                        <div class="space-y-4 text-sm">
                            <div class="flex justify-between text-zinc-400">
                                <span id="summary-count-label">Subtotal (0 Item)</span>
                                <span id="summary-subtotal" class="font-semibold text-white">Rp 0</span>
                            </div>
                            <div class="flex justify-between text-zinc-400">
                                <span>Biaya Layanan</span>
                                <span class="font-semibold text-emerald-400">GRATIS</span>
                            </div>
                            <div class="pt-4 border-t border-zinc-800 flex justify-between items-baseline">
                                <span class="font-bold text-white">Total Pembayaran</span>
                                <span id="summary-total" class="text-2xl font-bengkel tracking-wider text-white">Rp 0</span>
                            </div>
                        </div>

                        <div class="mt-6 p-4 bg-zinc-950 rounded-2xl border border-zinc-800">
                            <p class="text-[10px] uppercase tracking-widest text-zinc-500 font-bold mb-2">Pengambilan / Pengiriman</p>
                            <p class="text-xs text-zinc-300 font-semibold">BENGKELIN</p>
                            <p class="text-[10px] text-zinc-500 mt-1">Bengkelin Motor Workshop<br>Sidoarjo, Jawa Timur</p>
                        </div>

                        <button
                            type="submit"
                            id="submit-cart-checkout"
                            disabled
                            class="mt-6 w-full py-4 bg-red-600 hover:bg-red-700 disabled:opacity-40 disabled:cursor-not-allowed text-white font-bold rounded-2xl uppercase text-sm tracking-widest transition shadow-xl shadow-red-900/30 flex items-center justify-center gap-2"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M5 13l4 4L19 7" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            Konfirmasi Pesanan
                        </button>
                        <p class="text-[10px] text-zinc-500 text-center leading-relaxed mt-3">
                            Dengan melanjutkan, Anda menyetujui syarat dan ketentuan Bengkelin.
                        </p>
                    </div>
                </div>
            </div>
        </form>
    @include('partials.footer')
</div>

<script>
(function() {
    const CART_KEY = 'bengkelin_cart';

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

    function loadCart() {
        try { return JSON.parse(localStorage.getItem(CART_KEY)) || []; } catch { return []; }
    }

    function renderCheckoutCart() {
        const cart = loadCart();
        const checkedItems = cart.filter(i => i.checked !== false);
        const itemsEl = document.getElementById('checkout-cart-items');
        const emptyEl = document.getElementById('checkout-cart-empty');
        const submitBtn = document.getElementById('submit-cart-checkout');
        const formItems = document.getElementById('form-cart-items');
        const countLabel = document.getElementById('summary-count-label');
        const subtotalEl = document.getElementById('summary-subtotal');
        const totalEl = document.getElementById('summary-total');

        if (checkedItems.length === 0) {
            itemsEl.classList.add('hidden');
            emptyEl.classList.remove('hidden');
            submitBtn.disabled = true;
            formItems.value = '[]';
            countLabel.textContent = 'Subtotal (0 Item)';
            subtotalEl.textContent = 'Rp 0';
            totalEl.textContent = 'Rp 0';
            return;
        }

        itemsEl.classList.remove('hidden');
        emptyEl.classList.add('hidden');

        let subtotal = 0;
        let totalQty = 0;

        itemsEl.innerHTML = checkedItems.map(item => {
            const lineTotal = item.harga * (item.qty || 1);
            subtotal += lineTotal;
            totalQty += (item.qty || 1);
            return `<div class="flex items-center gap-4 p-3 bg-zinc-800/50 rounded-xl">
                <div class="w-12 h-12 flex-shrink-0 rounded-lg border border-zinc-700 bg-zinc-800 overflow-hidden flex items-center justify-center">
                    ${item.gambar ? `<img src="${sanitizeImgUrl(item.gambar)}" class="w-full h-full object-cover">` : '<svg class="w-6 h-6 text-zinc-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>'}
                </div>
                <div class="flex-1 min-w-0">
                    <span class="text-[9px] bg-blue-500/10 text-blue-400 px-2 py-0.5 rounded font-bold uppercase">${esc(item.kategori || '')}</span>
                    <p class="text-sm font-bold text-white uppercase truncate mt-1">${esc(item.nama)}</p>
                    <p class="text-xs text-zinc-400">Rp ${fmt(item.harga)} × ${item.qty || 1}</p>
                </div>
                <p class="text-sm font-bold text-white whitespace-nowrap">Rp ${fmt(lineTotal)}</p>
            </div>`;
        }).join('');

        countLabel.textContent = `Subtotal (${totalQty} Item)`;
        subtotalEl.textContent = 'Rp ' + fmt(subtotal);
        totalEl.textContent = 'Rp ' + fmt(subtotal);
        submitBtn.disabled = false;

        // Store checked items JSON in hidden form field
        formItems.value = JSON.stringify(checkedItems);
    }

    // On form submit, clear purchased items from cart
    document.getElementById('cart-checkout-form').addEventListener('submit', function() {
        // Items will be cleared from cart after successful checkout (via cart.result page)
        // Store the cart in sessionStorage as backup to clear on result page
        sessionStorage.setItem('pending_checkout_cart', JSON.stringify(
            loadCart().filter(i => i.checked !== false)
        ));
    });

    // Toggle Shipping Info based on Payment Method
    const codRadio = document.querySelector('input[name="metode_pembayaran"][value="COD"]');
    const transferRadio = document.querySelector('input[name="metode_pembayaran"][value="Transfer Bank"]');
    const teleponInput = document.getElementById('telepon');
    const alamatInput = document.getElementById('alamat');
    const catatanInput = document.getElementById('catatan');
    const teleponReq = document.querySelector('label[for="telepon"] .text-red-600');
    const alamatReq = document.querySelector('label[for="alamat"] .text-red-600');

    if (teleponInput) teleponInput.dataset.initialVal = teleponInput.value;
    if (alamatInput) alamatInput.dataset.initialVal = alamatInput.value;
    if (catatanInput) catatanInput.dataset.initialVal = catatanInput.value;

    function toggleShippingInfo() {
        const isTransfer = transferRadio && transferRadio.checked;
        
        [teleponInput, alamatInput, catatanInput].forEach(input => {
            if (input) {
                input.disabled = isTransfer;
                if (isTransfer) {
                    input.required = false;
                    input.value = '';
                    input.classList.add('opacity-50', 'cursor-not-allowed', 'bg-zinc-100', 'dark:bg-zinc-800/20');
                } else {
                    if (input !== catatanInput) input.required = true;
                    input.value = input.dataset.initialVal || '';
                    input.classList.remove('opacity-50', 'cursor-not-allowed', 'bg-zinc-100', 'dark:bg-zinc-800/20');
                }
            }
        });

        if (teleponReq) teleponReq.style.display = isTransfer ? 'none' : 'inline';
        if (alamatReq) alamatReq.style.display = isTransfer ? 'none' : 'inline';
    }

    if (codRadio && transferRadio) {
        document.querySelectorAll('input[name="metode_pembayaran"]').forEach(radio => {
            radio.addEventListener('change', toggleShippingInfo);
        });
        toggleShippingInfo();
    }

    document.addEventListener('DOMContentLoaded', () => {
        renderCheckoutCart();
        toggleShippingInfo();
    });
})();
</script>
@endsection
