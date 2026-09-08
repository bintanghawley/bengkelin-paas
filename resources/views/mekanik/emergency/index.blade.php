@extends('layouts.guest')

@section('content')
<div class="flex min-h-screen font-sans bg-zinc-950 text-white">
    @include('mekanik.partials.sidebar')

    <main class="flex-1 ml-64 p-10 min-h-screen">
        <header class="flex justify-between items-center mb-10">
            <div>
                <h2 class="text-4xl font-bengkel tracking-wider text-white">DARURAT <span class="text-red-600">MASUK</span></h2>
                <p class="text-zinc-500 text-xs uppercase tracking-[0.2em] mt-1 italic">Laporan darurat dari pelanggan.</p>
            </div>
        </header>

        @if(session('success'))
            <div class="bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 px-6 py-4 rounded-2xl mb-6 text-xs font-bold tracking-wider uppercase">
                {{ session('success') }}
            </div>
        @endif

        <!-- Pending Emergencies -->
        <div class="bg-zinc-900 rounded-3xl border border-zinc-800 overflow-hidden shadow-2xl mb-8">
            <div class="p-6 border-b border-zinc-800 flex justify-between items-center">
                <h3 class="font-bengkel text-lg text-white uppercase tracking-wider">🔴 Menunggu Ditanggapi</h3>
                <span class="text-[9px] bg-red-950/40 text-red-400 px-3 py-1 rounded-full border border-red-900/60 font-bold uppercase">{{ $pendingEmergencies->count() }} Pending</span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-[11px] uppercase tracking-tighter">
                    <thead class="bg-zinc-950 text-zinc-500 border-b border-zinc-800">
                        <tr>
                            <th class="px-6 py-4">Pelanggan</th>
                            <th class="px-6 py-4">Kendaraan</th>
                            <th class="px-6 py-4">Keluhan</th>
                            <th class="px-6 py-4">Lokasi</th>
                            <th class="px-6 py-4 text-center">Waktu</th>
                            <th class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-800/50 text-zinc-300">
                        @forelse($pendingEmergencies as $emergency)
                        <tr class="hover:bg-zinc-800/30 transition-colors">
                            <td class="px-6 py-4">
                                <span class="block font-bold text-white">{{ $emergency->user->name ?? 'Guest' }}</span>
                                <span class="text-[9px] text-zinc-500 font-mono">{{ $emergency->user->nomor_telepon ?? '-' }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="block text-red-500 font-bold">{{ $emergency->nama_kendaraan }}</span>
                                <span class="text-zinc-400 text-[10px] font-mono">{{ $emergency->plat_nomor }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-xs line-clamp-2">{{ Str::limit($emergency->keluhan, 60) }}</span>
                            </td>
                            <td class="px-6 py-4">
                                @if($emergency->lokasi_detail)
                                    <span class="text-xs">{{ Str::limit($emergency->lokasi_detail, 40) }}</span>
                                @else
                                    <span class="text-zinc-600 text-[10px]">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="text-zinc-400">{{ $emergency->created_at->diffForHumans() }}</span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('mekanik.emergency.show', $emergency->id) }}"
                                   class="inline-block bg-red-600 hover:bg-red-500 text-white text-[9px] font-bold py-2 px-4 rounded-lg transition">
                                    Lihat & Tanggapi
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-zinc-600 italic">
                                Tidak ada laporan darurat yang menunggu.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- My Emergency Tasks -->
        <div class="bg-zinc-900 rounded-3xl border border-zinc-800 overflow-hidden shadow-2xl">
            <div class="p-6 border-b border-zinc-800 flex justify-between items-center">
                <h3 class="font-bengkel text-lg text-white uppercase tracking-wider">Riwayat Tanggapan Darurat Saya</h3>
                <span class="text-[9px] bg-zinc-800 text-zinc-400 px-3 py-1 rounded-full border border-zinc-700 font-bold">{{ $myEmergencies->count() }} Total</span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-[11px] uppercase tracking-tighter">
                    <thead class="bg-zinc-950 text-zinc-500 border-b border-zinc-800">
                        <tr>
                            <th class="px-6 py-4">Pelanggan</th>
                            <th class="px-6 py-4">Kendaraan</th>
                            <th class="px-6 py-4">Tanggal</th>
                            <th class="px-6 py-4 text-center">Status</th>
                            <th class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-800/50 text-zinc-300">
                        @forelse($myEmergencies as $emergency)
                        <tr class="hover:bg-zinc-800/30 transition-colors">
                            <td class="px-6 py-4">
                                <span class="block font-bold text-white">{{ $emergency->user->name ?? 'Guest' }}</span>
                                <span class="text-[9px] text-zinc-500 font-mono">{{ $emergency->user->nomor_telepon ?? '-' }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="block text-red-500 font-bold">{{ $emergency->nama_kendaraan }}</span>
                                <span class="text-zinc-400 text-[10px] font-mono">{{ $emergency->plat_nomor }}</span>
                            </td>
                            <td class="px-6 py-4">{{ $emergency->created_at->format('d/m/Y H:i') }}</td>
                            <td class="px-6 py-4 text-center">
                                @php
                                    $sc = match($emergency->status) {
                                        'diterima'         => 'bg-blue-950/40 text-blue-400 border-blue-900/60',
                                        'dalam_perjalanan' => 'bg-yellow-950/40 text-yellow-500 border-yellow-900/60',
                                        'sampai_lokasi'    => 'bg-purple-950/40 text-purple-400 border-purple-900/60',
                                        'selesai'          => 'bg-emerald-950/40 text-emerald-400 border-emerald-900/60',
                                        'ditolak'          => 'bg-red-950/40 text-red-400 border-red-900/60',
                                        default            => 'bg-zinc-800 text-zinc-400 border-zinc-700',
                                    };
                                @endphp
                                <span class="px-3 py-1 rounded-full text-[9px] font-bold border inline-block {{ $sc }}">
                                    {{ strtoupper(str_replace('_', ' ', $emergency->status)) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('mekanik.emergency.show', $emergency->id) }}"
                                   class="inline-block bg-zinc-800 hover:bg-zinc-700 text-white text-[9px] font-bold py-2 px-4 rounded-lg transition">
                                    Detail
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-16 text-center text-zinc-600 italic">
                                Belum ada riwayat tanggapan darurat.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>
@endsection
