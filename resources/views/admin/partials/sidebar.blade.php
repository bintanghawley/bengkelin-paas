@php
    $section = request('section', 'stats');
    $dashboardRoute = fn (string $target) => route('admin.dashboard', ['section' => $target]);
    $active = 'text-red-500 bg-red-900/20';
    $idle = 'text-zinc-400 hover:text-red-500 hover:bg-red-900/10';
@endphp

<aside class="w-64 bg-zinc-900 border-r border-zinc-800 flex flex-col fixed inset-y-0 left-0 z-50">
    <div class="p-6 border-b border-zinc-800">
        <span class="text-3xl font-bengkel tracking-wider text-white">ADMIN<span class="text-red-600">PANEL</span></span>
    </div>
    <div class="p-5 border-b border-zinc-800 flex items-center gap-3 bg-zinc-950/20">
        <div class="h-10 w-10 bg-red-600 rounded-full flex items-center justify-center font-bold text-white uppercase shrink-0">{{ substr(auth()->user()->name, 0, 1) }}</div>
        <div class="min-w-0">
            <p class="text-zinc-200 text-sm font-bold truncate">{{ auth()->user()->name }}</p>
            <p class="text-zinc-500 text-[10px] uppercase tracking-widest">Admin Bengkelin</p>
        </div>
    </div>
    <nav class="flex-1 px-4 space-y-2 mt-6 overflow-y-auto">
        @foreach(['profile' => 'PROFIL', 'stats' => 'STATISTIK', 'users' => 'KELOLA USER', 'services' => 'KELOLA SERVIS', 'tires' => 'KELOLA BAN MOTOR', 'oils' => 'KELOLA OLI MOTOR', 'spareparts' => 'KELOLA SPAREPART'] as $target => $label)
            <a href="{{ $dashboardRoute($target) }}" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl font-bold transition {{ request()->routeIs('admin.dashboard') && $section === $target ? $active : $idle }}">{{ $label }}</a>
        @endforeach
        <a href="{{ route('admin.bookings.index') }}" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl font-bold transition {{ request()->routeIs('admin.bookings.*') ? $active : $idle }}">KELOLA BOOKING</a>
        <a href="{{ route('admin.payments.index') }}" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl font-bold transition {{ request()->routeIs('admin.payments.*') ? $active : $idle }}">RIWAYAT PEMBAYARAN</a>
    </nav>
    <div class="p-4 border-t border-zinc-800 space-y-2">
        <a href="{{ route('home') }}" class="flex items-center justify-center gap-2 w-full text-[10px] font-bold text-zinc-400 hover:text-white uppercase tracking-widest border border-zinc-800 hover:border-red-600 py-2.5 rounded-xl transition">← Kembali ke Beranda</a>
        <form action="{{ route('logout') }}" method="POST" onsubmit="return confirm('Yakin ingin logout?')">
            @csrf
            <button type="submit" class="w-full px-4 py-3 text-red-500 hover:bg-red-500/10 rounded-xl transition font-bold uppercase tracking-widest text-[10px]">Sign Out Account</button>
        </form>
    </div>
</aside>
