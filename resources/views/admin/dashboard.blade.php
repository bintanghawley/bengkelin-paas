@extends('layouts.guest')

@section('content')
<div class="flex min-h-screen font-sans">
    
    @include('admin.partials.sidebar')

    <main class="flex-1 ml-64 p-10 bg-gray-50 dark:bg-zinc-950 min-h-screen">
        
        {{-- Header / Navbar --}}
        <header class="flex justify-between items-center mb-10">
            <div>
                <h2 class="text-4xl font-bengkel tracking-wider text-zinc-800 dark:text-white">ADMIN <span class="text-red-600">DASHBOARD</span></h2>
                <p class="text-zinc-500 text-xs uppercase tracking-[0.2em] mt-1 italic">Sidoarjo High Performance Garage</p>
            </div>
            <div class="flex items-center gap-4 bg-gray-50 dark:bg-zinc-900 border border-gray-200 dark:border-zinc-800 p-2 pr-6 rounded-full shadow-lg">
                <div class="h-10 w-10 bg-red-600 rounded-full flex items-center justify-center font-bold text-white shadow-lg uppercase">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div class="flex flex-col text-left">
                    <span class="text-zinc-800 dark:text-white text-sm font-bold leading-none">{{ Auth::user()->name }}</span>
                    <span class="text-zinc-500 text-[10px] uppercase mt-1 tracking-widest">Admin Bengkelin</span>
                </div>
            </div>
        </header>

        {{-- Profile Section --}}
        <section id="admin-profile" class="admin-section hidden space-y-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 italic">
                <div class="bg-gray-50 dark:bg-zinc-900 p-8 rounded-3xl border border-gray-200 dark:border-zinc-800 shadow-xl flex flex-col items-center text-center">
                    <div class="relative mb-6">
                        <div class="h-32 w-32 bg-gray-100 dark:bg-zinc-950 rounded-3xl border-2 border-red-600 flex items-center justify-center overflow-hidden">
                            <svg class="w-16 h-16 text-gray-300 dark:text-zinc-800" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                        </div>
                        <div class="absolute -bottom-2 -right-2 h-8 w-8 bg-emerald-500 border-4 border-gray-50 dark:border-zinc-900 rounded-full shadow-[0_0_10px_rgba(16,185,129,0.5)]"></div>
                    </div>
                    <h3 class="text-2xl font-bengkel tracking-wide uppercase text-zinc-800 dark:text-white">{{ Auth::user()->name }}</h3>
                    <p class="text-zinc-500 text-[10px] uppercase tracking-[0.3em] mt-1">Admin Bengkelin</p>
                    
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

                <div class="lg:col-span-2 bg-gray-50 dark:bg-zinc-900 p-8 rounded-3xl border border-gray-200 dark:border-zinc-800 shadow-xl relative overflow-hidden">
                    <div class="absolute -top-10 -right-10 opacity-[0.02] -rotate-12">
                         <svg viewBox="0 0 24 24" fill="currentColor" class="w-64 h-64 text-zinc-800 dark:text-white"><path d="M14.5 11V5a2 2 0 0 0-2-2h-1a2 2 0 0 0-2 2v-6M7 11h10M7 15h10M8 11v8a2 2 0 0 0 2 2h4a2 2 0 0 0 2-2v-8"/></svg>
                    </div>

                    <h3 class="text-xl font-bengkel text-red-600 mb-8 uppercase tracking-widest relative z-10">Data Admin Terverifikasi</h3>
                    
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

        <section id="admin-stats" class="admin-section space-y-10">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white dark:bg-zinc-900 p-6 rounded-3xl border border-gray-200 dark:border-zinc-800 shadow-sm">
                    <p class="text-gray-400 dark:text-zinc-500 text-[10px] font-bold uppercase tracking-widest">Total Mekanik</p>
                    <h3 class="text-4xl font-bengkel text-red-600">{{ $countMekanik }}</h3>
                </div>
                <div class="bg-white dark:bg-zinc-900 p-6 rounded-3xl border border-gray-200 dark:border-zinc-800 shadow-sm">
                    <p class="text-gray-400 dark:text-zinc-500 text-[10px] font-bold uppercase tracking-widest">Total Pengguna</p>
                    <h3 class="text-4xl font-bengkel text-gray-900 dark:text-white">{{ $countPengguna }}</h3>
                </div>
                <div class="bg-white dark:bg-zinc-900 p-6 rounded-3xl border border-gray-200 dark:border-zinc-800 shadow-sm">
                    <p class="text-gray-400 dark:text-zinc-500 text-[10px] font-bold uppercase tracking-widest">Pendapatan Bln Ini</p>
                    <h3 class="text-4xl font-bengkel text-emerald-600 dark:text-emerald-500">Rp {{ number_format($pendapatanBulanIni / 1000000, 1) }}M</h3>
                </div>
            </div>

            <div class="bg-white dark:bg-zinc-900 p-8 rounded-3xl border border-gray-200 dark:border-zinc-800 shadow-sm">
                <h3 class="text-xl font-bengkel mb-6 uppercase tracking-widest text-gray-900 dark:text-white">Grafik Pesanan & Penjualan</h3>
                <canvas id="salesChart" class="max-h-[300px]"></canvas>
            </div>
        </section>

        <section id="admin-users" class="admin-section hidden ">
            @include('admin.users.index')
        </section>

        <!-- KELOLA SERVIS -->
        <section id="admin-services" class="admin-section hidden ">
            @include('admin.services.index')
        </section>

        <!-- KELOLA BAN MOTOR -->
        <section id="admin-tires" class="admin-section hidden ">
            @include('admin.tires.index')
        </section>

        <!-- KELOLA OLI MOTOR -->
        <section id="admin-oils" class="admin-section hidden ">
            @include('admin.oils.index')
        </section>

        <!-- KELOLA SPAREPART -->
        <section id="admin-spareparts" class="admin-section hidden ">
            @include('admin.spareparts.index')
        </section>
  <section id="admin-orders" class="admin-section hidden ">
    <div class="grid grid-cols-1 gap-6">
        
        <div class="flex justify-between items-center bg-white dark:bg-zinc-900 p-6 rounded-3xl border border-gray-200 dark:border-zinc-800 shadow-sm">
            <div>
                <h3 class="font-bengkel text-xl text-gray-900 dark:text-white uppercase tracking-wider">Manajemen Stok</h3>
                <p class="text-[9px] text-gray-400 dark:text-zinc-500 uppercase mt-1">Total: {{ $products->count() }} Produk terdaftar</p>
            </div>
            <button onclick="toggleModalProduk(true)" class="bg-red-600 hover:bg-red-700 text-white text-[10px] font-bold px-6 py-3 rounded-xl uppercase tracking-widest transition flex items-center gap-2">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 4v16m8-8H4" stroke-width="3" stroke-linecap="round"/></svg>
                Tambah Produk
            </button>
        </div>

        <div class="bg-white dark:bg-zinc-900 p-8 rounded-3xl border border-gray-200 dark:border-zinc-800 shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-[11px] uppercase tracking-tighter">
                    <thead class="bg-gray-100 dark:bg-zinc-950 text-gray-500 dark:text-zinc-500 border-b border-gray-200 dark:border-zinc-800">
                        <tr>
                            <th class="px-6 py-4 text-center">Gambar</th>
                            <th class="px-6 py-4">Nama Produk</th>
                            <th class="px-6 py-4">Kategori</th>
                            <th class="px-6 py-4">Harga</th>
                            <th class="px-6 py-4 text-center">Stok</th>
                            <th class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-zinc-800/50 text-gray-600 dark:text-zinc-300">
                        @forelse ($products as $product)
                        <tr class="hover:bg-gray-50 dark:hover:bg-zinc-800/30 transition-colors">
                            <td class="px-6 py-4 text-center">
                                @if($product->gambar)
                                    <img src="{{ str_starts_with($product->gambar, 'img/') || str_starts_with($product->gambar, 'http') ? asset($product->gambar) : asset('storage/' . $product->gambar) }}" class="w-10 h-10 object-cover rounded-lg border border-gray-200 dark:border-zinc-700 mx-auto">
                                @else
                                    <div class="w-10 h-10 bg-gray-100 dark:bg-zinc-800 rounded-lg border border-gray-200 dark:border-zinc-700 mx-auto"></div>
                                @endif
                            </td>
                            <td class="px-6 py-4 font-bold text-gray-900 dark:text-white">{{ $product->nama }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 rounded text-[9px] font-bold uppercase
                                    {{ $product->kategori === 'ban' ? 'bg-blue-500/20 text-blue-600 dark:text-blue-400' : '' }}
                                    {{ $product->kategori === 'oli' ? 'bg-amber-500/20 text-amber-600 dark:text-amber-400' : '' }}
                                    {{ $product->kategori === 'sparepart' ? 'bg-emerald-500/20 text-emerald-600 dark:text-emerald-400' : '' }}
                                ">{{ $product->kategori }}</span>
                            </td>
                            <td class="px-6 py-4 text-emerald-600 dark:text-emerald-500 font-bold">Rp {{ number_format($product->harga, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 text-center">{{ $product->stok }}</td>
                            <td class="px-6 py-4 text-right flex justify-end items-center gap-3">
                                <button onclick="openModalEditProduk('{{ $product->id }}', '{{ $product->nama }}', '{{ $product->stok }}', '{{ $product->harga }}', '{{ $product->kategori }}', '{{ $product->deskripsi }}')" class="text-amber-600 dark:text-amber-500 hover:text-gray-900 dark:hover:text-white transition font-bold">
                                    Edit
                                </button>
                                
                                <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Hapus?')">
                                    @csrf @method('DELETE')
                                    <button class="text-red-600 dark:text-red-500 hover:text-gray-900 dark:hover:text-white transition font-bold">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="px-6 py-10 text-center text-gray-400 dark:text-zinc-600">Gudang Kosong.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div id="modal-produk" class="fixed inset-0 z-[99] hidden flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-black/80 backdrop-blur-sm" onclick="toggleModalProduk(false)"></div>
        
        <div class="relative bg-zinc-900 w-full max-w-2xl rounded-3xl border border-zinc-800 shadow-2xl overflow-hidden transform transition-all">
            <div class="p-8">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="font-bengkel text-xl text-red-600 uppercase tracking-widest">Tambah Item Baru</h3>
                    <button type="button" onclick="toggleModalProduk(false)" class="text-zinc-500 hover:text-white transition text-2xl">&times;</button>
                </div>

                <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-1">
                            <label class="text-[10px] uppercase text-zinc-500 font-bold">Nama Barang</label>
                            <input type="text" name="nama" required class="w-full bg-zinc-950 border border-zinc-800 rounded-xl px-4 py-3 text-sm text-white focus:border-red-600 outline-none transition">
                        </div>
                        <div class="space-y-1">
                            <label class="text-[10px] uppercase text-zinc-500 font-bold">Kategori</label>
                            <select name="kategori" required class="w-full bg-zinc-950 border border-zinc-800 rounded-xl px-4 py-3 text-sm text-white focus:border-red-600 outline-none transition">
                                <option value="sparepart">Sparepart</option>
                                <option value="ban">Ban Motor</option>
                                <option value="oli">Oli Motor</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-1">
                            <label class="text-[10px] uppercase text-zinc-500 font-bold">Stok</label>
                            <input type="number" name="stok" required class="w-full bg-zinc-950 border border-zinc-800 rounded-xl px-4 py-3 text-sm text-white focus:border-red-600 outline-none transition">
                        </div>
                        <div class="space-y-1">
                            <label class="text-[10px] uppercase text-zinc-500 font-bold">Harga Jual (Rp)</label>
                            <input type="number" name="harga" required class="w-full bg-zinc-950 border border-zinc-800 rounded-xl px-4 py-3 text-sm text-white focus:border-red-600 outline-none transition">
                        </div>
                    </div>

                    <div class="space-y-1">
                        <label class="text-[10px] uppercase text-zinc-500 font-bold">Deskripsi (Opsional)</label>
                        <textarea name="deskripsi" rows="2" placeholder="Deskripsi singkat produk..." class="w-full bg-zinc-950 border border-zinc-800 rounded-xl px-4 py-3 text-sm text-white focus:border-red-600 outline-none transition"></textarea>
                    </div>

                    <div class="space-y-1">
                        <label class="text-[10px] uppercase text-zinc-500 font-bold">Foto Produk</label>
                        <input type="file" name="gambar" class="w-full bg-zinc-950 border border-zinc-800 rounded-xl px-4 py-3 text-xs text-zinc-400 file:bg-red-600 file:border-0 file:text-white file:rounded-lg file:px-3 file:mr-3">
                    </div>

                    <div class="pt-4 flex gap-3">
                        <button type="button" onclick="toggleModalProduk(false)" class="flex-1 bg-zinc-800 hover:bg-zinc-700 text-white font-bold py-3 rounded-xl uppercase text-[10px] transition">Batal</button>
                        <button type="submit" class="flex-[2] bg-red-600 hover:bg-red-700 text-white font-bold py-3 rounded-xl uppercase text-[10px] tracking-widest transition shadow-lg shadow-red-900/40">Simpan Sekarang</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="modal-edit-produk" class="fixed inset-0 z-[99] hidden flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-black/80 backdrop-blur-sm" onclick="toggleModalEditProduk(false)"></div>
        
        <div class="relative bg-zinc-900 w-full max-w-2xl rounded-3xl border border-zinc-800 shadow-2xl overflow-hidden transform transition-all">
            <div class="p-8">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="font-bengkel text-xl text-red-500 uppercase tracking-widest">Update Data Item</h3>
                    <button type="button" onclick="toggleModalEditProduk(false)" class="text-zinc-500 hover:text-white transition text-2xl">&times;</button>
                </div>

                <form id="form-edit-produk" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-1">
                            <label class="text-[10px] uppercase text-zinc-500 font-bold">Nama Barang</label>
                            <input type="text" id="edit-nama" name="nama" required class="w-full bg-zinc-950 border border-zinc-800 rounded-xl px-4 py-3 text-sm text-white focus:border-red-500 outline-none transition">
                        </div>
                        <div class="space-y-1">
                            <label class="text-[10px] uppercase text-zinc-500 font-bold">Kategori</label>
                            <select id="edit-kategori" name="kategori" required class="w-full bg-zinc-950 border border-zinc-800 rounded-xl px-4 py-3 text-sm text-white focus:border-red-500 outline-none transition">
                                <option value="sparepart">Sparepart</option>
                                <option value="ban">Ban Motor</option>
                                <option value="oli">Oli Motor</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-1">
                            <label class="text-[10px] uppercase text-zinc-500 font-bold">Stok</label>
                            <input type="number" id="edit-stok" name="stok" required class="w-full bg-zinc-950 border border-zinc-800 rounded-xl px-4 py-3 text-sm text-white focus:border-red-500 outline-none transition">
                        </div>
                        <div class="space-y-1">
                            <label class="text-[10px] uppercase text-zinc-500 font-bold">Harga Jual (Rp)</label>
                            <input type="number" id="edit-harga" name="harga" required class="w-full bg-zinc-950 border border-zinc-800 rounded-xl px-4 py-3 text-sm text-white focus:border-red-500 outline-none transition">
                        </div>
                    </div>

                    <div class="space-y-1">
                        <label class="text-[10px] uppercase text-zinc-500 font-bold">Deskripsi (Opsional)</label>
                        <textarea id="edit-deskripsi" name="deskripsi" rows="2" class="w-full bg-zinc-950 border border-zinc-800 rounded-xl px-4 py-3 text-sm text-white focus:border-red-500 outline-none transition"></textarea>
                    </div>

                    <div class="space-y-1">
                        <label class="text-[10px] uppercase text-zinc-500 font-bold">Ganti Foto Produk (Opsional)</label>
                        <input type="file" name="gambar" class="w-full bg-zinc-950 border border-zinc-800 rounded-xl px-4 py-3 text-xs text-zinc-400 file:bg-red-500 file:border-0 file:text-white file:rounded-lg file:px-3 file:mr-3">
                    </div>

                    <div class="pt-4 flex gap-3">
                        <button type="button" onclick="toggleModalEditProduk(false)" class="flex-1 bg-zinc-800 hover:bg-zinc-700 text-white font-bold py-3 rounded-xl uppercase text-[10px] transition">Batal</button>
                        <button type="submit" class="flex-[2] bg-emerald-500 hover:bg-emerald-600 text-black font-bold py-3 rounded-xl uppercase text-[10px] tracking-widest transition shadow-lg shadow-red-950/40">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    
</section>
        <br>   

        <section id="admin-booking" class=" admin-section hidden bg-white dark:bg-zinc-900 p-8 rounded-3xl border border-gray-200 dark:border-zinc-800 shadow-sm">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h3 class="font-bengkel text-2xl text-red-600 uppercase tracking-wider">Management Booking</h3>
            <p class="text-[10px] text-gray-400 dark:text-zinc-500  uppercase mt-1">Total Pesanan: {{ $allBookings->count() }} Entry terdeteksi</p>
        </div>
        <a href="{{ route('admin.bookings.index') }}" class="bg-red-600 hover:bg-red-700 text-white text-[10px] font-bold px-6 py-3 rounded-xl uppercase tracking-widest transition">
            Kelola Semua →
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left text-[11px] uppercase tracking-tighter">
            <thead class="bg-gray-100 dark:bg-zinc-950 text-gray-500 dark:text-zinc-500 border-b border-gray-200 dark:border-zinc-800">
                <tr>
                    <th class="px-6 py-4 font-bold text-gray-700 dark:text-white">Customer</th>
                    <th class="px-6 py-4 font-bold text-gray-700 dark:text-white">Kendaraan & Layanan</th>
                    <th class="px-6 py-4 font-bold text-gray-700 dark:text-white">Plat Nomor</th>
                    <th class="px-6 py-4 font-bold text-center text-gray-700 dark:text-white">Jadwal</th>
                    <th class="px-6 py-4 font-bold text-center text-gray-700 dark:text-white">Status</th>
                    <th class="px-6 py-4 font-bold text-right text-gray-700 dark:text-white">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-zinc-800/50 text-gray-600 dark:text-zinc-300">
                @forelse ($allBookings as $booking)
                    <tr class="hover:bg-gray-50 dark:hover:bg-zinc-800/30 transition-colors group">
                        <td class="px-6 py-4">
                            <div class="flex flex-col">
                                <span class="text-gray-900 dark:text-white font-bold">{{ $booking->user->name ?? 'Guest' }}</span>
                                <span class="text-[9px] text-gray-400 dark:text-zinc-500 lowercase italic">Telp: {{ $booking->user->nomor_telepon ?? '-' }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="block text-red-600 dark:text-red-500 font-bold">{{ $booking->nama_kendaraan }}</span>
                            <span class="text-gray-400 dark:text-zinc-400 text-[10px]">{{ $booking->service->nama ?? '-' }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="bg-gray-100 dark:bg-zinc-800 px-2 py-1 rounded border border-gray-200 dark:border-zinc-700 text-[9px] text-gray-700 dark:text-zinc-300">
                                {{ $booking->plat_nomor }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="text-gray-900 dark:text-white">{{ $booking->tanggal_booking ? $booking->tanggal_booking->format('d/m/Y') : '-' }}</span>
                            <span class="block text-[9px] text-gray-400 dark:text-zinc-500">{{ \Carbon\Carbon::parse($booking->jam_booking)->format('H:i') }} WIB</span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            @php
                                $bc = match($booking->status) {
                                    'pending'    => 'bg-orange-900/20 text-orange-500 border-orange-800',
                                    'diterima'   => 'bg-blue-900/20 text-blue-500 border-blue-800',
                                    'diproses'   => 'bg-yellow-900/20 text-yellow-500 border-yellow-800',
                                    'selesai'    => 'bg-emerald-900/20 text-emerald-500 border-emerald-800',
                                    'ditolak'    => 'bg-red-900/20 text-red-400 border-red-800',
                                    'dibatalkan' => 'bg-red-900/20 text-red-500 border-red-800',
                                    default      => 'bg-zinc-800 text-zinc-400 border-zinc-700',
                                };
                            @endphp
                            <span class="px-3 py-1 rounded-full text-[9px] font-bold border inline-block {{ $bc }}">
                                {{ strtoupper($booking->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('admin.bookings.show', $booking->id) }}" class="text-blue-400 hover:text-blue-300 font-bold transition">Kelola</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center justify-center space-y-3 opacity-20">
                                <svg class="w-12 h-12 text-zinc-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                <p class="italic tracking-[0.2em] text-sm">Tidak ada antrean servis saat ini</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    </section>


    <!-- Modals for User -->
    @include('admin.users.create')
    @include('admin.users.edit')

    <!-- Modals for Services -->
    @include('admin.services.create')
    @include('admin.services.edit')
    @include('admin.services.show')

    <!-- Modals for Tires -->
    @include('admin.tires.create')
    @include('admin.tires.edit')

    <!-- Modals for Oils -->
    @include('admin.oils.create')
    @include('admin.oils.edit')

    <!-- Modals for Spareparts -->
    @include('admin.spareparts.create')
    @include('admin.spareparts.edit')
    </main>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // 1. FUNGSI NAVIGASI SIDEBAR
    function showAdminSection(id) {
        // Sembunyikan semua section
        document.querySelectorAll('.admin-section').forEach(s => s.classList.add('hidden'));
        // Tampilkan section yang dipilih
        const target = document.getElementById('admin-' + id);
        if (target) {
            target.classList.remove('hidden');
        }
        
        // Update active classes on buttons
        document.querySelectorAll('.admin-nav').forEach(btn => {
            if (btn.tagName === 'BUTTON') {
                const onclickAttr = btn.getAttribute('onclick') || '';
                if (onclickAttr.includes(`'${id}'`)) {
                    btn.classList.remove('text-gray-500', 'dark:text-zinc-400');
                    btn.classList.add('text-gray-850', 'dark:text-white');
                } else {
                    btn.classList.remove('text-gray-850', 'dark:text-white');
                    btn.classList.add('text-gray-500', 'dark:text-zinc-400');
                }
            } else if (btn.tagName === 'A') {
                btn.classList.remove('text-gray-850', 'dark:text-white');
                btn.classList.add('text-gray-500', 'dark:text-zinc-400');
            }
        });

        // AUTO-CLOSE MODAL: Jika admin pindah menu saat modal buka, kita tutup paksa modalnya
        toggleModalProduk(false);
    }

    // Auto load section if present in URL query string
    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        const section = urlParams.get('section');
        if (section) {
            showAdminSection(section);
        }
    });
      function toggleModalEditProduk(show) {
            const modal = document.getElementById('modal-edit-produk');
            if (!modal) return;
            if (show) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            } else {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }
        }

        // Fungsi utama menyuntikkan data baris tabel ke input modal edit
        function openModalEditProduk(id, nama, stok, harga, kategori, deskripsi) {
            document.getElementById('edit-nama').value = nama;
            document.getElementById('edit-stok').value = stok;
            document.getElementById('edit-harga').value = harga;
            document.getElementById('edit-kategori').value = kategori || 'sparepart';
            document.getElementById('edit-deskripsi').value = deskripsi || '';

            // Update action form agar mengarah ke route update (Contoh: /products/12)
            document.getElementById('form-edit-produk').action = '/products/' + id;

            // Buka Modal Edit
            toggleModalEditProduk(true);
        }

    // 2. FUNGSI TOGGLE MODAL (POP-UP)
    function toggleModalProduk(show) {
        const modal = document.getElementById('modal-produk');
        if (!modal) return; // Guard clause jika elemen tidak ada

        if (show) {
            modal.classList.remove('hidden');
            modal.classList.add('flex'); // Pastikan pakai flex untuk centering
            document.body.style.overflow = 'hidden'; // Kunci scroll layar utama
        } else {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = 'auto'; // Aktifkan kembali scroll
        }
    }

    // 3. INISIALISASI SALES CHART (Line Chart)
    const ctx = document.getElementById('salesChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            datasets: [{
                label: 'Pesanan Masuk',
                data: [12, 19, 3, 5, 2, 20],
                borderColor: '#dc2626', // Red-600
                backgroundColor: 'rgba(220, 38, 38, 0.1)',
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#dc2626',
                pointRadius: 4,
                pointHoverRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { 
                legend: { display: false } 
            },
            scales: {
                y: { 
                    grid: { color: '#27272a' }, // Zinc-800
                    ticks: { 
                        color: '#71717a', 
                        font: { family: 'Inter', size: 10 } 
                    } 
                },
                x: { 
                    grid: { display: false }, 
                    ticks: { 
                        color: '#71717a', 
                        font: { family: 'Inter', size: 10 } 
                    } 
                }
            },
            interaction: {
                intersect: false,
                mode: 'index',
            }
        }
    });

    // Close modal jika user tekan tombol ESC
    document.addEventListener('keydown', function(event) {
        if (event.key === "Escape") {
            toggleModalProduk(false);
            toggleModalEditProduk(false);
            toggleModalUser(false);
            toggleModalEditUser(false);
            toggleModalService(false);
            toggleModalEditService(false);
            toggleModalDetailService(false);
            toggleModalTire(false);
            toggleModalEditTire(false);
            toggleModalSparepart(false);
            toggleModalEditSparepart(false);
        }
    });

    // Click outside modal to close
    window.addEventListener('click', (event) => {
        if (event.target === document.getElementById('modal-produk') || 
            event.target === document.getElementById('modal-service') || 
            event.target === document.getElementById('modal-edit-service') || 
            event.target === document.getElementById('modal-detail-service') ||
            event.target === document.getElementById('modal-tire') ||
            event.target === document.getElementById('modal-edit-tire') ||
            event.target === document.getElementById('modal-oil') ||
            event.target === document.getElementById('modal-edit-oil') ||
            event.target === document.getElementById('modal-sparepart') ||
            event.target === document.getElementById('modal-edit-sparepart')) {
            toggleModalProduk(false);
            toggleModalService(false);
            toggleModalEditService(false);
            toggleModalDetailService(false);
            toggleModalTire(false);
            toggleModalEditTire(false);
            toggleModalOil(false);
            toggleModalEditOil(false);
        }
    });

    // 4. USER MODALS
    function toggleModalUser(show) {
        const modal = document.getElementById('modal-user');
        if (!modal) return;
        if (show) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
        } else {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = 'auto';
        }
    }

    function toggleModalEditUser(show) {
        const modal = document.getElementById('modal-edit-user');
        if (!modal) return;
        if (show) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
        } else {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = 'auto';
        }
    }

    function openModalEditUser(id, name, phone, role) {
        document.getElementById('e_user_name').value = name;
        document.getElementById('e_user_phone').value = phone;
        document.getElementById('e_user_role').value = role;
        document.getElementById('form-edit-user').action = '/admin/users/' + id;
        toggleModalEditUser(true);
    }

    // 5. SERVICE MODALS
    function toggleModalService(show) {
        const modal = document.getElementById('modal-service');
        if (!modal) return;
        if (show) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
        } else {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = 'auto';
        }
    }

    function toggleModalEditService(show) {
        const modal = document.getElementById('modal-edit-service');
        if (!modal) return;
        if (show) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
        } else {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = 'auto';
        }
    }

    function openModalEditService(id, nama, deskripsi, harga, estimasi, items) {
        document.getElementById('e_serv_nama').value = nama;
        document.getElementById('e_serv_harga').value = harga;
        document.getElementById('e_serv_waktu').value = estimasi;
        document.getElementById('e_serv_desc').value = deskripsi;
        document.getElementById('form-edit-service').action = '/admin/services/' + id;

        const container = document.getElementById('e-service-items-container');
        container.innerHTML = '';
        if (Array.isArray(items)) {
            items.forEach(item => {
                addServiceItemRow('e-service-items-container', item, true);
            });
        }
        toggleModalEditService(true);
    }

    function toggleModalDetailService(show) {
        const modal = document.getElementById('modal-detail-service');
        if (!modal) return;
        if (show) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
        } else {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = 'auto';
        }
    }

    function openModalDetailService(nama, deskripsi, harga, estimasi, gambarUrl, items) {
        document.getElementById('d_serv_nama').innerText = nama;
        document.getElementById('d_serv_desc').innerText = deskripsi;
        document.getElementById('d_serv_harga').innerText = harga;
        document.getElementById('d_serv_waktu').innerText = estimasi;

        const imgEl = document.getElementById('d_serv_img');
        const noImgEl = document.getElementById('d_serv_no_img');
        if (gambarUrl) {
            imgEl.src = gambarUrl;
            imgEl.classList.remove('hidden');
            noImgEl.classList.add('hidden');
        } else {
            imgEl.classList.add('hidden');
            noImgEl.classList.remove('hidden');
        }

        const container = document.getElementById('d-service-items-container');
        container.innerHTML = '';
        if (Array.isArray(items)) {
            items.forEach(item => {
                const el = document.createElement('div');
                el.className = 'flex items-center gap-3 bg-zinc-950/80 border border-zinc-800/60 rounded-xl px-4 py-3';
                el.innerHTML = `
                    <div class="flex-shrink-0 w-6 h-6 rounded-full bg-emerald-900/40 border border-emerald-700/60 flex items-center justify-center">
                        <svg class="w-3 h-3 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M5 13l4 4L19 7" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <span class="text-sm text-zinc-200">${item}</span>
                `;
                container.appendChild(el);
            });
        }

        toggleModalDetailService(true);
    }

    function addServiceItemRow(containerId, value = '', isEdit = false) {
        const container = document.getElementById(containerId);
        if (!container) return;

        const row = document.createElement('div');
        row.className = 'flex items-center gap-2';

        const focusBorderClass = isEdit ? 'focus:border-yellow-500' : 'focus:border-red-600';
        const btnHoverClass = isEdit ? 'hover:text-yellow-500' : 'hover:text-red-500';

        row.innerHTML = `
            <input type="text" name="items[]" value="${value}" placeholder="Misal: Ganti Oli" required class="w-full bg-zinc-950 border border-zinc-800 rounded-xl px-4 py-3 text-sm text-white ${focusBorderClass} outline-none transition">
            <button type="button" onclick="this.parentElement.remove()" class="text-zinc-500 ${btnHoverClass} px-3 py-3 border border-zinc-800 rounded-xl bg-zinc-950">X</button>
        `;
        container.appendChild(row);
    }

    // 6. TIRE MODALS
    function toggleModalTire(show) {
        const modal = document.getElementById('modal-tire');
        if (!modal) return;
        if (show) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
        } else {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = 'auto';
        }
    }

    function toggleModalEditTire(show) {
        const modal = document.getElementById('modal-edit-tire');
        if (!modal) return;
        if (show) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
        } else {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = 'auto';
        }
    }

    function openModalEditTire(id, nama, harga, stok, jenis_ban, merek, ukuran_ban, posisi_ban, material, diameter, tipe, fitur, deskripsi) {
        document.getElementById('edit-tire-nama').value = nama;
        document.getElementById('edit-tire-harga').value = harga;
        document.getElementById('edit-tire-stok').value = stok;
        document.getElementById('edit-tire-jenis_ban').value = jenis_ban;
        document.getElementById('edit-tire-merek').value = merek;
        document.getElementById('edit-tire-ukuran_ban').value = ukuran_ban;
        document.getElementById('edit-tire-posisi_ban').value = posisi_ban;
        document.getElementById('edit-tire-material').value = material;
        document.getElementById('edit-tire-diameter').value = diameter;
        document.getElementById('edit-tire-tipe').value = tipe;
        document.getElementById('edit-tire-fitur').value = fitur || '';
        document.getElementById('edit-tire-deskripsi').value = deskripsi || '';

        document.getElementById('form-edit-tire').action = '/admin/tires/' + id;
        toggleModalEditTire(true);
    }

    // 7. OIL MODALS
    function toggleModalOil(show) {
        const modal = document.getElementById('modal-oil');
        if (!modal) return;
        if (show) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
        } else {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = 'auto';
        }
    }

    function toggleModalEditOil(show) {
        const modal = document.getElementById('modal-edit-oil');
        if (!modal) return;
        if (show) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
        } else {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = 'auto';
        }
    }

    function openModalEditOil(id, nama, harga, stok, jenis_oli, kekentalan, ukuran, tipe_oli, merek, fitur, deskripsi) {
        document.getElementById('edit-oil-nama').value = nama;
        document.getElementById('edit-oil-harga').value = harga;
        document.getElementById('edit-oil-stok').value = stok;
        document.getElementById('edit-oil-jenis_oli').value = jenis_oli;
        document.getElementById('edit-oil-kekentalan').value = kekentalan;
        document.getElementById('edit-oil-ukuran').value = ukuran;
        document.getElementById('edit-oil-tipe_oli').value = tipe_oli;
        document.getElementById('edit-oil-merek').value = merek;
        document.getElementById('edit-oil-fitur').value = fitur || '';
        document.getElementById('edit-oil-deskripsi').value = deskripsi || '';

        document.getElementById('form-edit-oil').action = '/admin/oils/' + id;
        toggleModalEditOil(true);
    }

    // 8. SPAREPART MODALS
    function toggleModalSparepart(show) {
        const modal = document.getElementById('modal-sparepart');
        if (!modal) return;
        if (show) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
        } else {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = 'auto';
        }
    }

    function toggleModalEditSparepart(show) {
        const modal = document.getElementById('modal-edit-sparepart');
        if (!modal) return;
        if (show) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
        } else {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = 'auto';
        }
    }

    function openModalEditSparepart(id, nama, harga, stok, jenis_sparepart, merek, fitur, deskripsi) {
        document.getElementById('edit-sp-nama').value = nama;
        document.getElementById('edit-sp-harga').value = harga;
        document.getElementById('edit-sp-stok').value = stok;
        document.getElementById('edit-sp-jenis_sparepart').value = jenis_sparepart;
        document.getElementById('edit-sp-merek').value = merek;
        document.getElementById('edit-sp-fitur').value = fitur || '';
        document.getElementById('edit-sp-deskripsi').value = deskripsi || '';

        document.getElementById('form-edit-sparepart').action = '/admin/spareparts/' + id;
        toggleModalEditSparepart(true);
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
</script>

{{-- Modals --}}
<div id="modal-update-profile" class="fixed inset-0 z-[99] hidden flex items-center justify-center p-4 bg-black/80 backdrop-blur-sm">
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

<div id="modal-change-password" class="fixed inset-0 z-[99] hidden flex items-center justify-center p-4 bg-black/80 backdrop-blur-sm">
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