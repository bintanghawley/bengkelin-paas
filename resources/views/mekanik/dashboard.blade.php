@extends('layouts.guest')

@section('content')
<div class="flex min-h-screen font-sans bg-zinc-950 text-white">
    @include('mekanik.partials.sidebar')

    <!-- Main Content -->
    <main class="flex-1 ml-64 p-10 min-h-screen">
        {{-- Header / Navbar --}}
        <header class="flex justify-between items-center mb-10">
            <div>
                <h2 class="text-4xl font-bengkel tracking-wider text-white">MEKANIK <span class="text-red-600">DASHBOARD</span></h2>
                <p class="text-zinc-500 text-xs uppercase tracking-[0.2em] mt-1 italic">Sidoarjo High Performance Garage</p>
            </div>
            <div class="flex items-center gap-4 bg-zinc-900 border border-zinc-800 p-2 pr-6 rounded-full shadow-lg">
                <div class="h-10 w-10 bg-red-650 rounded-full flex items-center justify-center font-bold text-white shadow-lg uppercase">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div class="flex flex-col text-left">
                    <span class="text-white text-sm font-bold leading-none">{{ Auth::user()->name }}</span>
                    <span class="text-zinc-500 text-[10px] uppercase mt-1 tracking-widest">Mekanik Bengkelin</span>
                </div>
            </div>
        </header>



        <!-- Dashboard Section -->
        <section id="mekanik-dashboard" class="mekanik-section space-y-6">
            <!-- Stats -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">
                <div class="bg-zinc-900 p-6 rounded-3xl border border-zinc-800 shadow-xl">
                    <p class="text-zinc-500 text-[10px] font-bold uppercase tracking-widest mb-2">Booking Menunggu</p>
                    <h3 class="text-4xl font-bengkel {{ $pendingCount > 0 ? 'text-red-500' : 'text-zinc-500' }}">{{ $pendingCount }}</h3>
                    <a href="{{ route('mekanik.bookings.index') }}" class="text-[10px] text-zinc-500 hover:text-red-400 transition uppercase tracking-wider mt-2 block">Lihat Semua →</a>
                </div>
                <div class="bg-zinc-900 p-6 rounded-3xl border border-zinc-800 shadow-xl">
                    <p class="text-zinc-500 text-[10px] font-bold uppercase tracking-widest mb-2">Darurat Masuk</p>
                    <h3 class="text-4xl font-bengkel {{ $pendingEmergencyCount > 0 ? 'text-red-500' : 'text-zinc-500' }}">{{ $pendingEmergencyCount }}</h3>
                    <a href="{{ route('mekanik.emergency.index') }}" class="text-[10px] text-zinc-500 hover:text-red-400 transition uppercase tracking-wider mt-2 block">Lihat Semua →</a>
                </div>
                <div class="bg-zinc-900 p-6 rounded-3xl border border-zinc-800 shadow-xl">
                    <p class="text-zinc-500 text-[10px] font-bold uppercase tracking-widest mb-2">Tugas Aktif Saya</p>
                    <h3 class="text-4xl font-bengkel text-yellow-500">{{ $activeBookings->count() }}</h3>
                    <p class="text-[10px] text-zinc-500 uppercase tracking-wider mt-2">Diterima / Diproses</p>
                </div>
                <div class="bg-zinc-900 p-6 rounded-3xl border border-zinc-800 shadow-xl">
                    <p class="text-zinc-500 text-[10px] font-bold uppercase tracking-widest mb-2">Total Selesai</p>
                    <h3 class="text-4xl font-bengkel text-emerald-500">{{ $completedCount }}</h3>
                    <p class="text-[10px] text-zinc-500 uppercase tracking-wider mt-2">Servis berhasil</p>
                </div>
            </div>

            <!-- Active Tasks -->
            @if($activeBookings->count() > 0)
            <div class="bg-zinc-900 rounded-3xl border border-zinc-800 overflow-hidden shadow-2xl mb-8">
                <div class="p-6 border-b border-zinc-800 flex justify-between items-center">
                    <h3 class="font-bengkel text-lg text-white uppercase tracking-wider">⚡ Tugas Aktif Saya</h3>
                    <span class="text-[9px] bg-yellow-950/40 text-yellow-400 px-3 py-1 rounded-full border border-yellow-900/60 font-bold uppercase">{{ $activeBookings->count() }} Aktif</span>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-[11px] uppercase tracking-tighter">
                        <thead class="bg-zinc-950 text-zinc-500 border-b border-zinc-800">
                            <tr>
                                <th class="px-6 py-4">Pelanggan</th>
                                <th class="px-6 py-4">Servis / Motor</th>
                                <th class="px-6 py-4">Tanggal Booking</th>
                                <th class="px-6 py-4 text-center">Status</th>
                                <th class="px-6 py-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-800/50 text-zinc-300">
                            @foreach ($activeBookings as $booking)
                            <tr class="hover:bg-zinc-800/30 transition-colors">
                                <td class="px-6 py-4">
                                    <span class="block font-bold text-white">{{ $booking->user->name ?? 'Guest' }}</span>
                                    <span class="text-[9px] text-zinc-500 font-mono">{{ $booking->user->nomor_telepon ?? '-' }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="block text-red-500 font-bold">{{ $booking->nama_kendaraan }}</span>
                                    <span class="text-zinc-400 text-[10px]">{{ $booking->service->nama ?? '-' }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    {{ $booking->tanggal_booking ? $booking->tanggal_booking->format('d/m/Y') : '-' }}
                                    @ {{ \Carbon\Carbon::parse($booking->jam_booking)->format('H:i') }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @php
                                        $sc = match($booking->status) {
                                            'diterima' => 'bg-blue-950/40 text-blue-400 border-blue-900/60',
                                            'diproses' => 'bg-yellow-950/40 text-yellow-500 border-yellow-900/60',
                                            default => 'bg-zinc-800 text-zinc-400 border-zinc-700',
                                        };
                                    @endphp
                                    <span class="px-3 py-1 rounded-full text-[9px] font-bold border inline-block {{ $sc }}">
                                        {{ strtoupper($booking->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('mekanik.bookings.show', $booking->id) }}"
                                       class="inline-block bg-zinc-800 hover:bg-zinc-700 text-white text-[9px] font-bold py-2 px-4 rounded-lg transition">
                                        Detail & Update
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif

            <!-- All My Bookings -->
            <div class="bg-zinc-900 rounded-3xl border border-zinc-800 overflow-hidden shadow-2xl">
                <div class="p-6 border-b border-zinc-800 flex justify-between items-center">
                    <h3 class="font-bengkel text-lg text-white uppercase tracking-wider">Riwayat Tugas Saya</h3>
                    <span class="text-[9px] bg-zinc-800 text-zinc-400 px-3 py-1 rounded-full border border-zinc-700 font-bold">{{ $bookings->count() }} Total</span>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-[11px] uppercase tracking-tighter">
                        <thead class="bg-zinc-950 text-zinc-500 border-b border-zinc-800">
                            <tr>
                                <th class="px-6 py-4">Pelanggan</th>
                                <th class="px-6 py-4">Servis / Motor</th>
                                <th class="px-6 py-4">Tanggal</th>
                                <th class="px-6 py-4 text-center">Status</th>
                                <th class="px-6 py-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-800/50 text-zinc-300">
                            @forelse ($bookings as $booking)
                            <tr class="hover:bg-zinc-800/30 transition-colors">
                                <td class="px-6 py-4">
                                    <span class="block font-bold text-white">{{ $booking->user->name ?? 'Guest' }}</span>
                                    <span class="text-[9px] text-zinc-500 italic font-mono">Telp: {{ $booking->user->nomor_telepon ?? '-' }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="block text-red-500 font-bold">{{ $booking->nama_kendaraan }}</span>
                                    <span class="text-zinc-400 text-[10px]">{{ $booking->service->nama ?? '-' }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    {{ $booking->tanggal_booking ? $booking->tanggal_booking->format('d/m/Y') : '-' }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @php
                                        $sc = match($booking->status) {
                                            'pending'    => 'bg-orange-950/40 text-orange-400 border-orange-900/60',
                                            'diterima'   => 'bg-blue-950/40 text-blue-400 border-blue-900/60',
                                            'diproses'   => 'bg-yellow-950/40 text-yellow-500 border-yellow-900/60',
                                            'selesai'    => 'bg-emerald-950/40 text-emerald-400 border-emerald-900/60',
                                            'ditolak'    => 'bg-red-950/40 text-red-400 border-red-900/60',
                                            'dibatalkan' => 'bg-red-950/40 text-red-500 border-red-900/60',
                                            default      => 'bg-zinc-800 text-zinc-400 border-zinc-700',
                                        };
                                    @endphp
                                    <span class="px-3 py-1 rounded-full text-[9px] font-bold border inline-block {{ $sc }}">
                                        {{ strtoupper($booking->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('mekanik.bookings.show', $booking->id) }}"
                                       class="inline-block bg-zinc-800 hover:bg-zinc-700 text-white text-[9px] font-bold py-2 px-4 rounded-lg transition">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-16 text-center text-zinc-600 italic">
                                    Belum ada tugas servis yang pernah dikerjakan.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        {{-- Profile Section --}}
        <section id="mekanik-profil" class="mekanik-section hidden space-y-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 italic">
                <div class="bg-gray-50 dark:bg-zinc-900 p-8 rounded-3xl border border-gray-200 dark:border-zinc-800 shadow-xl flex flex-col items-center text-center">
                    <div class="relative mb-6">
                        <div class="h-32 w-32 bg-gray-100 dark:bg-zinc-950 rounded-3xl border-2 border-red-600 flex items-center justify-center overflow-hidden">
                            <svg class="w-16 h-16 text-gray-300 dark:text-zinc-800" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                        </div>
                        <div class="absolute -bottom-2 -right-2 h-8 w-8 bg-emerald-500 border-4 border-gray-50 dark:border-zinc-900 rounded-full shadow-[0_0_10px_rgba(16,185,129,0.5)]"></div>
                    </div>
                    <h3 class="text-2xl font-bengkel tracking-wide uppercase text-zinc-800 dark:text-white">{{ Auth::user()->name }}</h3>
                    <p class="text-zinc-500 text-[10px] uppercase tracking-[0.3em] mt-1">Mekanik Bengkelin</p>
                    
                    <div class="w-full mt-8 pt-8 border-t border-gray-200 dark:border-zinc-800 space-y-3">
                        <div class="flex justify-between text-[10px]">
                            <span class="text-zinc-500 uppercase font-bold tracking-widest">ID Akun</span>
                            <span class="text-zinc-800 dark:text-white">#00{{ Auth::user()->id }}</span>
                        </div>
                        <div class="flex justify-between text-[10px]">
                            <span class="text-zinc-500 uppercase font-bold tracking-widest">Bergabung</span>
                            <span class="text-zinc-800 dark:text-white italic">{{ Auth::user()->created_at->format('M Y') }}</span>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-2 bg-gray-50 dark:bg-zinc-900 p-8 rounded-3xl border border-gray-200 dark:border-zinc-800 shadow-xl relative overflow-hidden text-zinc-200">
                    <div class="absolute -top-10 -right-10 opacity-[0.02] -rotate-12">
                         <svg viewBox="0 0 24 24" fill="currentColor" class="w-64 h-64 text-zinc-800 dark:text-white"><path d="M14.5 11V5a2 2 0 0 0-2-2h-1a2 2 0 0 0-2 2v-6M7 11h10M7 15h10M8 11v8a2 2 0 0 0 2 2h4a2 2 0 0 0 2-2v-8"/></svg>
                    </div>

                    <h3 class="text-xl font-bengkel text-red-600 mb-8 uppercase tracking-widest relative z-10">Data Mekanik Terverifikasi</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 relative z-10">
                        <div class="space-y-1">
                            <label class="text-[10px] text-zinc-500 uppercase font-bold tracking-widest block">Full Identity</label>
                            <p class="text-zinc-800 dark:text-white font-medium border-b border-gray-200 dark:border-zinc-800 pb-2">{{ Auth::user()->name }}</p>
                        </div>
                        <div class="space-y-1">
                            <label class="text-[10px] text-zinc-500 uppercase font-bold tracking-widest block">Nomor Telepon</label>
                            <p class="text-zinc-800 dark:text-white font-medium border-b border-gray-200 dark:border-zinc-800 pb-2">{{ Auth::user()->nomor_telepon ? implode('-', str_split(Auth::user()->nomor_telepon, 4)) : '-' }}</p>
                        </div>
                    </div>

                    <div class="mt-12 flex flex-col md:flex-row gap-4">
                        <button onclick="toggleModalUpdateProfile(true)" class="bg-red-600 hover:bg-red-700 text-white text-[10px] font-bold py-3 px-8 rounded-xl transition uppercase tracking-widest shadow-lg shadow-red-900/20">
                            Update Profil
                        </button>
                        <button onclick="toggleModalChangePassword(true)" class="bg-gray-200 dark:bg-zinc-800 hover:bg-gray-300 dark:hover:bg-zinc-700 text-zinc-800 dark:text-white text-[10px] font-bold py-3 px-8 rounded-xl transition uppercase tracking-widest border border-gray-300 dark:border-zinc-700">
                            Ganti Password
                        </button>
                    </div>
                </div>
            </div>
        </section>
    </main>
</div>

<script>
    function showMekanikSection(id) {
        document.querySelectorAll('.mekanik-section').forEach(s => s.classList.add('hidden'));
        const target = document.getElementById('mekanik-' + id);
        if (target) target.classList.remove('hidden');

        document.querySelectorAll('.mekanik-nav').forEach(btn => {
            if (btn.id === 'btn-' + id) {
                btn.className = "mekanik-nav w-full flex items-center gap-3 px-4 py-3 text-red-500 bg-red-900/20 rounded-xl font-bold transition";
            } else {
                btn.className = "mekanik-nav w-full flex items-center gap-3 px-4 py-3 text-zinc-400 hover:text-red-500 rounded-xl font-bold transition";
            }
        });
    }

    function toggleModalUpdateProfile(show) {
        const modal = document.getElementById('modal-update-profile');
        if (show) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        } else {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    }

    function toggleModalChangePassword(show) {
        const modal = document.getElementById('modal-change-password');
        if (show) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        } else {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    }

    // Auto load section if present in URL query string
    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        const section = urlParams.get('section');
        if (section && ['profil', 'dashboard'].includes(section)) {
            showMekanikSection(section);
        } else {
            showMekanikSection('dashboard');
        }
    });
</script>

{{-- Modals --}}
<div id="modal-update-profile" class="fixed inset-0 z-[99] hidden flex items-center justify-center p-4 bg-black/80 backdrop-blur-sm text-white">
    <div class="relative bg-zinc-900 w-full max-w-md rounded-3xl border border-zinc-800 shadow-2xl overflow-hidden p-8 text-left">
        <div class="flex justify-between items-center mb-6">
            <h3 class="font-bengkel text-xl text-red-600 uppercase tracking-widest">Update Profil</h3>
            <button type="button" onclick="toggleModalUpdateProfile(false)" class="text-zinc-500 hover:text-white transition text-2xl">&times;</button>
        </div>
        <form action="{{ route('profile.update') }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            <div class="space-y-1">
                <label class="text-[10px] uppercase text-zinc-500 font-bold block">Nama Lengkap</label>
                <input type="text" name="name" value="{{ Auth::user()->name }}" required class="w-full bg-zinc-950 border border-zinc-800 rounded-xl px-4 py-3 text-sm text-white focus:border-red-600 outline-none transition">
            </div>
            <div class="space-y-1">
                <label class="text-[10px] uppercase text-zinc-500 font-bold block">Nomor Telepon</label>
                <input type="text" name="nomor_telepon" value="{{ Auth::user()->nomor_telepon }}" required class="w-full bg-zinc-950 border border-zinc-800 rounded-xl px-4 py-3 text-sm text-white focus:border-red-600 outline-none transition">
            </div>
            <div class="pt-4 flex gap-3">
                <button type="button" onclick="toggleModalUpdateProfile(false)" class="flex-1 bg-zinc-800 hover:bg-zinc-700 text-white font-bold py-3 rounded-xl uppercase text-[10px] transition">Batal</button>
                <button type="submit" class="flex-[2] bg-red-600 hover:bg-red-700 text-white font-bold py-3 rounded-xl uppercase text-[10px] tracking-widest transition">Simpan</button>
            </div>
        </form>
    </div>
</div>

<div id="modal-change-password" class="fixed inset-0 z-[99] hidden flex items-center justify-center p-4 bg-black/80 backdrop-blur-sm text-white">
    <div class="relative bg-zinc-900 w-full max-w-md rounded-3xl border border-zinc-800 shadow-2xl overflow-hidden p-8 text-left">
        <div class="flex justify-between items-center mb-6">
            <h3 class="font-bengkel text-xl text-red-600 uppercase tracking-widest">Ganti Password</h3>
            <button type="button" onclick="toggleModalChangePassword(false)" class="text-zinc-500 hover:text-white transition text-2xl">&times;</button>
        </div>
        <form action="{{ route('profile.update') }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            <input type="hidden" name="name" value="{{ Auth::user()->name }}">
            <input type="hidden" name="nomor_telepon" value="{{ Auth::user()->nomor_telepon }}">
            
            <div class="space-y-1">
                <label class="text-[10px] uppercase text-zinc-500 font-bold block">Password Baru</label>
                <input type="password" name="password" required class="w-full bg-zinc-950 border border-zinc-800 rounded-xl px-4 py-3 text-sm text-white focus:border-red-600 outline-none transition">
            </div>
            <div class="pt-4 flex gap-3">
                <button type="button" onclick="toggleModalChangePassword(false)" class="flex-1 bg-zinc-800 hover:bg-zinc-700 text-white font-bold py-3 rounded-xl uppercase text-[10px] transition">Batal</button>
                <button type="submit" class="flex-[2] bg-red-600 hover:bg-red-700 text-white font-bold py-3 rounded-xl uppercase text-[10px] tracking-widest transition">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection
