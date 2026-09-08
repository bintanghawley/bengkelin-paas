<div id="modal-edit-user" class="fixed inset-0 z-[99] hidden flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-black/80 backdrop-blur-sm" onclick="toggleModalEditUser(false)"></div>
    <div class="relative bg-zinc-900 w-full max-w-lg rounded-3xl border border-zinc-800 shadow-2xl overflow-hidden transform transition-all">
        <div class="p-8">
            <div class="flex justify-between items-center mb-6">
                <h3 class="font-bengkel text-xl text-yellow-500 uppercase tracking-widest">Edit Data User</h3>
                <button type="button" onclick="toggleModalEditUser(false)" class="text-zinc-500 hover:text-white transition text-2xl">&times;</button>
            </div>
            <form id="form-edit-user" method="POST" class="space-y-4">
                @csrf @method('PUT')
                <div class="space-y-1">
                    <label class="text-[10px] uppercase text-zinc-500 font-bold">Nama</label>
                    <input type="text" id="e_user_name" name="name" required class="w-full bg-zinc-950 border border-zinc-800 rounded-xl px-4 py-3 text-sm text-white focus:border-yellow-500 outline-none transition">
                </div>
                <div class="space-y-1">
                    <label class="text-[10px] uppercase text-zinc-500 font-bold">Nomor Telepon</label>
                    <input type="text" id="e_user_phone" name="nomor_telepon" required class="w-full bg-zinc-950 border border-zinc-800 rounded-xl px-4 py-3 text-sm text-white focus:border-yellow-500 outline-none transition">
                </div>
                <div class="space-y-1">
                    <label class="text-[10px] uppercase text-zinc-500 font-bold">Password (Kosongkan jika tidak diubah)</label>
                    <input type="password" name="password" class="w-full bg-zinc-950 border border-zinc-800 rounded-xl px-4 py-3 text-sm text-white focus:border-yellow-500 outline-none transition">
                </div>
                <div class="space-y-1">
                    <label class="text-[10px] uppercase text-zinc-500 font-bold">Role</label>
                    <select id="e_user_role" name="role" required class="w-full bg-zinc-950 border border-zinc-800 rounded-xl px-4 py-3 text-sm text-white focus:border-yellow-500 outline-none transition">
                        <option value="admin">Admin</option>
                        <option value="mekanik">Mekanik</option>
                        <option value="pengguna">Pengguna</option>
                    </select>
                </div>
                <div class="pt-4 flex gap-3">
                    <button type="button" onclick="toggleModalEditUser(false)" class="flex-1 bg-zinc-800 hover:bg-zinc-700 text-white font-bold py-3 rounded-xl uppercase text-[10px] transition">Batal</button>
                    <button type="submit" class="flex-[2] bg-yellow-500 hover:bg-yellow-600 text-black font-bold py-3 rounded-xl uppercase text-[10px] tracking-widest transition">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
