@extends('layouts.guest')

@section('content')
<div class="min-h-screen bg-zinc-950 text-white flex items-center justify-center px-4 py-16">
    <div class="max-w-md w-full bg-zinc-900 border border-zinc-800 rounded-3xl p-8 shadow-[0_0_50px_rgba(239,68,68,0.05)] text-center space-y-6">
        
        {{-- Expired/Warning Icon --}}
        <div class="inline-flex items-center justify-center w-20 h-20 bg-red-950/40 border-2 border-red-500 rounded-full text-red-400 shadow-[0_0_30px_rgba(239,68,68,0.15)] animate-pulse">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
        </div>

        <div class="space-y-2">
            <h1 class="text-2xl font-bengkel tracking-wider uppercase text-red-500">Pembayaran Kadaluarsa</h1>
            <p class="text-zinc-550 text-xs uppercase tracking-widest leading-relaxed">
                Batas waktu pembayaran untuk transaksi ini telah habis (melebihi 60 menit).
            </p>
        </div>

        <hr class="border-zinc-800">

        {{-- Details --}}
        <div class="space-y-3 text-left bg-zinc-950/50 p-5 rounded-2xl border border-zinc-850 text-xs">
            <div class="flex justify-between">
                <span class="text-zinc-500 uppercase tracking-wider font-bold">No. Invoice</span>
                <span class="font-mono text-zinc-400 font-bold">#{{ $payment->invoice_number }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-zinc-500 uppercase tracking-wider font-bold">Total Tagihan</span>
                <span class="text-zinc-400 font-bold">Rp {{ number_format($payment->amount, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between items-center pt-1">
                <span class="text-zinc-500 uppercase tracking-wider font-bold">Status</span>
                <span class="px-2.5 py-0.5 rounded-full text-[9px] font-bold bg-red-950/60 text-red-400 border border-red-900/60 uppercase tracking-wider">
                    EXPIRED
                </span>
            </div>
        </div>

        <hr class="border-zinc-800">

        {{-- Actions --}}
        <div>
            <a href="{{ route('pengguna.dashboard') }}?section=riwayat" class="block w-full py-4 bg-zinc-850 hover:bg-zinc-800 text-zinc-300 hover:text-white text-xs font-bold uppercase tracking-widest rounded-xl border border-zinc-800 transition duration-200 text-center shadow-md">
                Kembali ke Pesanan
            </a>
        </div>

    </div>
</div>
@endsection
