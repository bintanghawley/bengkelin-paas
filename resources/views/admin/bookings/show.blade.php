@extends('layouts.guest')

@section('content')
<div class="flex min-h-screen font-sans">
    
    <!-- Sidebar Admin -->
    @include('admin.partials.sidebar')

    <!-- Main Content -->
    <main class="flex-1 ml-64 p-10 bg-gray-50 dark:bg-zinc-950 min-h-screen text-gray-900 dark:text-white">
        {{-- Header / Navbar --}}
        <header class="flex justify-between items-center mb-10">
            <div>
                <h2 class="text-4xl font-bengkel tracking-wider text-zinc-800 dark:text-white">ADMIN <span class="text-red-600">DASHBOARD</span></h2>
                <p class="text-zinc-500 text-xs uppercase tracking-[0.2em] mt-1 italic">Sidoarjo High Performance Garage</p>
            </div>
            <div class="flex items-center gap-4 bg-gray-50 dark:bg-zinc-900 border border-gray-200 dark:border-zinc-800 p-2 pr-6 rounded-full shadow-lg">
                <div class="h-10 w-10 bg-red-650 rounded-full flex items-center justify-center font-bold text-white shadow-lg uppercase">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div class="flex flex-col text-left">
                    <span class="text-zinc-800 dark:text-white text-sm font-bold leading-none">{{ Auth::user()->name }}</span>
                    <span class="text-zinc-500 text-[10px] uppercase mt-1 tracking-widest">Admin Bengkelin</span>
                </div>
            </div>
        </header>

        <div class="mb-8 flex items-center justify-between">
            <div>
            <a href="{{ route('admin.bookings.index') }}" class="text-xs text-red-600 dark:text-red-500 hover:text-red-500 dark:hover:text-red-400 transition uppercase font-bold tracking-widest">← Kembali ke Daftar</a>
                <h1 class="text-2xl font-bengkel uppercase tracking-widest mt-2 text-gray-900 dark:text-white">Kelola Booking #{{ $booking->id }}</h1>
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
            <!-- Left: Detail Booking -->
            <div class="lg:col-span-1 bg-white dark:bg-zinc-900 border border-gray-200 dark:border-zinc-800 rounded-3xl p-6 space-y-6 shadow-sm dark:shadow-2xl">
                <h3 class="text-xs text-gray-500 dark:text-zinc-500 uppercase tracking-widest font-bold border-b border-gray-200 dark:border-zinc-800 pb-3">Detail Booking</h3>
                
                <div>
                    <p class="text-[10px] text-gray-400 dark:text-zinc-400 uppercase font-bold tracking-widest">Pelanggan</p>
                    <p class="text-sm font-bold text-gray-900 dark:text-white uppercase">{{ $booking->user->name ?? 'Guest' }}</p>
                    <p class="text-xs text-gray-400 dark:text-zinc-500">Telp: {{ $booking->user->nomor_telepon ?? '-' }}</p>
                </div>

                <div>
                    <p class="text-[10px] text-gray-400 dark:text-zinc-400 uppercase font-bold tracking-widest">Layanan</p>
                    <p class="text-sm font-bold text-gray-900 dark:text-white uppercase">{{ $booking->service->nama }}</p>
                    <p class="text-xs text-emerald-600 dark:text-emerald-500 font-bold">Mulai: {{ $booking->service->harga_mulai_formatted }}</p>
                </div>

                <div>
                    <p class="text-[10px] text-gray-400 dark:text-zinc-400 uppercase font-bold tracking-widest">Waktu Booking</p>
                    <p class="text-sm font-semibold text-gray-900 dark:text-white">
                        {{ $booking->tanggal_booking->format('d/m/Y') }} @ {{ \Carbon\Carbon::parse($booking->jam_booking)->format('H:i') }} WIB
                    </p>
                </div>

                <div>
                    <p class="text-[10px] text-gray-400 dark:text-zinc-400 uppercase font-bold tracking-widest">Unit Motor</p>
                    <p class="text-sm font-bold text-gray-900 dark:text-white uppercase">{{ $booking->nama_kendaraan }}</p>
                    <p class="text-xs text-gray-400 dark:text-zinc-500 font-mono">{{ $booking->plat_nomor }}</p>
                </div>

                <div>
                    <p class="text-[10px] text-gray-400 dark:text-zinc-400 uppercase font-bold tracking-widest">Mekanik Terkini</p>
                    <p class="text-sm font-semibold text-gray-900 dark:text-white">
                        {{ $booking->mechanic ? $booking->mechanic->name : 'Belum Ditugaskan' }}
                    </p>
                </div>
            </div>

            <!-- Right: Action & Keluhan -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Keluhan -->
                <div class="bg-white dark:bg-zinc-900 border border-gray-200 dark:border-zinc-800 rounded-3xl p-6 shadow-sm dark:shadow-2xl">
                    <h3 class="text-xs text-gray-500 dark:text-zinc-500 uppercase tracking-widest font-bold border-b border-gray-200 dark:border-zinc-800 pb-3 mb-4">Keluhan Pelanggan</h3>
                    <p class="text-gray-700 dark:text-zinc-300 text-sm leading-relaxed whitespace-pre-line bg-gray-50 dark:bg-zinc-950 p-4 rounded-xl border border-gray-200 dark:border-zinc-850">
                        {{ $booking->keluhan ?: 'Tidak ada keluhan tertulis.' }}
                    </p>
                </div>

                <!-- Booking Status Info -->
                <div class="bg-white dark:bg-zinc-900 border border-gray-200 dark:border-zinc-800 rounded-3xl p-6 shadow-sm dark:shadow-2xl space-y-4">
                    <h3 class="text-xs text-gray-500 dark:text-zinc-500 uppercase tracking-widest font-bold border-b border-gray-200 dark:border-zinc-800 pb-3">Status Booking</h3>
                    
                    <div class="text-sm text-zinc-700 dark:text-zinc-300 space-y-2 normal-case">
                        <p>Booking ini dikelola langsung oleh mekanik. Admin dapat memantau status dan membatalkan bila diperlukan.</p>
                        <div class="mt-3">
                            <span class="text-[10px] uppercase font-bold tracking-widest text-zinc-500">Mekanik Bertugas</span>
                            <p class="font-bold text-gray-900 dark:text-white mt-1">{{ $booking->mechanic ? $booking->mechanic->name : 'Belum ada yang menerima' }}</p>
                        </div>
                    </div>

                    @if(in_array($booking->status, ['pending', 'diterima', 'diproses']))
                    <form action="{{ route('admin.bookings.update', $booking->id) }}" method="POST" onsubmit="return confirm('Batalkan booking ini?')">
                        @csrf @method('PUT')
                        <input type="hidden" name="action" value="cancel">
                        <button type="submit" class="w-full bg-gray-100 dark:bg-zinc-800 hover:bg-red-900/30 hover:text-red-400 text-gray-700 dark:text-zinc-400 font-bold py-3.5 rounded-xl uppercase text-[10px] tracking-widest transition border border-gray-300 dark:border-zinc-700">
                            Batalkan Booking
                        </button>
                    </form>
                    @else
                    <p class="text-xs text-zinc-500 italic normal-case">Booking tidak dapat dibatalkan pada status ini.</p>
                    @endif
                </div>


                <!-- Detail Catatan Mekanik -->
                <div class="bg-white dark:bg-zinc-900 border border-gray-200 dark:border-zinc-800 rounded-3xl p-6 shadow-sm dark:shadow-2xl">
                    <h3 class="text-xs text-gray-500 dark:text-zinc-500 uppercase tracking-widest font-bold border-b border-gray-200 dark:border-zinc-800 pb-3 mb-4">Catatan Mekanik</h3>
                    <p class="text-gray-700 dark:text-zinc-300 text-sm leading-relaxed whitespace-pre-line bg-gray-50 dark:bg-zinc-950 p-4 rounded-xl border border-gray-200 dark:border-zinc-850">
                        {{ $booking->catatan_mekanik ?: 'Mekanik belum menambahkan catatan.' }}
                    </p>
                </div>
            </div>
    </main>
</div>
@endsection
