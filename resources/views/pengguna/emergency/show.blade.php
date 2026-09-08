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
            <a href="{{ route('pengguna.emergency.index') }}" class="w-full flex items-center gap-3 px-4 py-3 text-red-600 bg-red-500/10 rounded-xl font-bold transition">
                <svg fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z"/></svg>
                RIWAYAT DARURAT
            </a>
        </nav>
        <div class="p-4 border-t border-gray-200 dark:border-zinc-800 space-y-2">
            <a href="{{ route('pengguna.emergency.index') }}" class="group relative flex items-center justify-center gap-2 w-full text-center text-[10px] font-bold text-zinc-500 dark:text-zinc-400 hover:text-white uppercase tracking-widest border border-zinc-300 dark:border-zinc-800 hover:border-red-600 bg-white dark:bg-zinc-900/50 hover:bg-red-600/10 py-2.5 rounded-xl transition-all">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M10 19l-7-7m0 0l7-7m-7 7h18" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                <span>Kembali</span>
            </a>
        </div>
    </aside>

    <main class="flex-1 ml-64 p-10">
        <header class="mb-8">
            <a href="{{ route('pengguna.emergency.index') }}" class="text-xs text-red-600 hover:text-red-500 transition uppercase font-bold tracking-widest">← Kembali ke Riwayat Darurat</a>
            <div class="flex justify-between items-center mt-2">
                <h2 class="text-4xl font-bengkel tracking-wider text-zinc-800 dark:text-white">DARURAT <span class="text-red-600">#{{ $emergency->id }}</span></h2>
                @php
                    $sc = match($emergency->status) {
                        'pending'          => 'bg-orange-100 dark:bg-orange-950/40 text-orange-600 dark:text-orange-400 border-orange-200 dark:border-orange-900/60',
                        'diterima'         => 'bg-blue-100 dark:bg-blue-950/40 text-blue-600 dark:text-blue-400 border-blue-200 dark:border-blue-900/60',
                        'dalam_perjalanan' => 'bg-yellow-100 dark:bg-yellow-950/40 text-yellow-600 dark:text-yellow-500 border-yellow-200 dark:border-yellow-900/60',
                        'sampai_lokasi'    => 'bg-purple-100 dark:bg-purple-950/40 text-purple-600 dark:text-purple-400 border-purple-200 dark:border-purple-900/60',
                        'selesai'          => 'bg-emerald-100 dark:bg-emerald-950/40 text-emerald-600 dark:text-emerald-400 border-emerald-200 dark:border-emerald-900/60',
                        'ditolak'          => 'bg-red-100 dark:bg-red-950/40 text-red-600 dark:text-red-500 border-red-200 dark:border-red-900/60',
                        default            => 'bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400 border-zinc-200 dark:border-zinc-700',
                    };
                @endphp
                <span class="px-4 py-1.5 rounded-full text-xs font-bold border {{ $sc }}">
                    {{ strtoupper(str_replace('_', ' ', $emergency->status)) }}
                </span>
            </div>
        </header>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
            <!-- Left: Info -->
            <div class="bg-gray-50 dark:bg-zinc-900 border border-gray-200 dark:border-zinc-800 rounded-3xl p-6 space-y-6 shadow-xl">
                <h3 class="text-xs text-zinc-500 uppercase tracking-widest font-bold border-b border-gray-200 dark:border-zinc-800 pb-3">Detail Darurat</h3>
                <div>
                    <p class="text-[10px] text-zinc-400 uppercase font-bold tracking-widest">Kendaraan</p>
                    <p class="text-sm font-bold text-zinc-800 dark:text-white uppercase mt-1">{{ $emergency->nama_kendaraan }}</p>
                    <p class="text-xs text-zinc-500 font-mono">{{ $emergency->plat_nomor }}</p>
                </div>
                <div>
                    <p class="text-[10px] text-zinc-400 uppercase font-bold tracking-widest">Lokasi</p>
                    <p class="text-sm text-zinc-800 dark:text-white mt-1">{{ $emergency->lokasi_detail ?: 'Tidak ada detail' }}</p>
                    <p class="text-[10px] text-zinc-500 font-mono mt-1">{{ number_format($emergency->latitude, 6) }}, {{ number_format($emergency->longitude, 6) }}</p>
                </div>
                @if($emergency->mechanic)
                <div>
                    <p class="text-[10px] text-zinc-400 uppercase font-bold tracking-widest">Mekanik</p>
                    <p class="text-sm font-bold text-zinc-800 dark:text-white uppercase mt-1">{{ $emergency->mechanic->name }}</p>
                    <p class="text-[10px] text-zinc-500 font-mono">{{ $emergency->mechanic->nomor_telepon ?? '-' }}</p>
                </div>
                @endif
                <div>
                    <p class="text-[10px] text-zinc-400 uppercase font-bold tracking-widest">Dikirim</p>
                    <p class="text-sm text-zinc-800 dark:text-white mt-1">{{ $emergency->created_at->format('d M Y, H:i') }}</p>
                </div>
            </div>

            <!-- Right: Keluhan & Map -->
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-gray-50 dark:bg-zinc-900 border border-gray-200 dark:border-zinc-800 rounded-3xl p-6 shadow-xl">
                    <h3 class="text-xs text-zinc-500 uppercase tracking-widest font-bold border-b border-gray-200 dark:border-zinc-800 pb-3 mb-4">Keluhan</h3>
                    <p class="text-zinc-800 dark:text-zinc-300 text-sm leading-relaxed whitespace-pre-line">{{ $emergency->keluhan }}</p>
                </div>

                @if($emergency->catatan_mekanik)
                <div class="bg-gray-50 dark:bg-zinc-900 border border-gray-200 dark:border-zinc-800 rounded-3xl p-6 shadow-xl">
                    <h3 class="text-xs text-zinc-500 uppercase tracking-widest font-bold border-b border-gray-200 dark:border-zinc-800 pb-3 mb-4">Catatan Mekanik</h3>
                    <p class="text-zinc-800 dark:text-zinc-300 text-sm leading-relaxed whitespace-pre-line">{{ $emergency->catatan_mekanik }}</p>
                </div>
                @endif

                <div class="bg-gray-50 dark:bg-zinc-900 border border-gray-200 dark:border-zinc-800 rounded-3xl p-6 shadow-xl">
                    <h3 class="text-xs text-zinc-500 uppercase tracking-widest font-bold border-b border-gray-200 dark:border-zinc-800 pb-3 mb-4">Lokasi di Peta</h3>
                    <div id="map" class="w-full h-72 rounded-2xl border border-gray-200 dark:border-zinc-800 bg-gray-200 dark:bg-zinc-950"></div>
                </div>

                <!-- Status Timeline -->
                <div class="bg-gray-50 dark:bg-zinc-900 border border-gray-200 dark:border-zinc-800 rounded-3xl p-6 shadow-xl">
                    <h3 class="text-xs text-zinc-500 uppercase tracking-widest font-bold border-b border-gray-200 dark:border-zinc-800 pb-3 mb-4">Status Penanganan</h3>
                    <div class="space-y-4">
                        @php
                            $steps = [
                                ['key' => 'pending', 'label' => 'Menunggu Mekanik', 'icon' => 'clock'],
                                ['key' => 'diterima', 'label' => 'Diterima Mekanik', 'icon' => 'check'],
                                ['key' => 'dalam_perjalanan', 'label' => 'Mekanik Dalam Perjalanan', 'icon' => 'car'],
                                ['key' => 'sampai_lokasi', 'label' => 'Sampai di Lokasi', 'icon' => 'pin'],
                                ['key' => 'selesai', 'label' => 'Selesai Ditangani', 'icon' => 'done'],
                            ];
                            $currentIndex = collect($steps)->pluck('key')->search($emergency->status);
                            if ($emergency->status === 'ditolak') $currentIndex = -1;
                        @endphp
                        @foreach($steps as $i => $step)
                            @php
                                $isActive = $i <= $currentIndex;
                                $isCurrent = $i === $currentIndex;
                            @endphp
                            <div class="flex items-center gap-4">
                                <div class="h-8 w-8 rounded-full flex items-center justify-center shrink-0 {{ $isActive ? 'bg-emerald-500' : 'bg-gray-200 dark:bg-zinc-800' }}">
                                    @if($isActive)
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                    @else
                                        <div class="h-2 w-2 bg-zinc-500 rounded-full {{ $isCurrent ? 'animate-pulse' : '' }}"></div>
                                    @endif
                                </div>
                                <span class="text-xs font-bold uppercase tracking-widest {{ $isActive ? 'text-zinc-800 dark:text-white' : 'text-zinc-400' }}">{{ $step['label'] }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet@1.9.4/dist/leaflet.css">
<script src="https://cdn.jsdelivr.net/npm/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    const position = [{{ $emergency->latitude }}, {{ $emergency->longitude }}];
    const map = L.map('map').setView(position, 15);
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);
    L.marker(position).addTo(map).bindPopup(@json($emergency->nama_kendaraan)).openPopup();
</script>
@endsection
