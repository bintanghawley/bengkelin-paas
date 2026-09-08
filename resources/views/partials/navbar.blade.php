<nav class="w-full border-b border-zinc-200/50 dark:border-zinc-900/60 bg-white/90 dark:bg-zinc-950/90 backdrop-blur relative z-30 text-zinc-900 dark:text-white transition-colors duration-300">
    <div class="max-w-7xl mx-auto px-6 py-5 flex items-center justify-between">
        <a href="{{ route('home') }}" class="flex items-center gap-2">
            <img src="{{ asset('img/home/logo.png') }}" alt="" class="w-10 h-10 object-contain">
            <span class="text-xl font-bengkel tracking-wider text-zinc-900 dark:text-white">Bengkel<span class="text-red-600">in</span></span>
        </a>
        <div class="hidden lg:flex items-center gap-10 text-xs font-semibold uppercase tracking-widest text-zinc-500 dark:text-zinc-400">
            <a href="{{ route('servis') }}" class="{{ Request::routeIs('servis*') ? 'text-red-600 dark:text-white font-bold' : 'hover:text-zinc-900 dark:hover:text-white transition' }}">Servis</a>
            <a href="{{ route('toko.banmotor') }}" class="{{ Request::routeIs('toko.banmotor*') ? 'text-red-660 dark:text-white font-bold' : 'hover:text-zinc-900 dark:hover:text-white transition' }}">Ban Motor</a>
            <a href="{{ route('toko.oli') }}" class="{{ Request::routeIs('toko.oli*') ? 'text-red-660 dark:text-white font-bold' : 'hover:text-zinc-900 dark:hover:text-white transition' }}">Oli Motor</a>
            <a href="{{ route('toko.sparepart') }}" class="{{ Request::routeIs('toko.sparepart*') ? 'text-red-660 dark:text-white font-bold' : 'hover:text-zinc-900 dark:hover:text-white transition' }}">Sparepart</a>
        </div>
        <div class="flex items-center gap-3">
            @include('partials.cart-widget')

            @auth
                @if (Auth::user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center justify-center h-10 w-10 rounded-full border border-zinc-300 dark:border-zinc-700 hover:border-zinc-400 dark:hover:border-zinc-500 bg-white dark:bg-zinc-900/50 hover:bg-zinc-100 dark:hover:bg-zinc-900 text-zinc-800 dark:text-zinc-200 hover:text-zinc-955 dark:hover:text-white transition shadow-sm" aria-label="Dashboard">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" class="w-4 h-4">
                            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M4 20c0-4 4-6 8-6s8 2 8 6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </a>
                @elseif (Auth::user()->role === 'mekanik')
                    <a href="{{ route('mekanik.dashboard') }}" class="inline-flex items-center justify-center h-10 w-10 rounded-full border border-zinc-300 dark:border-zinc-700 hover:border-zinc-400 dark:hover:border-zinc-500 bg-white dark:bg-zinc-900/50 hover:bg-zinc-100 dark:hover:bg-zinc-900 text-zinc-800 dark:text-zinc-200 hover:text-zinc-955 dark:hover:text-white transition shadow-sm" aria-label="Dashboard">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" class="w-4 h-4">
                            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M4 20c0-4 4-6 8-6s8 2 8 6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </a>
                @else
                    <a href="{{ route('pengguna.dashboard') }}" class="inline-flex items-center justify-center h-10 w-10 rounded-full border border-zinc-300 dark:border-zinc-700 hover:border-zinc-400 dark:hover:border-zinc-500 bg-white dark:bg-zinc-900/50 hover:bg-zinc-100 dark:hover:bg-zinc-900 text-zinc-800 dark:text-zinc-200 hover:text-zinc-955 dark:hover:text-white transition shadow-sm" aria-label="Dashboard">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" class="w-4 h-4">
                            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M4 20c0-4 4-6 8-6s8 2 8 6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </a>
                @endif
            @endauth
            @guest
                <div class="relative group">
                    <button type="button" class="inline-flex items-center justify-center h-10 w-10 rounded-full border border-zinc-300 dark:border-zinc-700 hover:border-zinc-400 dark:hover:border-zinc-500 bg-white dark:bg-zinc-900/50 hover:bg-zinc-100 dark:hover:bg-zinc-900 text-zinc-800 dark:text-zinc-200 hover:text-zinc-955 dark:hover:text-white transition shadow-sm" aria-label="Akun">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" class="w-4 h-4">
                            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M4 20c0-4 4-6 8-6s8 2 8 6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </button>
                    <div class="absolute right-0 top-full pt-2 w-72 z-50 opacity-0 translate-y-1 pointer-events-none transition group-hover:opacity-100 group-hover:translate-y-0 group-hover:pointer-events-auto group-focus-within:opacity-100 group-focus-within:translate-y-0 group-focus-within:pointer-events-auto">
                        <div class="bg-white dark:bg-zinc-900 text-zinc-900 dark:text-white border border-zinc-200 dark:border-zinc-800 rounded-2xl shadow-2xl p-4 space-y-3">
                            <p class="text-sm font-semibold">Akun</p>
                            <a href="{{ route('login') }}" class="block w-full text-center bg-red-600 hover:bg-red-700 text-white font-semibold py-2.5 rounded-full transition">Login</a>
                            <a href="{{ route('register') }}" class="block w-full text-center border border-red-600 text-red-600 hover:bg-red-50 dark:hover:bg-red-950/20 font-semibold py-2.5 rounded-full transition">Daftar Akun</a>
                        </div>
                    </div>
                </div>
            @endguest
        </div>
    </div>
</nav>
