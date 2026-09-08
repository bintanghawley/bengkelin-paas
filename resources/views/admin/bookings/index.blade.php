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

        <div class="mb-8">
            <h1 class="text-2xl font-bengkel uppercase tracking-widest text-gray-900 dark:text-white">Semua Booking Servis</h1>
            <p class="text-gray-400 dark:text-zinc-500 text-xs mt-1 uppercase tracking-widest">Total: {{ $bookings->total() }} booking terdaftar</p>
        </div>



        <div class="bg-white dark:bg-zinc-900 rounded-3xl border border-gray-200 dark:border-zinc-800 overflow-hidden shadow-sm dark:shadow-2xl">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-[11px] uppercase tracking-tighter">
                    <thead class="bg-gray-100 dark:bg-zinc-950 text-gray-500 dark:text-zinc-500 border-b border-gray-200 dark:border-zinc-800">
                        <tr>
                            <th class="px-6 py-4">Pelanggan</th>
                            <th class="px-6 py-4">Layanan</th>
                            <th class="px-6 py-4">Tanggal</th>
                            <th class="px-6 py-4">Jam</th>
                            <th class="px-6 py-4">Mekanik</th>
                            <th class="px-6 py-4 text-center">Status</th>
                            <th class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-zinc-800/50 text-gray-600 dark:text-zinc-300">
                        @forelse ($bookings as $booking)
                        <tr class="hover:bg-gray-50 dark:hover:bg-zinc-800/30 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex flex-col">
                                    <span class="text-gray-900 dark:text-white font-bold">{{ $booking->user->name ?? 'Guest' }}</span>
                                    <span class="text-[9px] text-gray-400 dark:text-zinc-500 lowercase italic">Telp: {{ $booking->user->nomor_telepon ?? '-' }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="block text-red-600 dark:text-red-500 font-bold">{{ $booking->nama_kendaraan }}</span>
                                <span class="text-gray-400 dark:text-zinc-400 text-[10px]">{{ $booking->service->nama ?? '-' }}</span>
                            </td>
                            <td class="px-6 py-4">
                                {{ $booking->tanggal_booking->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4">
                                {{ \Carbon\Carbon::parse($booking->jam_booking)->format('H:i') }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-gray-900 dark:text-white">{{ $booking->mechanic->name ?? 'Belum Ditugaskan' }}</span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                @php
                                    $bc = match($booking->status) {
                                        'pending'    => 'bg-orange-950/40 text-orange-400 border-orange-900/60',
                                        'diterima'   => 'bg-blue-950/40 text-blue-400 border-blue-900/60',
                                        'diproses'   => 'bg-yellow-950/40 text-yellow-500 border-yellow-900/60',
                                        'selesai'    => 'bg-emerald-950/40 text-emerald-400 border-emerald-900/60',
                                        'ditolak'    => 'bg-red-950/40 text-red-400 border-red-900/60',
                                        'dibatalkan' => 'bg-red-950/40 text-red-500 border-red-900/60',
                                        default      => 'bg-zinc-800 text-zinc-400 border-zinc-700',
                                    };
                                @endphp
                                <span class="px-3 py-1 rounded-full text-[9px] font-bold border inline-block {{ $bc }}">
                                    {{ strtoupper($booking->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('admin.bookings.show', $booking->id) }}"
                                   class="text-blue-400 hover:text-blue-300 font-bold transition">Kelola</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-16 text-center text-gray-400 dark:text-zinc-600">
                                Belum ada booking masuk.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-6">
            {{ $bookings->links() }}
    </main>
</div>
@endsection
