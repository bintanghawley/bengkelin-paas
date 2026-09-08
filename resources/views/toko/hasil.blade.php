@extends('layouts.guest')

@section('content')
<div class="min-h-screen bg-zinc-50 dark:bg-zinc-950 text-zinc-900 dark:text-white transition-colors duration-300">
    <div class="max-w-3xl mx-auto px-4 py-12">
        
        {{-- Success Banner --}}
        <div class="text-center mb-10 space-y-4">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-emerald-100 dark:bg-emerald-950/40 text-emerald-600 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-900/60 shadow-lg shadow-emerald-600/10">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <h1 class="text-3xl font-bengkel tracking-wider uppercase">Pembelian <span class="text-emerald-600">Berhasil</span></h1>
            <p class="text-zinc-500 text-xs uppercase tracking-widest">Terima kasih atas pesanan Anda. Kami sedang memproses barang pesanan Anda.</p>
        </div>

        {{-- Invoice Card --}}
        <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-3xl shadow-sm overflow-hidden mb-8">
            {{-- Header Invoice --}}
            <div class="p-6 md:p-8 bg-zinc-50 dark:bg-zinc-850/50 border-b border-zinc-200 dark:border-zinc-800/80 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <span class="text-[10px] text-zinc-400 dark:text-zinc-500 uppercase tracking-widest font-bold block">No. Invoice</span>
                    <span class="font-mono text-sm font-bold text-zinc-800 dark:text-zinc-200">#INV/{{ $purchase->created_at->format('Ymd') }}/{{ $purchase->id }}</span>
                </div>
                <div>
                    <span class="text-[10px] text-zinc-400 dark:text-zinc-500 uppercase tracking-widest font-bold block text-left sm:text-right">Tanggal Transaksi</span>
                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">{{ $purchase->created_at->format('d M Y, H:i') }} WIB</span>
                </div>
            </div>

            {{-- Detail Barang --}}
            <div class="p-6 md:p-8 border-b border-zinc-150 dark:border-zinc-800/60 space-y-4">
                <span class="text-[10px] text-zinc-400 dark:text-zinc-500 uppercase tracking-widest font-bold block">Rincian Pembelian</span>
                
                <div class="flex justify-between items-start gap-4">
                    <div>
                        <h3 class="font-bold text-zinc-800 dark:text-white uppercase tracking-wide text-sm">{{ $purchase->barang_nama }}</h3>
                        <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-1">
                            Rp {{ number_format($purchase->harga, 0, ',', '.') }} x {{ $purchase->jumlah ?? 1 }} unit
                        </p>
                    </div>
                    <span class="font-bold text-zinc-800 dark:text-white text-sm">
                        Rp {{ number_format($purchase->total_harga ?: ($purchase->harga * ($purchase->jumlah ?? 1)), 0, ',', '.') }}
                    </span>
                </div>

                {{-- Delivery Fee --}}
                <div class="flex justify-between items-center text-xs pt-2">
                    <span class="text-zinc-500">Biaya Pengiriman</span>
                    <span class="text-emerald-600 dark:text-emerald-500 font-bold uppercase tracking-wider text-[10px]">Gratis Ongkir</span>
                </div>

                {{-- Grand Total --}}
                <div class="flex justify-between items-baseline pt-4 border-t border-zinc-100 dark:border-zinc-800">
                    <span class="text-xs font-bold uppercase tracking-widest text-zinc-800 dark:text-zinc-200">Total Tagihan</span>
                    <span class="text-2xl font-bengkel text-red-600">
                        Rp {{ number_format($purchase->total_harga ?: ($purchase->harga * ($purchase->jumlah ?? 1)), 0, ',', '.') }}
                    </span>
                </div>
            </div>

            {{-- Detail Pengiriman --}}
            <div class="p-6 md:p-8 border-b border-zinc-150 dark:border-zinc-800/60 grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">
                <div class="space-y-3">
                    <div>
                        <span class="text-[10px] text-zinc-400 dark:text-zinc-500 uppercase tracking-widest font-bold block mb-1">Penerima & Kontak</span>
                        <p class="font-bold text-zinc-800 dark:text-white uppercase">{{ $purchase->user->name ?? 'Pelanggan' }}</p>
                        <p class="text-xs text-zinc-650 dark:text-zinc-400 mt-1">{{ $purchase->telepon ?? '-' }}</p>
                    </div>
                    <div>
                        <span class="text-[10px] text-zinc-400 dark:text-zinc-500 uppercase tracking-widest font-bold block mb-1">Alamat Tujuan</span>
                        <p class="text-xs text-zinc-650 dark:text-zinc-400 leading-relaxed">{{ $purchase->alamat ?? '-' }}</p>
                    </div>
                </div>

                <div class="space-y-3">
                    <div>
                        <span class="text-[10px] text-zinc-400 dark:text-zinc-500 uppercase tracking-widest font-bold block mb-1">Metode Pembayaran</span>
                        <p class="font-bold text-zinc-800 dark:text-white uppercase text-xs tracking-wider">{{ $purchase->metode_pembayaran ?? 'COD' }}</p>
                    </div>
                    <div>
                        <span class="text-[10px] text-zinc-400 dark:text-zinc-500 uppercase tracking-widest font-bold block mb-1">Status Pembayaran / Pesanan</span>
                        @php
                            $statusColor = match($purchase->status) {
                                'pending' => 'bg-orange-100 dark:bg-orange-950/40 text-orange-600 dark:text-orange-400 border border-orange-200 dark:border-orange-900/60',
                                'diproses' => 'bg-yellow-100 dark:bg-yellow-950/40 text-yellow-600 dark:text-yellow-500 border border-yellow-200 dark:border-yellow-900/60',
                                'dikirim' => 'bg-blue-100 dark:bg-blue-950/40 text-blue-600 dark:text-blue-400 border border-blue-200 dark:border-blue-900/60',
                                'selesai' => 'bg-emerald-100 dark:bg-emerald-950/40 text-emerald-600 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-900/60',
                                'dibatalkan' => 'bg-red-100 dark:bg-red-950/40 text-red-600 dark:text-red-500 border border-red-200 dark:border-red-900/60',
                                default => 'bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400 border border-zinc-200 dark:border-zinc-700'
                            };
                        @endphp
                        <span class="px-2.5 py-1 rounded-full text-[9px] font-bold border inline-block uppercase tracking-wider {{ $statusColor }}">
                            {{ $purchase->status ?? 'PENDING' }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- Catatan --}}
            @if($purchase->catatan)
            <div class="p-6 md:p-8 bg-zinc-50 dark:bg-zinc-850/30 text-xs">
                <span class="text-[10px] text-zinc-400 dark:text-zinc-500 uppercase tracking-widest font-bold block mb-2">Catatan Pesanan</span>
                <p class="text-zinc-650 dark:text-zinc-400 italic leading-relaxed">"{{ $purchase->catatan }}"</p>
            </div>
            @endif
        </div>

        {{-- Navigation Actions --}}
        <div class="flex flex-col sm:flex-row gap-4">
            <a href="{{ route('pengguna.dashboard') }}?section=riwayat" class="flex-1 text-center px-6 py-4 bg-red-600 hover:bg-red-700 text-white rounded-2xl text-sm font-bold uppercase tracking-widest transition shadow-lg shadow-red-600/20">
                Pantau Pesanan Anda
            </a>
            <a href="{{ route('toko.banmotor') }}" class="flex-1 text-center px-6 py-4 bg-zinc-200 dark:bg-zinc-800 hover:bg-zinc-300 dark:hover:bg-zinc-700 text-zinc-900 dark:text-white rounded-2xl text-sm font-bold uppercase tracking-widest border border-zinc-300 dark:border-zinc-700 transition">
                Belanja Lagi
            </a>
        </div>
</div>
@endsection
