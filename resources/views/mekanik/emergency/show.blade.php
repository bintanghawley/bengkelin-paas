@extends('layouts.guest')

@section('content')
<div class="flex min-h-screen font-sans bg-zinc-950 text-white">
    @include('mekanik.partials.sidebar')

    <main class="flex-1 ml-64 p-10 min-h-screen">
        <header class="flex justify-between items-center mb-10">
            <div>
                <a href="{{ route('mekanik.emergency.index') }}" class="text-xs text-red-500 hover:text-red-400 transition uppercase font-bold tracking-widest">← Kembali ke Darurat</a>
                <h2 class="text-4xl font-bengkel tracking-wider text-white mt-2">DARURAT <span class="text-red-600">#{{ $emergency->id }}</span></h2>
            </div>
            @php
                $sc = match($emergency->status) {
                    'pending'          => 'bg-orange-950/40 text-orange-400 border-orange-900/60',
                    'diterima'         => 'bg-blue-950/40 text-blue-400 border-blue-900/60',
                    'dalam_perjalanan' => 'bg-yellow-950/40 text-yellow-500 border-yellow-900/60',
                    'sampai_lokasi'    => 'bg-purple-950/40 text-purple-400 border-purple-900/60',
                    'selesai'          => 'bg-emerald-950/40 text-emerald-400 border-emerald-900/60',
                    'ditolak'          => 'bg-red-950/40 text-red-400 border-red-900/60',
                    default            => 'bg-zinc-800 text-zinc-400 border-zinc-700',
                };
            @endphp
            <span class="px-4 py-1.5 rounded-full text-xs font-bold border {{ $sc }}">
                {{ strtoupper(str_replace('_', ' ', $emergency->status)) }}
            </span>
        </header>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
            <!-- Left: Info -->
            <div class="bg-zinc-900 border border-zinc-800 rounded-3xl p-6 space-y-6 shadow-2xl">
                <h3 class="text-xs text-zinc-500 uppercase tracking-widest font-bold border-b border-zinc-800 pb-3">Informasi Darurat</h3>
                <div>
                    <p class="text-[10px] text-zinc-400 uppercase font-bold tracking-widest">Pelanggan</p>
                    <p class="text-sm font-bold text-white uppercase mt-1">{{ $emergency->user->name ?? 'Guest' }}</p>
                    <p class="text-[10px] text-zinc-500 font-mono">{{ $emergency->user->nomor_telepon ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-[10px] text-zinc-400 uppercase font-bold tracking-widest">Kendaraan</p>
                    <p class="text-sm font-bold text-white uppercase mt-1">{{ $emergency->nama_kendaraan }}</p>
                    <p class="text-xs text-zinc-500 font-mono">{{ $emergency->plat_nomor }}</p>
                </div>
                <div>
                    <p class="text-[10px] text-zinc-400 uppercase font-bold tracking-widest">Lokasi</p>
                    <p class="text-sm text-white mt-1">{{ $emergency->lokasi_detail ?: 'Tidak ada detail' }}</p>
                    <p class="text-[10px] text-zinc-500 font-mono mt-1">{{ number_format($emergency->latitude, 6) }}, {{ number_format($emergency->longitude, 6) }}</p>
                    <a href="https://www.openstreetmap.org/directions?engine=fossgis_osrm_car&route=;{{ $emergency->latitude }},{{ $emergency->longitude }}" target="_blank" rel="noopener noreferrer"
                       class="inline-flex items-center gap-1 mt-2 text-[10px] text-blue-400 hover:text-blue-300 font-bold uppercase tracking-widest">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
                        Buka Rute OpenStreetMap
                    </a>
                </div>
                <div>
                    <p class="text-[10px] text-zinc-400 uppercase font-bold tracking-widest">Dikirim</p>
                    <p class="text-sm text-white mt-1">{{ $emergency->created_at->format('d M Y, H:i') }}</p>
                </div>
            </div>

            <!-- Right: Keluhan & Aksi -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Keluhan -->
                <div class="bg-zinc-900 border border-zinc-800 rounded-3xl p-6 shadow-2xl">
                    <h3 class="text-xs text-zinc-500 uppercase tracking-widest font-bold border-b border-zinc-800 pb-3 mb-4">Keluhan Pelanggan</h3>
                    <p class="text-zinc-300 text-sm leading-relaxed whitespace-pre-line">{{ $emergency->keluhan }}</p>
                </div>

                <!-- Map -->
                <div class="bg-zinc-900 border border-zinc-800 rounded-3xl p-6 shadow-2xl">
                    <h3 class="text-xs text-zinc-500 uppercase tracking-widest font-bold border-b border-zinc-800 pb-3 mb-4">Lokasi Pelanggan</h3>
                    <div id="map" class="w-full h-64 rounded-2xl border border-zinc-800 bg-zinc-950"></div>
                </div>

                <!-- Aksi -->
                <div class="bg-zinc-900 border border-zinc-800 rounded-3xl p-6 shadow-2xl space-y-4">
                    <h3 class="text-xs text-zinc-500 uppercase tracking-widest font-bold border-b border-zinc-800 pb-3">Aksi Penanganan</h3>

                    @if($emergency->status === 'pending')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <form action="{{ route('mekanik.emergency.update', $emergency->id) }}" method="POST" onsubmit="return confirm('Terima laporan darurat ini?')">
                                @csrf @method('PUT')
                                <input type="hidden" name="action" value="accept">
                                <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-500 text-white font-bold py-4 rounded-xl uppercase text-[10px] tracking-widest transition shadow-lg shadow-emerald-950/20 flex items-center justify-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                    Terima & Menuju Lokasi
                                </button>
                            </form>
                            <form action="{{ route('mekanik.emergency.update', $emergency->id) }}" method="POST" class="space-y-3" onsubmit="return confirm('Tolak laporan ini?')">
                                @csrf @method('PUT')
                                <input type="hidden" name="action" value="reject">
                                <textarea name="catatan_mekanik" rows="2" placeholder="Alasan penolakan (opsional)..."
                                    class="w-full bg-zinc-950 border border-zinc-800 rounded-xl px-4 py-3 text-xs text-white focus:border-red-500 outline-none transition resize-none"></textarea>
                                <button type="submit" class="w-full bg-red-600 hover:bg-red-500 text-white font-bold py-4 rounded-xl uppercase text-[10px] tracking-widest transition shadow-lg shadow-red-950/20 flex items-center justify-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                                    Tolak
                                </button>
                            </form>
                        </div>

                    @elseif($emergency->status === 'diterima' && $emergency->mechanic_id === auth()->id())
                        <p class="text-blue-400 text-xs">Laporan diterima. Mulai perjalanan ke lokasi pelanggan.</p>
                        <form action="{{ route('mekanik.emergency.update', $emergency->id) }}" method="POST">
                            @csrf @method('PUT')
                            <input type="hidden" name="action" value="travel">
                            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 rounded-xl uppercase text-[10px] tracking-widest transition flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0H21a.75.75 0 01-.75-.75V14.25M3.375 14.25h2.25m0 0h9m-9 0V6.75a2.25 2.25 0 012.25-2.25h4.5a2.25 2.25 0 012.25 2.25v7.5"/></svg>
                                Mulai Perjalanan
                            </button>
                        </form>

                    @elseif($emergency->status === 'dalam_perjalanan' && $emergency->mechanic_id === auth()->id())
                        <p class="text-yellow-400 text-xs">Dalam perjalanan. Konfirmasi saat sampai di lokasi.</p>
                        <form action="{{ route('mekanik.emergency.update', $emergency->id) }}" method="POST">
                            @csrf @method('PUT')
                            <input type="hidden" name="action" value="arrive">
                            <button type="submit" class="w-full bg-yellow-600 hover:bg-yellow-700 text-white font-bold py-4 rounded-xl uppercase text-[10px] tracking-widest transition flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/></svg>
                                Sampai di Lokasi
                            </button>
                        </form>

                    @elseif(in_array($emergency->status, ['dalam_perjalanan', 'sampai_lokasi']) && $emergency->mechanic_id === auth()->id())
                        <p class="text-purple-400 text-xs">Di lokasi pelanggan. Selesaikan penanganan dan isi catatan.</p>
                        <form action="{{ route('mekanik.emergency.update', $emergency->id) }}" method="POST" class="space-y-4" onsubmit="return confirm('Tandai penanganan selesai?')">
                            @csrf @method('PUT')
                            <input type="hidden" name="action" value="complete">
                            <div class="space-y-2">
                                <label class="text-[10px] uppercase text-zinc-500 font-bold tracking-widest">Catatan Penanganan *</label>
                                <textarea name="catatan_mekanik" required rows="4"
                                    placeholder="Tuliskan penanganan yang dilakukan (misal: aki diganti, kabel starter diperbaiki)..."
                                    class="w-full bg-zinc-950 border border-zinc-800 rounded-xl px-4 py-3 text-sm text-white focus:border-emerald-600 outline-none transition"></textarea>
                            </div>
                            <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-4 rounded-xl uppercase text-[10px] tracking-widest transition flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                Selesaikan Penanganan
                            </button>
                        </form>

                    @elseif($emergency->status === 'selesai')
                        <div class="bg-emerald-900/20 border border-emerald-800 rounded-xl p-5">
                            <p class="text-[10px] uppercase text-emerald-400 font-bold tracking-widest mb-2">✓ Penanganan Selesai</p>
                            <p class="text-zinc-300 text-sm leading-relaxed whitespace-pre-line">{{ $emergency->catatan_mekanik ?: 'Tidak ada catatan.' }}</p>
                        </div>

                    @elseif($emergency->status === 'ditolak')
                        <div class="bg-red-900/20 border border-red-800 rounded-xl p-5">
                            <p class="text-[10px] uppercase text-red-400 font-bold tracking-widest mb-2">✗ Ditolak</p>
                            <p class="text-zinc-300 text-sm">{{ $emergency->catatan_mekanik ?: 'Tidak ada alasan.' }}</p>
                        </div>

                    @else
                        <p class="text-zinc-500 text-xs italic">Tidak ada aksi yang tersedia.</p>
                    @endif
                </div>

                @if(in_array($emergency->status, ['diterima', 'dalam_perjalanan', 'sampai_lokasi']) && $emergency->mechanic_id === auth()->id())
                    <div class="bg-zinc-900 border border-zinc-800 rounded-3xl p-6 shadow-2xl space-y-4">
                        <h3 class="text-xs text-zinc-500 uppercase tracking-widest font-bold border-b border-zinc-800 pb-3">Bantuan Teknisi Darurat</h3>
                        @php $activeAssistance = $emergency->activeAssistanceRequest()->with('targetMechanic')->first(); @endphp
                        @if($activeAssistance)
                            <div class="bg-zinc-950/60 border {{ $activeAssistance->status === 'accepted' ? 'border-emerald-900' : 'border-yellow-900' }} rounded-2xl p-5 space-y-3">
                                <span class="text-[10px] font-bold uppercase tracking-widest {{ $activeAssistance->status === 'accepted' ? 'text-emerald-400' : 'text-yellow-400' }}">{{ $activeAssistance::statusLabel($activeAssistance->status) }}</span>
                                <p class="text-sm font-bold">{{ $activeAssistance->targetMechanic->name }}</p>
                                <p class="text-sm text-zinc-300">{{ $activeAssistance->needed_item }}</p>
                                <a href="{{ route('mekanik.assistance-requests.show', $activeAssistance) }}" class="inline-block text-xs text-blue-400 hover:underline font-bold">Lihat Detail →</a>
                            </div>
                        @else
                            <p class="text-xs text-zinc-400">Gunakan fitur ini jika alat atau sparepart tertinggal saat menangani kendaraan di luar bengkel.</p>
                            <form action="{{ route('mekanik.assistance-requests.store', $emergency) }}" method="POST" class="space-y-4" onsubmit="return confirm('Kirim permintaan bantuan darurat?')">
                                @csrf
                                <select name="target_mechanic_id" required class="w-full bg-zinc-950 border border-zinc-800 rounded-xl px-4 py-3 text-sm text-white focus:border-red-500 outline-none">
                                    <option value="">Pilih Teknisi Tujuan</option>
                                    @foreach($mechanics as $mechanic)
                                        <option value="{{ $mechanic->id }}">{{ $mechanic->name }} — {{ $mechanic->nomor_telepon }}</option>
                                    @endforeach
                                </select>
                                <input type="text" name="needed_item" required maxlength="255" placeholder="Barang/alat yang dibutuhkan" class="w-full bg-zinc-950 border border-zinc-800 rounded-xl px-4 py-3 text-sm text-white focus:border-red-500 outline-none">
                                <textarea name="reason" rows="2" maxlength="2000" placeholder="Alasan meminta bantuan (opsional)" class="w-full bg-zinc-950 border border-zinc-800 rounded-xl px-4 py-3 text-sm text-white focus:border-red-500 outline-none resize-none"></textarea>
                                <input type="text" name="location_detail" required maxlength="500" value="{{ old('location_detail', $emergency->lokasi_detail) }}" placeholder="Detail lokasi/patokan" class="w-full bg-zinc-950 border border-zinc-800 rounded-xl px-4 py-3 text-sm text-white focus:border-red-500 outline-none">
                                <input type="url" name="maps_url" maxlength="1000" value="{{ old('maps_url', 'https://www.openstreetmap.org/?mlat='.$emergency->latitude.'&mlon='.$emergency->longitude.'#map=17/'.$emergency->latitude.'/'.$emergency->longitude) }}" class="w-full bg-zinc-950 border border-zinc-800 rounded-xl px-4 py-3 text-sm text-white focus:border-red-500 outline-none">
                                <button type="submit" class="w-full bg-red-600 hover:bg-red-500 text-white font-bold py-4 rounded-xl uppercase text-[10px] tracking-widest transition">Minta Bantuan Teknisi</button>
                            </form>
                        @endif
                    </div>
                @endif
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
    L.marker(position).addTo(map).bindPopup('Lokasi Pelanggan').openPopup();
</script>
@endsection
