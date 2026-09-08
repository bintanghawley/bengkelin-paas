@extends('layouts.guest')

@section('content')
<div class="min-h-screen bg-zinc-50 dark:bg-zinc-950 text-zinc-900 dark:text-white transition-colors duration-300">

    {{-- Navbar mini --}}
    @include('partials.navbar')


    <div class="max-w-7xl mx-auto px-6 py-10">
        
        {{-- Breadcrumbs --}}
        <div class="flex items-center gap-2 text-xs text-zinc-400 dark:text-zinc-500 uppercase tracking-widest mb-10">
            <a href="{{ route('toko.banmotor') }}" class="hover:text-red-600 transition">Ban</a>
            <span>/</span>
            <span class="hover:text-red-600 transition">{{ $tire->merek }}</span>
            <span>/</span>
            <span class="text-zinc-700 dark:text-zinc-350 font-bold">{{ $tire->tipe }} {{ $tire->nama }}</span>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
            
            {{-- Column Left: Image (Single Cover) --}}
            <div class="lg:col-span-6">
                <div class="relative bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-[2.5rem] aspect-square flex items-center justify-center overflow-hidden group shadow-sm">
                    @if($tire->gambar)
                        <img src="{{ str_starts_with($tire->gambar, 'img/') || str_starts_with($tire->gambar, 'http') ? asset($tire->gambar) : asset('storage/' . $tire->gambar) }}" alt="{{ $tire->nama }}" class="w-full h-full object-cover">
                    @else
                        {{-- Empty Placeholder --}}
                        <div class="absolute inset-0 p-8">
                            <div class="w-full h-full border-2 border-dashed border-zinc-200 dark:border-zinc-800 rounded-2xl flex flex-col items-center justify-center text-zinc-400 dark:text-zinc-600 gap-3">
                                <svg class="w-16 h-16 stroke-[1.2]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                <span class="text-xs uppercase tracking-widest font-bold">Foto Ban Belum Tersedia</span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Column Right: Specs & Actions --}}
            <div class="lg:col-span-6 space-y-8">
                <div class="space-y-3">
                    <span class="inline-block px-3 py-1 rounded-full text-[9px] font-bold uppercase tracking-widest bg-blue-500/10 text-blue-600 dark:text-blue-400">
                        {{ $tire->merek }}
                    </span>
                    <h1 class="text-3xl lg:text-4xl font-bengkel tracking-wide uppercase text-zinc-900 dark:text-white">
                        {{ $tire->nama }}
                    </h1>
                    <div class="flex items-center gap-2 text-xs text-zinc-400">
                        <span>Belum Ada Ulasan</span>
                        <span>•</span>
                        <span>Belum Terjual</span>
                        <span>•</span>
                        <span>SKU: TIRE-{{ str_pad($tire->id, 6, '0', STR_PAD_LEFT) }}</span>
                    </div>
                </div>

                {{-- Price --}}
                <div class="border-y border-zinc-200 dark:border-zinc-800 py-6">
                    <div class="flex items-baseline gap-1">
                        <span class="text-lg font-bold text-zinc-900 dark:text-white">Rp</span>
                        <span class="text-4xl font-bengkel tracking-wider text-zinc-900 dark:text-white">
                            {{ number_format($tire->harga, 0, ',', '.') }}
                        </span>
                    </div>
                </div>

                {{-- Specs Grid --}}
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6 bg-white dark:bg-zinc-900/60 border border-zinc-200 dark:border-zinc-800/80 rounded-3xl p-6">
                    <div>
                        <span class="block text-[10px] text-zinc-400 dark:text-zinc-500 font-bold uppercase tracking-widest">Ukuran Ban</span>
                        <span class="block text-sm font-semibold mt-1">{{ $tire->ukuran_ban }}</span>
                    </div>
                    <div>
                        <span class="block text-[10px] text-zinc-400 dark:text-zinc-500 font-bold uppercase tracking-widest">Posisi Ban</span>
                        <span class="block text-sm font-semibold mt-1 capitalize">{{ $tire->posisi_ban }}</span>
                    </div>
                    <div>
                        <span class="block text-[10px] text-zinc-400 dark:text-zinc-500 font-bold uppercase tracking-widest">Diameter</span>
                        <span class="block text-sm font-semibold mt-1">{{ $tire->diameter }}</span>
                    </div>
                    <div>
                        <span class="block text-[10px] text-zinc-400 dark:text-zinc-500 font-bold uppercase tracking-widest">Tipe</span>
                        <span class="block text-sm font-semibold mt-1 capitalize">{{ $tire->tipe }}</span>
                    </div>
                </div>

                {{-- Action buttons --}}
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="{{ route('toko.banmotor.checkout', $tire->id) }}" class="flex-1 text-center border border-blue-600 text-blue-600 dark:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/10 font-semibold py-3.5 px-8 rounded-full transition text-sm uppercase tracking-wider">
                        Beli Langsung
                    </a>
                    
                    <button 
                        type="button"
                        onclick='addToCart({
                            id: "tire-{{ $tire->id }}",
                            nama: {{ json_encode($tire->nama) }},
                            harga: {{ $tire->harga }},
                            gambar: "{{ $tire->gambar ? (str_starts_with($tire->gambar, 'img/') || str_starts_with($tire->gambar, 'http') ? asset($tire->gambar) : asset('storage/'.$tire->gambar)) : '' }}",
                            kategori: "Ban Motor"
                        })'
                        class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3.5 px-8 rounded-full transition flex items-center justify-center gap-2 text-sm uppercase tracking-wider">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        + Keranjang
                    </button>
                </div>

                {{-- Description --}}
                <div class="space-y-3 border-t border-zinc-200 dark:border-zinc-800 pt-6">
                    <h3 class="text-xs text-zinc-400 dark:text-zinc-500 font-bold uppercase tracking-widest">Deskripsi</h3>
                    <p class="text-sm text-zinc-650 dark:text-zinc-300 leading-relaxed">
                        {{ $tire->deskripsi ?: 'Tidak ada deskripsi untuk produk ini.' }}
                    </p>
                </div>

                {{-- Product Features --}}
                @if($tire->fitur)
                    <div class="space-y-3 border-t border-zinc-200 dark:border-zinc-800 pt-6">
                        <h3 class="text-xs text-zinc-400 dark:text-zinc-500 font-bold uppercase tracking-widest">Fitur Produk</h3>
                        <ul class="space-y-2.5 text-sm text-zinc-650 dark:text-zinc-350">
                            @foreach(explode(',', $tire->fitur) as $ft)
                                @if(trim($ft))
                                    <li class="flex items-start gap-2.5">
                                        <svg class="w-4 h-4 text-emerald-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path d="M5 13l4 4L19 7" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        <span>{{ trim($ft) }}</span>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                @endif
                
            </div>
            
        </div>
        
    </div>
    @include('partials.footer')
</div>
@endsection
