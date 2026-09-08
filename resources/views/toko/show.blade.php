@extends('layouts.guest')

@section('content')
<div class="min-h-screen bg-zinc-50 dark:bg-zinc-950 text-zinc-900 dark:text-white transition-colors duration-300">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        {{-- Breadcrumb --}}
        <div class="flex items-center gap-2 text-xs text-zinc-400 dark:text-zinc-500 uppercase tracking-widest mb-8">
            <a href="{{ route('toko.banmotor') }}" class="hover:text-red-600 transition">Toko</a>
            <span>/</span>
            <a href="{{ match($product->kategori) { 'ban' => route('toko.banmotor'), 'oli' => route('toko.oli'), default => route('toko.sparepart') } }}" class="hover:text-red-600 transition">{{ $product->kategori }}</a>
            <span>/</span>
            <span class="text-zinc-700 dark:text-zinc-300">{{ $product->nama }}</span>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
            {{-- Gambar --}}
            <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-3xl overflow-hidden aspect-square shadow-sm">
                @if($product->gambar)
                    <img src="{{ asset('storage/' . $product->gambar) }}" alt="{{ $product->nama }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center bg-zinc-100 dark:bg-zinc-800">
                        <svg class="w-24 h-24 text-zinc-300 dark:text-zinc-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                @endif
            </div>

            {{-- Info --}}
            <div class="flex flex-col justify-between">
                <div class="space-y-6">
                    {{-- Badge Kategori --}}
                    <span class="inline-block px-3 py-1.5 rounded-lg text-[10px] font-bold uppercase tracking-widest
                        {{ $product->kategori === 'ban' ? 'bg-blue-500/10 text-blue-600 dark:text-blue-400 border border-blue-500/20' : '' }}
                        {{ $product->kategori === 'oli' ? 'bg-amber-500/10 text-amber-600 dark:text-amber-400 border border-amber-500/20' : '' }}
                        {{ $product->kategori === 'sparepart' ? 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-500/20' : '' }}
                    ">
                        {{ $product->kategori }}
                    </span>

                    {{-- Nama --}}
                    <h1 class="text-3xl font-bengkel text-zinc-900 dark:text-white tracking-wide uppercase leading-tight">{{ $product->nama }}</h1>

                    {{-- Harga --}}
                    <div class="flex items-baseline gap-3">
                        <span class="text-4xl font-bengkel text-red-600">Rp {{ number_format($product->harga, 0, ',', '.') }}</span>
                    </div>

                    {{-- Deskripsi --}}
                    @if($product->deskripsi)
                    <div class="bg-zinc-100 dark:bg-zinc-800/50 rounded-2xl p-5 border border-zinc-200 dark:border-zinc-800">
                        <h3 class="text-[10px] text-zinc-400 dark:text-zinc-500 uppercase font-bold tracking-widest mb-2">Deskripsi</h3>
                        <p class="text-sm text-zinc-600 dark:text-zinc-400 leading-relaxed whitespace-pre-line">{{ $product->deskripsi }}</p>
                    </div>
                    @endif

                    {{-- Info Stok --}}
                    <div class="flex items-center gap-4">
                        <div class="flex items-center gap-2">
                            <div class="w-2 h-2 rounded-full {{ $product->stok > 5 ? 'bg-emerald-500' : ($product->stok > 0 ? 'bg-amber-500' : 'bg-red-500') }}"></div>
                            <span class="text-xs text-zinc-500 dark:text-zinc-400 uppercase tracking-widest font-bold">
                                @if($product->stok > 5) Stok Tersedia
                                @elseif($product->stok > 0) Stok Terbatas ({{ $product->stok }})
                                @else Stok Habis
                                @endif
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Action --}}
                <div class="mt-8 space-y-3">
                    @if($product->stok > 0)
                    <a href="{{ route('toko.checkout', $product->id) }}" class="block w-full text-center px-6 py-4 bg-red-600 hover:bg-red-700 text-white rounded-2xl text-sm font-bold uppercase tracking-widest transition shadow-lg shadow-red-600/20">
                        Beli Sekarang
                    </a>
                    @else
                    <button disabled class="w-full px-6 py-4 bg-zinc-300 dark:bg-zinc-800 text-zinc-500 rounded-2xl text-sm font-bold uppercase tracking-widest cursor-not-allowed">
                        Stok Habis
                    </button>
                    @endif

                    <a href="{{ match($product->kategori) { 'ban' => route('toko.banmotor'), 'oli' => route('toko.oli'), default => route('toko.sparepart') } }}"
                       class="block w-full text-center px-6 py-3.5 bg-zinc-100 dark:bg-zinc-800 hover:bg-zinc-200 dark:hover:bg-zinc-700 text-zinc-700 dark:text-zinc-300 rounded-2xl text-xs font-bold uppercase tracking-widest border border-zinc-200 dark:border-zinc-700 transition">
                        ← Kembali ke {{ ucfirst($product->kategori) }}
                    </a>
                </div>
            </div>
        </div>

    @include('partials.footer')
</div>
@endsection
