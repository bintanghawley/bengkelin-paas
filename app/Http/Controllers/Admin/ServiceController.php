<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\ServiceItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
    public function index()
    {
        return redirect()->route('admin.dashboard');
    }

    public function create()
    {
        return view('admin.services.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'           => 'required|string|max:255',
            'deskripsi'      => 'required|string',
            'harga_mulai'    => 'required|integer|min:0',
            'estimasi_waktu' => 'required|string|max:100',
            'gambar'         => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'items'          => 'nullable|array',
            'items.*'        => 'required|string|max:255',
        ]);

        DB::transaction(function () use ($validated, $request) {
            $slug = Str::slug($validated['nama']);
            $baseSlug = $slug;
            $counter = 1;
            while (Service::where('slug', $slug)->exists()) {
                $slug = $baseSlug . '-' . $counter++;
            }

            $gambarPath = null;
            if ($request->hasFile('gambar')) {
                $gambarPath = $this->uploadGambar($request->file('gambar'), 'services');
            }

            $service = Service::create([
                'nama'           => $validated['nama'],
                'slug'           => $slug,
                'deskripsi'      => $validated['deskripsi'],
                'harga_mulai'    => $validated['harga_mulai'],
                'estimasi_waktu' => $validated['estimasi_waktu'],
                'gambar'         => $gambarPath,
            ]);

            if (!empty($validated['items'])) {
                foreach ($validated['items'] as $item) {
                    if (!empty(trim($item))) {
                        ServiceItem::create([
                            'service_id'     => $service->id,
                            'nama_pekerjaan' => trim($item),
                        ]);
                    }
                }
            }
        });

        return redirect()->route('admin.dashboard')
            ->with('success', 'Layanan servis berhasil ditambahkan.');
    }

    public function show(Service $service)
    {
        $service->load('items');
        return view('admin.services.show', compact('service'));
    }

    public function edit(Service $service)
    {
        $service->load('items');
        return view('admin.services.edit', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'nama'           => 'required|string|max:255',
            'deskripsi'      => 'required|string',
            'harga_mulai'    => 'required|integer|min:0',
            'estimasi_waktu' => 'required|string|max:100',
            'gambar'         => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'items'          => 'nullable|array',
            'items.*'        => 'required|string|max:255',
        ]);

        DB::transaction(function () use ($validated, $request, $service) {
            $slug = Str::slug($validated['nama']);
            $baseSlug = $slug;
            $counter = 1;
            while (Service::where('slug', $slug)->where('id', '!=', $service->id)->exists()) {
                $slug = $baseSlug . '-' . $counter++;
            }

            $gambarPath = $service->gambar;
            if ($request->hasFile('gambar')) {
                if ($gambarPath && !str_starts_with($gambarPath, 'img/')) {
                    $disk = config('filesystems.default', 'public');
                    try {
                        Storage::disk($disk)->delete($gambarPath);
                    } catch (\Throwable $e) {
                        Storage::disk('public')->delete($gambarPath);
                    }
                }
                $uploaded = $this->uploadGambar($request->file('gambar'), 'services');
                if ($uploaded) {
                    $gambarPath = $uploaded;
                }
            }

            $service->update([
                'nama'           => $validated['nama'],
                'slug'           => $slug,
                'deskripsi'      => $validated['deskripsi'],
                'harga_mulai'    => $validated['harga_mulai'],
                'estimasi_waktu' => $validated['estimasi_waktu'],
                'gambar'         => $gambarPath,
            ]);

            // Hapus semua item lama lalu buat ulang
            $service->items()->delete();

            if (!empty($validated['items'])) {
                foreach ($validated['items'] as $item) {
                    if (!empty(trim($item))) {
                        ServiceItem::create([
                            'service_id'     => $service->id,
                            'nama_pekerjaan' => trim($item),
                        ]);
                    }
                }
            }
        });

        return redirect()->route('admin.dashboard')
            ->with('success', 'Layanan servis berhasil diperbarui.');
    }

    public function destroy(Service $service)
    {
        if ($service->gambar && !str_starts_with($service->gambar, 'img/')) {
            $disk = config('filesystems.default', 'public');
            try {
                Storage::disk($disk)->delete($service->gambar);
            } catch (\Throwable $e) {
                Storage::disk('public')->delete($service->gambar);
            }
        }
        $service->delete(); // cascade akan hapus service_items

        return redirect()->route('admin.dashboard')
            ->with('success', 'Layanan servis berhasil dihapus.');
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


