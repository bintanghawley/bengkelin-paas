<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Oil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class OilController extends Controller
{
    private function checkAdmin()
    {
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('home')->with('error', 'Akses ditolak');
        }
        return null;
    }

    public function store(Request $request)
    {
        $check = $this->checkAdmin();
        if ($check) {
            return $check;
        }

        $request->validate([
            'nama'       => 'required|string|max:255',
            'harga'      => 'required|numeric|min:0',
            'stok'       => 'required|integer|min:0',
            'jenis_oli'  => 'required|string',
            'kekentalan' => 'required|string',
            'ukuran'     => 'required|string',
            'tipe_oli'   => 'required|string',
            'merek'      => 'required|string',
            'gambar'     => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'deskripsi'  => 'nullable|string',
            'fitur'      => 'nullable|string',
        ]);

        $data = $request->only([
            'nama', 'harga', 'stok', 'jenis_oli', 'kekentalan', 
            'ukuran', 'tipe_oli', 'merek', 'deskripsi', 'fitur'
        ]);

        if ($request->hasFile('gambar')) {
            $disk = config('filesystems.default', 'public');
            $data['gambar'] = $request->file('gambar')->store('oils', $disk);
        }

        Oil::create($data);

        return back()->with('success', 'Oli motor berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $check = $this->checkAdmin();
        if ($check) {
            return $check;
        }

        $oil = Oil::findOrFail($id);

        $request->validate([
            'nama'       => 'required|string|max:255',
            'harga'      => 'required|numeric|min:0',
            'stok'       => 'required|integer|min:0',
            'jenis_oli'  => 'required|string',
            'kekentalan' => 'required|string',
            'ukuran'     => 'required|string',
            'tipe_oli'   => 'required|string',
            'merek'      => 'required|string',
            'gambar'     => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'deskripsi'  => 'nullable|string',
            'fitur'      => 'nullable|string',
        ]);

        $data = $request->only([
            'nama', 'harga', 'stok', 'jenis_oli', 'kekentalan', 
            'ukuran', 'tipe_oli', 'merek', 'deskripsi', 'fitur'
        ]);

        if ($request->hasFile('gambar')) {
            $disk = config('filesystems.default', 'public');
            if ($oil->gambar) {
                Storage::disk($disk)->delete($oil->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('oils', $disk);
        }

        $oil->update($data);

        return back()->with('success', 'Oli motor berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $check = $this->checkAdmin();
        if ($check) {
            return $check;
        }

        $oil = Oil::findOrFail($id);

        if ($oil->gambar) {
            $disk = config('filesystems.default', 'public');
            Storage::disk($disk)->delete($oil->gambar);
        }

        $oil->delete();

        return back()->with('success', 'Oli motor berhasil dihapus!');
    }
}
