<div class="flex items-center justify-between mb-4">
    <h3 class="text-lg font-bengkel uppercase tracking-widest text-gray-900 dark:text-white">Kelola Layanan Servis</h3>
    <button onclick="toggleModalService(true)" class="bg-red-600 hover:bg-red-700 text-white text-xs font-bold py-2 px-4 rounded-lg uppercase tracking-widest">Tambah Layanan</button>
</div>
<div class="bg-white dark:bg-zinc-900 rounded-3xl border border-gray-200 dark:border-zinc-800 overflow-hidden shadow-sm">
    <table class="w-full text-left text-sm">
        <thead class="bg-gray-100 dark:bg-zinc-800 text-gray-500 dark:text-zinc-400 uppercase text-[10px] tracking-widest border-b border-gray-200 dark:border-zinc-700">
            <tr>
                <th class="px-6 py-4">No</th>
                <th class="px-6 py-4">Nama Servis</th>
                <th class="px-6 py-4">Harga Mulai</th>
                <th class="px-6 py-4">Estimasi</th>
                <th class="px-6 py-4">Jml Pekerjaan</th>
                <th class="px-6 py-4 text-right">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 dark:divide-zinc-800">
            @forelse($services as $service)
            <tr class="hover:bg-gray-50 dark:hover:bg-zinc-800/30 transition text-gray-700 dark:text-zinc-300">
                <td class="px-6 py-4">{{ $loop->iteration }}</td>
                <td class="px-6 py-4 font-bold text-gray-900 dark:text-white">{{ strtoupper($service->nama) }}</td>
                <td class="px-6 py-4 text-emerald-600 dark:text-emerald-500 font-bold">Rp {{ number_format($service->harga_mulai, 0, ',', '.') }}</td>
                <td class="px-6 py-4 text-gray-500 dark:text-zinc-400">{{ $service->estimasi_waktu }}</td>
                <td class="px-6 py-4 text-gray-500 dark:text-zinc-400">{{ $service->items_count }} Item</td>
                <td class="px-6 py-4 text-right">
                    <button type="button" onclick="openModalDetailService('{{ htmlspecialchars($service->nama, ENT_QUOTES) }}', '{{ htmlspecialchars($service->deskripsi, ENT_QUOTES) }}', 'Rp {{ number_format($service->harga_mulai, 0, ',', '.') }}', '{{ htmlspecialchars($service->estimasi_waktu, ENT_QUOTES) }}', '{{ $service->gambar ? $service->gambar_url : '' }}', {{ json_encode($service->items->pluck('nama_pekerjaan')->toArray()) }})" class="text-blue-600 dark:text-blue-400 hover:text-blue-500 dark:hover:text-blue-300 text-[10px] font-bold uppercase tracking-tighter mr-3">Detail</button>
                    <button onclick="openModalEditService('{{ $service->id }}', '{{ htmlspecialchars($service->nama, ENT_QUOTES) }}', '{{ htmlspecialchars($service->deskripsi, ENT_QUOTES) }}', '{{ $service->harga_mulai }}', '{{ htmlspecialchars($service->estimasi_waktu, ENT_QUOTES) }}', {{ json_encode($service->items->pluck('nama_pekerjaan')->toArray()) }})" class="text-yellow-600 dark:text-yellow-400 hover:text-yellow-500 dark:hover:text-yellow-300 text-[10px] font-bold uppercase tracking-tighter mr-3">Edit</button>
                    <form action="{{ route('admin.services.destroy', $service->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus servis ini?')">
                        @csrf
                        @method('DELETE')
                        <button class="text-red-600 dark:text-red-500 hover:text-red-500 dark:hover:text-red-400 font-bold uppercase text-[10px] tracking-tighter">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-6 py-6 text-center text-gray-400 dark:text-zinc-400">Data servis belum ada</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
