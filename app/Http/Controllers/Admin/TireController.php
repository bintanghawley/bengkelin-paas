<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TireController extends Controller
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
            'jenis_ban'  => 'required|string',
            'merek'      => 'required|string',
            'ukuran_ban' => 'required|string',
            'posisi_ban' => 'required|string',
            'material'   => 'required|string',
            'diameter'   => 'required|string',
            'tipe'       => 'required|string',
            'gambar'     => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'deskripsi'  => 'nullable|string',
            'fitur'      => 'nullable|string',
        ]);

        $data = $request->only([
            'nama', 'harga', 'stok', 'jenis_ban', 'merek', 
            'ukuran_ban', 'posisi_ban', 'material', 'diameter', 
            'tipe', 'deskripsi', 'fitur'
        ]);

        if ($request->hasFile('gambar')) {
            $uploaded = $this->uploadGambar($request->file('gambar'), 'tires');
            if ($uploaded) {
                $data['gambar'] = $uploaded;
            }
        }

        Tire::create($data);

        return back()->with('success', 'Ban motor berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $check = $this->checkAdmin();
        if ($check) {
            return $check;
        }

        $tire = Tire::findOrFail($id);

        $request->validate([
            'nama'       => 'required|string|max:255',
            'harga'      => 'required|numeric|min:0',
            'stok'       => 'required|integer|min:0',
            'jenis_ban'  => 'required|string',
            'merek'      => 'required|string',
            'ukuran_ban' => 'required|string',
            'posisi_ban' => 'required|string',
            'material'   => 'required|string',
            'diameter'   => 'required|string',
            'tipe'       => 'required|string',
            'gambar'     => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'deskripsi'  => 'nullable|string',
            'fitur'      => 'nullable|string',
        ]);

        $data = $request->only([
            'nama', 'harga', 'stok', 'jenis_ban', 'merek', 
            'ukuran_ban', 'posisi_ban', 'material', 'diameter', 
            'tipe', 'deskripsi', 'fitur'
        ]);

        if ($request->hasFile('gambar')) {
            if ($tire->gambar && !str_starts_with($tire->gambar, 'img/')) {
                $disk = config('filesystems.default', 'public');
                try {
                    Storage::disk($disk)->delete($tire->gambar);
                } catch (\Throwable $e) {
                    Storage::disk('public')->delete($tire->gambar);
                }
            }
            $uploaded = $this->uploadGambar($request->file('gambar'), 'tires');
            if ($uploaded) {
                $data['gambar'] = $uploaded;
            }
        }

        $tire->update($data);

        return back()->with('success', 'Ban motor berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $check = $this->checkAdmin();
        if ($check) {
            return $check;
        }

        $tire = Tire::findOrFail($id);

        if ($tire->gambar && !str_starts_with($tire->gambar, 'img/')) {
            $disk = config('filesystems.default', 'public');
            try {
                Storage::disk($disk)->delete($tire->gambar);
            } catch (\Throwable $e) {
                Storage::disk('public')->delete($tire->gambar);
            }
        }

        $tire->delete();

        return back()->with('success', 'Ban motor berhasil dihapus!');
    }

    private function uploadGambar($file, string $folder): ?string
    {
        $defaultDisk = config('filesystems.default', 'public');

        if ($defaultDisk === 's3') {
            try {
                $path = $file->store($folder, 's3');
                if ($path) {
                    return $path;
                }
            } catch (\Throwable $e) {
                \Illuminate\Support\Facades\Log::warning("S3 upload failed: " . $e->getMessage());
            }
        }

        try {
            $path = $file->store($folder, 'public');
            if ($path) {
                return $path;
            }
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error("Public storage upload failed: " . $e->getMessage());
        }

        return null;
    }
}
