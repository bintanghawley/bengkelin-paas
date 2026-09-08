@extends('layouts.guest')

@section('content')
<div class="flex min-h-screen font-sans bg-zinc-950 text-white">
    
    <!-- Sidebar Admin -->
    @include('admin.partials.sidebar')

    <!-- Main Content -->
    <main class="flex-1 ml-64 p-10 min-h-screen text-zinc-200">
        {{-- Header / Navbar --}}
        <header class="flex justify-between items-center mb-10">
            <div>
                <h2 class="text-4xl font-bengkel tracking-wider text-zinc-800 dark:text-white">ADMIN <span class="text-red-600">DASHBOARD</span></h2>
                <p class="text-zinc-500 text-xs uppercase tracking-[0.2em] mt-1 italic">Sidoarjo High Performance Garage</p>
            </div>
            <div class="flex items-center gap-4 bg-gray-50 dark:bg-zinc-900 border border-gray-200 dark:border-zinc-800 p-2 pr-6 rounded-full shadow-lg">
                <div class="h-10 w-10 bg-red-650 rounded-full flex items-center justify-center font-bold text-white shadow-lg uppercase">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div class="flex flex-col text-left">
                    <span class="text-zinc-800 dark:text-white text-sm font-bold leading-none">{{ Auth::user()->name }}</span>
                    <span class="text-zinc-500 text-[10px] uppercase mt-1 tracking-widest">Admin Bengkelin</span>
                </div>
            </div>
        </header>

        <div class="mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h1 class="text-2xl font-bengkel uppercase tracking-widest text-white">Kelola Pembayaran</h1>
                <p class="text-zinc-550 text-xs mt-1 uppercase tracking-widest">Total: {{ $payments->total() }} transaksi tercatat</p>
            </div>
        </div>



        {{-- Table Container --}}
        <div class="bg-zinc-900 border border-zinc-800 rounded-3xl overflow-hidden shadow-xl">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs border-collapse">
                    <thead>
                        <tr class="border-b border-zinc-800 bg-zinc-950/50 text-zinc-400 font-bold uppercase tracking-wider">
                            <th class="px-6 py-4">Invoice</th>
                            <th class="px-6 py-4">Pelanggan</th>
                            <th class="px-6 py-4">Metode</th>
                            <th class="px-6 py-4">Nominal</th>
                            <th class="px-6 py-4 text-center">Status</th>
                            <th class="px-6 py-4">Tgl Dibuat</th>
                            <th class="px-6 py-4">Tgl Dibayar</th>
                            <th class="px-6 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-850">
                        @forelse($payments as $payment)
                            <tr class="hover:bg-zinc-850/35 transition">
                                <td class="px-6 py-4 font-mono font-bold text-white uppercase tracking-wider">
                                    #{{ $payment->invoice_number }}
                                </td>
                                <td class="px-6 py-4">
                                    @if($payment->purchases->first() && $payment->purchases->first()->user)
                                        <span class="block font-bold text-white">{{ $payment->purchases->first()->user->name }}</span>
                                        <span class="text-[10px] text-zinc-500">{{ $payment->purchases->first()->user->email }}</span>
                                    @else
                                        <span class="text-zinc-500">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 uppercase font-bold text-zinc-300">
                                    {{ $payment->payment_method ?: 'Belum Memilih' }}
                                </td>
                                <td class="px-6 py-4 font-bold text-white">
                                    Rp {{ number_format($payment->amount, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @php
                                        $badgeColor = match($payment->status) {
                                            'pending' => 'bg-orange-950/40 text-orange-400 border-orange-900/60',
                                            'paid' => 'bg-emerald-950/40 text-emerald-400 border-emerald-900/60',
                                            'expired' => 'bg-zinc-950/40 text-zinc-500 border-zinc-800',
                                            'failed' => 'bg-red-950/40 text-red-400 border-red-900/60',
                                            default => 'bg-zinc-850 text-zinc-400 border-zinc-800',
                                        };
                                    @endphp
                                    <span class="px-2.5 py-0.5 rounded-full text-[9px] font-bold border uppercase tracking-wider {{ $badgeColor }}">
                                        {{ $payment->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-zinc-400">
                                    {{ $payment->created_at->format('d M Y, H:i') }}
                                </td>
                                <td class="px-6 py-4 text-zinc-400">
                                    {{ $payment->paid_at ? $payment->paid_at->format('d M Y, H:i') : '-' }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <a href="{{ route('admin.payments.show', $payment->id) }}" class="inline-block px-3 py-1.5 bg-zinc-800 hover:bg-zinc-750 border border-zinc-700 text-zinc-200 hover:text-white rounded-lg font-bold transition">
                                        Detail →
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-12 text-center text-zinc-500 uppercase tracking-widest">
                                    Tidak ada data pembayaran.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($payments->hasPages())
                <div class="px-6 py-4 bg-zinc-950/30 border-t border-zinc-800">
                    {{ $payments->links() }}
                </div>
            @endif
    </main>
</div>
@endsection
