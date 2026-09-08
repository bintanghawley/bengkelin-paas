@extends('layouts.guest')

@section('content')
<div class="flex min-h-screen font-sans bg-gray-100 dark:bg-zinc-950">
    <aside class="w-64 bg-gray-50 dark:bg-zinc-900 border-r border-gray-200 dark:border-zinc-800 flex flex-col fixed h-full z-50">
        <div class="p-6 flex items-center gap-3 border-b border-gray-200 dark:border-zinc-800/50">
            <span class="text-3xl font-bengkel tracking-wider text-zinc-800 dark:text-white">BENGKEL<span class="text-red-600">IN</span></span>
        </div>
        <nav class="flex-1 px-4 space-y-2 mt-6">
            <a href="{{ route('pengguna.dashboard') }}?section=booking" class="w-full flex items-center gap-3 px-4 py-3 text-zinc-500 dark:text-zinc-400 rounded-xl font-bold transition">
                <svg fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17 17.25 21l2.75-2.75-5.83-5.83m-2.75 2.75 2.75-2.75m-2.75 2.75L8 18.59l-4.59-4.59L6.83 10.6m7.34 1.82 3.42-3.42a4 4 0 0 0-5.66-5.66L8.51 6.76"/></svg>
                BOOKING SERVIS
            </a>
            <a href="{{ route('pengguna.emergency.create') }}" class="w-full flex items-center gap-3 px-4 py-3 text-zinc-500 dark:text-zinc-400 rounded-xl font-bold transition">
                <svg fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z"/></svg>
                LAPOR DARURAT
            </a>
            <a href="{{ route('pengguna.emergency.index') }}" class="w-full flex items-center gap-3 px-4 py-3 text-red-600 bg-red-500/10 rounded-xl font-bold transition">
                <svg fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.03 0 1.9.693 2.166 1.638m-7.377 2.24c-.11.265-.166.552-.166.846v3.264c0 .294-.056.58-.166.846m0 0A2.25 2.25 0 006.75 12h.008a2.25 2.25 0 002.25-2.25V9m-2.25 0a2.25 2.25 0 012.25-2.25h.008"/></svg>
                RIWAYAT DARURAT
            </a>
        </nav>
        <div class="p-4 border-t border-gray-200 dark:border-zinc-800 space-y-2">
            <a href="{{ route('pengguna.dashboard') }}" class="group relative flex items-center justify-center gap-2 w-full text-center text-[10px] font-bold text-zinc-500 dark:text-zinc-400 hover:text-white uppercase tracking-widest border border-zinc-300 dark:border-zinc-800 hover:border-red-600 bg-white dark:bg-zinc-900/50 hover:bg-red-600/10 py-2.5 rounded-xl transition-all">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M10 19l-7-7m0 0l7-7m-7 7h18" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                <span>Kembali</span>
            </a>
            <form action="{{ route('logout') }}" method="POST" onsubmit="return confirm('Yakin ingin logout?')">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 text-red-500 hover:bg-red-500/10 rounded-xl transition font-bold uppercase tracking-widest text-[10px]">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9"/></svg>
                    Sign Out
                </button>
            </form>
        </div>
    </aside>

    <main class="flex-1 ml-64 p-10">
        <header class="flex justify-between items-center mb-10">
            <div>
                <h2 class="text-4xl font-bengkel tracking-wider text-zinc-800 dark:text-white">RIWAYAT <span class="text-red-600">DARURAT</span></h2>
                <p class="text-zinc-500 text-xs uppercase tracking-[0.2em] mt-1 italic">Laporan darurat yang pernah Anda kirim.</p>
            </div>
            <a href="{{ route('pengguna.emergency.create') }}" class="bg-red-600 hover:bg-red-700 text-white text-[10px] font-bold py-3 px-6 rounded-xl transition uppercase tracking-widest shadow-lg shadow-red-900/20">
                + Laporkan Darurat
            </a>
        </header>

        @if(session('success'))
            <div class="bg-emerald-500/10 border border-emerald-500/30 text-emerald-600 dark:text-emerald-400 px-6 py-4 rounded-2xl mb-6 text-xs font-bold tracking-wider uppercase">
                {{ session('success') }}
            </div>
        @endif

        <div class="space-y-4">
            @forelse($emergencies as $emergency)
                @php
                    $sc = match($emergency->status) {
                        'pending'          => 'bg-orange-100 dark:bg-orange-950/40 text-orange-600 dark:text-orange-400 border-orange-200 dark:border-orange-900/60',
                        'diterima'         => 'bg-blue-100 dark:bg-blue-950/40 text-blue-600 dark:text-blue-400 border-blue-200 dark:border-blue-900/60',
                        'dalam_perjalanan' => 'bg-yellow-100 dark:bg-yellow-950/40 text-yellow-600 dark:text-yellow-500 border-yellow-200 dark:border-yellow-900/60',
                        'sampai_lokasi'    => 'bg-purple-100 dark:bg-purple-950/40 text-purple-600 dark:text-purple-400 border-purple-200 dark:border-purple-900/60',
                        'selesai'          => 'bg-emerald-100 dark:bg-emerald-950/40 text-emerald-600 dark:text-emerald-400 border-emerald-200 dark:border-emerald-900/60',
                        'ditolak'          => 'bg-red-100 dark:bg-red-950/40 text-red-600 dark:text-red-500 border-red-200 dark:border-red-900/60',
                        'dibatalkan'       => 'bg-red-100 dark:bg-red-950/40 text-red-600 dark:text-red-500 border-red-200 dark:border-red-900/60',
                        default            => 'bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400 border-zinc-200 dark:border-zinc-700',
                    };
                @endphp
                <a href="{{ route('pengguna.emergency.show', $emergency->id) }}" class="block bg-gray-50 dark:bg-zinc-900 p-6 rounded-3xl border border-gray-200 dark:border-zinc-800 shadow-xl hover:shadow-2xl transition group">
                    <div class="flex justify-between items-start">
                        <div class="flex items-start gap-4">
                            <div class="h-12 w-12 bg-red-100 dark:bg-red-950/40 rounded-2xl flex items-center justify-center shrink-0 border border-red-200 dark:border-red-900/60">
                                <svg class="w-6 h-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z"/></svg>
                            </div>
                            <div>
                                <h4 class="font-bengkel text-lg text-zinc-800 dark:text-white uppercase tracking-wider group-hover:text-red-600 transition">{{ $emergency->nama_kendaraan }}</h4>
                                <p class="text-zinc-500 text-[10px] font-mono mt-0.5">{{ $emergency->plat_nomor }}</p>
                                <p class="text-zinc-500 text-xs mt-2 line-clamp-1">{{ $emergency->keluhan }}</p>
                                @if($emergency->lokasi_detail)
                                    <p class="text-zinc-400 text-[10px] mt-1 flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                        {{ $emergency->lokasi_detail }}
                                    </p>
                                @endif
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="px-3 py-1 rounded-full text-[9px] font-bold border inline-block {{ $sc }}">
                                {{ strtoupper(str_replace('_', ' ', $emergency->status)) }}
                            </span>
                            <p class="text-zinc-400 text-[10px] mt-2">{{ $emergency->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                </a>
            @empty
                <div class="text-center py-16 text-zinc-500 bg-gray-50 dark:bg-zinc-900 rounded-3xl border border-gray-200 dark:border-zinc-800 shadow-xl">
                    <svg class="w-12 h-12 text-zinc-400 mx-auto mb-3 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126Z"/></svg>
                    <p class="tracking-widest">Belum ada laporan darurat.</p>
                    <a href="{{ route('pengguna.emergency.create') }}" class="inline-block mt-4 text-red-600 hover:text-red-500 text-xs uppercase font-bold tracking-widest">Buat Laporan →</a>
                </div>
            @endforelse
        </div>

        <div class="mt-6">{{ $emergencies->links() }}</div>
    </main>
</div>
@endsection
