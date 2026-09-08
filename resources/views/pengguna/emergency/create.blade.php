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
            <a href="{{ route('pengguna.emergency.create') }}" class="w-full flex items-center gap-3 px-4 py-3 text-red-600 bg-red-500/10 rounded-xl font-bold transition">
                <svg fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z"/></svg>
                <div class="text-left">
                    <span class="block text-xs">DARURAT</span>
                    <span class="block text-[9px] opacity-60">Mogok di jalan?</span>
                </div>
            </a>
            <a href="{{ route('pengguna.emergency.index') }}" class="w-full flex items-center gap-3 px-4 py-3 text-zinc-500 dark:text-zinc-400 rounded-xl font-bold transition">
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
        <header class="mb-10">
            <a href="{{ route('pengguna.emergency.index') }}" class="text-xs text-red-600 hover:text-red-500 transition uppercase font-bold tracking-widest">← Kembali ke Riwayat Darurat</a>
            <h2 class="text-4xl font-bengkel tracking-wider text-zinc-800 dark:text-white mt-2">LAPORAN <span class="text-red-600">DARURAT</span></h2>
            <p class="text-zinc-500 text-xs uppercase tracking-[0.2em] mt-1 italic">Kendaraan mogok? Kirim lokasi Anda sekarang.</p>
        </header>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Form -->
            <div class="bg-gray-50 dark:bg-zinc-900 p-8 rounded-3xl border border-gray-200 dark:border-zinc-800 shadow-xl">
                <h3 class="text-xl font-bengkel text-red-600 uppercase tracking-widest mb-6">Detail Darurat</h3>
                <form action="{{ route('pengguna.emergency.store') }}" method="POST" class="space-y-5" onsubmit="return confirm('Kirim laporan darurat ke bengkel?')">
                    @csrf
                    <div class="space-y-1">
                        <label class="text-[10px] uppercase text-zinc-500 font-bold tracking-widest block">Nama Kendaraan *</label>
                        <input type="text" name="nama_kendaraan" required value="{{ old('nama_kendaraan') }}" placeholder="Misal: Honda Vario 125"
                            class="w-full bg-gray-100 dark:bg-zinc-950 border border-gray-200 dark:border-zinc-800 rounded-xl px-4 py-3 text-sm text-zinc-800 dark:text-white focus:border-red-600 outline-none transition">
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] uppercase text-zinc-500 font-bold tracking-widest block">Plat Nomor *</label>
                        <input type="text" name="plat_nomor" required value="{{ old('plat_nomor') }}" placeholder="Misal: L 1234 AB"
                            class="w-full bg-gray-100 dark:bg-zinc-950 border border-gray-200 dark:border-zinc-800 rounded-xl px-4 py-3 text-sm text-zinc-800 dark:text-white focus:border-red-600 outline-none transition">
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] uppercase text-zinc-500 font-bold tracking-widest block">Keluhan / Kondisi Darurat *</label>
                        <textarea name="keluhan" required rows="3" placeholder="Jelaskan kondisi kendaraan Anda (misal: motor mogok, mesin mati mendadak, ban bocor)..."
                            class="w-full bg-gray-100 dark:bg-zinc-950 border border-gray-200 dark:border-zinc-800 rounded-xl px-4 py-3 text-sm text-zinc-800 dark:text-white focus:border-red-600 outline-none transition resize-none">{{ old('keluhan') }}</textarea>
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] uppercase text-zinc-500 font-bold tracking-widest block">Detail Lokasi (opsional)</label>
                        <input type="text" name="lokasi_detail" value="{{ old('lokasi_detail') }}" placeholder="Misal: Depan Indomaret, Jl. Raya Sidoarjo"
                            class="w-full bg-gray-100 dark:bg-zinc-950 border border-gray-200 dark:border-zinc-800 rounded-xl px-4 py-3 text-sm text-zinc-800 dark:text-white focus:border-red-600 outline-none transition">
                    </div>

                    <!-- Hidden lat/lng -->
                    <input type="hidden" id="latitude" name="latitude" value="{{ old('latitude') }}">
                    <input type="hidden" id="longitude" name="longitude" value="{{ old('longitude') }}">

                    <button type="submit" id="submit-btn"
                        class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-4 rounded-xl uppercase text-[10px] tracking-widest transition shadow-lg shadow-red-900/20 flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/></svg>
                        Kirim Laporan Darurat
                    </button>
                </form>
            </div>

            <!-- Map -->
            <div class="bg-gray-50 dark:bg-zinc-900 p-8 rounded-3xl border border-gray-200 dark:border-zinc-800 shadow-xl">
                <h3 class="text-xl font-bengkel text-red-600 uppercase tracking-widest mb-2">Pin Lokasi Anda</h3>
                <p class="text-zinc-500 text-xs uppercase tracking-widest mb-4">Gunakan lokasi perangkat atau klik peta untuk memilih titik secara manual.</p>
                <button type="button" id="locate-button" class="mb-4 w-full bg-blue-600 hover:bg-blue-700 disabled:bg-zinc-700 disabled:text-zinc-400 text-white text-[10px] font-bold py-3 px-5 rounded-xl transition uppercase tracking-widest">
                    Gunakan Lokasi Saya
                </button>
                <div id="map" class="w-full h-96 rounded-2xl border border-gray-200 dark:border-zinc-800 bg-gray-200 dark:bg-zinc-950"></div>
                <p id="coord-display" role="status" class="text-zinc-500 text-[10px] uppercase tracking-widest mt-3 text-center">Lokasi belum dipilih</p>
            </div>
        </div>
    </main>
</div>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet@1.9.4/dist/leaflet.css">
<script src="https://cdn.jsdelivr.net/npm/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    const defaultLocation = [-7.4478, 112.7183];
    const map = L.map('map').setView(defaultLocation, 14);
    let marker;

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    function placeMarker(lat, lng) {
        if (marker) {
            marker.setLatLng([lat, lng]);
        } else {
            marker = L.marker([lat, lng], { draggable: true }).addTo(map);
            marker.on('dragend', function () {
                const position = marker.getLatLng();
                setCoords(position.lat, position.lng);
            });
        }
        setCoords(lat, lng);
    }

    function setCoords(lat, lng) {
        document.getElementById('latitude').value = lat.toFixed(7);
        document.getElementById('longitude').value = lng.toFixed(7);
        document.getElementById('coord-display').textContent = 'Koordinat: ' + lat.toFixed(6) + ', ' + lng.toFixed(6);
    }

    map.on('click', function (event) {
        placeMarker(event.latlng.lat, event.latlng.lng);
    });

    function locateUser() {
        const button = document.getElementById('locate-button');
        const display = document.getElementById('coord-display');
        if (!window.isSecureContext || !navigator.geolocation) {
            display.textContent = 'GPS browser tidak tersedia. Klik peta untuk memilih lokasi.';
            return;
        }
        button.disabled = true;
        display.textContent = 'Mencari lokasi perangkat...';
        navigator.geolocation.getCurrentPosition(function (position) {
            const lat = position.coords.latitude;
            const lng = position.coords.longitude;
            map.setView([lat, lng], 16);
            placeMarker(lat, lng);
            button.disabled = false;
        }, function () {
            display.textContent = 'Lokasi gagal dibaca. Pastikan GPS aktif atau klik peta secara manual.';
            button.disabled = false;
        }, { enableHighAccuracy: true, timeout: 15000, maximumAge: 0 });
    }

    document.getElementById('locate-button').addEventListener('click', locateUser);
</script>
@endsection
