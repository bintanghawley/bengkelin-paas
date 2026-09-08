
@extends('layouts.guest')

@section('content')
<div class="flex min-h-screen font-sans bg-gray-100 dark:bg-zinc-950">
    
    <aside class="w-64 bg-gray-50 dark:bg-zinc-900 border-r border-gray-200 dark:border-zinc-800 flex flex-col fixed h-full z-50">
        <div class="p-6 flex items-center gap-3 border-b border-gray-200 dark:border-zinc-800/50">
          
            <span class="text-3xl font-bengkel tracking-wider text-zinc-800 dark:text-white">BENGKEL<span class="text-red-600">IN</span></span>
        </div>

        <nav class="flex-1 px-4 space-y-2 mt-6" id="sidebar-nav">
            <button onclick="showSection('booking')" id="btn-booking" class="nav-link w-full flex items-center gap-3 px-4 py-3 text-zinc-500 dark:text-zinc-400 rounded-xl font-bold transition text-left">
                <svg fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17 17.25 21l2.75-2.75-5.83-5.83m-2.75 2.75 2.75-2.75m-2.75 2.75L8 18.59l-4.59-4.59L6.83 10.6m7.34 1.82 3.42-3.42a4 4 0 0 0-5.66-5.66L8.51 6.76"/>
                </svg>
                BOOKING SERVIS
            </button>
            <button onclick="showSection('emergency')" id="btn-emergency" class="nav-link w-full flex items-center gap-3 px-4 py-3 text-zinc-500 dark:text-zinc-400 rounded-xl font-bold transition text-left">
                <svg fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z"/>
                </svg>
                <div class="text-left">
                    <span class="block text-xs">DARURAT</span>
                    <span class="block text-[9px] opacity-60">Mogok di jalan?</span>
                </div>
            </button>
            <button onclick="showSection('profil')" id="btn-profil" class="nav-link w-full flex items-center gap-3 px-4 py-3 text-zinc-500 dark:text-zinc-400 rounded-xl font-bold transition">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                </svg>
                PROFIL
            </button>
            <button onclick="showSection('status')" id="btn-status" class="nav-link w-full flex items-center gap-3 px-4 py-3 text-zinc-500 dark:text-zinc-400 rounded-xl font-bold transition text-left">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
                STATUS SERVIS
            </button>
            <button onclick="showSection('riwayat')" id="btn-riwayat" class="nav-link w-full flex items-center gap-3 px-4 py-3 text-zinc-500 dark:text-zinc-400 rounded-xl font-bold transition text-left">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.03 0 1.9.693 2.166 1.638m-7.377 2.24a.75.75 0 0 1 .75.75 1.5 1.5 0 0 0 1.5 1.5h1.5a1.5 1.5 0 0 0 1.5-1.5.75.75 0 0 1 .75-.75h.45m-8.356 0h.45" />
                </svg>
                RIWAYAT PESANAN
            </button>

        </nav>

        <div class="p-4 border-t border-gray-200 dark:border-zinc-800 space-y-2">
            <a href="{{ route('home') }}" class="group relative flex items-center justify-center gap-2 w-full text-center text-[10px] font-bold text-zinc-500 dark:text-zinc-400 hover:text-white uppercase tracking-widest border border-zinc-300 dark:border-zinc-800 hover:border-red-600 bg-white dark:bg-zinc-900/50 hover:bg-red-600/10 py-2.5 rounded-xl transition-all duration-300 overflow-hidden shadow-sm hover:shadow-red-650/10">
                <svg class="w-3.5 h-3.5 transform transition-transform duration-300 group-hover:-translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M10 19l-7-7m0 0l7-7m-7 7h18" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <span>Kembali ke Beranda</span>
            </a>
            <form action="{{ route('logout') }}" method="POST" onsubmit="return confirm('Yakin ingin logout?')">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 text-red-500 hover:bg-red-500/10 rounded-xl transition font-bold uppercase tracking-widest text-[10px]">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9" />
                    </svg>
                    Sign Out Account
                </button>
            </form>
        </div>
    </aside>

    <main class="flex-1 ml-64 p-10">
        
        <header class="flex justify-between items-center mb-10">
            <div>
                <h2 class="text-4xl font-bengkel tracking-wider text-zinc-800 dark:text-white">USER <span class="text-red-600">DASHBOARD</span></h2>
                <p class="text-zinc-500 text-xs uppercase tracking-[0.2em] mt-1 italic">Sidoarjo High Performance Garage</p>
            </div>
            <div class="flex items-center gap-4 bg-gray-50 dark:bg-zinc-900 border border-gray-200 dark:border-zinc-800 p-2 pr-6 rounded-full shadow-lg">
                <div class="h-10 w-10 bg-red-600 rounded-full flex items-center justify-center font-bold text-white shadow-lg uppercase">
                    {{ substr($user->name, 0, 1) }}
                </div>
                <div class="flex flex-col">
                    <span class="text-zinc-800 dark:text-white text-sm font-bold leading-none">{{ $user->name }}</span>
                    <span class="text-zinc-500 text-[10px] uppercase mt-1 tracking-widest">Member Bengkelin</span>
                </div>
            </div>
        </header>

       

        <div id="content-area">
           
