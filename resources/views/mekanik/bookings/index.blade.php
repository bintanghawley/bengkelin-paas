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

        <div class="mb-8">
            <h1 class="text-3xl font-bengkel uppercase tracking-widest">BOOKING <span class="text-red-600">MASUK</span></h1>
            <p class="text-zinc-500 text-xs mt-1 uppercase tracking-widest">Terima atau tolak permintaan servis dari pelanggan</p>
        </div>



        {{-- ══ SECTION 1: Pending Bookings (can accept/reject) ══ --}}
        <div class="bg-zinc-900 rounded-3xl border border-zinc-800 overflow-hidden shadow-2xl mb-8">
            <div class="p-6 border-b border-zinc-800 flex justify-between items-center">
                <h3 class="font-bengkel text-lg uppercase tracking-wider">🔔 Permintaan Booking Baru</h3>
                @if($pendingBookings->count() > 0)
                    <span class="text-[9px] bg-red-950/40 text-red-400 px-3 py-1 rounded-full border border-red-900/60 font-bold uppercase animate-pulse">{{ $pendingBookings->count() }} Menunggu</span>
                @else
                    <span class="text-[9px] bg-zinc-800 text-zinc-500 px-3 py-1 rounded-full border border-zinc-700 font-bold uppercase">Tidak ada</span>
                @endif
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-[11px] uppercase tracking-tighter">
                    <thead class="bg-zinc-950 text-zinc-500 border-b border-zinc-800">
                        <tr>
                            <th class="px-6 py-4">Pelanggan</th>
                            <th class="px-6 py-4">Servis / Motor</th>
                            <th class="px-6 py-4">Jadwal</th>
                            <th class="px-6 py-4">Keluhan</th>
                            <th class="px-6 py-4 text-center">Aksi Cepat</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-800/50 text-zinc-300">
                        @forelse ($pendingBookings as $booking)
                        <tr class="hover:bg-zinc-800/20 transition-colors">
                            <td class="px-6 py-4">
                                <span class="block font-bold text-white">{{ $booking->user->name ?? 'Guest' }}</span>
                                <span class="text-[9px] text-zinc-500 font-mono">{{ $booking->user->nomor_telepon ?? '-' }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="block text-red-400 font-bold">{{ $booking->nama_kendaraan }}</span>
                                <span class="text-zinc-400 text-[10px]">{{ $booking->service->nama ?? '-' }}</span>
                                <span class="text-zinc-600 text-[9px] font-mono">{{ $booking->plat_nomor }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="block text-white font-semibold">{{ $booking->tanggal_booking->format('d M Y') }}</span>
                                <span class="text-zinc-400 text-[10px]">{{ \Carbon\Carbon::parse($booking->jam_booking)->format('H:i') }} WIB</span>
                            </td>
                            <td class="px-6 py-4 max-w-[180px]">
                                <p class="text-zinc-400 line-clamp-2 text-[10px] normal-case">{{ $booking->keluhan ?: 'Tidak ada keluhan.' }}</p>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <a href="{{ route('mekanik.bookings.show', $booking) }}"
                                    class="inline-block bg-zinc-700 hover:bg-zinc-600 text-white text-[9px] font-bold py-2 px-4 rounded-lg transition uppercase tracking-wider">
                                    Lihat Detail
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-16 text-center text-zinc-600 italic">
                                Tidak ada booking baru yang menunggu. Semua sudah tertangani! 🎉
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- ══ SECTION 2: My Bookings (accepted/in-progress/done/rejected) ══ --}}
        <div class="bg-zinc-900 rounded-3xl border border-zinc-800 overflow-hidden shadow-2xl">
            <div class="p-6 border-b border-zinc-800 flex justify-between items-center">
                <h3 class="font-bengkel text-lg uppercase tracking-wider">Tugas Saya</h3>
                <span class="text-[9px] bg-zinc-800 text-zinc-400 px-3 py-1 rounded-full border border-zinc-700 font-bold">{{ $myBookings->total() }} Total</span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-[11px] uppercase tracking-tighter">
                    <thead class="bg-zinc-950 text-zinc-500 border-b border-zinc-800">
                        <tr>
                            <th class="px-6 py-4">Pelanggan</th>
                            <th class="px-6 py-4">Servis / Motor</th>
                            <th class="px-6 py-4">Jadwal</th>
                            <th class="px-6 py-4 text-center">Status</th>
                            <th class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-800/50 text-zinc-300">
                        @forelse ($myBookings as $booking)
                        <tr class="hover:bg-zinc-800/30 transition-colors">
                            <td class="px-6 py-4 font-bold text-white">
                                {{ $booking->user->name ?? 'Guest' }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="block text-red-400 font-bold">{{ $booking->nama_kendaraan }}</span>
                                <span class="text-zinc-400 text-[10px]">{{ $booking->service->nama ?? '-' }}</span>
                            </td>
                            <td class="px-6 py-4">
                                {{ $booking->tanggal_booking->format('d/m/Y') }}
                                @ {{ \Carbon\Carbon::parse($booking->jam_booking)->format('H:i') }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                @php
                                    $sc = match($booking->status) {
                                        'diterima'   => 'bg-blue-950/40 text-blue-400 border-blue-900/60',
                                        'diproses'   => 'bg-yellow-950/40 text-yellow-500 border-yellow-900/60',
                                        'selesai'    => 'bg-emerald-950/40 text-emerald-400 border-emerald-900/60',
                                        'ditolak'    => 'bg-red-950/40 text-red-400 border-red-900/60',
                                        'dibatalkan' => 'bg-red-950/40 text-red-500 border-red-900/60',
                                        default      => 'bg-zinc-800 text-zinc-400 border-zinc-700',
                                    };
                                @endphp
                                <span class="px-3 py-1 rounded-full text-[9px] font-bold border inline-block {{ $sc }}">
                                    {{ strtoupper($booking->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('mekanik.bookings.show', $booking) }}"
                                    class="inline-block bg-zinc-800 hover:bg-zinc-700 text-white text-[9px] font-bold py-2 px-4 rounded-lg transition">
                                    Detail & Update
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-16 text-center text-zinc-600 italic">
                                Belum ada tugas yang pernah dikerjakan.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($myBookings->hasPages())
            <div class="p-6 border-t border-zinc-800">
                {{ $myBookings->links() }}
            </div>
            @endif
        </div>

    </main>
</div>
@endsection
