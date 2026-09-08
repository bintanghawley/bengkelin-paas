@extends('layouts.guest')

@section('content')
<div class="bg-zinc-950 text-white min-h-screen">
    {{-- Header / Navbar --}}
    <nav class="w-full border-b border-zinc-900/60 bg-zinc-950/90 backdrop-blur sticky top-0 z-30">
        <div class="max-w-7xl mx-auto px-6 py-5 flex items-center justify-between">
            <a href="{{ route('home') }}" class="flex items-center gap-2">
                <img src="{{ asset('img/home/logo.png') }}" alt="" class="w-10 h-10 object-contain">
                <span class="text-xl font-bengkel tracking-wider">Bengkel<span class="text-red-600">in</span></span>
            </a>
            <div class="flex items-center gap-4">
                <a href="{{ route('pengguna.bookings.index') }}" class="text-xs font-semibold text-zinc-400 hover:text-white transition uppercase tracking-widest">Kembali ke Daftar</a>
            </div>
        </div>
    </nav>

    <div class="max-w-4xl mx-auto px-6 py-10">
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bengkel uppercase tracking-wide">Detail Booking</h1>
                <p class="text-zinc-500 text-sm mt-1">ID Booking: #{{ $booking->id }}</p>
            </div>
            @php
                $sc = match($booking->status) {
                    'pending'    => 'bg-orange-950/40 text-orange-400 border-orange-900/60',
                    'diterima'   => 'bg-blue-950/40 text-blue-400 border-blue-900/60',
                    'diproses'   => 'bg-yellow-950/40 text-yellow-500 border-yellow-900/60',
                    'selesai'    => 'bg-emerald-950/40 text-emerald-400 border-emerald-900/60',
                    'ditolak'    => 'bg-red-950/40 text-red-400 border-red-900/60',
                    'dibatalkan' => 'bg-red-950/40 text-red-500 border-red-900/60',
                    default      => 'bg-zinc-800 text-zinc-400 border-zinc-700',
                };
            @endphp
            <span class="px-4 py-1.5 rounded-full text-xs font-bold border {{ $sc }}">
                {{ strtoupper($booking->status) }}
            </span>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
            <!-- Left: Info Utama -->
            <div class="lg:col-span-1 bg-zinc-900 border border-zinc-800 rounded-3xl p-6 space-y-6">
                <h3 class="text-xs text-zinc-500 uppercase tracking-widest font-bold border-b border-zinc-800 pb-3">Informasi Booking</h3>
                
                <div>
                    <p class="text-[10px] text-zinc-400 uppercase font-bold tracking-widest">Layanan</p>
                    <p class="text-base font-bold text-white uppercase">{{ $booking->service->nama }}</p>
                </div>

                <div>
                    <p class="text-[10px] text-zinc-400 uppercase font-bold tracking-widest">Mekanik</p>
                    <p class="text-sm font-semibold text-white">
                        {{ $booking->mechanic ? $booking->mechanic->name : 'Belum Ditugaskan' }}
                    </p>
                </div>

                <div>
                    <p class="text-[10px] text-zinc-400 uppercase font-bold tracking-widest">Waktu Servis</p>
                    <p class="text-sm font-semibold text-white">
                        {{ $booking->tanggal_booking->format('d/m/Y') }} @ {{ \Carbon\Carbon::parse($booking->jam_booking)->format('H:i') }} WIB
                    </p>
                </div>

                <div>
                    <p class="text-[10px] text-zinc-400 uppercase font-bold tracking-widest">Kendaraan</p>
                    <p class="text-sm font-bold text-white uppercase">{{ $booking->nama_kendaraan }}</p>
                    <p class="text-xs text-zinc-500 font-mono">{{ $booking->plat_nomor }}</p>
                </div>
            </div>

            <!-- Right: Keluhan & Catatan -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Keluhan -->
                <div class="bg-zinc-900 border border-zinc-800 rounded-3xl p-6">
                    <h3 class="text-xs text-zinc-500 uppercase tracking-widest font-bold border-b border-zinc-800 pb-3 mb-4">Keluhan Pelanggan</h3>
                    <p class="text-zinc-300 text-sm leading-relaxed whitespace-pre-line bg-zinc-950 p-4 rounded-xl border border-zinc-850">
                        {{ $booking->keluhan ?: 'Tidak ada keluhan tertulis.' }}
                    </p>
                </div>


                <!-- Catatan Admin & Mekanik -->
                <div class="bg-zinc-900 border border-zinc-800 rounded-3xl p-6 space-y-6">
                    <h3 class="text-xs text-zinc-500 uppercase tracking-widest font-bold border-b border-zinc-800 pb-3">Catatan Workshop</h3>
                    
                    <div>
                        <p class="text-[10px] text-zinc-400 uppercase font-bold tracking-widest mb-2">Catatan Admin</p>
                        <p class="text-zinc-300 text-sm leading-relaxed whitespace-pre-line bg-zinc-950 p-4 rounded-xl border border-zinc-850">
                            {{ $booking->catatan_admin ?: 'Belum ada catatan dari admin.' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-[10px] text-zinc-400 uppercase font-bold tracking-widest mb-2">Catatan Mekanik</p>
                        <p class="text-zinc-300 text-sm leading-relaxed whitespace-pre-line bg-zinc-950 p-4 rounded-xl border border-zinc-850">
                            {{ $booking->catatan_mekanik ?: 'Belum ada catatan dari mekanik.' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
