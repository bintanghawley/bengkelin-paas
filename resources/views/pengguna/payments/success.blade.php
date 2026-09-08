@extends('layouts.guest')

@section('content')
<div class="min-h-screen bg-zinc-950 text-white flex items-center justify-center px-4 py-16">
    <div class="max-w-md w-full bg-zinc-900 border border-zinc-800 rounded-3xl p-8 shadow-[0_0_50px_rgba(16,185,129,0.1)] text-center space-y-6">
        
        {{-- Success Checkmark Icon --}}
        <div class="inline-flex items-center justify-center w-20 h-20 bg-emerald-950/40 border-2 border-emerald-500 rounded-full text-emerald-400 shadow-[0_0_30px_rgba(16,185,129,0.2)] animate-pulse">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
            </svg>
        </div>

        <div class="space-y-2">
            <h1 class="text-2xl font-bengkel tracking-wider uppercase">Pembayaran <span class="text-emerald-400">Berhasil</span></h1>
            <p class="text-zinc-550 text-xs uppercase tracking-widest">Transaksi Anda telah dikonfirmasi secara lokal.</p>
        </div>

        <hr class="border-zinc-800">

        {{-- Details --}}
        <div class="space-y-3 text-left bg-zinc-950/50 p-5 rounded-2xl border border-zinc-850">
            <div class="flex justify-between text-xs">
                <span class="text-zinc-500 uppercase tracking-wider font-bold">No. Invoice</span>
                <span class="font-mono text-zinc-300 font-bold">#{{ $payment->invoice_number }}</span>
            </div>
            <div class="flex justify-between text-xs">
                <span class="text-zinc-500 uppercase tracking-wider font-bold">Metode Pembayaran</span>
                <span class="text-zinc-300 font-medium uppercase">{{ $payment->payment_method }}</span>
            </div>
            <div class="flex justify-between text-xs">
                <span class="text-zinc-500 uppercase tracking-wider font-bold">Tanggal Bayar</span>
                <span class="text-zinc-300 font-medium">{{ $payment->paid_at ? $payment->paid_at->format('d M Y, H:i') : '-' }} WIB</span>
            </div>
            <div class="flex justify-between text-xs">
                <span class="text-zinc-500 uppercase tracking-wider font-bold">Total Pembayaran</span>
                <span class="text-emerald-400 font-bold">Rp {{ number_format($payment->amount, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between items-center text-xs pt-1">
                <span class="text-zinc-500 uppercase tracking-wider font-bold">Status</span>
                <span class="px-2.5 py-0.5 rounded-full text-[9px] font-bold bg-emerald-950/60 text-emerald-400 border border-emerald-900/60 uppercase tracking-wider">
                    {{ $payment->status }}
                </span>
            </div>
        </div>

        <hr class="border-zinc-800">

        {{-- Actions --}}
        <div class="space-y-3">
            <a href="{{ route('pengguna.dashboard') }}?section=riwayat" class="block w-full py-3.5 bg-red-600 hover:bg-red-700 text-white text-xs font-bold uppercase tracking-widest rounded-xl transition duration-200 text-center shadow-lg shadow-red-900/30">
                Lihat Pesanan
            </a>
            <a href="{{ route('toko.banmotor') }}" class="block w-full py-3.5 bg-zinc-850 hover:bg-zinc-800 text-zinc-300 hover:text-white text-xs font-bold uppercase tracking-widest rounded-xl border border-zinc-800 transition duration-200 text-center">
                Belanja Lagi
            </a>
        </div>

    </div>
</div>
@endsection
