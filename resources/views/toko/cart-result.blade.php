@extends('layouts.guest')

@section('content')
<div class="min-h-screen bg-zinc-950 text-white flex items-center justify-center px-4 py-16">
    <div class="max-w-2xl w-full">
        {{-- Success Icon --}}
        <div class="text-center mb-10">
            <div class="inline-flex items-center justify-center w-24 h-24 bg-emerald-900/30 border-2 border-emerald-500 rounded-full mb-6 shadow-[0_0_30px_rgba(16,185,129,0.2)]">
                <svg class="w-12 h-12 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <h1 class="text-3xl font-bengkel tracking-wider uppercase">Pesanan <span class="text-emerald-400">Berhasil!</span></h1>
            <p class="text-zinc-400 text-sm mt-2 uppercase tracking-widest">{{ count($purchases) }} item telah masuk ke antrian pesanan</p>
        </div>

        {{-- Order Summary --}}
        <div class="bg-zinc-900 border border-zinc-800 rounded-3xl p-6 mb-6 space-y-4">
            <h2 class="text-sm font-bold uppercase tracking-widest text-zinc-400 border-b border-zinc-800 pb-3">Detail Pesanan</h2>
            @foreach($purchases as $purchase)
            <div class="flex items-center justify-between py-2">
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-bold text-white uppercase truncate">{{ $purchase->barang_nama }}</p>
                    <p class="text-xs text-zinc-500">#INV/{{ $purchase->created_at->format('Ymd') }}/{{ $purchase->id }} · {{ $purchase->jumlah }} item</p>
                </div>
                <p class="text-sm font-bold text-white ml-4 whitespace-nowrap">
                    Rp {{ number_format($purchase->total_harga, 0, ',', '.') }}
                </p>
            </div>
            @endforeach

            <div class="border-t border-zinc-800 pt-4 flex justify-between items-baseline">
                <span class="text-sm font-bold text-white">Total</span>
                <span class="text-2xl font-bengkel text-white">
                    Rp {{ number_format($purchases->sum('total_harga'), 0, ',', '.') }}
                </span>
            </div>
        </div>

        {{-- Pickup Info --}}
        <div class="bg-zinc-900 border border-zinc-800 rounded-3xl p-6 mb-6">
            <h2 class="text-sm font-bold uppercase tracking-widest text-zinc-400 border-b border-zinc-800 pb-3 mb-4">Informasi Pengambilan</h2>
            <div class="flex items-start gap-4">
                <div class="w-10 h-10 bg-red-600/20 border border-red-600/40 rounded-xl flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="font-bold text-white">BENGKELIN Motor Workshop</p>
                    <p class="text-zinc-400 text-sm mt-1">Sidoarjo, Jawa Timur</p>
                    <p class="text-zinc-500 text-xs mt-2 normal-case">Tim kami akan menghubungi Anda via WhatsApp untuk konfirmasi pesanan.</p>
                </div>
            </div>
        </div>

        {{-- Payment Method --}}
        @if($purchases->first())
        <div class="bg-zinc-900 border border-zinc-800 rounded-3xl p-6 mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-[10px] uppercase tracking-widest text-zinc-500 font-bold">Metode Pembayaran</p>
                    <p class="font-bold text-white mt-1">{{ $purchases->first()->metode_pembayaran }}</p>
                </div>
                <div>
                    <p class="text-[10px] uppercase tracking-widest text-zinc-500 font-bold">Status</p>
                    <span class="inline-block mt-1 px-3 py-1 bg-orange-950/40 text-orange-400 border border-orange-900/60 rounded-full text-[9px] font-bold uppercase">PENDING</span>
                </div>
            </div>
        </div>
        @endif

        {{-- Actions --}}
        <div class="flex flex-col sm:flex-row gap-3">
            <a href="{{ route('pengguna.dashboard') }}?section=riwayat"
               id="go-dashboard"
               class="flex-1 py-4 bg-red-600 hover:bg-red-700 text-white font-bold rounded-2xl uppercase text-sm tracking-widest transition text-center shadow-xl shadow-red-900/20 flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                Lihat Status Pesanan
            </a>
            <a href="{{ route('toko.banmotor') }}"
               class="flex-1 py-4 bg-zinc-900 hover:bg-zinc-800 text-zinc-300 hover:text-white font-bold rounded-2xl uppercase text-sm tracking-widest transition text-center border border-zinc-800">
                Belanja Lagi
            </a>
        </div>
</div>

<script>
// Clear checked items from cart after successful checkout
(function() {
    const CART_KEY = 'bengkelin_cart';
    
    function clearPurchasedItems() {
        try {
            var cart = JSON.parse(localStorage.getItem(CART_KEY)) || [];
            // Remove all checked items (those were the ones purchased)
            var remaining = cart.filter(function(i) { return i.checked === false; });
            localStorage.setItem(CART_KEY, JSON.stringify(remaining));
            
            // Also clear sessionStorage
            sessionStorage.removeItem('pending_checkout_cart');
            
            // Fire storage event to update other tabs
            window.dispatchEvent(new StorageEvent('storage', { key: CART_KEY }));
        } catch(e) { console.error(e); }
    }
    
    // Run immediately on page load
    clearPurchasedItems();
    
    // Update cart badge if cart widget is present
    if (typeof window.cartRefreshUI === 'function') {
        window.cartRefreshUI();
    }
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof window.cartRefreshUI === 'function') {
            window.cartRefreshUI();
        }
    });
})();
</script>
@endsection