<section id="section-profil" class="dashboard-section space-y-8">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 italic">
        <div class="bg-gray-50 dark:bg-zinc-900 p-8 rounded-3xl border border-gray-200 dark:border-zinc-800 shadow-xl flex flex-col items-center text-center">
            <div class="relative mb-6">
                <div class="h-32 w-32 bg-gray-100 dark:bg-zinc-950 rounded-3xl border-2 border-red-600 flex items-center justify-center overflow-hidden">
                    <svg class="w-16 h-16 text-gray-300 dark:text-zinc-800" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                </div>
                <div class="absolute -bottom-2 -right-2 h-8 w-8 bg-emerald-500 border-4 border-gray-50 dark:border-zinc-900 rounded-full shadow-[0_0_10px_rgba(16,185,129,0.5)]"></div>
            </div>
            <h3 class="text-2xl font-bengkel tracking-wide uppercase text-zinc-800 dark:text-white">{{ $user->name }}</h3>
            <p class="text-zinc-500 text-[10px] uppercase tracking-[0.3em] mt-1">Member Bengkelin</p>
            
            <div class="w-full mt-8 pt-8 border-t border-gray-200 dark:border-zinc-800 space-y-3">
                <div class="flex justify-between text-[10px]">
                    <span class="text-zinc-500 uppercase font-bold tracking-widest">ID Akun</span>
                    <span class="text-zinc-800 dark:text-white">#00{{ $user->id }}</span>
                </div>
                <div class="flex justify-between text-[10px]">
                    <span class="text-zinc-500 uppercase font-bold tracking-widest">Bergabung</span>
                    <span class="text-zinc-800 dark:text-white italic">{{ $user->created_at->format('M Y') }}</span>
                </div>
            </div>
        </div>

        <div class="lg:col-span-2 bg-gray-50 dark:bg-zinc-900 p-8 rounded-3xl border border-gray-200 dark:border-zinc-800 shadow-xl relative overflow-hidden">
            <div class="absolute -top-10 -right-10 opacity-[0.02] -rotate-12">
                 <svg viewBox="0 0 24 24" fill="currentColor" class="w-64 h-64 text-zinc-800 dark:text-white"><path d="M14.5 11V5a2 2 0 0 0-2-2h-1a2 2 0 0 0-2 2v6M7 11h10M7 15h10M8 11v8a2 2 0 0 0 2 2h4a2 2 0 0 0 2-2v-8"/></svg>
            </div>

            <h3 class="text-xl font-bengkel text-red-600 mb-8 uppercase tracking-widest relative z-10">Data Pelanggan Terverifikasi</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 relative z-10">
                <div class="space-y-1">
                    <label class="text-[10px] text-zinc-500 uppercase font-bold tracking-widest block">Full Identity</label>
                    <p class="text-zinc-800 dark:text-white font-medium border-b border-gray-200 dark:border-zinc-800 pb-2">{{ $user->name }}</p>
                </div>
                <div class="space-y-1">
                    <label class="text-[10px] text-zinc-500 uppercase font-bold tracking-widest block">Nomor Telepon</label>
                    <p class="text-zinc-800 dark:text-white font-medium border-b border-gray-200 dark:border-zinc-800 pb-2">{{ $user->nomor_telepon ? implode('-', str_split($user->nomor_telepon, 4)) : '-' }}</p>
                </div>
            </div>

            <div class="mt-12 flex flex-col md:flex-row gap-4">
                <button class="bg-red-600 hover:bg-red-700 text-white text-[10px] font-bold py-3 px-8 rounded-xl transition uppercase tracking-widest shadow-lg shadow-red-900/20">
                    Update Profil
                </button>
                <button class="bg-gray-200 dark:bg-zinc-800 hover:bg-gray-300 dark:hover:bg-zinc-700 text-zinc-800 dark:text-white text-[10px] font-bold py-3 px-8 rounded-xl transition uppercase tracking-widest border border-gray-300 dark:border-zinc-700">
                    Ganti Password
                </button>
            </div>
        </div>
    </div>
</section>

