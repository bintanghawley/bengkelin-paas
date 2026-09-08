@extends('layouts.guest')

@section('content')
<div class="bg-zinc-950 text-white min-h-screen">


    <div class="max-w-4xl mx-auto px-6 py-10">
        <div class="mb-8">
            <h1 class="text-3xl font-bengkel uppercase tracking-wide">Ajukan Booking Servis</h1>
            <p class="text-zinc-500 text-sm mt-1">Silakan isi formulir di bawah ini untuk memesan layanan servis.</p>
        </div>

        @if($errors->any())
            <div class="mb-6 bg-red-900/30 border border-red-700 text-red-400 px-6 py-4 rounded-2xl text-sm">
                <p class="font-bold mb-1">Terjadi kesalahan input:</p>
                <ul class="list-disc pl-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
            <!-- Left: Info Layanan (Readonly info) -->
            <div class="lg:col-span-1 bg-zinc-900 border border-zinc-800 rounded-3xl p-6 space-y-4">
                <h3 class="text-xs text-zinc-500 uppercase tracking-widest font-bold border-b border-zinc-800 pb-3">Layanan yang Dipilih</h3>
                <div>
                    <p class="text-[10px] text-zinc-400 uppercase font-bold tracking-widest">Nama Servis</p>
                    <p class="text-lg font-bold text-white uppercase">{{ $service->nama }}</p>
                </div>
                <div>
                    <p class="text-[10px] text-zinc-400 uppercase font-bold tracking-widest">Harga Mulai</p>
                    <p class="text-lg font-bold text-emerald-500">{{ $service->harga_mulai_formatted }}</p>
                </div>
                <div>
                    <p class="text-[10px] text-zinc-400 uppercase font-bold tracking-widest">Estimasi Waktu</p>
                    <p class="text-sm font-semibold text-white">{{ $service->estimasi_waktu }}</p>
                </div>
            </div>

            <!-- Right: Form Booking -->
            <div class="lg:col-span-2 bg-zinc-900 border border-zinc-800 rounded-3xl p-8">
                <form action="{{ route('booking.store', $service->slug) }}" method="POST" class="space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-[10px] uppercase text-zinc-500 font-bold tracking-widest">Nama Kendaraan / Motor</label>
                            <input type="text" name="nama_kendaraan" value="{{ old('nama_kendaraan') }}" placeholder="Misal: Honda Beat 2021" required
                                   class="w-full bg-zinc-950 border border-zinc-800 rounded-xl px-4 py-3.5 text-sm text-white focus:border-red-600 outline-none transition">
                        </div>

                        <div class="space-y-2">
                            <label class="text-[10px] uppercase text-zinc-500 font-bold tracking-widest">Plat Nomor</label>
                            <input type="text" name="plat_nomor" value="{{ old('plat_nomor') }}" placeholder="Misal: B 1234 ABC" required
                                   class="w-full bg-zinc-950 border border-zinc-800 rounded-xl px-4 py-3.5 text-sm text-white focus:border-red-600 outline-none transition">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-[10px] uppercase text-zinc-500 font-bold tracking-widest">Tanggal Booking</label>
                            <input type="date" name="tanggal_booking" value="{{ old('tanggal_booking', date('Y-m-d')) }}" required
                                   class="w-full bg-zinc-950 border border-zinc-800 rounded-xl px-4 py-3.5 text-sm text-white focus:border-red-600 outline-none transition">
                        </div>

                        <div class="space-y-2">
                            <label class="text-[10px] uppercase text-zinc-500 font-bold tracking-widest">Jam Booking</label>
                            <input type="time" name="jam_booking" value="{{ old('jam_booking') }}" required
                                   class="w-full bg-zinc-950 border border-zinc-800 rounded-xl px-4 py-3.5 text-sm text-white focus:border-red-600 outline-none transition">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] uppercase text-zinc-500 font-bold tracking-widest">Keluhan / Catatan Tambahan (Opsional)</label>
                        <textarea name="keluhan" rows="4" placeholder="Tuliskan keluhan atau permintaan tambahan..."
                                  class="w-full bg-zinc-950 border border-zinc-800 rounded-xl px-4 py-3.5 text-sm text-white focus:border-red-600 outline-none transition">{{ old('keluhan') }}</textarea>
                    </div>

                    <div class="pt-4 flex gap-4">
                        <a href="{{ route('servis.detail', $service->slug) }}"
                           class="flex-1 text-center bg-zinc-800 hover:bg-zinc-700 text-white font-bold py-4 rounded-xl uppercase text-[10px] tracking-widest transition">
                            Batal
                        </a>
                        <button type="submit"
                                class="flex-[2] bg-red-600 hover:bg-red-700 text-white font-bold py-4 rounded-xl uppercase text-[10px] tracking-widest transition shadow-lg shadow-red-900/40">
                            Ajukan Booking
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
