<div id="modal-service" class="fixed inset-0 z-[99] hidden flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-black/80 backdrop-blur-sm" onclick="toggleModalService(false)"></div>
    <div class="relative bg-zinc-900 w-full max-w-2xl rounded-3xl border border-zinc-800 shadow-2xl overflow-hidden transform transition-all max-h-[90vh] overflow-y-auto custom-scrollbar">
        <div class="p-8">
            <div class="flex justify-between items-center mb-6">
                <h3 class="font-bengkel text-xl text-red-600 uppercase tracking-widest">Tambah Layanan Servis</h3>
                <button type="button" onclick="toggleModalService(false)" class="text-zinc-500 hover:text-white transition text-2xl">&times;</button>
            </div>
            <form action="{{ route('admin.services.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="text-[10px] uppercase text-zinc-500 font-bold">Nama Servis</label>
                        <input type="text" name="nama" required class="w-full bg-zinc-950 border border-zinc-800 rounded-xl px-4 py-3 text-sm text-white focus:border-red-600 outline-none transition">
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] uppercase text-zinc-500 font-bold">Harga Mulai (Rp)</label>
                        <input type="number" name="harga_mulai" required class="w-full bg-zinc-950 border border-zinc-800 rounded-xl px-4 py-3 text-sm text-white focus:border-red-600 outline-none transition">
                    </div>
                </div>
                <div class="space-y-1">
                    <label class="text-[10px] uppercase text-zinc-500 font-bold">Estimasi Waktu</label>
                    <input type="text" name="estimasi_waktu" placeholder="Misal: 30-60 Menit" required class="w-full bg-zinc-950 border border-zinc-800 rounded-xl px-4 py-3 text-sm text-white focus:border-red-600 outline-none transition">
                </div>
                <div class="space-y-1">
                    <label class="text-[10px] uppercase text-zinc-500 font-bold">Deskripsi Singkat</label>
                    <textarea name="deskripsi" rows="3" required class="w-full bg-zinc-950 border border-zinc-800 rounded-xl px-4 py-3 text-sm text-white focus:border-red-600 outline-none transition"></textarea>
                </div>
                <div class="space-y-1">
                    <label class="text-[10px] uppercase text-zinc-500 font-bold">Gambar Layanan (Opsional)</label>
                    <input type="file" name="gambar" accept="image/*" class="w-full bg-zinc-950 border border-zinc-800 rounded-xl px-4 py-3 text-xs text-zinc-400 file:bg-red-600 file:border-0 file:text-white file:rounded-lg file:px-3 file:mr-3">
                </div>
                
                <hr class="border-zinc-800 my-4">
                <h4 class="text-sm font-bold text-white uppercase">Daftar Pekerjaan (Checklist)</h4>
                <div id="service-items-container" class="space-y-3">
                    <div class="flex items-center gap-2">
                        <input type="text" name="items[]" placeholder="Misal: Ganti Oli" required class="w-full bg-zinc-950 border border-zinc-800 rounded-xl px-4 py-3 text-sm text-white focus:border-red-600 outline-none transition">
                        <button type="button" onclick="this.parentElement.remove()" class="text-zinc-500 hover:text-red-500 px-3 py-3 border border-zinc-800 rounded-xl bg-zinc-950">X</button>
                    </div>
                </div>
                <button type="button" onclick="addServiceItemRow('service-items-container')" class="text-xs text-red-500 hover:text-red-400 font-bold">+ Tambah Pekerjaan Lain</button>

                <div class="pt-4 flex gap-3">
                    <button type="button" onclick="toggleModalService(false)" class="flex-1 bg-zinc-800 hover:bg-zinc-700 text-white font-bold py-3 rounded-xl uppercase text-[10px] transition">Batal</button>
                    <button type="submit" class="flex-[2] bg-red-600 hover:bg-red-700 text-white font-bold py-3 rounded-xl uppercase text-[10px] tracking-widest transition shadow-lg shadow-red-900/40">Simpan Layanan</button>
                </div>
            </form>
        </div>
    </div>
</div>