<section id="section-booking" class="dashboard-section hidden italic">
    <div class="bg-gray-50 dark:bg-zinc-900 p-10 rounded-3xl border border-gray-200 dark:border-zinc-800 shadow-xl text-zinc-800 dark:text-white">
        <!-- Header Section -->
        <h3 class="text-3xl font-bengkel text-red-600 mb-2 uppercase">Reservasi Servis</h3>
        <p class="text-zinc-500 text-sm mb-10 uppercase tracking-widest">Pilih layanan servis dan booking jadwalmu sekarang.</p>

        @if(isset($services) && $services->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($services as $service)
                    <div class="bg-gray-100 dark:bg-zinc-950 border border-gray-200 dark:border-zinc-800 rounded-2xl p-6 hover:border-red-600 transition duration-300 group">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h4 class="font-bengkel text-lg text-zinc-800 dark:text-white uppercase tracking-wider">{{ $service->nama }}</h4>
                                <p class="text-emerald-600 dark:text-emerald-500 font-bold text-sm mt-1">Mulai {{ $service->harga_mulai_formatted }}</p>
                            </div>
                            <span class="text-[9px] bg-red-100 dark:bg-red-950/40 text-red-600 dark:text-red-400 px-3 py-1 rounded-full border border-red-200 dark:border-red-900/60 font-bold uppercase tracking-widest">
                                {{ $service->estimasi_waktu }}
                            </span>
                        </div>
                        <p class="text-zinc-500 text-xs leading-relaxed mb-5 line-clamp-2">{{ $service->deskripsi }}</p>
                        <div class="flex items-center justify-between">
                            <span class="text-[9px] text-zinc-500 uppercase tracking-widest font-bold">{{ $service->items_count }} item pekerjaan</span>
                            <a href="{{ route('booking.create', $service->slug) }}" 
                               class="bg-red-600 hover:bg-red-700 text-white text-[9px] font-bold py-2.5 px-5 rounded-xl transition uppercase tracking-widest shadow-lg shadow-red-900/20">
                                Booking Sekarang
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-8 text-center">
                <a href="{{ route('servis') }}" class="text-zinc-500 hover:text-red-600 transition text-xs uppercase tracking-widest font-bold">
                    Lihat Detail Semua Layanan →
                </a>
            </div>
        @else
            <div class="text-center py-12 text-zinc-500">
                <p class="italic tracking-widest">Belum ada layanan servis yang tersedia.</p>
            </div>
        @endif
    </div>
</section>

<section id="section-emergency" class="dashboard-section hidden italic">
    <div class="bg-gray-50 dark:bg-zinc-900 p-10 rounded-3xl border border-gray-200 dark:border-zinc-800 shadow-xl text-zinc-800 dark:text-white">
        <h3 class="text-3xl font-bengkel text-red-600 mb-2 uppercase">Laporan Darurat</h3>
        <p class="text-zinc-500 text-sm mb-8 uppercase tracking-widest">Kendaraan mogok di jalan? Kirim lokasi Anda sekarang.</p>

        <div class="bg-red-50 dark:bg-red-950/20 border border-red-200 dark:border-red-900/40 rounded-2xl p-8 text-center">
            <svg class="w-16 h-16 text-red-500 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z"/>
            </svg>
            <h4 class="text-xl font-bengkel text-red-600 uppercase tracking-widest mb-2">Butuh Bantuan Darurat?</h4>
            <p class="text-zinc-500 text-sm mb-6">Jika kendaraan Anda mogok atau mengalami kerusakan di jalan, kirim laporan darurat dan mekanik kami akan segera menuju lokasi Anda.</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('pengguna.emergency.create') }}" class="bg-red-600 hover:bg-red-700 text-white text-[10px] font-bold py-3 px-8 rounded-xl transition uppercase tracking-widest shadow-lg shadow-red-900/20 inline-flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z"/></svg>
                    Kirim Laporan Darurat
                </a>
                <a href="{{ route('pengguna.emergency.index') }}" class="bg-gray-200 dark:bg-zinc-800 hover:bg-gray-300 dark:hover:bg-zinc-700 text-zinc-800 dark:text-white text-[10px] font-bold py-3 px-8 rounded-xl transition uppercase tracking-widest border border-gray-300 dark:border-zinc-700 inline-flex items-center justify-center gap-2">
                    Riwayat Darurat
                </a>
            </div>
        </div>
    </div>
