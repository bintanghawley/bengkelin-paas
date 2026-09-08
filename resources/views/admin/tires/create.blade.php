<div id="modal-tire" class="fixed inset-0 z-[99] hidden flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-black/80 backdrop-blur-sm" onclick="toggleModalTire(false)"></div>
    
    <div class="relative bg-zinc-900 w-full max-w-2xl rounded-3xl border border-zinc-800 shadow-2xl overflow-hidden transform transition-all">
        <div class="p-8 max-h-[85vh] overflow-y-auto">
            <div class="flex justify-between items-center mb-6">
                <h3 class="font-bengkel text-xl text-red-600 uppercase tracking-widest">Tambah Ban Motor Baru</h3>
                <button type="button" onclick="toggleModalTire(false)" class="text-zinc-500 hover:text-white transition text-2xl">&times;</button>
            </div>

            <form action="{{ route('admin.tires.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                
                {{-- Nama & Harga --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="text-[10px] uppercase text-zinc-500 font-bold">Nama Ban Motor</label>
                        <input type="text" name="nama" required placeholder="Contoh: Dunlop Tubeless D115 90/90-14" class="w-full bg-zinc-950 border border-zinc-800 rounded-xl px-4 py-3 text-sm text-white focus:border-red-600 outline-none transition">
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] uppercase text-zinc-500 font-bold">Harga Jual (Rp)</label>
                        <input type="number" name="harga" required placeholder="Contoh: 342000" class="w-full bg-zinc-950 border border-zinc-800 rounded-xl px-4 py-3 text-sm text-white focus:border-red-600 outline-none transition">
                    </div>
                </div>

                {{-- Stok & Jenis Ban --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="text-[10px] uppercase text-zinc-500 font-bold">Stok</label>
                        <input type="number" name="stok" required placeholder="Contoh: 15" class="w-full bg-zinc-950 border border-zinc-800 rounded-xl px-4 py-3 text-sm text-white focus:border-red-600 outline-none transition">
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] uppercase text-zinc-500 font-bold">Jenis Ban</label>
                        <select name="jenis_ban" required class="w-full bg-zinc-950 border border-zinc-800 rounded-xl px-4 py-3 text-sm text-white focus:border-red-600 outline-none transition">
                            <option value="ban motor matic">Ban Motor Matic</option>
                            <option value="ban motor bebek">Ban Motor Bebek</option>
                            <option value="ban motor sport">Ban Motor Sport</option>
                            <option value="ban motor big matic">Ban Motor Big Matic</option>
                        </select>
                    </div>
                </div>

                {{-- Merek & Ukuran --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="text-[10px] uppercase text-zinc-500 font-bold">Merek</label>
                        <select name="merek" required class="w-full bg-zinc-950 border border-zinc-800 rounded-xl px-4 py-3 text-sm text-white focus:border-red-600 outline-none transition">
                            @foreach(['aspira', 'planeto', 'Michelin', 'irc', 'Pirelli', 'ecostreet', 'presa', 'swallow', 'Dunlop', 'kenda', 'fdr'] as $mrk)
                                <option value="{{ $mrk }}">{{ ucfirst($mrk) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] uppercase text-zinc-500 font-bold">Ukuran Ban</label>
                        <select name="ukuran_ban" required class="w-full bg-zinc-950 border border-zinc-800 rounded-xl px-4 py-3 text-sm text-white focus:border-red-600 outline-none transition">
                            @foreach(['70/90', '80/80', '80/90', '90/80', '90/90', '100/80', '100/90', '110/70', '110/80', '110/90', '120/70', '120/80', '130/70', '130/80', '140/70', '150/60', '150/70', '160/60'] as $sz)
                                <option value="{{ $sz }}">{{ $sz }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Posisi & Material --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="text-[10px] uppercase text-zinc-500 font-bold">Posisi Ban</label>
                        <select name="posisi_ban" required class="w-full bg-zinc-950 border border-zinc-800 rounded-xl px-4 py-3 text-sm text-white focus:border-red-600 outline-none transition">
                            <option value="belakang">Belakang</option>
                            <option value="depan">Depan</option>
                            <option value="depan/belakang">Depan/Belakang</option>
                        </select>
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] uppercase text-zinc-500 font-bold">Material</label>
                        <input type="text" name="material" value="medium compound" required class="w-full bg-zinc-950 border border-zinc-800 rounded-xl px-4 py-3 text-sm text-white focus:border-red-600 outline-none transition">
                    </div>
                </div>

                {{-- Diameter & Tipe --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="text-[10px] uppercase text-zinc-500 font-bold">Diameter</label>
                        <select name="diameter" required class="w-full bg-zinc-950 border border-zinc-800 rounded-xl px-4 py-3 text-sm text-white focus:border-red-600 outline-none transition">
                            <option value="Ring 10">Ring 10</option>
                            <option value="Ring 11">Ring 11</option>
                            <option value="Ring 12">Ring 12</option>
                            <option value="Ring 13">Ring 13</option>
                            <option value="Ring 14">Ring 14</option>
                            <option value="Ring 17">Ring 17</option>
                        </select>
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] uppercase text-zinc-500 font-bold">Tipe Ban</label>
                        <select name="tipe" required class="w-full bg-zinc-950 border border-zinc-800 rounded-xl px-4 py-3 text-sm text-white focus:border-red-600 outline-none transition">
                            <option value="tubeless">Tubeless</option>
                            <option value="tubetype">Tubetype</option>
                        </select>
                    </div>
                </div>

                {{-- Fitur Produk --}}
                <div class="space-y-1">
                    <label class="text-[10px] uppercase text-zinc-500 font-bold">Fitur Produk (Pisahkan dengan koma)</label>
                    <input type="text" name="fitur" placeholder="Contoh: Desain Pattern Modern, Kompon Karet Berkualitas Tinggi" class="w-full bg-zinc-950 border border-zinc-800 rounded-xl px-4 py-3 text-sm text-white focus:border-red-600 outline-none transition">
                </div>

                {{-- Deskripsi --}}
                <div class="space-y-1">
                    <label class="text-[10px] uppercase text-zinc-500 font-bold">Deskripsi Ban Motor</label>
                    <textarea name="deskripsi" rows="2" placeholder="Deskripsi singkat ban..." class="w-full bg-zinc-950 border border-zinc-800 rounded-xl px-4 py-3 text-sm text-white focus:border-red-600 outline-none transition"></textarea>
                </div>

                {{-- Gambar --}}
                <div class="space-y-1">
                    <label class="text-[10px] uppercase text-zinc-500 font-bold">Foto Ban</label>
                    <input type="file" name="gambar" class="w-full bg-zinc-950 border border-zinc-800 rounded-xl px-4 py-3 text-xs text-zinc-400 file:bg-red-600 file:border-0 file:text-white file:rounded-lg file:px-3 file:mr-3">
                </div>

                {{-- Buttons --}}
                <div class="pt-4 flex gap-3">
                    <button type="button" onclick="toggleModalTire(false)" class="flex-1 bg-zinc-800 hover:bg-zinc-700 text-white font-bold py-3 rounded-xl uppercase text-[10px] transition">Batal</button>
                    <button type="submit" class="flex-[2] bg-red-600 hover:bg-red-700 text-white font-bold py-3 rounded-xl uppercase text-[10px] tracking-widest transition shadow-lg shadow-red-900/40">Simpan Sekarang</button>
                </div>
            </form>
        </div>
    </div>
</div>
