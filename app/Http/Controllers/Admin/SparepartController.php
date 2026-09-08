<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sparepart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SparepartController extends Controller
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
            'nama'            => 'required|string|max:255',
            'harga'           => 'required|numeric|min:0',
            'stok'            => 'required|integer|min:0',
            'jenis_sparepart' => 'required|string',
            'merek'           => 'required|string',
            'gambar'          => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'deskripsi'       => 'nullable|string',
            'fitur'           => 'nullable|string',
        ]);

        $data = $request->only([
            'nama', 'harga', 'stok', 'jenis_sparepart', 
            'merek', 'deskripsi', 'fitur'
        ]);

        if ($request->hasFile('gambar')) {
            $uploaded = $this->uploadGambar($request->file('gambar'), 'spareparts');
            if ($uploaded) {
                $data['gambar'] = $uploaded;
            }
        }

        Sparepart::create($data);

        return back()->with('success', 'Sparepart berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $check = $this->checkAdmin();
        if ($check) {
            return $check;
        }

        $sparepart = Sparepart::findOrFail($id);

        $request->validate([
            'nama'            => 'required|string|max:255',
            'harga'           => 'required|numeric|min:0',
            'stok'            => 'required|integer|min:0',
            'jenis_sparepart' => 'required|string',
            'merek'           => 'required|string',
            'gambar'          => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'deskripsi'       => 'nullable|string',
            'fitur'           => 'nullable|string',
        ]);

        $data = $request->only([
            'nama', 'harga', 'stok', 'jenis_sparepart', 
            'merek', 'deskripsi', 'fitur'
        ]);

        if ($request->hasFile('gambar')) {
            if ($sparepart->gambar && !str_starts_with($sparepart->gambar, 'img/')) {
                $disk = config('filesystems.default', 'public');
                try {
                    Storage::disk($disk)->delete($sparepart->gambar);
                } catch (\Throwable $e) {
                    Storage::disk('public')->delete($sparepart->gambar);
                }
            }
            $uploaded = $this->uploadGambar($request->file('gambar'), 'spareparts');
            if ($uploaded) {
                $data['gambar'] = $uploaded;
            }
        }

        $sparepart->update($data);

        return back()->with('success', 'Sparepart berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $check = $this->checkAdmin();
        if ($check) {
            return $check;
        }

        $sparepart = Sparepart::findOrFail($id);

        if ($sparepart->gambar && !str_starts_with($sparepart->gambar, 'img/')) {
            $disk = config('filesystems.default', 'public');
            try {
                Storage::disk($disk)->delete($sparepart->gambar);
            } catch (\Throwable $e) {
                Storage::disk('public')->delete($sparepart->gambar);
            }
        }

        $sparepart->delete();

        return back()->with('success', 'Sparepart berhasil dihapus!');
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
