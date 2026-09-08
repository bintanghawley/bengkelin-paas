@extends('layouts.guest')

@section('content')
<div class="flex min-h-screen font-sans bg-zinc-950 text-white">
    
    @include('mekanik.partials.sidebar')

    <!-- Main Content -->
    <main class="flex-1 ml-64 p-10 min-h-screen">
        {{-- Header / Navbar --}}
        <header class="flex justify-between items-center mb-10">
            <div>
                <h2 class="text-4xl font-bengkel tracking-wider text-white">MEKANIK <span class="text-red-600">DASHBOARD</span></h2>
                <p class="text-zinc-500 text-xs uppercase tracking-[0.2em] mt-1 italic">Sidoarjo High Performance Garage</p>
            </div>
            <div class="flex items-center gap-4 bg-zinc-900 border border-zinc-800 p-2 pr-6 rounded-full shadow-lg">
                <div class="h-10 w-10 bg-red-650 rounded-full flex items-center justify-center font-bold text-white shadow-lg uppercase">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div class="flex flex-col text-left">
                    <span class="text-white text-sm font-bold leading-none">{{ Auth::user()->name }}</span>
                    <span class="text-zinc-500 text-[10px] uppercase mt-1 tracking-widest">Mekanik Bengkelin</span>
                </div>
            </div>
        </header>

        <div class="mb-8 flex items-center justify-between">
            <div>
                <a href="{{ route('mekanik.bookings.index') }}" class="text-xs text-red-500 hover:text-red-400 transition uppercase font-bold tracking-widest">← Kembali ke Booking</a>
                <h1 class="text-2xl font-bengkel uppercase tracking-widest mt-2">Detail Booking #{{ $booking->id }}</h1>
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
            <div class="lg:col-span-1 bg-zinc-900 border border-zinc-800 rounded-3xl p-6 space-y-6 shadow-2xl">
                <h3 class="text-xs text-zinc-500 uppercase tracking-widest font-bold border-b border-zinc-800 pb-3">Informasi Booking</h3>
                
                <div>
                    <p class="text-[10px] text-zinc-400 uppercase font-bold tracking-widest">Pelanggan</p>
                    <p class="text-sm font-bold text-white uppercase mt-1">{{ $booking->user->name ?? 'Guest' }}</p>
                    <p class="text-[10px] text-zinc-500 font-mono">{{ $booking->user->nomor_telepon ?? '-' }}</p>
                </div>

                <div>
                    <p class="text-[10px] text-zinc-400 uppercase font-bold tracking-widest">Layanan</p>
                    <p class="text-sm font-bold text-white uppercase mt-1">{{ $booking->service->nama }}</p>
                    <p class="text-xs text-zinc-500">Estimasi: {{ $booking->service->estimasi_waktu }}</p>
                </div>

                <div>
                    <p class="text-[10px] text-zinc-400 uppercase font-bold tracking-widest">Jadwal</p>
                    <p class="text-sm font-semibold text-white mt-1">
                        {{ $booking->tanggal_booking->format('d M Y') }} @ {{ \Carbon\Carbon::parse($booking->jam_booking)->format('H:i') }} WIB
                    </p>
                </div>

                <div>
                    <p class="text-[10px] text-zinc-400 uppercase font-bold tracking-widest">Kendaraan</p>
                    <p class="text-sm font-bold text-white uppercase mt-1">{{ $booking->nama_kendaraan }}</p>
                    <p class="text-xs text-zinc-500 font-mono">{{ $booking->plat_nomor }}</p>
                </div>

                @if($booking->mechanic)
                <div>
                    <p class="text-[10px] text-zinc-400 uppercase font-bold tracking-widest">Mekanik Bertugas</p>
                    <p class="text-sm font-bold text-white uppercase mt-1">{{ $booking->mechanic->name }}</p>
                </div>
                @endif
            </div>

            <!-- Right: Keluhan & Aksi -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Keluhan -->
                <div class="bg-zinc-900 border border-zinc-800 rounded-3xl p-6 shadow-2xl">
                    <h3 class="text-xs text-zinc-500 uppercase tracking-widest font-bold border-b border-zinc-800 pb-3 mb-4">Keluhan Pelanggan</h3>
                    <p class="text-zinc-300 text-sm leading-relaxed whitespace-pre-line bg-zinc-950 p-4 rounded-xl border border-zinc-800 normal-case">
                        {{ $booking->keluhan ?: 'Tidak ada keluhan tertulis.' }}
                    </p>
                </div>

                <!-- Aksi Mekanik berdasarkan status -->
                <div class="bg-zinc-900 border border-zinc-800 rounded-3xl p-6 shadow-2xl space-y-4">
                    <h3 class="text-xs text-zinc-500 uppercase tracking-widest font-bold border-b border-zinc-800 pb-3">Aksi Pekerjaan</h3>

                    @if($booking->status === 'pending')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-stretch pt-2">
                            {{-- Terima Card --}}
                            <div class="bg-zinc-950/40 p-6 rounded-2xl border border-zinc-800 flex flex-col justify-between">
                                <div class="space-y-2">
                                    <span class="text-[10px] text-emerald-500 font-bold uppercase tracking-widest block">Terima Pekerjaan</span>
                                    <p class="text-zinc-400 text-xs normal-case leading-relaxed">Terima booking ini untuk mulai melakukan persiapan dan proses pengerjaan servis kendaraan.</p>
                                </div>
                                <form action="{{ route('mekanik.bookings.update', $booking->id) }}" method="POST" class="mt-6" onsubmit="return confirm('Terima booking ini dan mulai persiapan?')">
                                    @csrf @method('PUT')
                                    <input type="hidden" name="action" value="accept">
                                    <button type="submit"
                                        class="w-full bg-emerald-600 hover:bg-emerald-500 text-white font-bold py-4 rounded-xl uppercase text-[10px] tracking-widest transition shadow-lg shadow-emerald-950/20 flex items-center justify-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                        Terima Booking
                                    </button>
                                </form>
                            </div>

                            {{-- Tolak Card --}}
                            <div class="bg-zinc-950/40 p-6 rounded-2xl border border-zinc-800 flex flex-col justify-between">
                                <div class="space-y-2 mb-4">
                                    <span class="text-[10px] text-red-500 font-bold uppercase tracking-widest block">Tolak Pekerjaan</span>
                                    <p class="text-zinc-400 text-xs normal-case leading-relaxed">Tolak booking jika slot pengerjaan penuh atau terdapat kendala teknis lainnya.</p>
                                </div>
                                <form action="{{ route('mekanik.bookings.update', $booking->id) }}" method="POST" class="space-y-4" id="reject-form" onsubmit="return confirm('Tolak booking ini?')">
                                    @csrf @method('PUT')
                                    <input type="hidden" name="action" value="reject">
                                    <textarea name="catatan_mekanik" rows="2" placeholder="Alasan penolakan (opsional)..."
                                        class="w-full bg-zinc-950 border border-zinc-800 rounded-xl px-4 py-3 text-xs text-white focus:border-red-500 outline-none transition resize-none normal-case"></textarea>
                                    <button type="submit"
                                        class="w-full bg-red-600 hover:bg-red-500 text-white font-bold py-4 rounded-xl uppercase text-[10px] tracking-widest transition shadow-lg shadow-red-950/20 flex items-center justify-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                                        Tolak Booking
                                    </button>
                                </form>
                            </div>
                        </div>

                    @elseif($booking->status === 'diterima' && $booking->mechanic_id === auth()->id())
                        {{-- Start work --}}
                        <p class="text-blue-400 text-xs normal-case">Booking sudah diterima. Klik tombol di bawah untuk mulai pengerjaan servis.</p>
                        <form action="{{ route('mekanik.bookings.update', $booking->id) }}" method="POST">
                            @csrf @method('PUT')
                            <input type="hidden" name="action" value="start">
                            <button type="submit"
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 rounded-xl uppercase text-[10px] tracking-widest transition shadow-lg shadow-blue-900/40 flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Mulai Pengerjaan
                            </button>
                        </form>

                    @elseif($booking->status === 'diproses' && $booking->mechanic_id === auth()->id())
                        {{-- Complete work --}}
                        <p class="text-yellow-400 text-xs normal-case">Sedang dikerjakan. Isi catatan pekerjaan dan klik selesai bila sudah rampung.</p>
                        <form action="{{ route('mekanik.bookings.update', $booking->id) }}" method="POST" class="space-y-4" onsubmit="return confirm('Tandai servis ini sebagai selesai?')">
                            @csrf @method('PUT')
                            <input type="hidden" name="action" value="complete">
                            <div class="space-y-2">
                                <label class="text-[10px] uppercase text-zinc-500 font-bold tracking-widest">Catatan Pekerjaan Mekanik *</label>
                                <textarea name="catatan_mekanik" required rows="5"
                                    placeholder="Tuliskan detail pekerjaan yang diselesaikan (misal: ganti oli berhasil, kampas rem belakang diganti, rantai disetel)..."
                                    class="w-full bg-zinc-950 border border-zinc-800 rounded-xl px-4 py-3.5 text-sm text-white focus:border-emerald-600 outline-none transition normal-case">{{ $booking->catatan_mekanik }}</textarea>
                            </div>
                            <button type="submit"
                                class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-4 rounded-xl uppercase text-[10px] tracking-widest transition shadow-lg shadow-emerald-900/40 flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                Selesaikan Servis
                            </button>
                        </form>

                    @elseif($booking->status === 'selesai')
                        <div class="bg-emerald-900/20 border border-emerald-800 rounded-xl p-5">
                            <p class="text-[10px] uppercase text-emerald-400 font-bold tracking-widest mb-2">✓ Servis Selesai</p>
                            <p class="text-zinc-300 text-sm leading-relaxed whitespace-pre-line normal-case">
                                {{ $booking->catatan_mekanik ?: 'Tidak ada catatan pekerjaan tertulis.' }}
                            </p>
                        </div>

                    @elseif($booking->status === 'ditolak')
                        <div class="bg-red-900/20 border border-red-800 rounded-xl p-5">
                            <p class="text-[10px] uppercase text-red-400 font-bold tracking-widest mb-2">✗ Booking Ditolak</p>
                            <p class="text-zinc-300 text-sm leading-relaxed normal-case">
                                {{ $booking->catatan_mekanik ?: 'Tidak ada alasan penolakan.' }}
                            </p>
                        </div>

                    @else
                        <p class="text-zinc-500 text-xs normal-case italic">Tidak ada aksi yang tersedia untuk status ini.</p>
                    @endif
                </div>

            </div>
        </div>
    </main>
</div>
@endsection
