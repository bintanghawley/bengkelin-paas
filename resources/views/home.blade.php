@extends('layouts.guest')

@section('content')
<div class="min-h-screen bg-zinc-50 dark:bg-zinc-950 text-zinc-900 dark:text-white transition-colors duration-300">
    <style>
        /* Sembunyikan tombol toggle melayang bawaan layout di halaman utama */
        #floating-theme-toggle-container {
            display: none !important;
        }
        .sidebar-scrollbar-hide {
            scrollbar-width: none;
        }
        .sidebar-scrollbar-hide::-webkit-scrollbar {
            display: none;
        }
        /* Filter peta dinamis */
        .map-iframe {
            filter: grayscale(10%) contrast(100%);
            transition: all 0.7s ease;
        }
        .dark .map-iframe {
            filter: grayscale(20%) invert(90%) contrast(110%);
        }
        
        /* Scroll Reveal Animation Styles */
        .scroll-reveal,
        .scroll-reveal-left,
        .scroll-reveal-right,
        .scroll-reveal-scale {
            opacity: 1;
            transform: none;
        }
        .js .scroll-reveal {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 1s cubic-bezier(0.16, 1, 0.3, 1), transform 1s cubic-bezier(0.16, 1, 0.3, 1);
            will-change: transform, opacity;
        }
        .js .scroll-reveal-left {
            opacity: 0;
            transform: translateX(-40px);
            transition: opacity 1s cubic-bezier(0.16, 1, 0.3, 1), transform 1s cubic-bezier(0.16, 1, 0.3, 1);
            will-change: transform, opacity;
        }
        .js .scroll-reveal-right {
            opacity: 0;
            transform: translateX(40px);
            transition: opacity 1s cubic-bezier(0.16, 1, 0.3, 1), transform 1s cubic-bezier(0.16, 1, 0.3, 1);
            will-change: transform, opacity;
        }
        .js .scroll-reveal-scale {
            opacity: 0;
            transform: scale(0.95);
            transition: opacity 1.2s cubic-bezier(0.16, 1, 0.3, 1), transform 1.2s cubic-bezier(0.16, 1, 0.3, 1);
            will-change: transform, opacity;
        }
        
        /* State transition to show */
        .scroll-reveal.revealed,
        .scroll-reveal-left.revealed,
        .scroll-reveal-right.revealed,
        .scroll-reveal-scale.revealed {
            opacity: 1;
            transform: translate(0) scale(1);
        }

        /* Animation delays */
        .delay-75 { transition-delay: 75ms; }
        .delay-100 { transition-delay: 100ms; }
        .delay-150 { transition-delay: 150ms; }
        .delay-200 { transition-delay: 200ms; }
        .delay-300 { transition-delay: 300ms; }
        .delay-500 { transition-delay: 500ms; }
    </style>
    <nav class="sticky top-4 z-30 flex items-center justify-between px-8 py-4 max-w-7xl mx-auto bg-zinc-950/80 backdrop-blur-md rounded-2xl border border-zinc-800 shadow-xl">
       <div class="flex items-center gap-2">
            <div>
                <img src="{{ asset('img/home/logo.png') }}" alt="" class="w-20 h-20 object-contain" decoding="async">
            </div>
            <span class="text-2xl font-bengkel tracking-wider text-zinc-900 dark:text-white">Bengkel<span class="text-red-600">in</span></span>
        </div>
        <div class="hidden md:flex gap-8 text-xs font-semibold uppercase tracking-widest text-zinc-500 dark:text-zinc-400">
            <a href="#home" class="hover:text-zinc-900 dark:hover:text-white transition">Beranda</a>
            
            <a href="#about" class="hover:text-zinc-900 dark:hover:text-white transition">Tentang Kami</a>
            <a href="#location" class="hover:text-zinc-900 dark:hover:text-white transition">Lokasi</a> 
        </div>
        <div class="flex items-center gap-3">
            @include('partials.cart-widget')

            <button type="button" id="sidebar-open" class="inline-flex items-center justify-center h-10 w-10 rounded-full border border-zinc-300 dark:border-zinc-700 hover:border-zinc-400 dark:hover:border-zinc-500 bg-white dark:bg-zinc-900/50 hover:bg-zinc-100 dark:hover:bg-zinc-900 text-zinc-800 dark:text-zinc-200 hover:text-zinc-955 dark:hover:text-white transition shadow-sm" aria-label="Menu" aria-controls="sidebar" aria-expanded="false">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" class="w-4 h-4">
                    <path d="M4 6h16M4 12h16M4 18h10" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </button>
        </div>
    </nav>

    <div id="sidebar-overlay" class="fixed inset-0 bg-black/60 opacity-0 pointer-events-none transition-opacity duration-300 z-40"></div>
    <aside id="sidebar" class="fixed top-0 right-0 h-screen w-[85vw] max-w-sm bg-white dark:bg-zinc-900 text-zinc-900 dark:text-white translate-x-full transition-transform duration-300 z-50 shadow-2xl border-l border-zinc-200 dark:border-zinc-800">
        <div class="h-full flex flex-col">
            <div class="flex items-center justify-between p-5 border-b border-zinc-200 dark:border-zinc-800">
                <a href="{{ route('home') }}" class="flex items-center gap-2">
                    <img src="{{ asset('img/home/logo.png') }}" alt="" class="w-12 h-12 object-contain" decoding="async">
                    <span class="text-xl font-bengkel tracking-wider text-zinc-900 dark:text-white">Bengkel<span class="text-red-600">in</span></span>
                </a>
                <button type="button" id="sidebar-close" class="inline-flex items-center justify-center h-9 w-9 rounded-full border border-zinc-300 dark:border-zinc-700 hover:bg-zinc-100 dark:hover:bg-zinc-800 transition text-zinc-700 dark:text-zinc-300" aria-label="Tutup menu">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" class="w-4 h-4">
                        <path d="M6 6l12 12M18 6l-12 12" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </button>
            </div>
            <div class="flex-1 overflow-y-auto px-5 py-6 space-y-6 sidebar-scrollbar-hide">
                @guest
                    <div class="grid grid-cols-2 gap-3">
                        <a href="{{ route('login') }}" class="text-center font-semibold bg-red-600 text-white px-4 py-3 rounded-full hover:bg-red-700 transition">Login</a>
                        <a href="{{ route('register') }}" class="text-center font-semibold border border-red-600 text-red-600 px-4 py-3 rounded-full hover:bg-red-50 dark:hover:bg-red-950/20 transition">Daftar Akun</a>
                    </div>
                @endguest

                @auth
                    <div class="border border-zinc-200 dark:border-zinc-800 rounded-2xl p-4 space-y-3">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                @if (Auth::user()->role === 'admin')
                                    <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-zinc-900 dark:text-white hover:text-red-600 dark:hover:text-red-500 transition">
                                        {{ Auth::user()->name }}
                                    </a>
                                @elseif (Auth::user()->role === 'mekanik')
                                    <a href="{{ route('mekanik.dashboard') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-zinc-900 dark:text-white hover:text-red-600 dark:hover:text-red-500 transition">
                                        {{ Auth::user()->name }}
                                    </a>
                                @else
                                    <a href="{{ route('pengguna.dashboard') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-zinc-900 dark:text-white hover:text-red-600 dark:hover:text-red-500 transition">
                                        {{ Auth::user()->name }}
                                    </a>
                                @endif
                                <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-1">{{ Auth::user()->nomor_telepon ? implode('-', str_split(Auth::user()->nomor_telepon, 4)) : '-' }}</p>
                            </div>
                            <form action="{{ route('logout') }}" method="POST" onsubmit="return confirm('Yakin ingin logout?')">
                                @csrf
                                <button type="submit" class="inline-flex items-center gap-1 text-sm font-semibold text-red-600 hover:text-red-700 transition">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" class="w-4 h-4">
                                        <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M10 17l5-5-5-5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M15 12H3" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    Logout
                                </button>
                            </form>
                        </div>
                        @if (Auth::user()->role === 'pengguna')
                            @php
                                $activePurchasesCount = \App\Models\Purchase::where('user_id', Auth::id())
                                    ->whereIn('status', ['pending', 'menunggu_pembayaran', 'diproses', 'dikirim'])
                                    ->count();
                            @endphp
                            <a href="{{ route('pengguna.dashboard') }}?section=riwayat" class="flex items-center justify-between text-sm text-zinc-700 dark:text-zinc-300 hover:text-red-650 dark:hover:text-red-500 transition w-full">
                                <div class="inline-flex items-center gap-2">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" class="w-4 h-4 text-zinc-500 dark:text-zinc-400">
                                        <path d="M7 7h10M7 12h10M7 17h6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M5 4h14a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <span>Daftar Pesanan</span>
                                </div>
                                <span class="inline-flex items-center justify-center h-6 min-w-6 px-2 rounded-full bg-red-600 text-white text-xs font-semibold">{{ $activePurchasesCount }}</span>
                            </a>
                        @endif
                    </div>
                @endauth

                <div class="space-y-3">
                    <a href="{{ route('servis') }}" class="block w-full text-left py-2 font-semibold text-zinc-900 dark:text-white hover:text-red-600 dark:hover:text-red-500 transition">Servis</a>
                    <a href="{{ route('toko.banmotor') }}" class="block w-full text-left py-2 font-semibold text-zinc-900 dark:text-white hover:text-red-600 dark:hover:text-red-500 transition">Ban Motor</a>
                    <a href="{{ route('toko.oli') }}" class="block w-full text-left py-2 font-semibold text-zinc-900 dark:text-white hover:text-red-600 dark:hover:text-red-500 transition">Oli Motor</a>
                    <a href="{{ route('toko.sparepart') }}" class="block w-full text-left py-2 font-semibold text-zinc-900 dark:text-white hover:text-red-600 dark:hover:text-red-500 transition">Sparepart</a>
                </div>
            </div>
        </div>
    </aside>

    <main>
        <section id="home" class="max-w-7xl mx-auto px-8 pt-16 pb-0 overflow-hidden">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center mb-16">
                <div class="order-2 lg:order-1 text-center lg:text-left scroll-reveal-left">
                    <div class="inline-block px-4 py-1 rounded-full bg-red-600/10 border border-red-600/20 text-red-500 text-xs font-bold tracking-[0.2em] mb-6">
                        PREMIUM GARAGE SERVICE
                    </div>
                    <h1 class="text-7xl md:text-8xl font-bengkel leading-none tracking-tight mb-6 text-zinc-900 dark:text-white">
                        KEEP YOUR ENGINE <br> <span class="text-red-600">PERFORMANCE</span>
                    </h1>
                    <p class="text-zinc-600 dark:text-zinc-400 text-lg max-w-lg mx-auto lg:mx-0 mb-10 leading-relaxed">
                        Solusi perawatan kendaraan terpercaya dengan mekanik berpengalaman, suku cadang original, dan efisiensi waktu tanpa antrean panjang.
                    </p>
                    
                    <div class="flex flex-col sm:flex-row items-center gap-4 justify-center lg:justify-start">
                        <a href="{{ route('servis') }}" class="w-full sm:w-72 bg-red-600 hover:bg-red-700 text-white font-bold px-10 py-4 rounded-xl shadow-lg shadow-red-900/20 transition active:scale-95 text-center tracking-wider">
                            BOOKING SEKARANG
                        </a>
                    </div>
                </div>

                <div class="order-1 lg:order-2 relative scroll-reveal-right">
                    <div class="absolute -inset-1 bg-red-600 rounded-3xl blur opacity-10"></div>
                    <div class="relative bg-zinc-100 dark:bg-zinc-900 rounded-3xl border border-zinc-200 dark:border-zinc-800 overflow-hidden aspect-video lg:aspect-square flex items-center justify-center group transition-colors duration-300">
                        <img src="{{ asset ('img/home/bengkel.jpg') }}" alt="Gambar" class="w-full h-full object-cover" decoding="async">
                        <div class="absolute bottom-8 right-8 text-right">
                            <p class="text-red-600 text-6xl font-bengkel opacity-100 uppercase leading-none">Bengkelin<br>Sidoarjo</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Row -->
            <div class="border-t border-zinc-200 dark:border-zinc-800 py-12 scroll-reveal">
                <div class="grid grid-cols-3 gap-8 text-center max-w-3xl mx-auto">
                    <div>
                        <p class="text-3xl font-bengkel text-zinc-900 dark:text-white">500+</p>
                        <p class="text-xs text-zinc-500 dark:text-zinc-400 uppercase tracking-widest mt-1">Customers</p>
                    </div>
                    <div>
                        <p class="text-3xl font-bengkel text-zinc-900 dark:text-white">10+</p>
                        <p class="text-xs text-zinc-500 dark:text-zinc-400 uppercase tracking-widest mt-1">Expert Mechanics</p>
                    </div>
                    <div>
                        <p class="text-3xl font-bengkel text-zinc-900 dark:text-white">24/7</p>
                        <p class="text-xs text-zinc-500 dark:text-zinc-400 uppercase tracking-widest mt-1">Support</p>
                    </div>
                </div>
            </div>
        </section>

        <section id="about" class="max-w-7xl mx-auto px-8 py-24 border-t border-zinc-200 dark:border-zinc-800">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center overflow-hidden">
                <div class="space-y-6 scroll-reveal-left">
                    <h2 class="text-5xl font-bengkel text-zinc-900 dark:text-white leading-tight uppercase">
                        Lebih Dari Sekadar <br> <span class="text-red-600">Layanan Bengkel</span>
                    </h2>
                    <p class="text-zinc-650 dark:text-zinc-450 leading-relaxed text-sm">
                        Lahir dari komitmen untuk merevolusi sistem perawatan kendaraan konvensional, <span class="text-zinc-900 dark:text-white font-bold">Bengkelin</span> mengintegrasikan presisi mekanik bersertifikasi dengan efisiensi platform digital. Kami hadir untuk mengeliminasi antrean panjang dan memberikan transparansi penuh demi kenyamanan dan keselamatan berkendara Anda.
                    </p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4">
                        <!-- Visi Card -->
                        <div class="group/card relative p-6 bg-zinc-100/30 dark:bg-zinc-900/30 border border-zinc-200 dark:border-zinc-800 hover:border-red-600/30 rounded-2xl transition-all duration-500 hover:shadow-xl hover:shadow-red-950/5 hover:-translate-y-1 scroll-reveal delay-100">
                            <div class="flex items-center gap-3 mb-3">
                                <div class="h-9 w-9 rounded-lg bg-red-600/10 flex items-center justify-center text-red-500 border border-red-600/20 group-hover/card:bg-red-600 group-hover/card:text-white group-hover/card:scale-110 group-hover/card:rotate-3 transition-all duration-300">
                                    <i class="fa-solid fa-eye text-sm"></i>
                                </div>
                                <p class="text-red-600 font-bold text-xs uppercase tracking-widest">Visi Kami</p>
                            </div>
                            <p class="text-zinc-500 dark:text-zinc-400 text-xs leading-relaxed">Mewujudkan ekosistem digital perawatan otomotif terintegrasi di Sidoarjo yang mengedepankan transparansi, kecepatan layanan, dan kualitas standar prima.</p>
                        </div>
                        
                        <!-- Misi Card -->
                        <div class="group/card relative p-6 bg-zinc-100/30 dark:bg-zinc-900/30 border border-zinc-200 dark:border-zinc-800 hover:border-red-600/30 rounded-2xl transition-all duration-500 hover:shadow-xl hover:shadow-red-950/5 hover:-translate-y-1 scroll-reveal delay-200">
                            <div class="flex items-center gap-3 mb-3">
                                <div class="h-9 w-9 rounded-lg bg-red-600/10 flex items-center justify-center text-red-500 border border-red-600/20 group-hover/card:bg-red-600 group-hover/card:text-white group-hover/card:scale-110 group-hover/card:rotate-3 transition-all duration-300">
                                    <i class="fa-solid fa-bullseye text-sm"></i>
                                </div>
                                <p class="text-red-600 font-bold text-xs uppercase tracking-widest">Misi Kami</p>
                            </div>
                            <p class="text-zinc-500 dark:text-zinc-400 text-xs leading-relaxed">Menyediakan pelayanan berkualitas tinggi berbasis teknologi modern, menjamin keaslian suku cadang, dan membangun kepercayaan penuh konsumen.</p>
                        </div>
                    </div>
                </div>
                
                <div class="relative group scroll-reveal-right">
                    <div class="absolute -inset-1 bg-gradient-to-r from-red-600 to-zinc-300 dark:to-zinc-800 rounded-3xl blur opacity-20 group-hover:opacity-40 transition duration-1000"></div>
                    <div class="relative bg-zinc-100 dark:bg-zinc-900 rounded-3xl border border-zinc-200 dark:border-zinc-800 p-2 overflow-hidden transition-colors duration-300">
                        <img src="{{ asset("img/home/bengkel-samping.jpg") }}" alt="Workshop" class="rounded-2xl grayscale hover:grayscale-0 transition duration-700 w-full object-cover aspect-video lg:aspect-auto" loading="lazy" decoding="async">
                    </div>
                </div>
            </div>
        </section>

        <section id="location" class="max-w-7xl mx-auto px-8 py-24 border-t border-zinc-200 dark:border-zinc-800 overflow-hidden">
            <div class="text-center mb-16 scroll-reveal">
                <p class="text-red-600 font-bold text-xs tracking-[0.3em] mb-4 uppercase">Kunjungi Workshop Kami</p>
                <h2 class="text-4xl font-bengkel text-zinc-900 dark:text-white uppercase">Bengkelin Sidoarjo</h2>
            </div>

            <div class="bg-zinc-100 dark:bg-zinc-900 rounded-[2.5rem] border border-zinc-200 dark:border-zinc-800 overflow-hidden shadow-2xl transition-colors duration-300 scroll-reveal-scale delay-100">
                <div class="grid grid-cols-1 lg:grid-cols-3">
                    <div class="p-12 lg:border-r border-zinc-200 dark:border-zinc-800 flex flex-col justify-center">
                        <div class="space-y-8">
                            <div>
                                <h4 class="text-zinc-500 dark:text-zinc-400 text-[10px] uppercase tracking-widest font-bold mb-3">Alamat Utama</h4>
                                <p class="text-zinc-800 dark:text-white text-lg font-medium leading-relaxed italic">
                                    Nggrekmas, Pagerwojo, Kec. Buduran, Kabupaten Sidoarjo, Jawa Timur 61252
                                </p>
                            </div>
                            <div>
                                <h4 class="text-zinc-500 dark:text-zinc-400 text-[10px] uppercase tracking-widest font-bold mb-3">Jam Operasional</h4>
                                <p class="text-zinc-700 dark:text-zinc-300 text-sm">Senin - Sabtu: 08.00 - 17.00 WIB</p>
                                <p class="text-red-500 text-sm mt-1">Minggu: Tutup (Booking Only)</p>
                            </div>
                            <div class="pt-4">
                                <a href="https://www.openstreetmap.org/search?query=Nggrekmas%20Pagerwojo%20Buduran%20Sidoarjo" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-3 text-red-600 hover:text-red-500 font-bold text-xs uppercase tracking-widest transition">
                                    Buka di OpenStreetMap
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></svg>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="lg:col-span-2 h-[450px] opacity-80 hover:opacity-100 transition-all duration-700">
                        <div id="workshop-map" class="map-iframe w-full h-full" aria-label="Peta lokasi Bengkelin Sidoarjo"></div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    
    @include('partials.footer')

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet@1.9.4/dist/leaflet.css">
    <script src="https://cdn.jsdelivr.net/npm/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        const workshopLocation = [-7.4478, 112.7183];
        const workshopMap = L.map('workshop-map', { scrollWheelZoom: false }).setView(workshopLocation, 15);
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(workshopMap);
        L.marker(workshopLocation).addTo(workshopMap).bindPopup('Bengkelin').openPopup();
    </script>
    
    <script>
        const sidebarOpen = document.getElementById('sidebar-open');
        const sidebarClose = document.getElementById('sidebar-close');
        const sidebar = document.getElementById('sidebar');
        const sidebarOverlay = document.getElementById('sidebar-overlay');

        const lockBody = (locked) => {
            if (locked) {
                const scrollbarWidth = window.innerWidth - document.documentElement.clientWidth;
                document.body.classList.add('overflow-hidden');
                document.body.style.paddingRight = scrollbarWidth > 0 ? `${scrollbarWidth}px` : '';
                return;
            }
            document.body.classList.remove('overflow-hidden');
            document.body.style.paddingRight = '';
        };

        const openSidebar = () => {
            sidebar.classList.remove('translate-x-full');
            sidebarOverlay.classList.remove('opacity-0', 'pointer-events-none');
            sidebarOverlay.classList.add('opacity-100');
            lockBody(true);
            sidebarOpen.setAttribute('aria-expanded', 'true');
        };

        const closeSidebar = () => {
            sidebar.classList.add('translate-x-full');
            sidebarOverlay.classList.add('opacity-0', 'pointer-events-none');
            sidebarOverlay.classList.remove('opacity-100');
            lockBody(false);
            sidebarOpen.setAttribute('aria-expanded', 'false');
        };

        if (sidebarOpen) {
            sidebarOpen.addEventListener('click', openSidebar);
        }
        if (sidebarClose) {
            sidebarClose.addEventListener('click', closeSidebar);
        }
        if (sidebarOverlay) {
            sidebarOverlay.addEventListener('click', closeSidebar);
        }
        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') {
                closeSidebar();
            }
        });

        // IntersectionObserver for Scroll Reveal Animations
        document.addEventListener('DOMContentLoaded', () => {
             const revealElements = document.querySelectorAll('.scroll-reveal, .scroll-reveal-left, .scroll-reveal-right, .scroll-reveal-scale');
             if (!('IntersectionObserver' in window) || window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
                 revealElements.forEach(el => el.classList.add('revealed'));
                 return;
             }

             const revealObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('revealed');
                        observer.unobserve(entry.target); // Animasi sekali saja saat scroll masuk
                    }
                });
            }, {
                threshold: 0.1, // Trigger jika 10% elemen masuk ke viewport
                rootMargin: '0px 0px -50px 0px'
            });
            
            revealElements.forEach(el => revealObserver.observe(el));
        });
    </script>
</div>
@endsection