@extends('layouts.guest')

@section('content')
<div class="flex min-h-screen bg-zinc-950 text-white">
    @include('mekanik.partials.sidebar')
    <main class="flex-1 ml-64 p-6 lg:p-10">
    <div class="max-w-6xl mx-auto">
        <div class="flex items-center justify-between mb-8">
            <div>
                <a href="{{ route('mekanik.dashboard') }}" class="text-xs text-red-500 font-bold uppercase tracking-widest">← Dashboard</a>
                <h1 class="text-4xl font-bengkel tracking-wider mt-2">PERMINTAAN <span class="text-red-600">BANTUAN</span></h1>
            </div>
        </div>

        <div class="grid lg:grid-cols-2 gap-8">
            <section class="space-y-4">
                <h2 class="text-sm font-bold uppercase tracking-widest text-zinc-400">Permintaan Masuk</h2>
                @forelse($incoming as $item)
                    <a href="{{ route('mekanik.assistance-requests.show', $item) }}" class="block bg-zinc-900 border {{ $item->status === 'pending' ? 'border-red-700' : 'border-zinc-800' }} rounded-2xl p-5 hover:border-red-500 transition">
                        <div class="flex justify-between gap-4">
                            <div>
                                <p class="text-xs text-zinc-500 uppercase">Dari {{ $item->requesterMechanic->name }}</p>
                                <h3 class="font-bold mt-1">{{ $item->needed_item }}</h3>
                                <p class="text-xs text-zinc-400 mt-2">Darurat #{{ $item->emergency_report_id }} · {{ $item->location_detail }}</p>
                            </div>
                            <div class="shrink-0 text-right">
                                <span class="block text-[10px] font-bold uppercase text-{{ $item::statusColor($item->status) }}-400">{{ $item::statusLabel($item->status) }}</span>
                                <span class="inline-block mt-4 bg-red-600 hover:bg-red-500 text-white text-[10px] font-bold uppercase tracking-widest px-4 py-2 rounded-xl">Buka Permintaan</span>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="bg-zinc-900 border border-zinc-800 rounded-2xl p-8 text-center space-y-4">
                        <p class="text-zinc-500 text-sm">Belum ada permintaan masuk. Permintaan akan muncul setelah teknisi utama memilih akunmu sebagai teknisi bantuan.</p>
                        <a href="{{ route('mekanik.emergency.index') }}" class="inline-block bg-zinc-800 hover:bg-zinc-700 text-zinc-200 text-[10px] font-bold uppercase tracking-widest px-4 py-2.5 rounded-xl transition">Lihat Darurat Masuk</a>
                    </div>
                @endforelse
            </section>

            <section class="space-y-4">
                <h2 class="text-sm font-bold uppercase tracking-widest text-zinc-400">Permintaan Terkirim</h2>
                @forelse($outgoing as $item)
                    <a href="{{ route('mekanik.assistance-requests.show', $item) }}" class="block bg-zinc-900 border border-zinc-800 rounded-2xl p-5 hover:border-red-500 transition">
                        <div class="flex justify-between gap-4">
                            <div>
                                <p class="text-xs text-zinc-500 uppercase">Kepada {{ $item->targetMechanic->name }}</p>
                                <h3 class="font-bold mt-1">{{ $item->needed_item }}</h3>
                                <p class="text-xs text-zinc-400 mt-2">Darurat #{{ $item->emergency_report_id }} · {{ $item->location_detail }}</p>
                            </div>
                            <div class="shrink-0 text-right">
                                <span class="block text-[10px] font-bold uppercase text-{{ $item::statusColor($item->status) }}-400">{{ $item::statusLabel($item->status) }}</span>
                                <span class="inline-block mt-4 bg-zinc-800 hover:bg-zinc-700 text-white text-[10px] font-bold uppercase tracking-widest px-4 py-2 rounded-xl">Lihat Detail</span>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="bg-zinc-900 border border-zinc-800 rounded-2xl p-8 text-center text-zinc-500 text-sm">Belum ada permintaan terkirim. Permintaan bantuan hanya dapat dibuat dari laporan darurat yang sedang ditangani.</div>
                @endforelse
            </section>
        </div>
    </div>
    </main>
</div>
@endsection
