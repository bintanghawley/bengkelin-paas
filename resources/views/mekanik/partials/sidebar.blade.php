@php
    $currentSection = request('section', 'dashboard');
    $isProfile = request()->routeIs('mekanik.dashboard') && $currentSection === 'profil';
    $isHistory = request()->routeIs('mekanik.dashboard') && $currentSection !== 'profil';
    $isBookings = request()->routeIs('mekanik.bookings.*');
    $isEmergency = request()->routeIs('mekanik.emergency.*');
    $isAssistance = request()->routeIs('mekanik.assistance-requests.*');
    $pendingBookingCount = \App\Models\ServiceBooking::where('status', 'pending')->count();
    $pendingEmergencyCount = \App\Models\EmergencyReport::where('status', 'pending')->count();
    $pendingAssistanceCount = auth()->user()->receivedAssistanceRequests()->where('status', 'pending')->count();
    $activeClass = 'text-red-500 bg-red-900/20';
    $idleClass = 'text-zinc-400 hover:text-red-500 hover:bg-red-900/10';
@endphp

<aside class="w-64 bg-zinc-900 border-r border-zinc-800 flex flex-col fixed inset-y-0 left-0 z-50">
    <div class="p-6 flex items-center gap-3 border-b border-zinc-800/50">
        <span class="text-3xl font-bengkel tracking-wider">MEKANIK<span class="text-red-600">PANEL</span></span>
    </div>

    <div class="p-5 border-b border-zinc-800 flex items-center gap-3 bg-zinc-950/20">
        <div class="h-10 w-10 bg-red-600 rounded-full flex items-center justify-center font-bold text-white shadow-lg uppercase shrink-0">
            {{ substr(auth()->user()->name, 0, 1) }}
        </div>
        <div class="flex flex-col min-w-0 text-left">
            <span class="text-zinc-200 text-sm font-bold truncate leading-none mb-1.5">{{ auth()->user()->name }}</span>
            <span class="text-zinc-500 text-[10px] uppercase tracking-widest font-semibold leading-none">Mekanik Bengkelin</span>
        </div>
    </div>

    <nav class="flex-1 px-4 space-y-2 mt-6">
        <a href="{{ route('mekanik.dashboard', ['section' => 'profil']) }}" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl font-bold transition {{ $isProfile ? $activeClass : $idleClass }}">
            PROFIL
        </a>
        <a href="{{ route('mekanik.bookings.index') }}" class="relative w-full flex items-center gap-3 px-4 py-3 rounded-xl font-bold transition {{ $isBookings ? $activeClass : $idleClass }}">
            BOOKING MASUK
            @if($pendingBookingCount > 0)
                <span class="absolute right-3 bg-red-600 text-white text-[9px] font-bold rounded-full min-w-5 h-5 px-1 flex items-center justify-center">{{ $pendingBookingCount }}</span>
            @endif
        </a>
        <a href="{{ route('mekanik.emergency.index') }}" class="relative w-full flex items-center gap-3 px-4 py-3 rounded-xl font-bold transition {{ $isEmergency ? $activeClass : $idleClass }}">
            <svg fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z"/></svg>
            DARURAT
            @if($pendingEmergencyCount > 0)
                <span class="absolute right-3 bg-red-600 text-white text-[9px] font-bold rounded-full min-w-5 h-5 px-1 flex items-center justify-center">{{ $pendingEmergencyCount }}</span>
            @endif
        </a>
        <a href="{{ route('mekanik.assistance-requests.index') }}" class="relative w-full flex items-center gap-3 px-4 py-3 rounded-xl font-bold transition {{ $isAssistance ? $activeClass : $idleClass }}">
            BANTUAN TEKNISI
            @if($pendingAssistanceCount > 0)
                <span class="absolute right-3 bg-red-600 text-white text-[9px] font-bold rounded-full min-w-5 h-5 px-1 flex items-center justify-center">{{ $pendingAssistanceCount }}</span>
            @endif
        </a>
        <a href="{{ route('mekanik.dashboard', ['section' => 'dashboard']) }}" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl font-bold transition {{ $isHistory ? $activeClass : $idleClass }}">
            RIWAYAT
        </a>
    </nav>

    <div class="p-4 border-t border-zinc-800 space-y-2">
        <a href="{{ route('home') }}" class="group flex items-center justify-center gap-2 w-full text-center text-[10px] font-bold text-zinc-400 hover:text-white uppercase tracking-widest border border-zinc-800 hover:border-red-600 bg-zinc-900/50 hover:bg-red-600/10 py-2.5 rounded-xl transition-all duration-300">
            <svg class="w-3.5 h-3.5 transition-transform duration-300 group-hover:-translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M10 19l-7-7m0 0l7-7m-7 7h18" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <span>Kembali ke Beranda</span>
        </a>
        <form action="{{ route('logout') }}" method="POST" onsubmit="return confirm('Yakin ingin logout?')">
            @csrf
            <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 text-red-500 hover:bg-red-500/10 rounded-xl transition font-bold uppercase tracking-widest text-[10px]">
                <svg fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9"/>
                </svg>
                Sign Out Account
            </button>
        </form>
    </div>
</aside>