</section>

          <section id="section-status" class="dashboard-section hidden italic">
    <div class="space-y-6">
        <!-- Progress Tracker (Visual Indikator) -->
        <div class="bg-gray-50 dark:bg-zinc-900 p-10 rounded-3xl border border-gray-200 dark:border-zinc-800 shadow-xl">
            <h3 class="text-3xl font-bengkel text-red-600 mb-8 uppercase">Service Progress</h3>
            
            <div class="space-y-8 text-zinc-800 dark:text-white">
                <div class="flex items-start gap-6 relative">
                    <div class="h-8 w-8 bg-emerald-500 rounded-full flex items-center justify-center shrink-0 shadow-[0_0_15px_rgba(16,185,129,0.4)]">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M5 13l4 4L19 7" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-zinc-800 dark:text-white uppercase text-sm tracking-widest">Booking Terkonfirmasi</h4>
                        <p class="text-[10px] text-zinc-500 mt-1 uppercase italic">Pesanan lu sudah masuk ke sistem kami.</p>
                    </div>
                </div>

                <div class="flex items-start gap-6 relative">
                    <div class="h-8 w-8 bg-red-600 rounded-full flex items-center justify-center shrink-0 animate-pulse">
                        <div class="h-3 w-3 bg-white rounded-full"></div>
                    </div>
                    <div>
                        <h4 class="font-bold text-red-500 uppercase text-sm tracking-widest">Monitor Status</h4>
                        <p class="text-[10px] text-zinc-500 mt-1 uppercase italic">Cek tabel di bawah untuk update berkala.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabel Riwayat Booking -->
        <div class="bg-gray-50 dark:bg-zinc-900 rounded-3xl border border-gray-200 dark:border-zinc-800 overflow-hidden shadow-xl">
            <div class="p-6 border-b border-gray-200 dark:border-zinc-800 flex justify-between items-center">
                <h3 class="font-bengkel text-xl text-zinc-800 dark:text-white uppercase tracking-wider">Riwayat Booking</h3>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs uppercase tracking-tighter">
                    <thead class="bg-gray-100 dark:bg-zinc-950 text-zinc-500 border-b border-gray-200 dark:border-zinc-800">
                        <tr>
                            <th class="px-6 py-4 font-bold text-zinc-800 dark:text-white">Unit</th>
                            <th class="px-6 py-4 font-bold text-zinc-800 dark:text-white">Layanan</th>
                            <th class="px-6 py-4 font-bold text-center text-zinc-800 dark:text-white">Tanggal</th>
                            <th class="px-6 py-4 font-bold text-center text-zinc-800 dark:text-white">Jam</th>
                            <th class="px-6 py-4 font-bold text-center text-zinc-800 dark:text-white">Status</th>
                            <th class="px-6 py-4 font-bold text-right text-zinc-800 dark:text-white">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-zinc-800/50 text-zinc-600 dark:text-zinc-300">
                        @if(isset($bookings) && $bookings->count() > 0)
                            @foreach ($bookings as $booking)
                                <tr class="hover:bg-gray-100 dark:hover:bg-zinc-800/30 transition-colors group">
                                    <td class="px-6 py-4">
                                        <span class="block font-bold text-zinc-800 dark:text-white">{{ $booking->nama_kendaraan }}</span>
                                        <span class="text-[9px] text-zinc-500 italic font-mono">{{ $booking->plat_nomor }}</span>
                                    </td>
                                    <td class="px-6 py-4 font-medium">{{ $booking->service->nama ?? 'Custom Service' }}</td>
                                    <td class="px-6 py-4 text-center">
                                        {{ $booking->tanggal_booking ? $booking->tanggal_booking->format('d M Y') : '-' }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        {{ \Carbon\Carbon::parse($booking->jam_booking)->format('H:i') }} WIB
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @php
                                            $statusColor = match($booking->status) {
                                                'pending'    => 'bg-orange-100 dark:bg-orange-950/40 text-orange-600 dark:text-orange-400 border border-orange-200 dark:border-orange-900/60',
                                                'diterima'   => 'bg-blue-100 dark:bg-blue-950/40 text-blue-600 dark:text-blue-400 border border-blue-200 dark:border-blue-900/60',
                                                'diproses'   => 'bg-yellow-100 dark:bg-yellow-950/40 text-yellow-600 dark:text-yellow-500 border border-yellow-200 dark:border-yellow-900/60',
                                                'selesai'    => 'bg-emerald-100 dark:bg-emerald-950/40 text-emerald-600 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-900/60',
                                                'ditolak'    => 'bg-red-100 dark:bg-red-950/40 text-red-600 dark:text-red-500 border border-red-200 dark:border-red-900/60',
                                                'dibatalkan' => 'bg-red-100 dark:bg-red-950/40 text-red-600 dark:text-red-500 border border-red-200 dark:border-red-900/60',
                                                default      => 'bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400 border border-zinc-200 dark:border-zinc-700'
                                            };
                                        @endphp
                                        <span class="px-3 py-1 rounded-full text-[9px] font-bold border inline-block {{ $statusColor }}">
                                            {{ strtoupper($booking->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <button type="button" onclick="toggleBookingDetailModal({{ $booking->id }}, true)" class="inline-block bg-zinc-850 hover:bg-zinc-800 text-white text-[9px] font-bold py-2 px-4 rounded-lg transition uppercase tracking-wider border border-zinc-700">
                                            Lihat Detail
                                        </button>
                                    </td>
                                </tr>
                                
                                {{-- Modal Detail Booking --}}
                                <div id="modal-booking-detail-{{ $booking->id }}" class="fixed inset-0 z-[99] hidden flex items-center justify-center p-4 bg-black/80 backdrop-blur-sm text-white">
                                    <div class="relative bg-zinc-900 w-full max-w-2xl rounded-3xl border border-zinc-800 shadow-2xl overflow-hidden p-8 text-left">
                                        <div class="flex justify-between items-center mb-6">
                                            <div>
                                                <h3 class="font-bengkel text-xl text-red-600 uppercase tracking-widest">Detail Booking</h3>
                                                <p class="text-[10px] text-zinc-500 uppercase tracking-widest mt-1">ID Booking: #{{ $booking->id }}</p>
                                            </div>
                                            <button type="button" onclick="toggleBookingDetailModal({{ $booking->id }}, false)" class="text-zinc-500 hover:text-white transition text-2xl">&times;</button>
                                        </div>
                                        
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                            <div class="space-y-4 bg-zinc-950/40 p-5 rounded-2xl border border-zinc-800/80">
                                                <div>
                                                    <span class="text-[9px] text-zinc-500 uppercase font-bold tracking-widest block mb-0.5">Layanan</span>
                                                    <span class="text-sm font-bold text-white uppercase">{{ $booking->service->nama ?? 'Custom Service' }}</span>
                                                </div>
                                                <div>
                                                    <span class="text-[9px] text-zinc-500 uppercase font-bold tracking-widest block mb-0.5">Mekanik</span>
                                                    <span class="text-sm font-semibold text-white">{{ $booking->mechanic ? $booking->mechanic->name : 'Belum Ditugaskan' }}</span>
                                                </div>
                                                <div>
                                                    <span class="text-[9px] text-zinc-500 uppercase font-bold tracking-widest block mb-0.5">Waktu Servis</span>
                                                    <span class="text-sm font-semibold text-white">
                                                        {{ $booking->tanggal_booking ? $booking->tanggal_booking->format('d/m/Y') : '-' }} @ {{ \Carbon\Carbon::parse($booking->jam_booking)->format('H:i') }} WIB
                                                    </span>
                                                </div>
                                                <div>
                                                    <span class="text-[9px] text-zinc-500 uppercase font-bold tracking-widest block mb-0.5">Kendaraan</span>
                                                    <span class="text-sm font-bold text-white uppercase">{{ $booking->nama_kendaraan }}</span>
                                                    <span class="text-xs text-zinc-400 font-mono block mt-0.5">{{ $booking->plat_nomor }}</span>
                                                </div>
                                                <div>
                                                    <span class="text-[9px] text-zinc-500 uppercase font-bold tracking-widest block mb-0.5">Status</span>
                                                    <span class="px-2.5 py-0.5 rounded-full text-[9px] font-bold border uppercase tracking-wider inline-block {{ $statusColor }}">
                                                        {{ strtoupper($booking->status) }}
                                                    </span>
                                                </div>
                                            </div>
                                            
                                            <div class="space-y-4">
                                                <div>
                                                    <span class="text-[9px] text-zinc-500 uppercase font-bold tracking-widest block mb-1">Keluhan Pelanggan</span>
                                                    <div class="text-xs text-zinc-300 bg-zinc-950 p-3.5 rounded-xl border border-zinc-800 leading-relaxed max-h-[100px] overflow-y-auto">
                                                        {{ $booking->keluhan ?: 'Tidak ada keluhan tertulis.' }}
                                                    </div>
                                                </div>
                                                <div>
                                                    <span class="text-[9px] text-zinc-500 uppercase font-bold tracking-widest block mb-1">Catatan Admin</span>
                                                    <div class="text-xs text-zinc-300 bg-zinc-950 p-3.5 rounded-xl border border-zinc-800 leading-relaxed max-h-[80px] overflow-y-auto">
                                                        {{ $booking->catatan_admin ?: 'Belum ada catatan dari admin.' }}
                                                    </div>
                                                </div>
                                                <div>
                                                    <span class="text-[9px] text-zinc-550 uppercase font-bold tracking-widest block mb-1">Catatan Mekanik</span>
                                                    <div class="text-xs text-zinc-300 bg-zinc-950 p-3.5 rounded-xl border border-zinc-800 leading-relaxed max-h-[80px] overflow-y-auto">
                                                        {{ $booking->catatan_mekanik ?: 'Belum ada catatan dari mekanik.' }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="mt-6 pt-4 border-t border-zinc-800 flex justify-end">
                                            <button type="button" onclick="toggleBookingDetailModal({{ $booking->id }}, false)" class="bg-zinc-800 hover:bg-zinc-700 text-white font-bold py-2.5 px-6 rounded-xl uppercase text-[10px] tracking-widest transition">
                                                Tutup
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-zinc-500 dark:text-zinc-600 italic tracking-widest bg-gray-50 dark:bg-zinc-900">
                                    Belum ada catatan aktivitas mesin.
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>


    </div>
</section>

          
<section id="section-riwayat" class="dashboard-section hidden italic">
    <div class="space-y-6">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h3 class="text-3xl font-bengkel text-zinc-800 dark:text-white uppercase">Riwayat Pesanan</h3>
                <p class="text-zinc-500 text-xs uppercase tracking-widest mt-1">Daftar transaksi pembelian produk e-commerce Anda.</p>
            </div>
        </div>

        @php
            // Group purchases by payment_id. If payment_id is null (COD), group by individual purchase so they are shown separately.
            $groupedPurchases = $purchases->groupBy(function ($purchase) {
                return $purchase->payment_id ? 'payment_' . $purchase->payment_id : 'purchase_' . $purchase->id;
            });

            $orderGroups = [];
            foreach ($groupedPurchases as $groupKey => $items) {
                $firstItem = $items->first();
                $payment = $firstItem->payment;
                
                $status = 'pending';
                $statusText = 'Pending';
                
                if ($payment) {
                    if ($payment->status === 'expired') {
                        $status = 'kedaluwarsa';
                        $statusText = 'Kedaluwarsa';
                    } elseif ($payment->status === 'pending') {
                        $status = 'menunggu_pembayaran';
                        $statusText = 'Menunggu Pembayaran';
                    } elseif ($payment->status === 'paid') {
                        $pStatus = $firstItem->status;
                        if ($pStatus === 'dikirim') {
                            $status = 'dikirimkan';
                            $statusText = 'Dikirimkan';
                        } else {
                            $status = $pStatus; // diproses, selesai, dibatalkan
                            $statusText = ucwords($pStatus);
                        }
                    }
                } else {
                    // COD
                    $pStatus = $firstItem->status;
                    if ($pStatus === 'dikirim') {
                        $status = 'dikirimkan';
                        $statusText = 'Dikirimkan';
                    } else {
                        $status = $pStatus; // diproses, selesai, dibatalkan
                        $statusText = ucwords($pStatus);
                    }
                }
                
                // Build detail URL
                if ($payment) {
                    if ($payment->status === 'pending') {
                        $detailUrl = route('pengguna.payments.show', $payment->id);
                    } elseif ($payment->status === 'paid') {
                        $detailUrl = route('pengguna.payments.success', $payment->id);
                    } else {
                        $detailUrl = route('pengguna.payments.expired', $payment->id);
                    }
                } else {
                    $detailUrl = route('toko.result', $firstItem->id);
                }
                
                $totalBelanja = $items->sum('total_harga');
                
                $orderGroups[] = [
                    'key' => $groupKey,
                    'items' => $items,
                    'first_item' => $firstItem,
                    'payment' => $payment,
                    'status' => strtolower($status),
                    'status_text' => $statusText,
                    'detail_url' => $detailUrl,
                    'total_belanja' => $totalBelanja,
                    'date' => $firstItem->created_at->translatedFormat('d M Y'),
                    'reference_code' => $firstItem->getReferenceCode()
                ];
            }
        @endphp

        <!-- Filter Status Tabs -->
        <div class="flex flex-wrap gap-2 py-2 border-b border-gray-200 dark:border-zinc-800">
            <span class="text-zinc-400 dark:text-zinc-500 text-[10px] font-bold uppercase tracking-widest w-full mb-1">Status Pesanan</span>
            <button onclick="filterOrders('semua')" id="tab-semua" class="order-tab bg-blue-600 text-white px-5 py-2.5 rounded-full text-xs font-bold transition shadow-sm">
                Semua
            </button>
            <button onclick="filterOrders('diproses')" id="tab-diproses" class="order-tab bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 text-zinc-650 dark:text-zinc-400 hover:bg-zinc-50 dark:hover:bg-zinc-850 px-5 py-2.5 rounded-full text-xs font-bold transition">
                Diproses
            </button>
            <button onclick="filterOrders('dikirimkan')" id="tab-dikirimkan" class="order-tab bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 text-zinc-650 dark:text-zinc-400 hover:bg-zinc-50 dark:hover:bg-zinc-850 px-5 py-2.5 rounded-full text-xs font-bold transition">
                Dikirimkan
            </button>
            <button onclick="filterOrders('menunggu_pembayaran')" id="tab-menunggu_pembayaran" class="order-tab bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 text-zinc-650 dark:text-zinc-400 hover:bg-zinc-50 dark:hover:bg-zinc-850 px-5 py-2.5 rounded-full text-xs font-bold transition">
                Menunggu Pembayaran
            </button>
            <button onclick="filterOrders('dibatalkan')" id="tab-dibatalkan" class="order-tab bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 text-zinc-650 dark:text-zinc-400 hover:bg-zinc-50 dark:hover:bg-zinc-850 px-5 py-2.5 rounded-full text-xs font-bold transition">
                Dibatalkan
            </button>
            <button onclick="filterOrders('selesai')" id="tab-selesai" class="order-tab bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 text-zinc-650 dark:text-zinc-400 hover:bg-zinc-50 dark:hover:bg-zinc-850 px-5 py-2.5 rounded-full text-xs font-bold transition">
                Selesai
            </button>
            <button onclick="filterOrders('kedaluwarsa')" id="tab-kedaluwarsa" class="order-tab bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 text-zinc-650 dark:text-zinc-400 hover:bg-zinc-50 dark:hover:bg-zinc-850 px-5 py-2.5 rounded-full text-xs font-bold transition">
                Kedaluwarsa
            </button>
        </div>

        <!-- Orders List -->
        <div class="space-y-4 mt-6">
            @forelse($orderGroups as $group)
                @php
                    $firstItem = $group['first_item'];
                    $items = $group['items'];
                    $badgeClasses = match($group['status']) {
                        'diproses' => 'bg-yellow-100 text-yellow-850 dark:bg-yellow-950/40 dark:text-yellow-400 border border-yellow-200 dark:border-yellow-900/40',
                        'dikirimkan' => 'bg-blue-100 text-blue-800 dark:bg-blue-950/40 dark:text-blue-400 border border-blue-200 dark:border-blue-900/40',
                        'menunggu_pembayaran' => 'bg-orange-100 text-orange-850 dark:bg-orange-950/40 dark:text-orange-400 border border-orange-200 dark:border-orange-900/40',
                        'dibatalkan' => 'bg-red-100 text-red-800 dark:bg-red-950/40 dark:text-red-400 border border-red-200 dark:border-red-900/40',
                        'selesai' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-950/40 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-900/40',
                        'kedaluwarsa' => 'bg-[#9a3412] text-white',
                        default => 'bg-zinc-100 text-zinc-850 dark:bg-zinc-800 dark:text-zinc-350 border border-zinc-200 dark:border-zinc-700'
                    };
                @endphp
                <div class="order-card bg-white dark:bg-zinc-900 p-6 rounded-3xl border border-gray-200 dark:border-zinc-800 shadow-sm relative overflow-hidden transition hover:shadow-md" data-status="{{ $group['status'] }}">
                    <!-- Card Top Header -->
                    <div class="flex justify-between items-center mb-4">
                        <span class="text-zinc-500 dark:text-zinc-400 text-xs font-semibold">{{ $group['date'] }}</span>
                        <span class="px-3 py-1 rounded-md text-[10px] font-bold uppercase tracking-wider {{ $badgeClasses }}">
                            {{ $group['status_text'] }}
                        </span>
                    </div>

                    <!-- Card Body -->
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-center">
                        <!-- Left Side: Product Info -->
                        <div class="md:col-span-6 flex gap-4 items-center">
                            <div class="h-20 w-20 bg-gray-100 dark:bg-zinc-950 rounded-2xl flex-shrink-0 overflow-hidden border border-zinc-200 dark:border-zinc-800 flex items-center justify-center">
                                @if($firstItem->getImageUrl())
                                    <img src="{{ $firstItem->getImageUrl() }}" alt="{{ $firstItem->barang_nama }}" class="w-full h-full object-cover">
                                @else
                                    <svg class="w-8 h-8 text-zinc-400 dark:text-zinc-650" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                @endif
                            </div>
                            <div>
                                <h4 class="font-bengkel text-lg text-zinc-800 dark:text-white uppercase tracking-wider font-bold leading-tight">{{ $firstItem->barang_nama }}</h4>
                                <p class="text-zinc-500 text-xs mt-1 font-semibold">Rp {{ number_format($firstItem->harga, 0, ',', '.') }} <span class="text-zinc-450">x {{ $firstItem->jumlah }} Barang</span></p>
                                
                                @if($items->count() > 1)
                                    <p class="text-blue-600 dark:text-blue-400 font-bold text-xs mt-2 hover:underline cursor-pointer">+{{ $items->count() - 1 }} Produk Lainnya</p>
                                @endif
                            </div>
                        </div>

                        <!-- Mid-Right: Total Belanja -->
                        <div class="md:col-span-3 text-left md:text-right flex flex-col md:justify-center">
                            <span class="text-zinc-400 dark:text-zinc-500 text-[10px] uppercase font-bold tracking-widest">Total Belanja</span>
                            <span class="text-zinc-800 dark:text-white font-extrabold text-lg mt-0.5">Rp {{ number_format($group['total_belanja'], 0, ',', '.') }}</span>
                        </div>

                        <!-- Right: Action Button -->
                        <div class="md:col-span-3 flex justify-end">
                            <a href="{{ $group['detail_url'] }}" class="w-full md:w-auto text-center border border-blue-600 text-blue-600 hover:bg-blue-50 dark:border-blue-500 dark:text-blue-400 dark:hover:bg-blue-950/20 font-bold px-6 py-2.5 rounded-full text-xs flex items-center justify-center gap-2 transition tracking-wider uppercase">
                                Lihat Detail
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path d="M14 5l7 7m0 0l-7 7m7-7H3" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </a>
                        </div>
                    </div>

                    <!-- Card Footer -->
                    <div class="mt-4 pt-4 border-t border-gray-100 dark:border-zinc-800/60 flex items-center justify-between text-[10px] font-mono text-zinc-400 dark:text-zinc-500">
                        <span>No. Referensi: {{ $group['reference_code'] }}</span>
                        @if($group['payment'])
                            <span class="uppercase">Invoice: {{ $group['payment']->invoice_number }}</span>
                        @else
                            <span class="uppercase">Metode: COD</span>
                        @endif
                    </div>
                </div>
            @empty
                <div class="text-center py-16 text-zinc-500 dark:text-zinc-650 bg-white dark:bg-zinc-900 rounded-3xl border border-gray-200 dark:border-zinc-800 shadow-sm italic">
                    <svg class="w-12 h-12 text-zinc-400 mx-auto mb-3 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <p class="tracking-widest">Belum ada riwayat pesanan.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>
        


        </div>
    </main>
</div><script>
    function showSection(sectionId) {
        document.querySelectorAll('.dashboard-section').forEach(section => {
            section.classList.add('hidden');
        });

        document.getElementById('section-' + sectionId).classList.remove('hidden');

        document.querySelectorAll('.nav-link').forEach(btn => {
            btn.classList.remove('text-red-650', 'text-red-600', 'dark:text-red-505', 'dark:text-red-500', 'bg-gray-100', 'dark:bg-zinc-800/50');
            btn.classList.add('text-zinc-505', 'text-zinc-500', 'dark:text-zinc-400', 'hover:bg-gray-100', 'dark:hover:bg-zinc-800/50');
        });

        const activeBtn = document.getElementById('btn-' + sectionId);
        if (activeBtn) {
            activeBtn.classList.add('text-red-600', 'dark:text-red-500', 'bg-gray-100', 'dark:bg-zinc-800/50');
            activeBtn.classList.remove('text-zinc-500', 'dark:text-zinc-400', 'text-zinc-505');
        }

        const url = new URL(window.location.href);
        url.searchParams.set('section', sectionId);
        window.history.replaceState({}, '', url);
    }

    function filterOrders(status) {
        // Update active tab style
        document.querySelectorAll('.order-tab').forEach(tab => {
            tab.className = "order-tab bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 text-zinc-650 dark:text-zinc-400 hover:bg-zinc-50 dark:hover:bg-zinc-850 px-5 py-2.5 rounded-full text-xs font-bold transition";
        });

        const activeTab = document.getElementById('tab-' + status);
        if (activeTab) {
            activeTab.className = "order-tab bg-blue-600 text-white px-5 py-2.5 rounded-full text-xs font-bold transition shadow-sm";
        }

        // Show/Hide order cards
        document.querySelectorAll('.order-card').forEach(card => {
            if (status === 'semua' || card.getAttribute('data-status') === status) {
                card.classList.remove('hidden');
            } else {
                card.classList.add('hidden');
            }
        });
    }

    // Show default section based on query param
    document.addEventListener('DOMContentLoaded', () => {
        const urlParams = new URLSearchParams(window.location.search);
        const section = urlParams.get('section');
        if (section && ['profil', 'booking', 'emergency', 'status', 'riwayat'].includes(section)) {
            showSection(section);
        } else {
            showSection('profil');
        }
    });

    function toggleModalUpdateProfile(show) {
        const modal = document.getElementById('modal-update-profile');
        if (show) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        } else {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    }

    function toggleModalChangePassword(show) {
        const modal = document.getElementById('modal-change-password');
        if (show) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        } else {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    }

    function toggleBookingDetailModal(id, show) {
        const modal = document.getElementById('modal-booking-detail-' + id);
        if (modal) {
            if (show) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            } else {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }
        }
    }
</script>

{{-- Modals --}}
<div id="modal-update-profile" class="fixed inset-0 z-[99] hidden flex items-center justify-center p-4 bg-black/80 backdrop-blur-sm">
    <div class="relative bg-zinc-900 w-full max-w-md rounded-3xl border border-zinc-800 shadow-2xl overflow-hidden p-8 text-left">
        <div class="flex justify-between items-center mb-6">
            <h3 class="font-bengkel text-xl text-red-600 uppercase tracking-widest">Update Profil</h3>
            <button type="button" onclick="toggleModalUpdateProfile(false)" class="text-zinc-500 hover:text-white transition text-2xl">&times;</button>
        </div>
        <form action="{{ route('profile.update') }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            <div class="space-y-1">
                <label class="text-[10px] uppercase text-zinc-500 font-bold block">Nama Lengkap</label>
                <input type="text" name="name" value="{{ Auth::user()->name }}" required class="w-full bg-zinc-950 border border-zinc-800 rounded-xl px-4 py-3 text-sm text-white focus:border-red-600 outline-none transition">
            </div>
            <div class="space-y-1">
                <label class="text-[10px] uppercase text-zinc-500 font-bold block">Nomor Telepon</label>
                <input type="text" name="nomor_telepon" value="{{ Auth::user()->nomor_telepon }}" required class="w-full bg-zinc-950 border border-zinc-800 rounded-xl px-4 py-3 text-sm text-white focus:border-red-600 outline-none transition">
            </div>
            <div class="pt-4 flex gap-3">
                <button type="button" onclick="toggleModalUpdateProfile(false)" class="flex-1 bg-zinc-800 hover:bg-zinc-700 text-white font-bold py-3 rounded-xl uppercase text-[10px] transition">Batal</button>
                <button type="submit" class="flex-[2] bg-red-600 hover:bg-red-700 text-white font-bold py-3 rounded-xl uppercase text-[10px] tracking-widest transition">Simpan</button>
            </div>
        </form>
    </div>
</div>

<div id="modal-change-password" class="fixed inset-0 z-[99] hidden flex items-center justify-center p-4 bg-black/80 backdrop-blur-sm">
    <div class="relative bg-zinc-900 w-full max-w-md rounded-3xl border border-zinc-800 shadow-2xl overflow-hidden p-8 text-left">
        <div class="flex justify-between items-center mb-6">
            <h3 class="font-bengkel text-xl text-red-600 uppercase tracking-widest">Ganti Password</h3>
            <button type="button" onclick="toggleModalChangePassword(false)" class="text-zinc-500 hover:text-white transition text-2xl">&times;</button>
        </div>
        <form action="{{ route('profile.update') }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            <input type="hidden" name="name" value="{{ Auth::user()->name }}">
            <input type="hidden" name="nomor_telepon" value="{{ Auth::user()->nomor_telepon }}">
            
            <div class="space-y-1">
                <label class="text-[10px] uppercase text-zinc-500 font-bold block">Password Baru</label>
                <input type="password" name="password" required class="w-full bg-zinc-950 border border-zinc-800 rounded-xl px-4 py-3 text-sm text-white focus:border-red-600 outline-none transition">
            </div>
            <div class="pt-4 flex gap-3">
                <button type="button" onclick="toggleModalChangePassword(false)" class="flex-1 bg-zinc-800 hover:bg-zinc-700 text-white font-bold py-3 rounded-xl uppercase text-[10px] transition">Batal</button>
                <button type="submit" class="flex-[2] bg-red-600 hover:bg-red-700 text-white font-bold py-3 rounded-xl uppercase text-[10px] tracking-widest transition">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection