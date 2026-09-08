@extends('layouts.guest')

@section('content')
<div class="min-h-screen bg-zinc-950 text-white transition-colors duration-300">

    {{-- Navbar --}}
    @include('partials.navbar')


    <div class="max-w-7xl mx-auto px-6 py-10">
        
        {{-- Breadcrumbs --}}
        <div class="flex items-center gap-2 text-xs text-zinc-500 uppercase tracking-widest mb-10">
            <a href="{{ route('servis') }}" class="hover:text-red-500 transition">Servis</a>
            <span>/</span>
            <span class="text-zinc-350 font-bold">{{ $service->nama }}</span>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
            
            {{-- Column Left: Image --}}
            <div class="lg:col-span-6">
                <div class="relative bg-zinc-900 border border-zinc-800 rounded-[2.5rem] aspect-video flex items-center justify-center overflow-hidden group shadow-sm">
                    <img src="{{ $service->gambar_url }}" alt="{{ $service->nama }}" class="w-full h-full object-cover">
                </div>
            </div>

            {{-- Column Right: Detail Information --}}
            <div class="lg:col-span-6 space-y-8">
                <div class="space-y-3">
                    <span class="inline-block px-3 py-1 rounded-full text-[9px] font-bold uppercase tracking-widest bg-red-500/10 text-red-500 border border-red-500/20">
                        Layanan Servis
                    </span>
                    <h1 class="text-3xl lg:text-4xl font-bengkel tracking-wide uppercase text-white">
                        {{ $service->nama }}
                    </h1>
                    <div class="flex items-center gap-2 text-xs text-zinc-450">
                        <span>Estimasi: {{ $service->estimasi_waktu }}</span>
                        <span>•</span>
                        <span>Total Pekerjaan: {{ $service->items->count() }} Item</span>
                        <span>•</span>
                        <span>SKU: SRV-{{ str_pad($service->id, 6, '0', STR_PAD_LEFT) }}</span>
                    </div>
                </div>

                {{-- Price --}}
                <div class="border-y border-zinc-800 py-6">
                    <span class="text-xs text-zinc-500 uppercase font-bold tracking-widest block mb-2">Mulai Dari</span>
                    <div class="flex items-baseline gap-1">
                        <span class="text-lg font-bold text-white">Rp</span>
                        <span class="text-4xl font-bengkel tracking-wider text-red-500">
                            {{ number_format($service->harga_mulai, 0, ',', '.') }}
                        </span>
                    </div>
                </div>

                {{-- Specs Grid --}}
                <div class="grid grid-cols-2 gap-6 bg-zinc-900/60 border border-zinc-800/80 rounded-3xl p-6">
                    <div>
                        <span class="block text-[10px] text-zinc-500 font-bold uppercase tracking-widest">Estimasi Waktu</span>
                        <span class="block text-sm font-semibold mt-1">{{ $service->estimasi_waktu }}</span>
                    </div>
                    <div>
                        <span class="block text-[10px] text-zinc-500 font-bold uppercase tracking-widest">Detail Pekerjaan</span>
                        <span class="block text-sm font-semibold mt-1">{{ $service->items->count() }} Pekerjaan</span>
                    </div>
                </div>

                {{-- Action buttons --}}
                <div class="flex">
                    @if(auth()->check() && auth()->user()->role === 'pengguna')
                        <a href="{{ route('booking.create', $service->slug) }}" class="w-full text-center bg-red-600 hover:bg-red-700 text-white font-bold py-4 px-8 rounded-full transition text-sm uppercase tracking-wider shadow-lg shadow-red-600/20">
                            Booking Servis
                        </a>
                    @elseif(auth()->guest())
                        <a href="{{ route('login', ['redirect' => route('booking.create', $service->slug)]) }}" class="w-full text-center bg-red-600 hover:bg-red-700 text-white font-bold py-4 px-8 rounded-full transition text-sm uppercase tracking-wider shadow-lg shadow-red-600/20">
                            Login untuk Booking
                        </a>
                    @else
                        <div class="w-full text-center bg-zinc-800 text-zinc-400 font-bold py-4 px-8 rounded-full text-sm uppercase tracking-wider">
                            Booking hanya untuk akun pengguna
                        </div>
                    @endif
                </div>

                {{-- Description --}}
                <div class="space-y-3 border-t border-zinc-800 pt-6">
                    <h3 class="text-xs text-zinc-500 font-bold uppercase tracking-widest">Deskripsi Layanan</h3>
                    <p class="text-sm text-zinc-350 leading-relaxed">
                        {{ $service->deskripsi }}
                    </p>
                </div>

                {{-- Details list --}}
                <div class="space-y-3 border-t border-zinc-800 pt-6">
                    <h3 class="text-xs text-zinc-500 font-bold uppercase tracking-widest">Yang Dikerjakan</h3>
                    @if($service->items->isEmpty())
                        <p class="text-zinc-650 text-sm italic">Belum ada detail pekerjaan.</p>
                    @else
                        <ul class="space-y-2.5 text-sm text-zinc-350">
                            @foreach($service->items as $item)
                                <li class="flex items-start gap-2.5">
                                    <svg class="w-4 h-4 text-emerald-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path d="M5 13l4 4L19 7" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    <span>{{ $item->nama_pekerjaan }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
                
            </div>
            
        </div>
        
    </div>
    @include('partials.footer')
</div>
@endsection


