<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    private function checkAdmin()
    {
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('home')->with('error', 'Akses ditolak');
        }

        return null;
    }

    public function index()
    {
        $checkAdmin = $this->checkAdmin();
        if ($checkAdmin) {
            return $checkAdmin;
        }

        return redirect()->route('admin.dashboard');
    }

    public function create()
    {
        $checkAdmin = $this->checkAdmin();
        if ($checkAdmin) {
            return $checkAdmin;
        }

        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $checkAdmin = $this->checkAdmin();
        if ($checkAdmin) {
            return $checkAdmin;
        }

        $validated = $request->validate([
            'name' => 'required',
            'nomor_telepon' => ['required', 'regex:/^08[0-9]{8,11}$/', 'unique:users,nomor_telepon'],
            'password' => 'required|min:6',
            'role' => 'required|in:admin,mekanik,pengguna',
        ]);

        User::create([
            'name' => $validated['name'],
            'nomor_telepon' => $validated['nomor_telepon'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'User berhasil ditambahkan');
    }

    public function edit(string $id)
    {
        $checkAdmin = $this->checkAdmin();
        if ($checkAdmin) {
            return $checkAdmin;
        }

        $user = User::findOrFail($id);

        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, string $id)
    {
        $checkAdmin = $this->checkAdmin();
        if ($checkAdmin) {
            return $checkAdmin;
        }

        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required',
            'nomor_telepon' => ['required', 'regex:/^08[0-9]{8,11}$/', 'unique:users,nomor_telepon,' . $user->id],
            'password' => 'nullable|min:6',
            'role' => 'required|in:admin,mekanik,pengguna',
        ]);

        $data = [
            'name' => $validated['name'],
            'nomor_telepon' => $validated['nomor_telepon'],
            'role' => $validated['role'],
        ];

        if (!empty($validated['password'])) {
            $data['password'] = Hash::make($validated['password']);
        }

        $user->update($data);

        return redirect()->route('admin.dashboard')->with('success', 'User berhasil diupdate');
    }

    public function destroy(string $id)
    {
        $checkAdmin = $this->checkAdmin();
        if ($checkAdmin) {
            return $checkAdmin;
        }

        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.dashboard')->with('success', 'User berhasil dihapus');
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required',
            'nomor_telepon' => ['required', 'regex:/^08[0-9]{8,11}$/', 'unique:users,nomor_telepon,' . $user->id],
            'password' => 'nullable|min:6',
        ]);

        $data = [
            'name' => $validated['name'],
            'nomor_telepon' => $validated['nomor_telepon'],
        ];

        if (!empty($validated['password'])) {
            $data['password'] = Hash::make($validated['password']);
        }

        $user->update($data);

        return back()->with('success', 'Profil Anda berhasil diperbarui');
    }
}