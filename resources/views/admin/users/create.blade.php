<div id="modal-user" class="fixed inset-0 z-[99] hidden flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-black/80 backdrop-blur-sm" onclick="toggleModalUser(false)"></div>
    <div class="relative bg-zinc-900 w-full max-w-lg rounded-3xl border border-zinc-800 shadow-2xl overflow-hidden transform transition-all">
        <div class="p-8">
            <div class="flex justify-between items-center mb-6">
                <h3 class="font-bengkel text-xl text-red-600 uppercase tracking-widest">Tambah User Baru</h3>
                <button type="button" onclick="toggleModalUser(false)" class="text-zinc-500 hover:text-white transition text-2xl">&times;</button>
            </div>
            <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-4">
                @csrf
                <div class="space-y-1">
                    <label class="text-[10px] uppercase text-zinc-500 font-bold">Nama</label>
                    <input type="text" name="name" required class="w-full bg-zinc-950 border border-zinc-800 rounded-xl px-4 py-3 text-sm text-white focus:border-red-600 outline-none transition">
                </div>
                <div class="space-y-1">
                    <label class="text-[10px] uppercase text-zinc-500 font-bold">Nomor Telepon</label>
                    <input type="text" name="nomor_telepon" required placeholder="08xxxxxxxxx" class="w-full bg-zinc-950 border border-zinc-800 rounded-xl px-4 py-3 text-sm text-white focus:border-red-600 outline-none transition">
                </div>
                <div class="space-y-1">
                    <label class="text-[10px] uppercase text-zinc-500 font-bold">Password</label>
                    <input type="password" name="password" required class="w-full bg-zinc-950 border border-zinc-800 rounded-xl px-4 py-3 text-sm text-white focus:border-red-600 outline-none transition">
                </div>
                <div class="space-y-1">
                    <label class="text-[10px] uppercase text-zinc-500 font-bold">Role</label>
                    <select name="role" required class="w-full bg-zinc-950 border border-zinc-800 rounded-xl px-4 py-3 text-sm text-white focus:border-red-600 outline-none transition">
                        <option value="">Pilih Role</option>
                        <option value="admin">Admin</option>
                        <option value="mekanik">Mekanik</option>
                        <option value="pengguna">Pengguna</option>
                    </select>
                </div>
                <div class="pt-4 flex gap-3">
                    <button type="button" onclick="toggleModalUser(false)" class="flex-1 bg-zinc-800 hover:bg-zinc-700 text-white font-bold py-3 rounded-xl uppercase text-[10px] transition">Batal</button>
                    <button type="submit" class="flex-[2] bg-red-600 hover:bg-red-700 text-white font-bold py-3 rounded-xl uppercase text-[10px] tracking-widest transition shadow-lg shadow-red-900/40">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
