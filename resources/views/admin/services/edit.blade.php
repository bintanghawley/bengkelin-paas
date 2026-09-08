<div id="modal-edit-service" class="fixed inset-0 z-[99] hidden flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-black/80 backdrop-blur-sm" onclick="toggleModalEditService(false)"></div>
    <div class="relative bg-zinc-900 w-full max-w-2xl rounded-3xl border border-zinc-800 shadow-2xl overflow-hidden transform transition-all max-h-[90vh] overflow-y-auto custom-scrollbar">
        <div class="p-8">
            <div class="flex justify-between items-center mb-6">
                <h3 class="font-bengkel text-xl text-yellow-500 uppercase tracking-widest">Edit Layanan Servis</h3>
                <button type="button" onclick="toggleModalEditService(false)" class="text-zinc-500 hover:text-white transition text-2xl">&times;</button>
            </div>
            <form id="form-edit-service" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="text-[10px] uppercase text-zinc-500 font-bold">Nama Servis</label>
                        <input type="text" id="e_serv_nama" name="nama" required class="w-full bg-zinc-950 border border-zinc-800 rounded-xl px-4 py-3 text-sm text-white focus:border-yellow-500 outline-none transition">
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] uppercase text-zinc-500 font-bold">Harga Mulai (Rp)</label>
                        <input type="number" id="e_serv_harga" name="harga_mulai" required class="w-full bg-zinc-950 border border-zinc-800 rounded-xl px-4 py-3 text-sm text-white focus:border-yellow-500 outline-none transition">
                    </div>
                </div>
                <div class="space-y-1">
                    <label class="text-[10px] uppercase text-zinc-500 font-bold">Estimasi Waktu</label>
                    <input type="text" id="e_serv_waktu" name="estimasi_waktu" required class="w-full bg-zinc-950 border border-zinc-800 rounded-xl px-4 py-3 text-sm text-white focus:border-yellow-500 outline-none transition">
                </div>
                <div class="space-y-1">
                    <label class="text-[10px] uppercase text-zinc-500 font-bold">Deskripsi Singkat</label>
                    <textarea id="e_serv_desc" name="deskripsi" rows="3" required class="w-full bg-zinc-950 border border-zinc-800 rounded-xl px-4 py-3 text-sm text-white focus:border-yellow-500 outline-none transition"></textarea>
                </div>
                <div class="space-y-1">
                    <label class="text-[10px] uppercase text-zinc-500 font-bold">Gambar (Biarkan jika tidak diganti)</label>
                    <input type="file" name="gambar" accept="image/*" class="w-full bg-zinc-950 border border-zinc-800 rounded-xl px-4 py-3 text-xs text-zinc-400 file:bg-yellow-500 file:border-0 file:text-black file:rounded-lg file:px-3 file:mr-3">
                </div>
                
                <hr class="border-zinc-800 my-4">
                <h4 class="text-sm font-bold text-white uppercase">Daftar Pekerjaan (Checklist)</h4>
                <div id="e-service-items-container" class="space-y-3">
                    <!-- JS WILL INJECT HERE -->
                </div>
                <button type="button" onclick="addServiceItemRow('e-service-items-container', '', true)" class="text-xs text-yellow-500 hover:text-yellow-400 font-bold">+ Tambah Pekerjaan Lain</button>

                <div class="pt-4 flex gap-3">
                    <button type="button" onclick="toggleModalEditService(false)" class="flex-1 bg-zinc-800 hover:bg-zinc-700 text-white font-bold py-3 rounded-xl uppercase text-[10px] transition">Batal</button>
                    <button type="submit" class="flex-[2] bg-yellow-500 hover:bg-yellow-600 text-black font-bold py-3 rounded-xl uppercase text-[10px] tracking-widest transition shadow-lg">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
