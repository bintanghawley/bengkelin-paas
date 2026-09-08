@extends('layouts.guest')

@section('content')
<div class="flex min-h-screen bg-zinc-950 text-white">
    @include('mekanik.partials.sidebar')
    <main class="flex-1 ml-64 p-6 lg:p-10">
    <div class="max-w-4xl mx-auto">
        <div class="mb-8">
            <a href="{{ route('mekanik.assistance-requests.index') }}" class="text-xs text-red-500 font-bold uppercase tracking-widest">← Permintaan Bantuan</a>
            <div class="flex items-center gap-4 mt-2">
                <h1 class="text-4xl font-bengkel tracking-wider">DETAIL PERMINTAAN</h1>
                @php
                    $sc = match($assistanceRequest->status) {
                        'pending' => 'bg-yellow-950/40 text-yellow-400 border-yellow-900/60',
                        'accepted' => 'bg-emerald-950/40 text-emerald-400 border-emerald-900/60',
                        'rejected' => 'bg-red-950/40 text-red-400 border-red-900/60',
                        'completed' => 'bg-blue-950/40 text-blue-400 border-blue-900/60',
                        'cancelled' => 'bg-zinc-800 text-zinc-400 border-zinc-700',
                    };
                @endphp
                <span class="px-4 py-1.5 rounded-full text-xs font-bold border {{ $sc }}">{{ $assistanceRequest::statusLabel($assistanceRequest->status) }}</span>
            </div>
        </div>

        <div class="grid lg:grid-cols-2 gap-8 items-start">
            <div class="space-y-6">
                <div class="bg-zinc-900 border border-zinc-800 rounded-3xl p-6 space-y-5">
                    <h3 class="text-xs text-zinc-500 uppercase tracking-widest font-bold border-b border-zinc-800 pb-3">Informasi Permintaan</h3>
                    <div class="space-y-4">
                        <div>
                            <p class="text-[10px] text-zinc-400 uppercase font-bold tracking-widest">Barang Dibutuhkan</p>
                            <p class="text-lg font-bold mt-1">{{ $assistanceRequest->needed_item }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] text-zinc-400 uppercase font-bold tracking-widest">Lokasi</p>
                            <p class="text-sm mt-1">{{ $assistanceRequest->location_detail }}</p>
                        </div>
                        @if($assistanceRequest->maps_url)
                            <a href="{{ $assistanceRequest->maps_url }}" target="_blank" rel="noopener noreferrer" class="text-blue-400 hover:underline text-sm font-bold">Buka di OpenStreetMap ↗</a>
                        @endif
                        @if($assistanceRequest->reason)
                            <div>
                                <p class="text-[10px] text-zinc-400 uppercase font-bold tracking-widest">Alasan</p>
                                <p class="text-sm mt-1 text-zinc-300">{{ $assistanceRequest->reason }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                @if($assistanceRequest->response_note)
                    <div class="bg-zinc-900 border border-zinc-800 rounded-3xl p-6">
                        <h3 class="text-xs text-zinc-500 uppercase tracking-widest font-bold border-b border-zinc-800 pb-3 mb-4">Catatan Respons</h3>
                        <p class="text-sm text-zinc-300">{{ $assistanceRequest->response_note }}</p>
                    </div>
                @endif
            </div>

            <div class="space-y-6">
                <div class="bg-zinc-900 border border-zinc-800 rounded-3xl p-6 space-y-5">
                    <h3 class="text-xs text-zinc-500 uppercase tracking-widest font-bold border-b border-zinc-800 pb-3">Kontak</h3>
                    <div class="space-y-4">
                        <div>
                            <p class="text-[10px] text-zinc-400 uppercase font-bold tracking-widest">Teknisi Peminta</p>
                            <p class="text-sm font-bold mt-1">{{ $assistanceRequest->requesterMechanic->name }}</p>
                            <a href="tel:{{ $assistanceRequest->requesterMechanic->nomor_telepon }}" class="text-xs text-red-400 font-mono hover:underline">{{ $assistanceRequest->requesterMechanic->nomor_telepon }}</a>
                        </div>
                        <div>
                            <p class="text-[10px] text-zinc-400 uppercase font-bold tracking-widest">Pelanggan</p>
                            <p class="text-sm font-bold mt-1">{{ $assistanceRequest->emergencyReport->user->name ?? '-' }}</p>
                            <a href="tel:{{ $assistanceRequest->emergencyReport->user->nomor_telepon ?? '' }}" class="text-xs text-red-400 font-mono hover:underline">{{ $assistanceRequest->emergencyReport->user->nomor_telepon ?? '-' }}</a>
                        </div>
                        <div>
                            <p class="text-[10px] text-zinc-400 uppercase font-bold tracking-widest">Kendaraan</p>
                            <p class="text-sm font-bold mt-1">{{ $assistanceRequest->emergencyReport->nama_kendaraan }}</p>
                            <p class="text-xs text-zinc-500 font-mono">{{ $assistanceRequest->emergencyReport->plat_nomor }}</p>
                        </div>
                    </div>
                </div>

                @if(auth()->id() === $assistanceRequest->target_mechanic_id && $assistanceRequest->isPending())
                    <div class="grid grid-cols-2 gap-4">
                        <form action="{{ route('mekanik.assistance-requests.reject', $assistanceRequest) }}" method="POST" onsubmit="return confirm('Tolak permintaan ini?')">
                            @csrf @method('PATCH')
                            <input type="hidden" name="response_note" value="Maaf, saya sedang tidak bisa membantu.">
                            <button type="submit" class="w-full bg-zinc-800 hover:bg-red-900/30 border border-zinc-700 hover:border-red-600 text-zinc-300 hover:text-red-400 font-bold py-4 rounded-xl uppercase text-[10px] tracking-widest transition">Tolak</button>
                        </form>
                        <form action="{{ route('mekanik.assistance-requests.accept', $assistanceRequest) }}" method="POST" onsubmit="return confirm('Terima permintaan ini? Menuju lokasi sekarang.')">
                            @csrf @method('PATCH')
                            <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-500 text-white font-bold py-4 rounded-xl uppercase text-[10px] tracking-widest transition shadow-lg shadow-emerald-950/20">Terima Bantuan</button>
                        </form>
                    </div>
                @endif

                @if(auth()->id() === $assistanceRequest->requester_mechanic_id && $assistanceRequest->isPending())
                    <form action="{{ route('mekanik.assistance-requests.cancel', $assistanceRequest) }}" method="POST" onsubmit="return confirm('Batalkan permintaan ini?')">
                        @csrf @method('PATCH')
                        <button type="submit" class="w-full bg-zinc-800 hover:bg-red-900/30 border border-zinc-700 hover:border-red-600 text-zinc-300 hover:text-red-400 font-bold py-4 rounded-xl uppercase text-[10px] tracking-widest transition">Batalkan Permintaan</button>
                    </form>
                @endif

                @if(auth()->id() === $assistanceRequest->requester_mechanic_id && $assistanceRequest->isAccepted())
                    <form action="{{ route('mekanik.assistance-requests.complete', $assistanceRequest) }}" method="POST" onsubmit="return confirm('Tandai bantuan ini sebagai selesai?')">
                        @csrf @method('PATCH')
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-500 text-white font-bold py-4 rounded-xl uppercase text-[10px] tracking-widest transition shadow-lg shadow-blue-950/20">Selesaikan Bantuan</button>
                    </form>
                @endif
            </div>
        </div>
    </div>
    </main>
</div>
@endsection
