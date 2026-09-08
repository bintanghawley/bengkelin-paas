<div class="grid grid-cols-1 gap-6">
    
    <div class="flex justify-between items-center bg-white dark:bg-zinc-900 p-6 rounded-3xl border border-gray-200 dark:border-zinc-800 shadow-sm">
        <div>
            <h3 class="font-bengkel text-xl text-red-600 uppercase tracking-wider">Kelola Ban Motor</h3>
            <p class="text-[9px] text-gray-400 dark:text-zinc-500 uppercase mt-1">Total: {{ $tires->count() }} Ban terdaftar</p>
        </div>
        <button onclick="toggleModalTire(true)" class="bg-red-600 hover:bg-red-700 text-white text-[10px] font-bold px-6 py-3 rounded-xl uppercase tracking-widest transition flex items-center gap-2">
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 4v16m8-8H4" stroke-width="3" stroke-linecap="round"/></svg>
            Tambah Ban
        </button>
    </div>

    <div class="bg-white dark:bg-zinc-900 p-8 rounded-3xl border border-gray-200 dark:border-zinc-800 shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-[11px] uppercase tracking-tighter">
                <thead class="bg-gray-100 dark:bg-zinc-950 text-gray-500 dark:text-zinc-500 border-b border-gray-200 dark:border-zinc-800">
                    <tr>
                        <th class="px-6 py-4 text-center">Gambar</th>
                        <th class="px-6 py-4">Nama Ban</th>
                        <th class="px-6 py-4">Jenis Ban</th>
                        <th class="px-6 py-4">Merek</th>
                        <th class="px-6 py-4">Spesifikasi</th>
                        <th class="px-6 py-4">Harga</th>
                        <th class="px-6 py-4 text-center">Stok</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-zinc-800/50 text-gray-600 dark:text-zinc-300">
                    @forelse ($tires as $tire)
                    <tr class="hover:bg-gray-50 dark:hover:bg-zinc-800/30 transition-colors">
                        <td class="px-6 py-4 text-center">
                            @if($tire->gambar)
                                <img src="{{ str_starts_with($tire->gambar, 'img/') || str_starts_with($tire->gambar, 'http') ? asset($tire->gambar) : asset('storage/' . $tire->gambar) }}" class="w-10 h-10 object-cover rounded-lg border border-gray-200 dark:border-zinc-700 mx-auto">
                            @else
                                <div class="w-10 h-10 bg-gray-100 dark:bg-zinc-800 rounded-lg border border-gray-200 dark:border-zinc-700 mx-auto flex items-center justify-center text-zinc-400 text-[8px]">KOSONG</div>
                            @endif
                        </td>
                        <td class="px-6 py-4 font-bold text-gray-900 dark:text-white">{{ $tire->nama }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 rounded text-[9px] font-bold bg-blue-500/20 text-blue-600 dark:text-blue-400">
                                {{ $tire->jenis_ban }}
                            </span>
                        </td>
                        <td class="px-6 py-4 font-medium">{{ $tire->merek }}</td>
                        <td class="px-6 py-4 text-zinc-500 text-[10px]">
                            SIZE: {{ $tire->ukuran_ban }} | POS: {{ $tire->posisi_ban }} | DIA: {{ $tire->diameter }} | TYPE: {{ $tire->tipe }}
                        </td>
                        <td class="px-6 py-4 text-emerald-600 dark:text-emerald-500 font-bold">Rp {{ number_format($tire->harga, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 text-center">{{ $tire->stok }}</td>
                        <td class="px-6 py-4 text-right flex justify-end items-center gap-3">
                            <button onclick="openModalEditTire('{{ $tire->id }}', '{{ htmlspecialchars($tire->nama, ENT_QUOTES) }}', '{{ $tire->harga }}', '{{ $tire->stok }}', '{{ htmlspecialchars($tire->jenis_ban, ENT_QUOTES) }}', '{{ htmlspecialchars($tire->merek, ENT_QUOTES) }}', '{{ htmlspecialchars($tire->ukuran_ban, ENT_QUOTES) }}', '{{ htmlspecialchars($tire->posisi_ban, ENT_QUOTES) }}', '{{ htmlspecialchars($tire->material, ENT_QUOTES) }}', '{{ htmlspecialchars($tire->diameter, ENT_QUOTES) }}', '{{ htmlspecialchars($tire->tipe, ENT_QUOTES) }}', '{{ htmlspecialchars($tire->fitur, ENT_QUOTES) }}', '{{ htmlspecialchars($tire->deskripsi, ENT_QUOTES) }}')" class="text-amber-600 dark:text-amber-500 hover:text-gray-900 dark:hover:text-white transition font-bold">
                                Edit
                            </button>
                            
                            <form action="{{ route('admin.tires.destroy', $tire->id) }}" method="POST" onsubmit="return confirm('Hapus ban motor ini?')">
                                @csrf @method('DELETE')
                                <button class="text-red-600 dark:text-red-500 hover:text-gray-900 dark:hover:text-white transition font-bold">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="8" class="px-6 py-10 text-center text-gray-400 dark:text-zinc-600">Belum ada data ban motor.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
