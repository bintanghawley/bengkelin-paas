<div id="modal-edit-sparepart" class="fixed inset-0 z-50 items-center justify-center p-4 bg-black/60 backdrop-blur-sm hidden transition-all duration-300">
    <div class="bg-white dark:bg-zinc-900 border border-gray-200 dark:border-zinc-800 rounded-[2rem] w-full max-w-2xl overflow-hidden shadow-2xl animate-fade-in">
        
        <div class="flex justify-between items-center bg-gray-50 dark:bg-zinc-950 px-8 py-5 border-b border-gray-100 dark:border-zinc-850">
            <h3 class="font-bengkel text-lg text-blue-600 uppercase tracking-wider">Edit Sparepart Motor</h3>
            <button onclick="toggleModalEditSparepart(false)" class="text-gray-400 hover:text-gray-900 dark:hover:text-white transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12" stroke-width="2" stroke-linecap="round"/></svg>
            </button>
        </div>

        <form id="form-edit-sparepart" method="POST" enctype="multipart/form-data" class="p-8 space-y-6 max-h-[70vh] overflow-y-auto text-xs uppercase tracking-wider font-bold">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Nama --}}
                <div class="space-y-2">
                    <label for="edit-sp-nama" class="text-[10px] text-gray-400 dark:text-zinc-500">Nama Sparepart</label>
                    <input type="text" name="nama" id="edit-sp-nama" required class="w-full px-4 py-3 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-xl text-gray-900 dark:text-white focus:outline-none focus:ring-1 focus:ring-blue-600 transition">
                </div>

                {{-- Merek --}}
                <div class="space-y-2">
                    <label for="edit-sp-merek" class="text-[10px] text-gray-400 dark:text-zinc-500">Merek</label>
                    <select name="merek" id="edit-sp-merek" required class="w-full px-4 py-3 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-xl text-gray-900 dark:text-white focus:outline-none focus:ring-1 focus:ring-blue-600 transition">
                        <option value="X-Grade">X-Grade</option>
                        <option value="X-Ten">X-Ten</option>
                        <option value="MK">MK</option>
                        <option value="Denso">Denso</option>
                        <option value="Jossz">Jossz</option>
                        <option value="X-Guard">X-Guard</option>
                        <option value="X-Smart">X-Smart</option>
                    </select>
                </div>

                {{-- Harga --}}
                <div class="space-y-2">
                    <label for="edit-sp-harga" class="text-[10px] text-gray-400 dark:text-zinc-500">Harga (Rp)</label>
                    <input type="number" name="harga" id="edit-sp-harga" min="0" required class="w-full px-4 py-3 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-xl text-gray-900 dark:text-white focus:outline-none focus:ring-1 focus:ring-blue-600 transition">
                </div>

                {{-- Stok --}}
                <div class="space-y-2">
                    <label for="edit-sp-stok" class="text-[10px] text-gray-400 dark:text-zinc-500">Stok</label>
                    <input type="number" name="stok" id="edit-sp-stok" min="0" required class="w-full px-4 py-3 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-xl text-gray-900 dark:text-white focus:outline-none focus:ring-1 focus:ring-blue-600 transition">
                </div>

                {{-- Jenis Sparepart --}}
                <div class="space-y-2">
                    <label for="edit-sp-jenis_sparepart" class="text-[10px] text-gray-400 dark:text-zinc-500">Jenis Sparepart</label>
                    <select name="jenis_sparepart" id="edit-sp-jenis_sparepart" required class="w-full px-4 py-3 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-xl text-gray-900 dark:text-white focus:outline-none focus:ring-1 focus:ring-blue-600 transition">
                        <option value="aki motor">Aki Motor</option>
                        <option value="filter udara motor">Filter Udara Motor</option>
                        <option value="kampas rem">Kampas Rem</option>
                        <option value="cairan anti bocor">Cairan Anti Bocor</option>
                    </select>
                </div>
            </div>

            {{-- Gambar --}}
            <div class="space-y-2">
                <label class="text-[10px] text-gray-400 dark:text-zinc-500 block">Gambar Sparepart (Biarkan kosong jika tidak diganti)</label>
                <input type="file" name="gambar" class="w-full text-zinc-500 border border-gray-200 dark:border-zinc-700 rounded-xl bg-gray-50 dark:bg-zinc-800 px-4 py-3 focus:outline-none">
            </div>

            {{-- Fitur --}}
            <div class="space-y-2">
                <label for="edit-sp-fitur" class="text-[10px] text-gray-400 dark:text-zinc-500">Keunggulan &amp; Fitur (pisahkan dengan koma)</label>
                <input type="text" name="fitur" id="edit-sp-fitur" class="w-full px-4 py-3 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-xl text-gray-900 dark:text-white focus:outline-none focus:ring-1 focus:ring-blue-600 transition">
            </div>

            {{-- Deskripsi --}}
            <div class="space-y-2">
                <label for="edit-sp-deskripsi" class="text-[10px] text-gray-400 dark:text-zinc-500">Deskripsi Lengkap</label>
                <textarea name="deskripsi" id="edit-sp-deskripsi" rows="3" class="w-full px-4 py-3 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-xl text-gray-900 dark:text-white focus:outline-none focus:ring-1 focus:ring-blue-600 transition"></textarea>
            </div>

            {{-- Submit --}}
            <div class="flex justify-end gap-3 pt-4 border-t border-gray-100 dark:border-zinc-850">
                <button type="button" onclick="toggleModalEditSparepart(false)" class="px-6 py-3 border border-gray-200 dark:border-zinc-700 text-gray-500 dark:text-zinc-450 hover:bg-gray-100 dark:hover:bg-zinc-800 font-bold uppercase tracking-widest text-[9px] rounded-xl transition">Batal</button>
                <button type="submit" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold uppercase tracking-widest text-[9px] rounded-xl transition">Perbarui Sparepart</button>
            </div>
        </form>
    </div>
</div>
