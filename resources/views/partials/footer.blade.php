<!-- FOOTER SECTION -->
<footer class="bg-zinc-50 dark:bg-zinc-950 pt-20 pb-10 px-6 transition-colors duration-300">
    <div class="max-w-7xl mx-auto footer-reveal">
        <!-- Main Footer Card -->
        <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-[2.5rem] p-8 md:p-12 shadow-2xl transition-colors duration-300">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-12">
                
                <!-- Brand & Description -->
                <div class="md:col-span-4 space-y-6">
                    <div class="flex items-center gap-3">
                        <div>
                            <img src="{{ asset('img/home/logo.png') }}" alt="" class="w-20 h-20 object-contain">
                        </div>
                        <span class="text-2xl font-bengkel tracking-wider text-zinc-900 dark:text-white">BENGKEL<span class="text-red-600">IN</span></span>
                    </div>
                    <p class="text-zinc-600 dark:text-zinc-400 text-sm leading-relaxed max-w-xs">
                        Solusi perawatan motor modern berbasis digital. Booking mekanik ahli dan beli sparepart original dalam satu platform.
                    </p>
                    <!-- Social Icons -->
                    <div class="flex gap-3">
                        <a href="https://instagram.com" target="_blank" rel="noopener noreferrer" class="h-10 w-10 bg-zinc-100 dark:bg-zinc-800 hover:bg-red-600 rounded-xl flex items-center justify-center text-zinc-500 dark:text-zinc-400 hover:text-white dark:hover:text-white transition-all duration-300" aria-label="Instagram">
                            <i class="fa-brands fa-instagram text-lg"></i>
                        </a>
                        <a href="https://x.com" target="_blank" rel="noopener noreferrer" class="h-10 w-10 bg-zinc-100 dark:bg-zinc-800 hover:bg-red-600 rounded-xl flex items-center justify-center text-zinc-500 dark:text-zinc-400 hover:text-white dark:hover:text-white transition-all duration-300" aria-label="Twitter">
                            <i class="fa-brands fa-x-twitter text-lg"></i>
                        </a>
                        <a href="https://facebook.com" target="_blank" rel="noopener noreferrer" class="h-10 w-10 bg-zinc-100 dark:bg-zinc-800 hover:bg-red-600 rounded-xl flex items-center justify-center text-zinc-500 dark:text-zinc-400 hover:text-white dark:hover:text-white transition-all duration-300" aria-label="Facebook">
                            <i class="fa-brands fa-facebook-f text-lg"></i>
                        </a>
                        <a href="https://youtube.com" target="_blank" rel="noopener noreferrer" class="h-10 w-10 bg-zinc-100 dark:bg-zinc-800 hover:bg-red-600 rounded-xl flex items-center justify-center text-zinc-500 dark:text-zinc-400 hover:text-white dark:hover:text-white transition-all duration-300" aria-label="YouTube">
                            <i class="fa-brands fa-youtube text-lg"></i>
                        </a>
                    </div>
                </div>

                <!-- Navigation Links -->
                <div class="md:col-span-8 flex flex-col sm:flex-row sm:justify-between gap-8 md:gap-12">
                    <div>
                        <h4 class="text-zinc-900 dark:text-white font-bold text-sm mb-6 uppercase tracking-widest">Navigasi</h4>
                        <ul class="space-y-4 text-zinc-500 dark:text-zinc-400 text-sm">
                            <li>
                                <a href="{{ route('home') }}#home" class="group flex items-center gap-2 hover:text-red-500 dark:hover:text-red-400 transition">
                                    <i class="fa-solid fa-chevron-right text-[8px] text-red-500/60 group-hover:text-red-500 group-hover:translate-x-0.5 transition-all"></i>
                                    <span>Beranda</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('home') }}#about" class="group flex items-center gap-2 hover:text-red-500 dark:hover:text-red-400 transition">
                                    <i class="fa-solid fa-chevron-right text-[8px] text-red-500/60 group-hover:text-red-500 group-hover:translate-x-0.5 transition-all"></i>
                                    <span>Tentang Kami</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('home') }}#location" class="group flex items-center gap-2 hover:text-red-500 dark:hover:text-red-400 transition">
                                    <i class="fa-solid fa-chevron-right text-[8px] text-red-500/60 group-hover:text-red-500 group-hover:translate-x-0.5 transition-all"></i>
                                    <span>Lokasi</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="text-zinc-900 dark:text-white font-bold text-sm mb-6 uppercase tracking-widest">Layanan & Toko</h4>
                        <ul class="space-y-4 text-zinc-500 dark:text-zinc-400 text-sm">
                            <li>
                                <a href="{{ route('servis') }}" class="group flex items-center gap-2 hover:text-red-500 dark:hover:text-red-400 transition">
                                    <i class="fa-solid fa-chevron-right text-[8px] text-red-500/60 group-hover:text-red-500 group-hover:translate-x-0.5 transition-all"></i>
                                    <span>Servis Motor</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('toko.banmotor') }}" class="group flex items-center gap-2 hover:text-red-500 dark:hover:text-red-400 transition">
                                    <i class="fa-solid fa-chevron-right text-[8px] text-red-500/60 group-hover:text-red-500 group-hover:translate-x-0.5 transition-all"></i>
                                    <span>Ban Motor</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('toko.oli') }}" class="group flex items-center gap-2 hover:text-red-500 dark:hover:text-red-400 transition">
                                    <i class="fa-solid fa-chevron-right text-[8px] text-red-500/60 group-hover:text-red-500 group-hover:translate-x-0.5 transition-all"></i>
                                    <span>Oli Motor</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('toko.sparepart') }}" class="group flex items-center gap-2 hover:text-red-500 dark:hover:text-red-400 transition">
                                    <i class="fa-solid fa-chevron-right text-[8px] text-red-500/60 group-hover:text-red-500 group-hover:translate-x-0.5 transition-all"></i>
                                    <span>Sparepart</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="text-zinc-900 dark:text-white font-bold text-sm mb-6 uppercase tracking-widest">Hubungi Kami</h4>
                        <ul class="space-y-4 text-zinc-500 dark:text-zinc-400 text-sm">
                            <li class="flex items-center gap-2">
                                <i class="fa-solid fa-phone text-xs text-red-500"></i>
                                <span>0812-3022-0688</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <i class="fa-solid fa-envelope text-xs text-red-500"></i>
                                <span>support@bengkelin.id</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <i class="fa-solid fa-clock text-xs text-red-500"></i>
                                <span>Senin - Sabtu: 08:00 - 17:00</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Bottom Row: Badges -->
            <div class="mt-16 pt-8 border-t border-zinc-200 dark:border-zinc-800/50 flex flex-col md:flex-row items-center justify-between gap-8">
                <div class="flex flex-wrap items-center gap-4">
                    <div class="flex items-center gap-2 px-4 py-2 bg-zinc-50 dark:bg-zinc-950 rounded-lg border border-zinc-200 dark:border-zinc-800 text-[10px] font-bold text-zinc-500 dark:text-zinc-400 uppercase tracking-widest transition-colors duration-300">
                        <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                        Service Certified
                    </div>
                    <div class="flex items-center gap-2 px-4 py-2 bg-zinc-50 dark:bg-zinc-950 rounded-lg border border-zinc-200 dark:border-zinc-800 text-[10px] font-bold text-zinc-500 dark:text-zinc-400 uppercase tracking-widest transition-colors duration-300">
                        <span class="text-yellow-500">★★★★★</span>
                        4.9/5 Rating
                    </div>
                </div>
                
                <div class="text-[10px] font-bold text-zinc-500 dark:text-zinc-400 uppercase tracking-widest flex items-center gap-2">
                    <span class="w-1.5 h-1.5 bg-red-600 rounded-full animate-pulse"></span>
                    <span>Suku Cadang 100% Original</span>
                </div>
            </div>
        </div>

        <!-- Copyright -->
        <div class="mt-10 text-center text-[10px] text-zinc-500 dark:text-zinc-600 uppercase tracking-[0.2em] font-medium">
            <p>© 2026 Bengkelin.</p>
        </div>
    </div>
</footer>

<style>
    /* Independent footer scroll reveal animations */
    .footer-reveal {
        opacity: 1;
        transform: translateY(0);
    }
    .js .footer-reveal {
        opacity: 0;
        transform: translateY(30px);
        transition: opacity 1s cubic-bezier(0.16, 1, 0.3, 1), transform 1s cubic-bezier(0.16, 1, 0.3, 1);
        will-change: transform, opacity;
    }
    .js .footer-reveal.revealed {
        opacity: 1;
        transform: translateY(0);
    }
    @media (prefers-reduced-motion: reduce) {
        .js .footer-reveal {
            opacity: 1;
            transform: none;
            transition: none;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const reveals = document.querySelectorAll('.footer-reveal');
        if (!('IntersectionObserver' in window) || window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
            reveals.forEach(el => el.classList.add('revealed'));
            return;
        }
        const obs = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('revealed');
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        });
        reveals.forEach(el => obs.observe(el));
    });
</script>
