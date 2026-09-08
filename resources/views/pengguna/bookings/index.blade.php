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
                <a href="{{ route('pengguna.dashboard') }}" class="text-xs font-semibold text-zinc-400 hover:text-white transition uppercase tracking-widest">Dashboard</a>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-6 py-10">
        <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bengkel uppercase tracking-wide">Riwayat Booking Servis</h1>
                <p class="text-zinc-500 text-sm mt-1">Daftar pemesanan servis sepeda motor Anda.</p>
            </div>
            <a href="{{ route('servis') }}" class="inline-flex items-center bg-red-600 hover:bg-red-700 text-white text-[10px] font-bold px-6 py-3.5 rounded-xl uppercase tracking-widest transition shadow-lg shadow-red-900/40 w-max">
                Booking Baru
            </a>
        </div>

        @if(session('success'))
            <div class="mb-6 bg-emerald-900/30 border border-emerald-700 text-emerald-400 px-6 py-4 rounded-2xl text-sm font-semibold">
                ✓ {{ session('success') }}
            </div>
        @endif

        <div class="bg-zinc-900 rounded-3xl border border-zinc-800 overflow-hidden shadow-2xl">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-[11px] uppercase tracking-tighter">
                    <thead class="bg-zinc-950 text-zinc-500 border-b border-zinc-800">
                        <tr>
                            <th class="px-6 py-4">Servis</th>
                            <th class="px-6 py-4">Kendaraan</th>
                            <th class="px-6 py-4">Tanggal</th>
                            <th class="px-6 py-4">Jam</th>
                            <th class="px-6 py-4 text-center">Status</th>
                            <th class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-800/50 text-zinc-300">
                        @forelse ($bookings as $booking)
                        <tr class="hover:bg-zinc-800/30 transition-colors">
                            <td class="px-6 py-4 font-bold text-white">
                                {{ $booking->service->nama ?? 'Custom Service' }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="block text-white font-bold">{{ $booking->nama_kendaraan }}</span>
                                <span class="text-[9px] text-zinc-500">{{ $booking->plat_nomor }}</span>
                            </td>
                            <td class="px-6 py-4">
                                {{ $booking->tanggal_booking->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4">
                                {{ \Carbon\Carbon::parse($booking->jam_booking)->format('H:i') }} WIB
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="px-3 py-1 rounded-full text-[9px] font-bold border inline-block
                                    {{ $booking->status === 'pending' ? 'bg-orange-950/40 text-orange-400 border-orange-900/60' : '' }}
                                    {{ $booking->status === 'diterima' ? 'bg-blue-950/40 text-blue-400 border-blue-900/60' : '' }}
                                    {{ $booking->status === 'ditolak' ? 'bg-red-950/40 text-red-400 border-red-900/60' : '' }}
                                    {{ $booking->status === 'diproses' ? 'bg-yellow-950/40 text-yellow-500 border-yellow-900/60' : '' }}
                                    {{ $booking->status === 'selesai' ? 'bg-emerald-950/40 text-emerald-400 border-emerald-900/60' : '' }}
                                    {{ $booking->status === 'dibatalkan' ? 'bg-red-950/40 text-red-500 border-red-900/60' : '' }}
                                ">
                                    {{ $booking->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('pengguna.bookings.show', $booking->id) }}"
                                   class="inline-block bg-zinc-800 hover:bg-zinc-700 text-white text-[9px] font-bold py-2 px-4 rounded-lg transition">
                                    Lihat Detail
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-16 text-center">
                                <div class="flex flex-col items-center justify-center space-y-3 opacity-30">
                                    <svg class="w-12 h-12 text-zinc-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" stroke-width="1.5" stroke-linecap="round"/>
                                    </svg>
                                    <p class="italic tracking-widest text-sm">Belum ada riwayat booking</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="mt-6">
            {{ $bookings->links() }}
        </div>
    </div>
</div>
@endsection
