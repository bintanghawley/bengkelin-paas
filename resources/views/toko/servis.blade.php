@extends('layouts.guest')

@section('content')
<div class="bg-zinc-950 text-white">
    <section class="relative overflow-hidden bg-gradient-to-br from-[#ea0d2b] via-[#d90d2a] to-[#b40b23]">
        <style>
            @keyframes float-soft {
                0%, 100% { transform: translateY(0); }
                50% { transform: translateY(-10px); }
            }
            @keyframes fade-up {
                0% { opacity: 0; transform: translateY(12px); }
                100% { opacity: 1; transform: translateY(0); }
            }
            .float-soft { animation: float-soft 8s ease-in-out infinite; }
            .fade-up { animation: fade-up 0.8s ease-out both; }
            .fade-up-delay { animation-delay: 0.15s; }
            .range-input {
                -webkit-appearance: none;
                appearance: none;
            }
            .range-input::-webkit-slider-runnable-track {
                height: 8px;
                background: transparent;
            }
            .range-input::-moz-range-track {
                height: 8px;
                background: transparent;
            }
            .range-input::-webkit-slider-thumb {
                -webkit-appearance: none;
                height: 18px;
                width: 18px;
                border-radius: 9999px;
                background: #ef4444;
                border: 2px solid #ffffff;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.25);
                cursor: pointer;
            }
            .range-input::-moz-range-thumb {
                height: 18px;
                width: 18px;
                border-radius: 9999px;
                background: #ef4444;
                border: 2px solid #ffffff;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.25);
                cursor: pointer;
            }
        </style>

        @include('partials.navbar')


        <div class="absolute inset-0">
            <div class="absolute right-[-10%] top-[-10%] h-[140%] w-[60%] opacity-20 pointer-events-none" style="background-image: repeating-linear-gradient(135deg, rgba(255,255,255,0.25) 0, rgba(255,255,255,0.25) 6px, transparent 6px, transparent 26px);"></div>
            <div class="absolute inset-0 bg-gradient-to-br from-white/10 via-transparent to-transparent"></div>
        </div>

        <div class="relative max-w-7xl mx-auto px-6 py-10 lg:py-14 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div class="relative">
                <div class="relative w-full max-w-lg mx-auto lg:mx-0">
                    <div class="absolute -top-6 -left-6 h-24 w-24 bg-white/15 rounded-full blur-2xl"></div>
                    <div class="absolute -bottom-10 -right-12 h-32 w-32 bg-black/20 rounded-full blur-2xl"></div>
                    <div class="relative rounded-[2rem] bg-[#b90b24] p-4 shadow-[0_30px_80px_rgba(0,0,0,0.35)]">
                        <img src="{{ asset('img/servis/bengkel.jpg') }}" alt="Workshop Bengkelin" class="w-full h-full object-cover rounded-[1.5rem] aspect-[4/3]" decoding="async">
                    </div>
                    <img src="{{ asset('img/servis/bengkel-2.jpg') }}" alt="Motor" class="hidden md:block absolute -bottom-10 -left-4 w-52 drop-shadow-[0_25px_35px_rgba(0,0,0,0.45)] float-soft" decoding="async">
                    <img src="{{ asset('img/servis/bengkel-2.jpg') }}" alt="Motor" class="md:hidden mt-6 w-52 mx-auto drop-shadow-[0_20px_30px_rgba(0,0,0,0.35)]" decoding="async">
                </div>
            </div>

            <div class="relative z-10 text-center lg:text-left space-y-6">
                <p class="text-2xl md:text-3xl font-light tracking-wide fade-up">Mau Tarikan Motormu Enteng</p>
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bengkel uppercase tracking-wide fade-up fade-up-delay">Rasa Mesin Baru?</h1>
                <p class="text-lg md:text-xl text-red-100 max-w-xl leading-relaxed fade-up fade-up-delay">
                    Servis sepeda motormu di Bengkelin. Pengalaman rasa mesin baru jadi nyata dengan layanan servis yang rapi, cepat, dan terpercaya.
                </p>
            </div>
        </div>
    </section>

    <section class="py-20 relative z-10">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center max-w-2xl mx-auto mb-16">
                <h2 class="text-3xl md:text-4xl font-bengkel uppercase tracking-wide mb-4">Layanan Servis Kami</h2>
                <p class="text-zinc-400">Pilih layanan servis yang sesuai dengan kebutuhan motor Anda.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($services as $service)
                <div class="group relative bg-zinc-900 border border-zinc-800 rounded-[2rem] overflow-hidden hover:shadow-xl transition-all duration-300 flex flex-col justify-between">
                    <a href="{{ route('servis.detail', $service->slug) }}" class="flex-1 flex flex-col">
                        <div class="aspect-video bg-zinc-800/30 flex items-center justify-center relative overflow-hidden">
                            <img src="{{ $service->gambar_url }}" alt="{{ $service->nama }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" loading="lazy" decoding="async">
                            <div class="absolute top-4 left-4">
                                <span class="inline-block bg-red-600 text-white text-[9px] font-bold uppercase tracking-widest px-2.5 py-1 rounded-full">{{ $service->estimasi_waktu }}</span>
                            </div>
                        </div>
                        <div class="p-6 space-y-4 flex-1 flex flex-col justify-between">
                            <div>
                                <span class="inline-block text-[10px] text-zinc-500 font-bold uppercase tracking-widest">Layanan Servis</span>
                                <h4 class="font-bold text-lg uppercase tracking-wide text-zinc-200 line-clamp-1 mt-1 group-hover:text-red-500 transition">
                                    {{ $service->nama }}
                                </h4>
                                <p class="text-xs text-zinc-400 line-clamp-2 mt-2 leading-relaxed">{{ $service->deskripsi }}</p>
                            </div>
                            
                            <div class="flex items-center justify-between pt-4 border-t border-zinc-800/60 mt-auto">
                                <div>
                                    <span class="block text-[9px] text-zinc-500 font-bold uppercase tracking-widest">Mulai Dari</span>
                                    <div class="flex items-baseline gap-0.5 text-white mt-1">
                                        <span class="text-[10px] font-bold text-red-500">Rp</span>
                                        <span class="text-xl font-bengkel tracking-wider text-red-500">{{ number_format($service->harga_mulai, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <span class="block text-[9px] text-zinc-500 font-bold uppercase tracking-widest">Pekerjaan</span>
                                    <span class="block text-xs font-semibold text-zinc-300 mt-1.5">{{ $service->items_count }} Item</span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
            
            @if($services->isEmpty())
            <div class="text-center py-20 bg-zinc-900 rounded-3xl border border-zinc-800">
                <svg class="w-16 h-16 text-zinc-700 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <h3 class="text-xl font-bold text-white mb-2">Belum Ada Layanan Servis</h3>
                <p class="text-zinc-400">Silakan kembali lagi nanti untuk melihat daftar layanan kami.</p>
            </div>
            @endif
        </div>
    </section>
    @include('partials.footer')
</div>
@endsection
