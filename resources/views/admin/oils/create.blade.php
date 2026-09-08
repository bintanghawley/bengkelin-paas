<div id="modal-oil" class="fixed inset-0 z-50 items-center justify-center p-4 bg-black/60 backdrop-blur-sm hidden transition-all duration-300">
    <div class="bg-white dark:bg-zinc-900 border border-gray-200 dark:border-zinc-800 rounded-[2rem] w-full max-w-2xl overflow-hidden shadow-2xl animate-fade-in">
        
        <div class="flex justify-between items-center bg-gray-50 dark:bg-zinc-950 px-8 py-5 border-b border-gray-100 dark:border-zinc-850">
            <h3 class="font-bengkel text-lg text-blue-600 uppercase tracking-wider">Tambah Oli Motor</h3>
            <button onclick="toggleModalOil(false)" class="text-gray-400 hover:text-gray-900 dark:hover:text-white transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12" stroke-width="2" stroke-linecap="round"/></svg>
            </button>
        </div>

        <form action="/admin/oils" method="POST" enctype="multipart/form-data" class="p-8 space-y-6 max-h-[70vh] overflow-y-auto text-xs uppercase tracking-wider font-bold">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Nama Oli --}}
                <div class="space-y-2">
                    <label for="oil-nama" class="text-[10px] text-gray-400 dark:text-zinc-500">Nama Oli Motor</label>
                    <input type="text" name="nama" id="oil-nama" required class="w-full px-4 py-3 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-xl text-gray-900 dark:text-white focus:outline-none focus:ring-1 focus:ring-blue-600 transition">
                </div>

                {{-- Merek --}}
                <div class="space-y-2">
                    <label for="oil-merek" class="text-[10px] text-gray-400 dark:text-zinc-500">Merek</label>
                    <input type="text" name="merek" id="oil-merek" placeholder="Yamalube, MPX, Motul, Shell, dll" required class="w-full px-4 py-3 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-xl text-gray-900 dark:text-white focus:outline-none focus:ring-1 focus:ring-blue-600 transition">
                </div>

                {{-- Harga --}}
                <div class="space-y-2">
                    <label for="oil-harga" class="text-[10px] text-gray-400 dark:text-zinc-500">Harga (Rp)</label>
                    <input type="number" name="harga" id="oil-harga" min="0" required class="w-full px-4 py-3 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-xl text-gray-900 dark:text-white focus:outline-none focus:ring-1 focus:ring-blue-600 transition">
                </div>

                {{-- Stok --}}
                <div class="space-y-2">
                    <label for="oil-stok" class="text-[10px] text-gray-400 dark:text-zinc-500">Stok</label>
                    <input type="number" name="stok" id="oil-stok" min="0" required class="w-full px-4 py-3 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-xl text-gray-900 dark:text-white focus:outline-none focus:ring-1 focus:ring-blue-600 transition">
                </div>

                {{-- Jenis Oli --}}
                <div class="space-y-2">
                    <label for="oil-jenis_oli" class="text-[10px] text-gray-400 dark:text-zinc-500">Jenis Oli</label>
                    <select name="jenis_oli" id="oil-jenis_oli" required class="w-full px-4 py-3 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-xl text-gray-900 dark:text-white focus:outline-none focus:ring-1 focus:ring-blue-600 transition">
                        <option value="oli motor matic">Oli Motor Matic</option>
                        <option value="oli motor bebek">Oli Motor Bebek</option>
                        <option value="oli motor sport">Oli Motor Sport</option>
                    </select>
                </div>

                {{-- Kekentalan --}}
                <div class="space-y-2">
                    <label for="oil-kekentalan" class="text-[10px] text-gray-400 dark:text-zinc-500">Kekentalan</label>
                    <select name="kekentalan" id="oil-kekentalan" required class="w-full px-4 py-3 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-xl text-gray-900 dark:text-white focus:outline-none focus:ring-1 focus:ring-blue-600 transition">
                        <option value="10W30">10W30</option>
                        <option value="10W40">10W40</option>
                        <option value="20W50">20W50</option>
                    </select>
                </div>

                {{-- Ukuran --}}
                <div class="space-y-2">
                    <label for="oil-ukuran" class="text-[10px] text-gray-400 dark:text-zinc-500">Ukuran / Volume</label>
                    <select name="ukuran" id="oil-ukuran" required class="w-full px-4 py-3 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-xl text-gray-900 dark:text-white focus:outline-none focus:ring-1 focus:ring-blue-600 transition">
                        <option value="1 L">1 L</option>
                        <option value="30ML">30ML</option>
                        <option value="40ML">40ML</option>
                        <option value="120ML">120ML</option>
                        <option value="200 ml">200 ml</option>
                        <option value="200ML">200ML</option>
                        <option value="500ML">500ML</option>
                        <option value="800 mL">800 mL</option>
                        <option value="800 ml">800 ml</option>
                        <option value="900 ml">900 ml</option>
                        <option value="900 mL">900 mL</option>
                    </select>
                </div>

                {{-- Tipe Oli --}}
                <div class="space-y-2">
                    <label for="oil-tipe_oli" class="text-[10px] text-gray-400 dark:text-zinc-500">Tipe Oli</label>
                    <select name="tipe_oli" id="oil-tipe_oli" required class="w-full px-4 py-3 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-xl text-gray-900 dark:text-white focus:outline-none focus:ring-1 focus:ring-blue-600 transition">
                        <option value="Oli Double Ester">Oli Double Ester</option>
                        <option value="Oli Ester">Oli Ester</option>
                        <option value="Oli Gear">Oli Gear</option>
                        <option value="Oli Semi Sintetik">Oli Semi Sintetik</option>
                    </select>
                </div>
            </div>

            {{-- Gambar --}}
            <div class="space-y-2">
                <label for="oil-gambar" class="text-[10px] text-gray-400 dark:text-zinc-500">Gambar Oli</label>
                <input type="file" name="gambar" id="oil-gambar" class="w-full text-zinc-500 border border-gray-200 dark:border-zinc-700 rounded-xl bg-gray-50 dark:bg-zinc-800 px-4 py-3 focus:outline-none">
            </div>

            {{-- Fitur (Kelebihan) --}}
            <div class="space-y-2">
                <label for="oil-fitur" class="text-[10px] text-gray-400 dark:text-zinc-500">Keunggulan &amp; Fitur (pisahkan dengan koma)</label>
                <input type="text" name="fitur" id="oil-fitur" placeholder="Contoh: Menghemat Bensin, Melindungi Mesin, Ester Core Technology" class="w-full px-4 py-3 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-xl text-gray-900 dark:text-white focus:outline-none focus:ring-1 focus:ring-blue-600 transition">
            </div>

            {{-- Deskripsi --}}
            <div class="space-y-2">
                <label for="oil-deskripsi" class="text-[10px] text-gray-400 dark:text-zinc-500">Deskripsi Lengkap</label>
                <textarea name="deskripsi" id="oil-deskripsi" rows="3" class="w-full px-4 py-3 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-xl text-gray-900 dark:text-white focus:outline-none focus:ring-1 focus:ring-blue-600 transition"></textarea>
            </div>

            {{-- Submit --}}
            <div class="flex justify-end gap-3 pt-4 border-t border-gray-100 dark:border-zinc-850">
                <button type="button" onclick="toggleModalOil(false)" class="px-6 py-3 border border-gray-200 dark:border-zinc-700 text-gray-500 dark:text-zinc-450 hover:bg-gray-100 dark:hover:bg-zinc-800 font-bold uppercase tracking-widest text-[9px] rounded-xl transition">Batal</button>
                <button type="submit" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold uppercase tracking-widest text-[9px] rounded-xl transition">Simpan Oli</button>
            </div>
        </form>
    </div>
</div>
