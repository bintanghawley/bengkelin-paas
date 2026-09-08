<div class="flex items-center justify-between mb-4">
    <h3 class="text-lg font-bengkel uppercase tracking-widest text-gray-900 dark:text-white">Kelola Users</h3>
    <button onclick="toggleModalUser(true)" class="bg-red-600 hover:bg-red-700 text-white text-xs font-bold py-2 px-4 rounded-lg uppercase tracking-widest">Tambah User</button>
</div>
<div class="bg-white dark:bg-zinc-900 rounded-3xl border border-gray-200 dark:border-zinc-800 overflow-hidden shadow-sm">
    <table class="w-full text-left text-sm">
        <thead class="bg-gray-100 dark:bg-zinc-800 text-gray-500 dark:text-zinc-400 uppercase text-[10px] tracking-widest border-b border-gray-200 dark:border-zinc-700">
            <tr>
                <th class="px-6 py-4">No</th>
                <th class="px-6 py-4">Nama</th>
                <th class="px-6 py-4">No. Telepon</th>
                <th class="px-6 py-4">Role</th>
                <th class="px-6 py-4">Dibuat pada</th>
                <th class="px-6 py-4">Diperbarui pada</th>
                <th class="px-6 py-4">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 dark:divide-zinc-800">
            @forelse($users as $user)
            <tr class="hover:bg-gray-50 dark:hover:bg-zinc-800/30 transition text-gray-700 dark:text-zinc-300">
                <td class="px-6 py-4">{{ $loop->iteration }}</td>
                <td class="px-6 py-4 font-bold text-gray-900 dark:text-white">{{ $user->name }}</td>
                <td class="px-6 py-4 text-gray-500 dark:text-zinc-500">{{ $user->nomor_telepon ? implode('-', str_split($user->nomor_telepon, 4)) : '-' }}</td>
                <td class="px-6 py-4">
                    <span class="px-2 py-1 rounded text-[10px] font-bold {{ $user->role == 'mekanik' ? 'bg-blue-500/20 text-blue-600 dark:text-blue-400' : 'bg-gray-200 dark:bg-zinc-700 text-gray-600 dark:text-zinc-300' }}">
                        {{ strtoupper($user->role) }}
                    </span>
                </td>
                <td class="px-6 py-4 text-gray-500 dark:text-zinc-400">{{ $user->created_at }}</td>
                <td class="px-6 py-4 text-gray-500 dark:text-zinc-400">{{ $user->updated_at }}</td>
                <td class="px-6 py-4">
                    <button type="button" onclick="openModalEditUser('{{ $user->id }}', '{{ htmlspecialchars($user->name, ENT_QUOTES) }}', '{{ $user->nomor_telepon }}', '{{ $user->role }}')" class="text-yellow-600 dark:text-yellow-400 hover:text-yellow-500 dark:hover:text-yellow-300 text-[10px] font-bold uppercase tracking-tighter mr-3">Edit</button>
                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus user ini?')">
                        @csrf
                        @method('DELETE')
                        <button class="text-red-600 dark:text-red-500 hover:text-red-500 dark:hover:text-red-400 font-bold uppercase text-[10px] tracking-tighter">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="px-6 py-6 text-center text-gray-400 dark:text-zinc-400">Data user belum ada</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
